<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Amenitie;
use App\Models\Room;
use App\Models\Booking; // thêm nếu chưa có
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
