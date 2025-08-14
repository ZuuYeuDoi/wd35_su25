<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Booking;
use App\Models\Service;
use App\Models\CartServiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
{
    try {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_id' => 'required|exists:services,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        $booking = Booking::findOrFail($validated['booking_id']);

        // Tìm hoặc tạo cart
        $cart = Cart::firstOrCreate(
            [
                'booking_id' => $booking->id,
                'status'     => 'ordered'
            ],
            [
                'user_id' => $booking->user_id,
                'status'  => 'ordered',
            ]
        );

        $service = Service::findOrFail($validated['service_id']);

        $existing = CartServiceItem::where('cart_id', $cart->id)
            ->where('service_id', $service->id)
            ->first();

        if ($existing) {
            $existing->quantity += $validated['quantity'];
            $existing->save();
        } else {
            CartServiceItem::create([
                'cart_id'     => $cart->id,
                'service_id'  => $service->id,
                'quantity'    => $validated['quantity'],
                'unit_price'  => $service->price,
                'total_price' => $service->price * $validated['quantity']
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Thêm dịch vụ thành công.',
            'cart_id' => $cart->id
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ.',
            'errors'  => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
        ], 500);
    }
}

}
