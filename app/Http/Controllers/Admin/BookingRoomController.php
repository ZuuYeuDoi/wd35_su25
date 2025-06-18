<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingRoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room'])->latest();

        // Nếu có nhập cả hai ngày
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

        $bookings = $query->paginate(10);

        return view('admin.bookingrooms.orders.index', compact('bookings'));
    }



    // Hiển thị chi tiết 1 booking
    public function show($id)
    {
        $booking = Booking::with('room')->findOrFail($id);
        return view('admin.bookingrooms.orders.show', compact('booking'));
    }

    // Hiển thị form chỉnh sửa booking
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $rooms = Room::all();
        return view('admin.bookingrooms.orders.edit', compact('booking', 'rooms'));
    }

    // Cập nhật thông tin booking
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'customer_name' => 'required|string|max:255',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'status' => 'required|in:confirmed,checked_in,checked_out,cancelled'
        ]);

        $booking->update([
            'room_id' => $request->room_id,
            'customer_name' => $request->customer_name,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status' => $request->status,
        ]);

        return redirect()->route('room_order.index')->with('success', 'Cập nhật booking thành công!');
    }
}
