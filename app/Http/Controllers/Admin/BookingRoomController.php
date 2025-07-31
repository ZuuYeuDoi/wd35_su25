<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Guest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\FeesIncurred;
use Illuminate\Http\Request;
use App\Models\ManageStatusRoom;
use App\Http\Controllers\Controller;

class BookingRoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with([
            'user',
            'room.roomType',
            'bookingRooms.room',
        ])->latest();

        // Lọc theo ngày
        if ($request->filled('check_in_date') || $request->filled('check_out_date')) {
            $query->where(function ($q) use ($request) {
                if ($request->filled('check_in_date')) {
                    $q->orWhere(function ($sub) use ($request) {
                        $sub->whereDate('check_in_date', '<=', $request->check_in_date)
                            ->whereDate('check_out_date', '>=', $request->check_in_date);
                    });
                }
                if ($request->filled('check_out_date')) {
                    $q->orWhere(function ($sub) use ($request) {
                        $sub->whereDate('check_in_date', '<=', $request->check_out_date)
                            ->whereDate('check_out_date', '>=', $request->check_out_date);
                    });
                }
            });
        }

        // Lọc theo loại ở
        if ($request->filled('stay_type')) {
            if ($request->stay_type === 'dayuse') {
                $query->whereRaw('DATE(check_in_date) = DATE(check_out_date)');
            } elseif ($request->stay_type === 'overnight') {
                $query->whereRaw('DATE(check_in_date) <> DATE(check_out_date)');
            }
        }

        // Lọc theo trạng thái (đang xử lý, hoàn tất, hủy,...)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10);
        $bookings->getCollection()->transform(function ($booking) {
        $guestName = optional($booking->bookingRooms->first())->guest_name;
        $booking->display_customer_name = $guestName ?: optional($booking->user)->name ?: '---';
        return $booking;
    });

        return view('admin.bookingrooms.orders.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with([
            'user', 
            'room.roomType',
            'bookingRooms.room.roomType',
            'payments',
        ])->findOrFail($id);

        return view('admin.bookingrooms.orders.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::with('bookingRooms.room')->findOrFail($id);
        $rooms = Room::all();

        return view('admin.bookingrooms.orders.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2,3,4,5',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return redirect()->route('room_order.index')->with('success', 'Cập nhật trạng thái thành công!');
    }


public function cancel(Request $request, $id)
{
    $booking = Booking::with('bookingRooms.room')->findOrFail($id);

    $booking->status = 5;
    $booking->note = $request->note; 
    $booking->save();

    foreach ($booking->bookingRooms as $bookingRoom) {
        $room = $bookingRoom->room;
        $room->status = 0;
        $room->save();

        ManageStatusRoom::where('room_id', $room->id)
            ->where('booking_id', $booking->id)
            ->update([
                'status' => 0,
                'note' => $request->note,
            ]);
    }

    return redirect()->route('room_order.index')->with('success', 'Đơn đặt phòng đã được hủy và cập nhật lý do thành công.');
}
        
    public function showExtendHour($id)
    {
        $booking = Booking::with('bookingRooms.room')->findOrFail($id);
        return view('admin.bookingrooms.orders.extend_hour', compact('booking'));
    }

    public function handleExtendHour(Request $request, $id)
    {
        $request->validate([
            'extend_hour' => 'required|in:2,4',
        ]);

        $booking = Booking::findOrFail($id);

        $price_per_hour = [
            2 => 100000,
            4 => 200000,
        ];

        FeesIncurred::create([
            'booking_id' => $booking->id,
            'name' => 'Phí gia hạn ' . $request->extend_hour . ' giờ',
            'description' => 'Khách yêu cầu gia hạn ' . $request->extend_hour . ' giờ',
            'price' => $price_per_hour[$request->extend_hour],
        ]);

        return redirect()->route('room_order.show', $booking->id)
            ->with('success', "Gia hạn thêm {$request->extend_hour} giờ. Phụ thu: " . number_format($price_per_hour[$request->extend_hour]) . "đ");
    }

    public function showExtendDay($id)
    {
        $booking = Booking::with('bookingRooms.room')->findOrFail($id);
        return view('admin.bookingrooms.orders.extend_day', compact('booking'));
    }

  public function handleExtendDay(Request $request, $id)
{
    $request->validate([
        'new_check_out_date' => 'required|date|after:' . $request->old_check_out_date,
    ]);

    $booking = Booking::with('bookingRooms.room')->findOrFail($id);

    $oldCheckOut = Carbon::parse($request->old_check_out_date);
    $newCheckOut = Carbon::parse($request->new_check_out_date);
    $checkIn = Carbon::parse($booking->check_in_date);

    $oldDays = $checkIn->diffInDays($oldCheckOut);
    $newDays = $checkIn->diffInDays($newCheckOut);
    $extendDays = $newDays - $oldDays;

    if ($extendDays <= 0) {
        return back()->with('error', 'Ngày mới phải lớn hơn ngày cũ.');
    }

    $totalRoomFee = $booking->bookingRooms->sum('room.price') * $extendDays;

    FeesIncurred::create([
        'booking_id' => $booking->id,
        'name' => 'Phí gia hạn ' . $extendDays . ' ngày',
        'description' => 'Khách yêu cầu gia hạn thêm ' . $extendDays . ' ngày',
        'price' => $totalRoomFee,
    ]);

    $booking->check_out_date = $newCheckOut;
    $booking->save();

    return redirect()->route('room_order.show', $booking->id)
        ->with('success', "Gia hạn thêm {$extendDays} ngày. Phụ thu: " . number_format($totalRoomFee) . "đ");
}


        
}
