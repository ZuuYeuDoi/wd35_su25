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
    $booking = Booking::with(['user', 'bookingRooms.room.roomType', 'feeIncurreds'])
        ->findOrFail($id);
    $services = Service::where('status', 1)->get();

    // Cập nhật trạng thái booking
    $booking->status = 2;
    $booking->actual_check_in = now();
    $booking->save();

    // Cập nhật trạng thái phòng + ghi log
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

    // ✅ Lấy tất cả cart ordered của booking này
    $carts = Cart::where('booking_id', $booking->id)
    ->where('status', 'ordered')
    ->with('cartServiceItems.service')
    ->get();

    // Gộp tất cả items
    $cartItems = $carts->flatMap(fn($cart) => $cart->cartServiceItems);

    // ✅ Nhóm theo service_id và cộng dồn quantity + total
    $groupedItems = $cartItems->groupBy('service_id')->map(function ($items) {
        $first = $items->first();
        $totalQty = $items->sum('quantity');
        $unitPrice = $first->unit_price;
        $service = $first->service;

        return (object)[
            'service_id'   => $service->id,
            'service'      => $service,
            'quantity'     => $totalQty,
            'unit_price'   => $unitPrice,
            'total_price'  => $unitPrice * $totalQty,
        ];
    })->values();


    return view('admin.bills.temporary_bill', compact('booking', 'services', 'groupedItems'));

}

public function confirmPayment($id)
{
    DB::beginTransaction();
    try {
        $booking = Booking::with(['user', 'bookingRooms.room.roomType'])->findOrFail($id);

        // Lưu thời gian trả phòng thực tế
        $booking->actual_check_out = now();
        $booking->save();

        // Lấy tất cả cart ordered của booking này
        $carts = Cart::with('cartServiceItems.service')
            ->where('booking_id', $id)
            ->where('status', 'ordered')
            ->get();

        // Lấy tất cả items
        $cartItems = $carts->flatMap(fn($cart) => $cart->cartServiceItems);

        // ✅ Gộp dịch vụ giống nhau
        $groupedServices = $cartItems->groupBy('service_name')->map(function ($items) {
            $first = $items->first();
            $quantity = $items->sum('quantity');
            $totalPrice = $first->unit_price * $quantity;

            return (object)[
                'service_id'   => $first->service_id,
                'service_name' => $first->service->name,
                'unit_price'   => $first->unit_price,
                'quantity'     => $quantity,
                'total_price'  => $totalPrice,
            ];
        });

        $roomAmount = 0;
        $serviceAmount = $groupedServices->sum('total_price');
        $feeAmount = FeesIncurred::where('booking_id', $booking->id)->sum('price');
        $discount = 0;
        $vatPercent = 8;

        // Tính số đêm thực tế
        $actualCheckIn = $booking->actual_check_in ?? $booking->check_in_date;
        $actualCheckOut = $booking->actual_check_out ?? $booking->check_out_date;
        $nights = max(1, Carbon::parse($actualCheckIn)->diffInDays(Carbon::parse($actualCheckOut)));

        // Tiền phòng
        foreach ($booking->bookingRooms as $bookingRoom) {
            $room = $bookingRoom->room;
            $roomAmount += $room->price * $nights;
        }

        // Tiền cọc
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

        // Tạo hóa đơn final
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

        // ✅ Lưu chi tiết dịch vụ sau khi gộp
        foreach ($groupedServices as $service) {
            BillService::create([
                'bill_id'      => $bill->id,
                'service_id'   => $service->service_id,
                'service_name' => $service->service_name,
                'unit_price'   => $service->unit_price,
                'quantity'     => $service->quantity,
                'total_price'  => $service->total_price,
            ]);
        }

        // Đánh dấu cart đã thanh toán
        foreach ($carts as $cart) {
            $cart->update(['status' => 'paid']);
        }

        // Lưu phụ phí
        $fees = FeesIncurred::where('booking_id', $booking->id)->get();
        foreach ($fees as $fee) {
            BillFee::create([
                'bill_id'    => $bill->id,
                'fee_name'   => $fee->name,
                'amount'     => $fee->price,
                'description'=> $fee->description ?? null,
            ]);
        }

        // Cập nhật trạng thái booking và phòng
        $booking->update(['status' => 3]);
        foreach ($booking->bookingRooms as $bookingRoom) {
            $bookingRoom->room->update(['status' => 1]);
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
    $bill = Bill::with(['rooms', 'services', 'fees', 'booking.bookingRooms'])
        ->findOrFail($id);

    if ($bill->booking) {
        $checkIn = \Carbon\Carbon::parse($bill->booking->actual_check_in ?? $bill->booking->check_in_date);
        $checkOut = \Carbon\Carbon::parse($bill->booking->actual_check_out ?? $bill->booking->check_out_date);

        // Tính số ngày ở, làm tròn hợp lý (<0.5 xuống, >=0.5 lên)
        $diff = $checkIn->floatDiffInDays($checkOut);
        $days = ($diff - floor($diff)) < 0.5 ? floor($diff) : ceil($diff);

        $bill->stay_days = $days > 0 ? $days : 0;
    }

    foreach ($bill->rooms as $room) {
        // Gán số đêm cho phòng
        $room->nights = $bill->stay_days ?? $room->nights;

        if (($bill->stay_days ?? 0) < 1) {
            // Nếu ở dưới 1 ngày: tính phí mặc định và đánh dấu "trong ngày"
            $room->total_price = 200000;
            $room->in_day = true;
        } else {
            // Nếu ở >= 1 ngày: tính theo giá/đêm * số đêm
            $room->total_price = $room->price_per_night * $room->nights;
            $room->in_day = false;
        }
    }

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
