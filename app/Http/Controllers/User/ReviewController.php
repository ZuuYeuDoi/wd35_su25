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
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000',
    ]);

    $userId = Auth::id();
    $roomId = $request->room_id;


    $hasBooked = Booking::where('user_id', $userId)
        ->where('status', 4)
        ->whereHas('rooms', function ($q) use ($roomId) {
            $q->where('rooms.id', $roomId);
        })
        ->exists();

    if (!$hasBooked) {
        return back()->with('error', 'Bạn chỉ có thể đánh giá khi đã hoàn tất đặt phòng.');
    }

    $alreadyReviewed = Review::where('user_id', $userId)
        ->where('room_id', $roomId)
        ->exists();

    if ($alreadyReviewed) {
        return back()->with('error', 'Bạn đã đánh giá phòng này rồi. Mỗi khách chỉ được đánh giá một lần cho mỗi lần đặt phòng.');
    }

    Review::create([
        'user_id' => $userId,
        'room_id' => $roomId,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
}


}
