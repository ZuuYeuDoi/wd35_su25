<?php

namespace App\Http\Controllers;

use App\Models\Amenitie;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('roomType')->orderBy('created_at', 'desc')->get();
        return view('admin.bookingrooms.rooms.rooms', compact('rooms'));
    }
   public function map(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate   = $request->input('end_date');
     $rooms = Room::with('roomType')
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->get();
    return view('admin.bookingrooms.rooms.room-map', compact('rooms', 'startDate', 'endDate'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTypes = RoomType::get();
        $amenities = Amenitie::where('status', 1)->get();
        return view('admin.bookingrooms.rooms.createRoom', compact('roomTypes', 'amenities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->amenities);
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_people' => 'required|integer|min:1',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
            'image_room' => 'required|array|min:1',
            'image_room.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'amenities' => 'required|array',
            'amenities.*' => 'integer|exists:amenities,id',
        ], [
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng không hợp lệ.',
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá phòng.',
            'price.numeric' => 'Giá phòng phải là số.',
            'price.min' => 'Giá phòng không được nhỏ hơn 0.',
            'max_people.required' => 'Vui lòng nhập số giường.',
            'max_people.integer' => 'Số giường tối đa phải là số nguyên.',
            'max_people.min' => 'Số giường tối đa ít nhất là 1.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'image_room.required' => 'Vui lòng chọn ít nhất một ảnh.',
            'image_room.array' => 'Dữ liệu ảnh không hợp lệ.',
            'image_room.*.image' => 'Tất cả file phải là hình ảnh.',
            'image_room.*.mimes' => 'Ảnh phải thuộc định dạng jpeg, png, jpg, gif, webp.',
            'image_room.*.max' => 'Kích thước ảnh không vượt quá 2MB.',
            'amenities.required' => 'Vui lòng chọn ít nhất một tiện ích.',
            'amenities.*.exists' => 'Tiện ích không hợp lệ.',
        ]);

        try {
            // Tạo phòng mới
            $room = Room::create([
                'room_type_id' => $request->room_type_id,
                'title' => $request->title,
                'price' => $request->price,
                'max_people' => $request->max_people,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            // Upload & lưu ảnh vào bảng room_images
            if ($request->hasFile('image_room')) {
                foreach ($request->file('image_room') as $key => $file) {
                    $path = $file->store('rooms/image_room', 'public');

                    RoomImage::create([
                        'room_id' => $room->id,
                        'image_path' => $path,
                        'order' => $key + 1,
                    ]);
                }
            }
            return redirect()->route('room.index')->with('success', 'Thêm phòng thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm phòng thất bại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $room = Room::with('roomType')->findOrFail($id);
            return view('admin.bookingrooms.rooms.showRoom', compact('room'));
        } catch (\Throwable $th) {
            return view('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $room = Room::with(['roomType', 'images_room'])->findOrFail($id);
            $roomTypes = RoomType::get();
            $amenities = Amenitie::where('status', 1)->get();
            $room->amenities = $room->amenities ? json_decode($room->amenities, true) : [];
            // dd($room->images_room);
            return view('admin.bookingrooms.rooms.editRoom', compact('room', 'roomTypes', 'amenities'));
        } catch (\Throwable $th) {
            return view('errors.404');
        }
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
            'image_room' => 'nullable|array',
            'image_room.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
            'amenities' => 'required|array',
        ], [
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng không hợp lệ.',
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá phòng.',
            'price.numeric' => 'Giá phòng phải là số.',
            'price.min' => 'Giá phòng không được nhỏ hơn 0.',
            'max_people.required' => 'Vui lòng nhập số giường.',
            'max_people.integer' => 'Số giường tối đa phải là số nguyên.',
            'max_people.min' => 'Số giường tối đa ít nhất là 1.',
            'image_room.array' => 'Dữ liệu ảnh không hợp lệ.',
            'image_room.*.image' => 'Tất cả file phải là hình ảnh.',
            'image_room.*.mimes' => 'Ảnh phải thuộc định dạng jpeg, png, jpg, gif, webp.',
            'image_room.*.max' => 'Kích thước ảnh không vượt quá 2MB.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'amenities.required' => 'Vui lòng chọn tiện ích.',
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
                'amenities' => json_encode($request->amenities),
            ];

            // Xử lý upload ảnh phòng mới nếu có
            if ($request->hasFile('image_room')) {
                // Xóa ảnh cũ
                foreach ($room->images_room as $oldImage) {
                    Storage::disk('public')->delete($oldImage->image_path);
                    $oldImage->delete();
                }

                // Upload ảnh mới
                foreach ($request->file('image_room') as $key => $file) {
                    $path = $file->store('rooms/image_room', 'public');
                    RoomImage::create([
                        'room_id' => $room->id,
                        'image_path' => $path,
                        'order' => $key + 1,
                    ]);
                }
            }

            $room->update($data);

            return redirect()->route('room.index')->with('success', 'Cập nhật phòng thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sửa thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('room.index')->with('success', 'xóa phòng thành công');

    }

    public function trash()
    {
        $rooms = Room::onlyTrashed()->with('roomType')->orderBy('deleted_at', 'desc')->paginate(10);
        return view('admin.bookingrooms.rooms.trashRoom', compact('rooms'));
    }

    public function restore($id)
    {
        $room = Room::onlyTrashed()->findOrFail($id);
        $room->restore();
        return redirect()->route('room.trash')->with('success', 'Khôi Phục thành công');
    }
    public function forceDelete($id)
    {
        $room = Room::onlyTrashed()->findOrFail($id);
        if ($room->image_room) {
            Storage::disk('public')->delete($room->image_room);
        }
        if ($room->thumbnail) {
            Storage::disk('public')->delete($room->thumbnail);
        }
        $room->forceDelete();

        return redirect()->route('room.trash')->with('success', 'xóa phòng vĩnh viễn thành công');
    }
}
