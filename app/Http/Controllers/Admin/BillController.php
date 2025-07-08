<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bill;
use App\Models\Cart;
use App\Models\Booking;
use App\Models\Service;
use App\Models\BillRoom;
use App\Models\BillService;
use App\Models\BillServices;
use Illuminate\Http\Request;
use App\Models\ManageStatusRoom;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BillController extends Controller
{

    public function temporary($id)
    {
        $booking = Booking::with(['user', 'bookingRooms.room.roomType'])->findOrFail($id);
        $services = Service::where('status', 1)->get();

        // Cập nhật trạng thái booking
        $booking->status = 2;
        $booking->actual_check_in = now();
        $booking->save();

        // Cập nhật trạng thái phòng và ghi log vào manage_status_rooms
        foreach ($booking->bookingRooms as $bookingRoom) {
            $room = $bookingRoom->room;
            $room->status = 2;
            $room->save();

            ManageStatusRoom::create([
                'room_id' => $room->id,
                'booking_id' => $booking->id,
                'status' => 2,
                'from_date' => $booking->check_in_date,
                'to_date' => $booking->check_out_date,
                'note' => 'Check-in từ đơn đặt #' . $booking->id,
            ]);
        }

        $cart = Cart::where('booking_id', $booking->id)
            ->where('status', 'ordered')
            ->with('cartServiceItems.service') // eager load
            ->first();

        return view('admin.bills.temporary_bill', compact('booking', 'services', 'cart'));
    }


    public function confirmPayment($id)
    {
        DB::beginTransaction();

        try {
            $booking = Booking::with(['user', 'bookingRooms.room.roomType'])->findOrFail($id);

            $cart = Cart::with('cartServiceItems.service')
                ->where('booking_id', $id)
                ->where('status', 'ordered')
                ->first();

            $roomAmount = 0;
            $serviceAmount = 0;
            $feeAmount = 0;
            $discount = 0;
            $vatPercent = 8;
            $vatAmount = 0;

            // 1. Tạo hóa đơn trước để có bill_id
            $bill = \App\Models\Bill::create([
                'bill_code'       => 'HD' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                'customer_name'   => $booking->user->name,
                'customer_phone'  => $booking->user->phone,
                'payment_method'  => 'Tiền mặt',
                'payment_date'    => now(),
                'note'            => 'Tạo từ đơn đặt phòng #' . $booking->id,
                'room_amount'     => 0,
                'service_amount'  => 0,
                'fee_amount'      => 0,
                'discount'        => 0,
                'vat_percent'     => $vatPercent,
                'vat_amount'      => 0,
                'final_amount'    => 0,
                'status'          => 'paid',
            ]);

            // 2. Ghi thông tin phòng vào bill_rooms
            foreach ($booking->bookingRooms as $bookingRoom) {
                $room = $bookingRoom->room;
                $nights = $booking->check_in_date->diffInDays($booking->check_out_date);
                $total = $room->price * $nights;
                $roomAmount += $total;

               BillRoom::create([
                    'bill_id'          => $bill->id,
                    'room_name'        => $room->title . ' (' . $room->roomType->name . ')',
                    'price_per_night'  => $room->price,
                    'nights'           => $nights,
                    'adults'           => $bookingRoom->adults ?? 1,
                    'children'         => $bookingRoom->children ?? 0,
                    'total_price'      => $total,
                    'note'             => null,
                ]);
            }

            // 3. Ghi thông tin dịch vụ vào bill_services
            if ($cart) {
                $cart->status = 'paid';
                $cart->save();

                foreach ($cart->cartServiceItems as $item) {
                    $service = $item->service;
                    $total = $service->price * $item->quantity;
                    $serviceAmount += $total;

                    \App\Models\BillService::create([
                        'bill_id'       => $bill->id,
                        'service_name'  => $service->name,
                        'unit_price'    => $service->price,
                        'quantity'      => $item->quantity,
                        'total_price'   => $total,
                    ]);
                }
            }

            // 4. Tính toán tổng tiền, VAT, discount
            $subtotal   = $roomAmount + $serviceAmount + $feeAmount - $discount;
            $vatAmount  = intval($subtotal * $vatPercent / 100);
            $finalTotal = $subtotal + $vatAmount;

            // 5. Cập nhật lại hóa đơn với tổng tiền chính xác
            $bill->update([
                'room_amount'    => $roomAmount,
                'service_amount' => $serviceAmount,
                'fee_amount'     => $feeAmount,
                'discount'       => $discount,
                'vat_amount'     => $vatAmount,
                'final_amount'   => $finalTotal,
            ]);

            // 6. Cập nhật trạng thái booking & phòng
            $booking->status = 3;
            $booking->save();

            foreach ($booking->bookingRooms as $bookingRoom) {
                $room = $bookingRoom->room;
                $room->status = 3;
                $room->save();
            }

            DB::commit();

            return redirect()->route('bills.final', $booking->id)
                ->with('success', 'Thanh toán thành công và hóa đơn đã được tạo.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function final($id)
    {
        $bill = Bill::with(['rooms', 'services', 'fees'])->findOrFail(
            Bill::where('bill_code', 'HD' . str_pad($id, 6, '0', STR_PAD_LEFT))->value('id') ?? $id
        );

        return view('admin.bills.final_bill', compact('bill'));
    }
}
