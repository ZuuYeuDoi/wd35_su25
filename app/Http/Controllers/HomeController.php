<?php

namespace App\Http\Controllers;

use App\Models\Amenitie;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function indexRoom(Request $request)
    {
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');
        $adults = (int) $request->input('adults', 0);
        $children = (int) $request->input('children', 0);
        $childAges = $request->input('child_ages', []);

        $isSearching = $checkIn || $checkOut || ($adults > 0 || $children > 0);

        if ($isSearching) {
            // Tính tổng người thực tế để lọc phòng
            $totalPeople = $adults;
            $under6Count = 0;
            $under12Count = 0;

            foreach ($childAges as $index => $age) {
                $age = (int) $age;
                if ($age < 6) {
                    $under6Count++;
                } elseif ($age < 12) {
                    $under12Count++;
                } else {
                    $totalPeople++; // Trẻ >=12 tuổi tính như người lớn
                }
            }

            if ($under6Count > 1) {
                $totalPeople += ($under6Count - 1); // Trẻ dưới 6 tuổi từ thứ 2 tính như người lớn
            }

            // Tìm phòng phù hợp
            $rooms = Room::with(['images_room', 'roomType'])
                ->where('status', 1)
                ->where('max_people', '>=', $totalPeople)
                ->orderBy('price', 'asc')
                ->get();
        } else {
            // Load mặc định (không tìm kiếm)
            $rooms = Room::with(['images_room', 'roomType'])
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        }


        // dd($request->all(), $rooms);

        // Gom tất cả ID tiện ích từ các phòng
        $amenityIds = $rooms->pluck('amenities')
            ->filter()
            ->flatten()
            ->unique()
            ->toArray();

        // Lấy tiện ích
        $allAmenities = Amenitie::whereIn('id', $amenityIds)->get()->keyBy('id');

        return view('client.room.index', compact('rooms', 'allAmenities', 'checkIn', 'checkOut', 'adults', 'children', 'childAges'));
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