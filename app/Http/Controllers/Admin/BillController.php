<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bill;
use App\Models\Cart;
use App\Models\BillFee;
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
        $booking = Booking::with(['user', 'bookingRooms.room.roomType', 'feeIncurreds'])->findOrFail($id);
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
            ->with('cartServiceItems.service') 
            ->first();

        return view('admin.bills.temporary_bill', compact('booking', 'services', 'cart' ));
    }
public function confirmPayment($id)
{
    DB::beginTransaction();
    try {
        $booking = Booking::with(['user', 'bookingRooms.room.roomType'])->findOrFail($id);

        // Cập nhật actual_check_out
        $booking->actual_check_out = now();
        $booking->save();

        // Cart service
        $cart = Cart::with('cartServiceItems.service')
            ->where('booking_id', $id)
            ->where('status', 'ordered')
            ->first();

        // Tiền phí
        $roomAmount = 0;
        $serviceAmount = 0;
        $feeAmount = FeesIncurred::where('booking_id', $booking->id)->sum('price');
        $discount = 0;
        $vatPercent = 8;
        $vatAmount = 0;

        // Tính số đêm thực tế
        $actualCheckIn = $booking->actual_check_in ?? $booking->check_in_date;
        $actualCheckOut = $booking->actual_check_out ?? $booking->check_out_date;
        $nights = Carbon::parse($actualCheckIn)->diffInDays(Carbon::parse($actualCheckOut));
        $nights = max(1, $nights);

        // Tính tiền phòng
        foreach ($booking->bookingRooms as $bookingRoom) {
            $room = $bookingRoom->room;
            $roomAmount += $room->price * $nights;
        }

        // Tính dịch vụ
        if ($cart) {
            $cart->status = 'paid';
            $cart->save();

            foreach ($cart->cartServiceItems as $item) {
                $service = $item->service;
                $serviceAmount += $service->price * $item->quantity;
            }
        }

        // Tiền cọc đã thanh toán trước
        $depositBill = Bill::where('booking_id', $booking->id)
            ->where('bill_type', 'deposit')
            ->where('status', 'paid')
            ->first();

        $depositAmount = $depositBill ? $depositBill->final_amount : 0;

        // Tổng cộng
        $subtotal = $roomAmount + $serviceAmount + $feeAmount - $discount;
        $subtotalAfterDeposit = max(0, $subtotal - $depositAmount);
        $vatAmount = intval($subtotalAfterDeposit * $vatPercent / 100);
        $finalTotal = $subtotalAfterDeposit + $vatAmount;

        // Tạo Bill Final
        $bill = Bill::create([
            'customer_name'  => $booking->user->name,
            'customer_phone' => $booking->user->phone,
            'booking_id'     => $booking->id,
            'bill_type'      => 'final',
            'room_amount'    => $roomAmount,
            'service_amount' => $serviceAmount,
            'fee_amount'     => $feeAmount,
            'discount'       => $discount,
            'vat_amount'     => $vatAmount,
            'final_amount'   => $finalTotal,
            'status'         => 'paid',
            'payment_date'   => now(),
            'payment_method' => 'cash',
            'bill_code'      => 'HD' . now()->format('YmdHis'),
            'note'           => 'Đã trừ tiền cọc: ' . number_format($depositAmount) . 'đ',
        ]);

        // Lưu chi tiết phòng
        foreach ($booking->bookingRooms as $bookingRoom) {
            $room = $bookingRoom->room;
            BillRoom::create([
                'bill_id'         => $bill->id,
                'room_id'         => $room->id,
                'room_name'       => $room->title,
                'price_per_night' => $room->price,
                'nights'          => $nights,
                'total_price'     => $room->price * $nights,
            ]);
        }

        // Lưu chi tiết dịch vụ
        if ($cart) {
            foreach ($cart->cartServiceItems as $item) {
                BillService::create([
                    'bill_id'      => $bill->id,
                    'service_id'   => $item->service_id,
                    'service_name' => $item->service->name,
                    'unit_price'   => $item->service->price,
                    'quantity'     => $item->quantity,
                    'total_price'  => $item->service->price * $item->quantity,
                ]);
            }
        }

        // Lưu phụ thu
        $fees = FeesIncurred::where('booking_id', $booking->id)->get();
        foreach ($fees as $fee) {
            BillFee::create([
                'bill_id'    => $bill->id,
                'fee_name'   => $fee->name,
                'amount'     => $fee->price,
                'description'=> $fee->description ?? null,
            ]);
        }

        // Update booking + phòng
        $booking->status = 4;
        $booking->save();

        foreach ($booking->bookingRooms as $bookingRoom) {
            $room = $bookingRoom->room;
            $room->status = 4;
            $room->save();
        }

        DB::commit();

        return redirect()->route('bills.final', $bill->id)
            ->with('success', 'Checkout thành công, đã tạo hóa đơn chính thức.');
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
