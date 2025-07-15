<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bill;
use App\Models\Cart;
use App\Models\Booking;
use App\Models\Service;
use App\Models\BillRoom;
use App\Models\BillService;
use App\Models\BillServices;
use App\Models\FeesIncurred;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        // Cập nhật actual_check_out
        $booking->actual_check_out = now();
        $booking->save();

        $cart = Cart::with('cartServiceItems.service')
            ->where('booking_id', $id)
            ->where('status', 'ordered')
            ->first();

        $roomAmount = 0;
        $serviceAmount = 0;
        $feeAmount = FeesIncurred::where('booking_id', $booking->id)->sum('price');
        $discount = 0;
        $vatPercent = 8;
        $vatAmount = 0;

        $bill_id = $booking->bill_id;

        $bill = Bill::find($bill_id);

        if (!$bill) {
            DB::rollBack();
            return back()->with('error', 'Không tìm thấy hóa đơn cọc của đơn này.');
        }

        // Tính đêm thực tế
        $actualCheckIn = $booking->actual_check_in ?? $booking->check_in_date;
        $actualCheckOut = $booking->actual_check_out ?? $booking->check_out_date;
        $nights = Carbon::parse($actualCheckIn)->diffInDays(Carbon::parse($actualCheckOut));
        $nights = max(1, $nights);

        // Tính phí phòng
        foreach ($booking->bookingRooms as $bookingRoom) {
            $room = $bookingRoom->room;
            $roomAmount += $room->price * $nights;
        }

        // Tính phí dịch vụ
        if ($cart) {
            $cart->status = 'paid';
            $cart->save();

            foreach ($cart->cartServiceItems as $item) {
                $service = $item->service;
                $serviceAmount += $service->price * $item->quantity;
            }
        }

        // Tổng cộng
        $subtotal = $roomAmount + $serviceAmount + $feeAmount - $discount;
        $vatAmount = intval($subtotal * $vatPercent / 100);
        $finalTotal = $subtotal + $vatAmount;

        // Cập nhật bill cũ
        $bill->update([
            'room_amount'    => $roomAmount,
            'service_amount' => $serviceAmount,
            'fee_amount'     => $feeAmount,
            'discount'       => $discount,
            'vat_amount'     => $vatAmount,
            'final_amount'   => $finalTotal,
            'status'         => 'paid',
            'payment_date'   => now(),
        ]);

        // Update booking & room
        $booking->status = 3; // Đã thanh toán toàn bộ
        $booking->save();

        foreach ($booking->bookingRooms as $bookingRoom) {
            $room = $bookingRoom->room;
            $room->status = 3;
            $room->save();
        }

        DB::commit();

        return redirect()->route('bills.final', $bill_id)
            ->with('success', 'Checkout thành công, đã cập nhật hóa đơn.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
}

    public function final($id)
{
    $bill = Bill::with(['rooms', 'services', 'fees'])->findOrFail($id);
    return view('admin.bills.final_bill', compact('bill'));
}


  public function index(Request $request)
{
    $query = Bill::query();

    if ($request->filled('customer_name')) {
        $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
    }

    if ($request->filled('customer_phone')) {
        $query->where('customer_phone', 'like', '%' . $request->customer_phone . '%');
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('payment_date')) {
        $query->whereDate('payment_date', $request->payment_date);
    }

    $bills = $query->latest()->paginate(10);

    return view('admin.bills.index', compact('bills'));
}

   public function show($id)
{
    $bill = Bill::with(['billRooms', 'billServices', 'billFees'])->findOrFail($id);
    return view('admin.bills.show', compact('bill'));
}
}
