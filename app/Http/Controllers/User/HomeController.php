<?php

namespace App\Http\Controllers\User;

use App\Models\Room;
use App\Models\Amenitie;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
        $roomTypes = RoomType::with(['rooms' => function ($query) {
            $query->with('images_room', 'roomType')->where('status', 1)->latest()->take(3);
        }])->get();

        $allRooms = $roomTypes->pluck('rooms')->flatten();
        $amenityIds = $allRooms->pluck('amenities')->filter()->flatten()->unique()->toArray();
        $allAmenities = Amenitie::whereIn('id', $amenityIds)->get()->keyBy('id');

        return view('home', compact('roomTypes', 'allAmenities'));
    }

    public function indexRoom(Request $request)
    {
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');
        $adults = (int) $request->input('adults', 0);
        $children = (int) $request->input('children', 0);
        $childAges = $request->input('child_ages', []);

        $isSearching = $checkIn || $checkOut || ($adults > 0 || $children > 0);

        $roomTypesQuery = RoomType::with(['rooms' => function ($query) use ($isSearching, $adults, $childAges) {
            $query->with(['images_room', 'roomType'])->where('status', 1);

            if ($isSearching) {
                $totalPeople = $adults;
                $under6Count = 0;
                $under12Count = 0;

                foreach ($childAges as $age) {
                    $age = (int) $age;
                    if ($age < 6) {
                        $under6Count++;
                    } elseif ($age < 12) {
                        $under12Count++;
                    } else {
                        $totalPeople++;
                    }
                }
                if ($under6Count > 1) {
                    $totalPeople += ($under6Count - 1);
                }
                $query->where('max_people', '>=', $totalPeople)->orderBy('price', 'asc');
            } else {
                $query->orderBy('created_at', 'desc');
            }
        }]);

        $roomTypes = $roomTypesQuery->get();

        $allRooms = $roomTypes->pluck('rooms')->flatten();
        $amenityIds = $allRooms->pluck('amenities')->filter()->flatten()->unique()->toArray();
        $allAmenities = Amenitie::whereIn('id', $amenityIds)->get()->keyBy('id');


        return view('client.room.index', compact('roomTypes', 'allAmenities', 'checkIn', 'checkOut', 'adults', 'children', 'childAges'));
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
