<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminBookingController extends Controller
{
    public function create()
{
    $roomTypes = RoomType::all();
    return view('admin.bookings.create', compact('roomTypes'));
}

public function store(Request $request)
{
    $request->validate([
        'guest_name' => 'required|string',
        'guest_phone' => 'required|string',
        'check_out' => 'required|date|after:check_in',
        'adults' => 'required|integer|min:1',
        'children' => 'nullable|integer|min:0',
        'room_type_id' => 'required|exists:room_types,id',
    ]);

    DB::beginTransaction();
    try {
        // Tìm 1 phòng trống phù hợp
        $room = Room::where('room_type_id', $request->room_type_id)
        ->where('status', 1) // chỉ lấy phòng có trạng thái = 1
        ->whereDoesntHave('bookingRooms', function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->whereBetween('check_in_date', [$request->check_in, $request->check_out])
                    ->orWhereBetween('check_out_date', [$request->check_in, $request->check_out]);
            });
        })
        ->first();

            $checkIn = Carbon::parse($request->check_in . ' 12:00:00');
            $checkOut = Carbon::parse($request->check_out . ' 12:00:00');

            $nights = (int) $checkIn->diffInDays($checkOut);

            $totalAmount = $room->price * $nights;

        if (!$room) {
            return back()->with('error', 'Không còn phòng trống thuộc loại đã chọn');
        }

        // Tạo booking
       $booking = Booking::create([
            'booking_code' => 'BK-' . now()->format('Ymd') . '-' . rand(1000, 9999),
            'check_in_date' => $request->check_in,
            'actual_check_in' => now(),
            'check_out_date' => $request->check_out,
            'adults' => $request->adults,
            'children' => $request->children,
            'special_request' => 'khách vãng lai',
            'status' => 2,
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
        ]);


        // Tạo booking_room
        BookingRoom::create([
            'booking_id' => $booking->id,
            'room_id' => $room->id,
            'check_in_date' => $request->check_in,
            'check_out_date' => $request->check_out,
            'price' => $room->price,
            'guest_name' => $request->guest_name,
            'note' => $request->guest_phone,
        ]);

        DB::commit();

        return redirect()->route('admin.bookings.create')->with('success', 'Đặt phòng thành công!');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Lỗi khi đặt phòng: ' . $e->getMessage());
    }
}
}
