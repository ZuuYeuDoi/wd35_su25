<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\Room;
use App\Models\Amenitie;
use App\Models\RoomType;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
    $checkIn   = $request->input('check_in');
    $checkOut  = $request->input('check_out');
    $stayType  = $request->input('stay_type', 'overnight');
    // $adults    = (int) $request->input('adults', 0);
    // $children  = (int) $request->input('children', 0);
    // $childAges = $request->input('children_ages', []);

    $status = $request->input('status');

    $query = Room::with('roomType');

    if ($status !== null && $status !== '') {
        $query->where('status', $status); 
    }

    // $requiredBeds = $adults;
    // foreach ($childAges as $age) {
    //     $age = (int) $age;
    //     if ($age >= 12) {
    //         $requiredBeds += 1; 
    //     } elseif ($age >= 1) {
    //         $requiredBeds += 0.5; 
    //     }
    // }

    if ($checkIn) {
        try {
            $startDate = Carbon::createFromFormat('d/m/Y', $checkIn)->startOfDay();

            if ($stayType === 'dayuse') {

                $query->whereDate('created_at', $startDate);
            } elseif ($checkOut) {
                $endDate = Carbon::createFromFormat('d/m/Y', $checkOut)->endOfDay();


                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate])
                      ->orWhereBetween('updated_at', [$startDate, $endDate]);
                });
            }
        } catch (\Exception $e) {

        }
    }


    // if ($requiredBeds > 0) {
    //     $query->where('max_people', '>=', ceil($requiredBeds));
    // }

    $rooms = $query->get();

    return view('admin.bookingrooms.rooms.room-map', [
        'rooms' => $rooms,
        'startDate' => $checkIn,
        'endDate' => $checkOut,
        // 'adults' => $adults,
        // 'children' => $children,
        // 'childAges' => $childAges,
        'stayType' => $stayType
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTypes = RoomType::all();
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
            // 'max_people' => 'required|integer|min:1',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
            'image_room' => 'required|array|min:1',
            'image_room.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'amenities' => 'required|array',
            'amenities.*' => 'integer|exists:room_amenities,id',
        ], [
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng không hợp lệ.',
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá phòng.',
            'price.numeric' => 'Giá phòng phải là số.',
            'price.min' => 'Giá phòng không được nhỏ hơn 0.',
            // 'max_people.required' => 'Vui lòng nhập số giường.',
            // 'max_people.integer' => 'Số giường tối đa phải là số nguyên.',
            // 'max_people.min' => 'Số giường tối đa ít nhất là 1.',
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
                // 'max_people' => $request->max_people,
                'description' => $request->description,
                'status' => $request->status,
                'amenities' => $request->input('amenities')
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
            $room = Room::with('roomType', 'images_room')->findOrFail($id);
            //  $amenityList = Amenitie::whereIn('id', $room->amenities ?? [])->get();
            $amenityList = Amenitie::whereIn('id', (array) $room->amenities)->get();

            // dd($amenityList);

            return view('admin.bookingrooms.rooms.showRoom', compact('room', 'amenityList'));
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
        $roomTypes = RoomType::all();
        $amenities = Amenitie::where('status', 1)->get();
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
            // 'max_people' => 'required|integer|min:1',
            'image_room' => 'nullable|array',
            'image_room.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10220',
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
            // 'max_people.required' => 'Vui lòng nhập số giường.',
            // 'max_people.integer' => 'Số giường tối đa phải là số nguyên.',
            // 'max_people.min' => 'Số giường tối đa ít nhất là 1.',
            'image_room.array' => 'Dữ liệu ảnh không hợp lệ.',
            'image_room.*.image' => 'Tất cả file phải là hình ảnh.',
            'image_room.*.mimes' => 'Ảnh phải thuộc định dạng jpeg, png, jpg, gif, webp.',
            'image_room.*.max' => 'Kích thước ảnh không vượt quá 10MB.',
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
                // 'max_people' => $request->max_people,
                'description' => $request->description,
                'status' => $request->status,
                'amenities' => $request->amenities, 
            ];

            // Xử lý upload ảnh phòng mới nếu có
            if ($request->hasFile('image_room')) {
            $lastOrder = RoomImage::where('room_id', $room->id)->max('order') ?? 0;

            foreach ($request->file('image_room') as $index => $file) {
                $path = $file->store('rooms/image_room', 'public');
                RoomImage::create([
                    'room_id' => $room->id,
                    'image_path' => $path,
                    'order' => $lastOrder + $index + 1,
                ]);
            }
        }

            $room->update($data);

            return redirect()->route('room.index')->with('success', 'Cập nhật phòng thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sửa thất bại');
        }
    }

    public function deleteImage($id)
{
    try {
        $image = RoomImage::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false], 500);
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