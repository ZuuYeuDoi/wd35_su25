<?php

namespace App\Http\Controllers\Admin;

use App\Models\Amenitie;
use App\Models\RoomType;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::orderBy('id', 'desc')->paginate(10);
        return view('admin.bookingrooms.roomtypes.viewRoomType', compact('roomTypes'));
    }

    public function create()
    {
        $amenities = Amenitie::where('status', 1)->get();
        return view('admin.bookingrooms.roomtypes.createRoomType', compact('amenities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'bed_type' => 'required|string|max:255',
            'room_type_price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'amenities' => 'nullable|array',
            'amenities.*' => 'integer|exists:room_amenities,id'
        ]);

        $data = $request->only(['name', 'type', 'bed_type', 'room_type_price']);
        $data['amenities'] = $request->input('amenities', []);

        $roomType = RoomType::create($data);

        // Lưu album ảnh
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('room_types/album', 'public');
                RoomImage::create([
                    'room_type_id' => $roomType->id,
                    'image_path' => $path,
                    'order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('room_types.index')->with('success', 'Thêm loại phòng thành công');
    }

    public function show($id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('admin.bookingrooms.roomtypes.viewRoomType', compact('roomType'));
    }

    public function edit($id)
    {
        $roomType = RoomType::findOrFail($id);
        $amenities = Amenitie::where('status', 1)->get();
        return view('admin.bookingrooms.roomtypes.editRoomType', compact('roomType', 'amenities'));
    }

    public function update(Request $request, $id)
    {
        $roomType = RoomType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'bed_type' => 'required|string|max:255',
            'room_type_price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'amenities' => 'nullable|array',
            'amenities.*' => 'integer|exists:room_amenities,id'
        ]);

        $data = $request->only(['name', 'type', 'bed_type', 'room_type_price']);
        $data['amenities'] = $request->input('amenities', []);

        $roomType->update($data);

        // Lưu thêm ảnh mới (nếu có)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('room_types/album', 'public');
                RoomImage::create([
                    'room_type_id' => $roomType->id,
                    'image_path' => $path,
                    'order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('room_types.index')->with('success', 'Cập nhật loại phòng thành công');
    }

    public function destroy($id)
    {
        $roomType = RoomType::findOrFail($id);

        // Xóa ảnh chính nếu có
        if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
            Storage::disk('public')->delete($roomType->image);
        }

        // Xóa album ảnh
        foreach ($roomType->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        $roomType->delete();

        return redirect()->route('room_types.index')->with('success', 'Xóa loại phòng thành công');
    }
public function deleteImage($id)
{
    $image = RoomImage::findOrFail($id);

    // Xóa file trên ổ đĩa
    Storage::disk('public')->delete($image->image_path);

    // Xóa bản ghi trong DB
    $image->delete();

    // Trả về JSON nếu là request AJAX
    if (request()->expectsJson()) {
        return response()->json(['message' => 'Xóa ảnh thành công']);
    }

    // Ngược lại, fallback về redirect
    return back()->with('success', 'Xóa ảnh thành công');
}

}
