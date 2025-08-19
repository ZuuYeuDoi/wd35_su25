<?php

namespace App\Http\Controllers\User;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ReviewController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'room_id'    => 'required|exists:rooms,id',
        'booking_id' => 'required|exists:bookings,id',
        'rating'     => 'required|integer|min:1|max:5',
        'comment'    => 'required|string|max:1000',
    ]);

    $userId = Auth::id();
    $roomId = $request->room_id;
    $bookingId = $request->booking_id;

    // Xác nhận booking này thuộc user và đã checkout
    $booking = Booking::where('id', $bookingId)
        ->where('user_id', $userId)
        ->where('status', '>=', 3)
        ->whereHas('rooms', function ($q) use ($roomId) {
            $q->where('rooms.id', $roomId);
        })
        ->first();

    if (!$booking) {
        return back()->with('error', 'Bạn chỉ có thể đánh giá sau khi đã hoàn tất đặt phòng.');
    }

    // Kiểm tra đã review chưa
    $alreadyReviewed = Review::where('user_id', $userId)
        ->where('room_id', $roomId)
        ->where('booking_id', $booking->id)
        ->exists();

    if ($alreadyReviewed) {
        return back()->with('error', 'Bạn đã đánh giá phòng này cho lần đặt phòng này rồi.');
    }

    // Tạo review
    Review::create([
        'user_id'    => $userId,
        'room_id'    => $roomId,
        'booking_id' => $booking->id,
        'rating'     => $request->rating,
        'comment'    => $request->comment,
    ]);

    return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
}



}
