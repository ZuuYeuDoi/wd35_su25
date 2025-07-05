<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Bắt buộc đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục đặt phòng.');
        }

        $request->validate([
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
        ], [
            'checkin_date.required' => 'Chọn ngày nhận phòng.',
            'checkout_date.required' => 'Chọn ngày trả phòng.',
            'checkout_date.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',
        ]);

        $user = Auth::user();
        $data = $request->only(['checkin_date', 'checkout_date']);
        $roomIds = $request->input('room_ids', []);
        $rooms = Room::with('images_room', 'roomType')->whereIn('id', $roomIds)->get();

        $checkin = Carbon::parse($data['checkin_date']);
        $checkout = Carbon::parse($data['checkout_date']);
        $numberOfNights = $checkin->diffInDays($checkout);

        $bookingCode = $this->generateBookingCode();
        
        $totalPrice = $rooms->sum(function ($room) use ($numberOfNights) {
            return $room->price * $numberOfNights;
        });

        // Booking tạm chưa lưu DB
        $booking = new \stdClass();
        $booking->id = null;
        $booking->total_price = $totalPrice;

        return view('client.checkout.index', compact(
            'user',
            'data',
            'room',
            'totalPrice',
            'numberOfNights',
            'bookingCode',
            'booking'
        ));
    }
public function store(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
    }

    $data = $request->validate([
        'checkin_date' => 'required|date',
        'checkout_date' => 'required|date|after:checkin_date',
        'room_ids' => 'required|array',
        'room_ids.*' => 'exists:rooms,id',
    ]);

    $user = Auth::user();
    $checkin = Carbon::parse($data['checkin_date']);
    $checkout = Carbon::parse($data['checkout_date']);
    $numberOfNights = $checkin->diffInDays($checkout);

    $booking = Booking::create([
        'booking_code' => $this->generateBookingCode(),
        'user_id' => $user->id,
        'check_in_date' => $checkin,
        'check_out_date' => $checkout,
        'status' => 0,
    ]);

    $totalPrice = 0;

    foreach ($data['room_ids'] as $roomId) {
        $room = Room::findOrFail($roomId);
        $price = $room->price * $numberOfNights;

        $totalPrice += $price;

        \DB::table('booking_rooms')->insert([
            'booking_id' => $booking->id,
            'room_id' => $room->id,
            'price' => $room->price,
            'adults' => 1, // Tùy chỉnh
            'children' => 0, // Tùy chỉnh
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return view('client.payments.auto_submit', [
        'booking_id' => $booking->id,
        'amount' => $totalPrice,
    ]);
}


    private function generateBookingCode()
    {
        $date = Carbon::now()->format('Ymd');
        $random = mt_rand(1000, 9999);
        return "BK-{$date}-{$random}";
    }
}
