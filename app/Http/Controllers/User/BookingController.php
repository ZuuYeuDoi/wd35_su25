<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Amenitie;
use App\Models\RoomType;
use App\Models\BookingRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * ✅ Thêm một loại phòng vào giỏ booking
     */
    public function addToCart(Request $request)
{
    $data = $request->validate([
        'room_type_id'    => 'required|exists:room_types,id',
        'check_in'        => 'required|date|after_or_equal:today',
        'check_out'       => 'required|date|after:check_in',
        'number_of_rooms' => 'required|integer|min:1',
        'adults'          => 'required|integer|min:1',
        'children'        => 'required|integer|min:0',
    ]);

    $cart = session()->get('booking_cart', []);

    // ✅ Nếu giỏ đã có phòng, fix ngày theo phòng đầu tiên
    if (!empty($cart)) {
        $first = $cart[0];
        if ($data['check_in'] !== $first['check_in'] || $data['check_out'] !== $first['check_out']) {
            return back()->with('error', 'Ngày nhận/trả phải giống các phòng đã chọn trước đó.');
        }
    }

    $cart[] = $data;
    session(['booking_cart' => $cart]);

    if ($request->input('action') === 'checkout') {
        return redirect()->route('booking.cart.view');
    }

    return redirect()->route('room.indexRoom')->with('success', 'Đã thêm loại phòng vào giỏ booking.');
}

/**
 * Xóa 1 item khỏi giỏ
 */
public function removeCartItem($index)
{
    $cart = session('booking_cart', []);
    if (isset($cart[$index])) {
        unset($cart[$index]);
        session(['booking_cart' => array_values($cart)]);
    }
    return back()->with('success', 'Đã xóa phòng khỏi giỏ.');
}


    /**
     * ✅ Hiển thị giỏ booking (trang checkout tạm)
     */
    public function viewCart()
    {
        $cart = session('booking_cart', []);
        if (empty($cart)) {
            return redirect()->route('room.index')->with('error', 'Bạn chưa chọn phòng nào.');
        }

        $summary = collect($cart)->map(function ($item) {
            $roomType = RoomType::find($item['room_type_id']);
            $ci = Carbon::parse($item['check_in']);
            $co = Carbon::parse($item['check_out']);
            $nights = max($ci->diffInDays($co), 1);
            return [
                'room_type' => $roomType,
                'check_in'  => $item['check_in'],
                'check_out' => $item['check_out'],
                'qty'       => $item['number_of_rooms'],
                'adults'    => $item['adults'],
                'children'  => $item['children'],
                'sub_total' => $item['number_of_rooms'] * $nights * $roomType->room_type_price,
            ];
        });

        $total = $summary->sum('sub_total');

        return view('client.checkout.cart', compact('summary', 'total'));
    }

    /**
     * ✅ Lưu booking từ giỏ
     */
    public function storeCartBooking(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt phòng.');
    }

    $cart = session('booking_cart', []);
    if (empty($cart)) {
        return redirect()->route('room.index')->with('error', 'Giỏ booking trống.');
    }

    $user = Auth::user();
    $bookingCode = $this->generateBookingCode();

    $checkInMin = Carbon::parse(min(array_column($cart, 'check_in')));
    $checkOutMax = Carbon::parse(max(array_column($cart, 'check_out')));

    $booking = Booking::create([
        'booking_code'   => $bookingCode,
        'user_id'        => $user->id,
        'check_in_date'  => $checkInMin,
        'check_out_date' => $checkOutMax,
        'status'         => 0,
        'adults'         => array_sum(array_column($cart, 'adults')),
        'children'       => array_sum(array_column($cart, 'children')),
        'deposit'        => 0,
        'total_amount'   => 0,
    ]);

    $grandTotal = 0;

    foreach ($cart as $item) {
        $ci = Carbon::parse($item['check_in']);
        $co = Carbon::parse($item['check_out']);
        $nights = max($ci->diffInDays($co), 1);
        $qty = $item['number_of_rooms'];

        $rooms = $this->getAvailableRooms($item['room_type_id'], $ci, $co, $qty);

        foreach ($rooms as $room) {
            BookingRoom::create([
                'booking_id'     => $booking->id,
                'room_id'        => $room->id,
                'check_in_date'  => $ci,
                'check_out_date' => $co,
                'price'          => $room->price,
            ]);
            $grandTotal += $room->price * $nights;
        }
    }

    // dd($rooms);

    // ✅ Tính tiền đặt cọc = 10%
    $deposit = round($grandTotal * 0.1);

    $booking->update([
        'total_amount' => $grandTotal,
        'deposit' => $deposit,
    ]);


    // Xóa session giỏ
    // session()->forget('booking_cart');

    // ✅ Truyền đúng deposit sang auto_submit
    return view('client.payments.auto_submit', [
        'booking_id' => $booking->id,
        'amount'     => $deposit
    ]);
}

    /**
     * ✅ Lấy phòng trống theo loại
     */
 private function getAvailableRooms($roomTypeId, $checkIn, $checkOut, $limit = null)
{
    // Danh sách phòng thuộc loại
    $roomIds = Room::where('room_type_id', $roomTypeId)
        ->where('status', 1)
        ->pluck('id');

    if ($roomIds->isEmpty()) return collect();

    // Lấy phòng đã được đặt có overlap ngày
    $bookedRoomIds = BookingRoom::whereIn('room_id', $roomIds)
        ->where(function ($q) use ($checkIn, $checkOut) {
            $q->where(function ($sub) use ($checkIn, $checkOut) {
                $sub->where('check_in_date', '<', $checkOut)
                    ->where('check_out_date', '>', $checkIn);
            });
        })
        ->pluck('room_id');

    // Lọc ra phòng còn trống
    $availableQuery = Room::where('room_type_id', $roomTypeId)
        ->where('status', 1)
        ->whereNotIn('id', $bookedRoomIds);

    return $limit ? $availableQuery->limit($limit)->get() : $availableQuery->get();
}



    /**
     * ✅ Sinh mã booking
     */
    private function generateBookingCode()
    {
        $date = Carbon::now()->format('Ymd');
        $random = mt_rand(1000, 9999);
        return "BK-{$date}-{$random}";
    }

    public function showFinalCheckout()
{
    $cart = session('booking_cart', []);
    if (empty($cart)) {
        return redirect()->route('room.index')->with('error', 'Giỏ booking trống.');
    }

    $user = Auth::user();
    $summary = collect($cart)->map(function ($item) {
        $type = RoomType::find($item['room_type_id']);
        $ci = Carbon::parse($item['check_in']);
        $co = Carbon::parse($item['check_out']);
        $nights = max($ci->diffInDays($co), 1);
        return [
            'room_type' => $type,
            'check_in'  => $item['check_in'],
            'check_out' => $item['check_out'],
            'qty'       => $item['number_of_rooms'],
            'adults'    => $item['adults'],
            'children'  => $item['children'],
            'sub_total' => $item['number_of_rooms'] * $nights * $type->room_type_price,
        ];
    });

    $checkIn = $cart[0]['check_in'];
    $checkOut = $cart[0]['check_out'];
    $total = $summary->sum('sub_total');
    $deposit = round($total * 0.1);
    $totalAdults = $summary->sum('adults');
    $totalChildren = $summary->sum('children');

    return view('client.checkout.index', compact('summary', 'total', 'deposit', 'checkIn', 'checkOut', 'user', 'totalAdults', 'totalChildren'));
}

public function suggestTours()
{
     $roomTypes = RoomType::whereHas('rooms', function ($query) {
        $query->where('status', 1);
    })->get();
    return view('client.tours.index', compact('roomTypes'));
}

public function searchTours(Request $request)
{
    $request->validate([
        'check_in'            => 'required|date|after_or_equal:today',
        'check_out'           => 'required|date|after:check_in',
        'preferred_room_type' => 'required|exists:room_types,type', // ✅ sửa lại để kiểm tra theo type
        'adults'              => 'required|integer|min:1',
        'children'            => 'required|integer|min:0',
    ]);

    $checkIn = Carbon::parse($request->check_in);
    $checkOut = Carbon::parse($request->check_out);
    $nights = max($checkIn->diffInDays($checkOut), 1);

    // ✅ Tìm theo type
    $preferredType = RoomType::where('type', $request->preferred_room_type)->firstOrFail();

    $allRoomTypes = RoomType::whereHas('rooms', fn($q) => $q->where('status', 1))->with('rooms')->get();

    $totalPeople = $request->adults + $request->children;

    $result = [];

    foreach ($allRoomTypes as $roomType) {
        $availableRooms = $this->getAvailableRooms($roomType->id, $checkIn, $checkOut);

        if ($availableRooms->isEmpty()) continue;

        $capacity = ($roomType->max_adult ?? 2) + ($roomType->max_children ?? 0);
        if ($capacity <= 0) $capacity = 1;

        $roomsNeeded = ceil($totalPeople / $capacity);
        if ($availableRooms->count() < $roomsNeeded) continue;

        $subTotal = $roomsNeeded * $roomType->room_type_price * $nights;

        $result[] = [
            'room_type' => $roomType,
            'rooms_needed' => $roomsNeeded,
            'sub_total' => $subTotal,
            'services' => $roomType->services ?? [],
        ];
    }

    return view('client.tours.index', [
        'roomTypes'    => RoomType::whereHas('rooms', fn($q) => $q->where('status', 1))->get(),
        'preferred'    => $preferredType,
        'combinations' => $result,
        'check_in'     => $request->check_in,
        'check_out'    => $request->check_out,
        'adults'       => $request->adults,
        'children'     => $request->children,
        'nights'       => $nights,
        'allAmenities' => Amenitie::all()->keyBy('id'),
    ]);
}



public function addTourToCart(Request $request)
{
    $request->validate([
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
        'adults' => 'required|integer|min:1',
        'children' => 'required|integer|min:0',
        'rooms' => 'required|array',
        'rooms.*.room_type_id' => 'required|exists:room_types,id',
        'rooms.*.qty' => 'required|integer|min:1',
    ]);

    $cart = [];

    foreach ($request->rooms as $roomData) {
        $cart[] = [
            'room_type_id'    => $roomData['room_type_id'],
            'number_of_rooms' => $roomData['qty'],
            'check_in'        => $request->check_in,
            'check_out'       => $request->check_out,
            'adults'          => $request->adults,
            'children'        => $request->children,
        ];
    }

    session(['booking_cart' => $cart]);

    return redirect()->route('booking.cart.view')->with('success', 'Đã thêm tour vào giỏ đặt phòng.');
}


}
