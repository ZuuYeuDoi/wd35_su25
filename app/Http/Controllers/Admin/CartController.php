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
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $bookingId = $validated['booking_id'];

            // Lấy booking để lấy user_id
            $booking = Booking::findOrFail($bookingId);

            // Kiểm tra cart tồn tại chưa
            $cart = Cart::where('booking_id', $bookingId)
                ->where('status', 'ordered')
                ->first();
            
                // dd($booking);

            // Nếu chưa có -> tạo mới cart với user_id từ booking
            if (!$cart) {
                $cart = Cart::create([
                    'booking_id' => $bookingId,
                    'user_id' => $booking->user_id,
                    'status' => 'ordered',
                ]);
            }

            // Lấy service
            $service = Service::findOrFail($validated['service_id']);

            // Kiểm tra item tồn tại chưa
            $existing = CartServiceItem::where('cart_id', $cart->id)
                ->where('service_id', $service->id)
                ->first();

            if ($existing) {
                $existing->quantity += $validated['quantity'];
                $existing->save();
            } else {
                CartServiceItem::create([
                    'cart_id' => $cart->id,
                    'service_id' => $service->id,
                    'quantity' => $validated['quantity'],
                    'unit_price' => $service->price,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Thêm dịch vụ thành công.',
                'cart_id' => $cart->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}
