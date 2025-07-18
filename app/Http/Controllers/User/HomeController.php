<?php

namespace App\Http\Controllers\User;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Amenitie;
use App\Models\RoomType;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BookingRoom;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       // Lấy tất cả RoomType cùng phòng + ảnh
    $roomTypes = RoomType::with(['rooms.images_room'])->get();

    // Nhóm theo type (ví dụ: Standard, Deluxe...)
    $groupedRoomTypes = $roomTypes->groupBy('type');

    // Lấy các ID tiện nghi để load 1 lần
        $amenityIds = $roomTypes->pluck('amenities')
            ->filter() // loại bỏ null
            ->flatMap(function ($item) {
                // $item có thể là JSON string hoặc array → ép về array
                return is_array($item) ? $item : json_decode($item, true);
            })
            ->unique()
            ->toArray();

    // Lấy toàn bộ tiện nghi và keyBy theo ID
    $allAmenities = Amenitie::whereIn('id', $amenityIds)->get()->keyBy('id');

        return view('home', compact('groupedRoomTypes', 'allAmenities'));
    }



public function indexRoom(Request $request)
{
    // Chỉ lấy 1 phòng đầu tiên cho mỗi RoomType
    $roomTypes = RoomType::with([
        'rooms' => function ($q) {
            $q->where('status', 1)->limit(1)->with('images_room');
        }
    ])->get();

    // Nhóm theo type (Deluxe, Standard,...)
    $groupedRoomTypes = $roomTypes->groupBy('type');

    // Xử lý tiện nghi
    $amenityIds = $roomTypes->pluck('amenities')
        ->filter()
        ->flatMap(function ($item) {
            return is_array($item) ? $item : json_decode($item, true);
        })
        ->unique()
        ->toArray();

    $allAmenities = Amenitie::whereIn('id', $amenityIds)->get()->keyBy('id');

    return view('client.room.index', compact('groupedRoomTypes', 'allAmenities'));
}


public function getAvailableRoomsCount($roomTypeId, $checkIn, $checkOut)
{
    // Lấy ID các phòng thuộc loại này
    $rooms = Room::where('room_type_id', $roomTypeId)->pluck('id');

    // Tìm các phòng đã được đặt trong khoảng thời gian đó
    $bookedRoomIds = BookingRoom::whereIn('room_id', $rooms)
        ->where(function ($query) use ($checkIn, $checkOut) {
            $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                  ->orWhere(function ($query2) use ($checkIn, $checkOut) {
                      $query2->where('check_in_date', '<', $checkIn)
                             ->where('check_out_date', '>', $checkOut);
                  });
        })
        ->pluck('room_id');

    // Trả về số lượng phòng còn trống
    return Room::where('room_type_id', $roomTypeId)
        ->where('status', 1)
        ->whereNotIn('id', $bookedRoomIds)
        ->count();
}


public function showRoomType($id, Request $request)
{
    $roomType = RoomType::with([
    'images',
    'rooms' => function ($q) {
        $q->with('images_room');
    }])->findOrFail($id);

    $amenityIds = collect($roomType->amenities)->filter()->unique()->toArray();
    $allAmenities = Amenitie::whereIn('id', $amenityIds)->get();

    $checkIn = $request->check_in ?? now()->format('Y-m-d');
    $checkOut = $request->check_out ?? now()->addDay()->format('Y-m-d');

    $availableRoomsCount = $this->getAvailableRoomsCount($roomType->id, $checkIn, $checkOut);

    // ✅ Thêm phần lấy đúng phòng
    $roomId = $request->room_id;
    $room = null;

    if ($roomId) {
        $room = $roomType->rooms->firstWhere('id', $roomId);
    }

    // Nếu không có room_id hoặc không tìm được → lấy phòng đầu tiên
    $room = $room ?? $roomType->rooms->first();

    $reviews = $room
    ? Review::where('room_id', $room->id)
        ->where('status', true) // Chỉ lấy review được hiển thị
        ->with('user')
        ->latest()
        ->get()
    : collect();
    $canReview = false;
    if (auth()->check()) {
        $canReview = Booking::where('user_id', auth()->id())
            ->where('status', 4) 
            ->whereHas('rooms', function ($q) use ($room) {
                $q->where('rooms.id', $room->id);
            })
            ->exists();
    }
        return view('client.room.detail', compact(
            'roomType',
            'allAmenities',
            'checkIn',
            'checkOut',
            'availableRoomsCount',
            'room',
            'reviews',
            'canReview'
        ));
    }


public function showRoom($id, Request $request)
{
    $room = Room::with(['images_room', 'roomType'])->findOrFail($id);
    
    $roomType = $room->roomType;

    // Lấy tiện nghi của loại phòng
   $amenityIds = collect($room->amenities)->filter()->unique()->toArray();
    $allAmenities = Amenitie::whereIn('id', $amenityIds)->get();

    // Lấy ngày check-in / check-out mặc định
    $checkIn = $request->check_in ?? now()->format('Y-m-d');
    $checkOut = $request->check_out ?? now()->addDay()->format('Y-m-d');

    // Tính số lượng phòng còn trống
    $availableRoomsCount = $this->getAvailableRoomsCount($roomType->id, $checkIn, $checkOut);

    // Lấy danh sách đánh giá
    $reviews = Review::where('room_id', $room->id)
    ->where('status', true) // Chỉ lấy review được hiển thị
    ->with('user')
    ->latest()
    ->get();


 
    $canReview = false;
    if (auth()->check()) {
        $canReview = Booking::where('user_id', auth()->id())
            ->where('status', 4) 
            ->whereHas('rooms', function ($q) use ($room) {
                $q->where('rooms.id', $room->id);
            })
            ->exists();
    }

    return view('client.room.detail', compact(
        'room',
        'roomType',
        'allAmenities',
        'checkIn',
        'checkOut',
        'availableRoomsCount',
        'reviews',
        'canReview' 
    ));
}



public function checkAvailableRoom(Request $request)
{
    try {
        $roomTypeId = $request->room_type_id;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        if (!$roomTypeId || !$checkIn || !$checkOut) {
            return response()->json([
                'status' => false,
                'message' => 'Thiếu dữ liệu'
            ]);
        }

        $available = $this->getAvailableRoomsCount($roomTypeId, $checkIn, $checkOut);

        return response()->json([
            'status' => true,
            'available' => $available
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Lỗi server: ' . $e->getMessage()
        ]);
    }
}

}