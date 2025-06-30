<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BillServices;
use App\Models\Booking;
use App\Models\Cart;
use App\Models\CartService;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addService(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate([
            'booking_id' => $request->booking_id
        ], [
            'status' => 'active'
        ]);

        CartService::create([
            'cart_id' => $cart->id,
            'service_id' => $request->service_id,
            'quantity' => $request->quantity,
            'unit_price' => Service::find($request->service_id)->price,
        ]);

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function index()
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('status', 2)
            ->whereDate('actual_check_in', '<=', Carbon::today())
            ->whereDate('actual_check_out', '>=', Carbon::today())
            ->first();

        if (!$booking) {
            return redirect()->route('home')->with('error', 'Không có đơn đặt phòng nào hợp lệ.');
        }

        $cart = Cart::with('services')
            ->where('booking_id', $booking->id)
            ->where('status', 'active')
            ->with('services.service')
            ->first();
        // dd($cart);
        return view('client.cart.index', compact('cart'));
    }

    public function remove($id)
    {
        $cartItem = CartService::findOrFail($id);
        $cartItem->delete();
        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function update(Request $request)
    {
        $quantities = $request->input('quantities', []);
        foreach ($quantities as $cartServiceId => $newQty) {
            $cartItem = CartService::find($cartServiceId);
            if ($cartItem) {
                $max = $cartItem->service->quantity;
                $fixedQty = max(1, min((int)$newQty, $max));
                $cartItem->update(['quantity' => $fixedQty]);
            }
        }
        return back()->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    public function order(Request $request)
    {
        $cartId = $request->input('cart_id');
        $serviceNames = $request->input('service_names', []);
        $servicePrices = $request->input('service_prices', []);
        $quantities = $request->input('quantities', []);
        $subtotals = $request->input('subtotals', []);

        if (!$cartId) {
            return back()->with('error', 'Thiếu thông tin giỏ hàng.');
        }

        DB::beginTransaction();
        try {
            foreach ($quantities as $id => $qty) {
                BillServices::create([
                    // 'bill_id' => 1, 
                    'cart_id' => $cartId,
                    'service_name' => $serviceNames[$id] ?? '',
                    'service_price' => $servicePrices[$id] ?? 0,
                    'quantity' => $qty,
                    'total_price' => $subtotals[$id] ?? 0,
                ]);
            }

            CartService::where('cart_id', $cartId)->delete();

            DB::commit();
            return back()->with('success', 'Đặt món thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
