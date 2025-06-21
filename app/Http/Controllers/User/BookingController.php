<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Amenitie;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'checkin_date' => 'required',
            'checkout_date' => 'required',
        ], [
            'checkin_date.required' => 'Chọn ngày nhận phòng.',
            'checkout_date.required' => 'Chọn ngày trả phòng.',
        ]);

        $user = Auth::check() ? Auth::user() : null;
        $data = $request->only(['checkin_date', 'checkout_date']);
        $roomId = $request->input('room_id');
        $room = Room::with('images_room', 'roomType')->find($roomId);
        $checkin = Carbon::parse($data['checkin_date']);
        $checkout = Carbon::parse($data['checkout_date']);
        $numberOfNights = $checkin->diffInDays($checkout);
        $bookingCode = $this->generateBookingCode();
        $totalPrice = $numberOfNights * $room->price;
        return view('client.checkout.index', compact('user', 'data', 'room', 'totalPrice', 'numberOfNights','bookingCode'));
    }

    private function generateBookingCode()
    {
        $date = Carbon::now()->format('Ymd');
        $random = mt_rand(1000, 9999);
        return "BK-{$date}-{$random}";
    }
}
