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
            'room_id' => 'required|exists:rooms,id',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $userId = Auth::id();
        $roomId = $request->room_id;

        // Kiểm tra user có booking nào với phòng này đã checkout không
        $hasBooking = Booking::where('user_id', $userId)
            ->where('status', '>=', 3) // trạng thái >= 3 = đã checkout
            ->whereHas('rooms', fn($q) => $q->where('rooms.id', $roomId))
            ->exists();

        if (! $hasBooking) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sau khi đã đặt phòng và checkout phòng.');
        }

        // Kiểm tra đã review phòng này chưa
        $alreadyReviewed = Review::where('user_id', $userId)
            ->where('room_id', $roomId)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Bạn đã đánh giá phòng này rồi.');
        }

        // Tạo review
        Review::create([
            'user_id' => $userId,
            'room_id' => $roomId,
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
}