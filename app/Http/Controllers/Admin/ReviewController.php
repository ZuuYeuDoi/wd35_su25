<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
public function index(Request $request)
{
    $query = Review::with(['user', 'room'])->latest();

    // Tìm kiếm theo tên người dùng hoặc tên phòng
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->orWhereHas('room', function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%");
        });
    }

    // Lọc theo số sao
    if ($request->filled('rating')) {
        $query->where('rating', $request->rating);
    }

    // Lọc theo ngày (định dạng: YYYY-MM-DD)
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $reviews = $query->get();

    return view('admin.comment.index', compact('reviews'));
}


public function toggleStatus($id)
{
    $review = Review::findOrFail($id);
    $review->status = !$review->status;
    $review->save();

    return redirect()->route('admin.comment.index')->with('success', 'Cập nhật trạng thái thành công!');
}
}

