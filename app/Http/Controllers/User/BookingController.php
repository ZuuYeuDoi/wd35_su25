<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Amenitie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking; // thêm nếu chưa có

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
        ], [
            'checkin_date.required' => 'Chọn ngày nhận phòng.',
            'checkout_date.required' => 'Chọn ngày trả phòng.',
            'checkout_date.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',
        ]);

        $user = Auth::check() ? Auth::user() : null;
        $data = $request->only(['checkin_date', 'checkout_date']);
        $roomId = $request->input('room_id');
        $room = Room::with('images_room', 'roomType')->findOrFail($roomId);

        $checkin = Carbon::parse($data['checkin_date']);
        $checkout = Carbon::parse($data['checkout_date']);
        $numberOfNights = $checkin->diffInDays($checkout);

        $bookingCode = $this->generateBookingCode();
        $totalPrice = $numberOfNights * $room->price;

        // 👉 Tạo đối tượng booking tạm (chưa lưu vào DB)
        $booking = new \stdClass();
        $booking->id = null; // hoặc gán ID tạm thời nếu cần
        $booking->total_price = $totalPrice;

        return view('client.checkout.index', compact(
            'user',
            'data',
            'room',
            'totalPrice',
            'numberOfNights',
            'bookingCode',
            'booking' // ✅ thêm vào đây để tránh lỗi
        ));
    }

    private function generateBookingCode()
    {
        $date = Carbon::now()->format('Ymd');
        $random = mt_rand(1000, 9999);
        return "BK-{$date}-{$random}";
    }

        public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'required|string|max:255',
        'cccd' => 'required|string|max:20',
        'checkin_date' => 'required|date',
        'checkout_date' => 'required|date|after:checkin_date',
        'room_id' => 'required|exists:rooms,id',
    ]);

    // Tạo guest
    $guest = Guest::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'cccd' => $data['cccd'],
    ]);

    // Tính số đêm
    $checkin = Carbon::parse($data['checkin_date']);
    $checkout = Carbon::parse($data['checkout_date']);
    $numberOfNights = $checkin->diffInDays($checkout);

    // Lấy giá phòng
    $room = Room::findOrFail($data['room_id']);
    $totalPrice = $numberOfNights * $room->price;

    // dd($room, $totalPrice);
    // Tạo booking
    $booking = Booking::create([
        'booking_code' => $this->generateBookingCode(),
        'room_id' => $room->id,
        'user_id'  => Auth::check() ? Auth::id() : null,
        'guest_id' => Auth::check() ? null : $guest->id,
        'check_in_date' => $data['checkin_date'],
        'check_out_date' => $data['checkout_date'],
        'deposit' => null,
        'status' => 0,
    ]);

    // Chuyển sang payment
    return view('client.payments.auto_submit', [
    'booking_id' => $booking->id,
    'amount' => $totalPrice,
    ]);
}
    
}


