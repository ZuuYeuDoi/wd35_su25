<?php

namespace App\Http\Controllers;

use App\Models\Amenitie;
use App\Models\Room;
use Illuminate\Http\Request;

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
        //lấy danh sách phòng
        $rooms = Room::with(['images_room', 'roomType'])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Gom tất cả ID tiện ích từ các phòng
        $amenityIds = $rooms->pluck('amenities') // lấy danh sách các mảng JSON
            ->filter()                          // bỏ null
            ->flatten()                         // gộp thành mảng 1 chiều
            ->unique()                          // bỏ trùng
            ->toArray();                        // ép thành mảng thuần PHP

        // Lấy toàn bộ tiện ích liên quan
        $allAmenities = Amenitie::whereIn('id', $amenityIds)->get()->keyBy('id');

        return view('home', compact('rooms', 'allAmenities'));
    }

    public function indexRoom()
    {
        //lấy danh sách phòng
        $rooms = Room::with(['images_room', 'roomType'])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Gom tất cả ID tiện ích từ các phòng
        $amenityIds = $rooms->pluck('amenities') // lấy danh sách các mảng JSON
            ->filter()                          // bỏ null
            ->flatten()                         // gộp thành mảng 1 chiều
            ->unique()                          // bỏ trùng
            ->toArray();                        // ép thành mảng thuần PHP

        // Lấy toàn bộ tiện ích liên quan
        $allAmenities = Amenitie::whereIn('id', $amenityIds)->get()->keyBy('id');

        return view('client.room.index', compact('rooms', 'allAmenities'));
    }
    public function show($id)
    {
        $room = Room::with(['images_room', 'roomType'])->findOrFail($id);

        // Lấy danh sách tiện ích của phòng
        $amenityIds = collect($room->amenities)->filter()->unique()->toArray();
        $allAmenities = Amenitie::whereIn('id', $amenityIds)->get();

        // Lấy các phòng cùng loại (trừ phòng hiện tại)
        $relatedRooms = Room::with('images_room')
            ->where('room_type_id', $room->room_type_id)
            ->where('id', '!=', $room->id)
            ->where('status', 1)
            ->take(3)
            ->get();

        return view('client.room.detail', compact('room', 'allAmenities', 'relatedRooms'));
    }

}
