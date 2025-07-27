<?php

namespace App\Http\Controllers\User;

use App\Events\NewOrderEvent;
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
            'quantity'   => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $service = Service::findOrFail($request->service_id);

        $cart = Cart::where('booking_id', $request->booking_id)
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            $cart = new Cart();
            $cart->booking_id = $request->booking_id;
            $cart->user_id    = $userId;
            $cart->status     = 'active';
            $cart->save();
        }

        $cartService = CartService::where('cart_id', $cart->id)
            ->where('service_id', $service->id)
            ->first();

        if ($cartService) {
            $newQuantity = $cartService->quantity + $request->quantity;

            if ($service->type == 2 && $newQuantity > $service->quantity) {
                return redirect()->back()->with('error', 'Tổng số lượng vượt quá tồn kho. Còn lại: ' . $service->quantity);
            }

            $cartService->quantity = $newQuantity;
            $cartService->save();
        } else {
            // Với món ăn kiểm tra nếu vượt kho ngay lần đầu thêm
            if ($service->type == 2 && $request->quantity > $service->quantity) {
                return redirect()->back()->with('error', 'Số lượng vượt quá tồn kho. Còn lại: ' . $service->quantity);
            }

            CartService::create([
                'cart_id'    => $cart->id,
                'service_id' => $service->id,
                'quantity'   => $request->quantity,
                'unit_price' => $service->price,
            ]);
        }
        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function index()
    {
        $cart = Cart::with('services')
            ->where('status', 'active')
            ->with('services.service')
            ->first();
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
        $quantities = $request->input('quantities', []);

        if (!$cartId) {
            return back()->with('error', 'Thiếu thông tin giỏ hàng.');
        }

        DB::beginTransaction();
        try {
            $cart = Cart::findOrFail($cartId);
            $cart->status = 'ordered';
            $cart->save();

            foreach ($quantities as $cartServiceId => $qty) {
                $cartService = CartService::with('service')->find($cartServiceId);

                if ($cartService && $cartService->service->type == 2) {
                    $service = $cartService->service;
                    $service->quantity = max(0, $service->quantity - $qty);
                    $service->save();
                }
            }

            DB::commit();

            // sự kiện thông báo
            event(new NewOrderEvent($cart->id));

            return back()->with('success', 'Đặt món thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
