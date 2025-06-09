<?php

namespace App\Http\Controllers;

use App\Models\Amenitie;
use App\Models\RoomType;
use Illuminate\Http\Request;
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
        return view('admin.bookingrooms.roomtypes.createRoomType',compact('amenities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'room_type_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|array',
            'amenities.*' => 'integer|exists:room_amenities,id'

        ]);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('room_types', 'public');
            
        }

        $data = $request->only(['name', 'type', 'room_type_price', 'image']);

        $data['amenities'] = $request->input('amenities', []);

        RoomType::create($data);


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
            'room_type_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|array',
            'amenities,*' => 'interger|exist: room_amenities,id'
        ]);

        $data = $request->only(['name', 'type', 'room_type_price']);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
                Storage::disk('public')->delete($roomType->image);
            }

            $data['image'] = $request->file('image')->store('room_types', 'public');
        }

        $data['amenities'] = $request->input('amenities', []);

        $roomType->update($data);

        return redirect()->route('room_types.index')->with('success', 'Cập nhật loại phòng thành công');
    }

    public function destroy($id)
    {
        $roomType = RoomType::findOrFail($id);

        // Xóa ảnh nếu có
        if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
            Storage::disk('public')->delete($roomType->image);
        }

        $roomType->delete();

        return redirect()->route('room_types.index')->with('success', 'Xóa loại phòng thành công');
    }
}
