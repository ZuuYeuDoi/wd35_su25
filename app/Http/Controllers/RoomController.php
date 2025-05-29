<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.bookingrooms.rooms.rooms');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTypes = RoomType::get();
        return view('admin.bookingrooms.rooms.createRoom', compact('roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_people' => 'required|integer|min:1',
            'image_room' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
        ], [
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng không hợp lệ.',
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá phòng.',
            'price.numeric' => 'Giá phòng phải là số.',
            'price.min' => 'Giá phòng không được nhỏ hơn 0.',
            'max_people.required' => 'Vui lòng nhập số người tối đa.',
            'max_people.integer' => 'Số người tối đa phải là số nguyên.',
            'max_people.min' => 'Số người tối đa ít nhất là 1.',
            'image_room.required' => 'Vui lòng chọn ảnh phòng.',
            'image_room.image' => 'File ảnh phòng không hợp lệ.',
            'image_room.mimes' => 'Ảnh phòng phải có định dạng jpeg, png, jpg, gif.',
            'image_room.max' => 'Ảnh phòng không được vượt quá 2MB.',
            'thumbnail.required' => 'Vui lòng chọn ảnh đại diện.',
            'thumbnail.image' => 'File ảnh đại diện không hợp lệ.',
            'thumbnail.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif.',
            'thumbnail.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        // Upload ảnh
        $imageRoomPath = $request->file('image_room')->store('rooms/image_room', 'public');
        $thumbnailPath = $request->file('thumbnail')->store('rooms/thumbnails', 'public');

        // Tạo phòng mới
        Room::create([
            'room_type_id' => $request->room_type_id,
            'title' => $request->title,
            'price' => $request->price,
            'max_people' => $request->max_people,
            'image_room' => $imageRoomPath,
            'thumbnail' => $thumbnailPath,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('room.index')->with('success', 'Thêm phòng thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $room = Room::with('roomType')->findOrFail($id);
            $roomTypes = RoomType::get();
            return view('admin.bookingrooms.rooms.editRoom', compact('room', 'roomTypes'));
        } catch (\Throwable $th) {
            return view('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_people' => 'required|integer|min:1',
            'image_room' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
        ], [
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng không hợp lệ.',
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá phòng.',
            'price.numeric' => 'Giá phòng phải là số.',
            'price.min' => 'Giá phòng không được nhỏ hơn 0.',
            'max_people.required' => 'Vui lòng nhập số người tối đa.',
            'max_people.integer' => 'Số người tối đa phải là số nguyên.',
            'max_people.min' => 'Số người tối đa ít nhất là 1.',
            'image_room.image' => 'File ảnh phòng không hợp lệ.',
            'image_room.mimes' => 'Ảnh phòng phải có định dạng jpeg, png, jpg, gif.',
            'image_room.max' => 'Ảnh phòng không được vượt quá 2MB.',
            'thumbnail.image' => 'File ảnh đại diện không hợp lệ.',
            'thumbnail.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif.',
            'thumbnail.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        try {
            $room = Room::findOrFail($id);
            $data = [
                'room_type_id' => $request->room_type_id,
                'title' => $request->title,
                'price' => $request->price,
                'max_people' => $request->max_people,
                'description' => $request->description,
                'status' => $request->status,
            ];

            // Xử lý upload ảnh phòng mới nếu có
            if ($request->hasFile('image_room')) {
                // Xóa ảnh cũ
                if ($room->image_room) {
                    Storage::disk('public')->delete($room->image_room);
                }
                $data['image_room'] = $request->file('image_room')->store('rooms/image_room', 'public');
            }

            // Xử lý upload thumbnail mới nếu có
            if ($request->hasFile('thumbnail')) {
                // Xóa thumbnail cũ
                if ($room->thumbnail) {
                    Storage::disk('public')->delete($room->thumbnail);
                }
                $data['thumbnail'] = $request->file('thumbnail')->store('rooms/thumbnails', 'public');
            }

            $room->update($data);

            return redirect()->route('room.index')->with('success', 'Cập nhật phòng thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật phòng');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
