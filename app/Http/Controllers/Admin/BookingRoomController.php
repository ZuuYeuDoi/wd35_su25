<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Guest;
use App\Models\Booking;
use App\Models\Payment;
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

        return view('admin.bookingrooms.orders.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with([
            'user', 'guest',
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


}
