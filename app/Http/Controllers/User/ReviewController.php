<?php

namespace App\Http\Controllers\User;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Kiểm tra xem user có đặt và đã checkout phòng này chưa
        $hasBooked = Booking::where('user_id', Auth::id())
            ->whereDate('check_out_date', '<=', now())
            ->whereHas('rooms', function ($q) use ($request) {
                $q->where('rooms.id', $request->room_id);
            })
            ->exists();

        if (!$hasBooked) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá khi đã đặt và checkout phòng.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
}
