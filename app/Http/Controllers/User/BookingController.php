<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomType;
use App\Models\BookingRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
  public function index(Request $request)
{
    // Yêu cầu đăng nhập
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục đặt phòng.');
    }

    // Validate input ngày
    $request->validate([
        'checkin_date' => 'required|date',
        'checkout_date' => 'required|date|after_or_equal:checkin_date',
    ], [
        'checkin_date.required' => 'Chọn ngày nhận phòng.',
        'checkout_date.required' => 'Chọn ngày trả phòng.',
        'checkout_date.after_or_equal' => 'Ngày trả phòng phải sau hoặc cùng ngày nhận phòng.',
    ]);

    $user = Auth::user();
    $roomIds = $request->input('room_ids', []);

    if (empty($roomIds)) {
        return redirect()->route('home')->with('error', 'Vui lòng chọn phòng để tiếp tục.');
    }

    // Lấy danh sách phòng
    $rooms = Room::with('images_room', 'roomType')
                ->whereIn('id', $roomIds)
                ->get();

    if ($rooms->isEmpty()) {
        return redirect()->route('home')->with('error', 'Không tìm thấy phòng bạn chọn.');
    }

    // Xử lý ngày nhận - trả phòng
    $checkin = Carbon::parse($request->input('checkin_date'));
    $checkout = Carbon::parse($request->input('checkout_date'));

    // Nếu cùng ngày -> tính là 1 đêm
    $numberOfNights = max($checkin->diffInDays($checkout), 1);

    // Tổng tiền = tổng giá phòng * số đêm
    $totalPrice = $rooms->sum(function ($room) use ($numberOfNights) {
        return $room->price * $numberOfNights;
    });

    $bookingCode = $this->generateBookingCode();

    // Booking giả tạm để hiển thị
    $booking = new \stdClass();
    $booking->id = null;
    $booking->total_price = $totalPrice;

    return view('client.checkout.index', [
        'user' => $user,
        'data' => [
            'checkin_date' => $checkin->format('Y-m-d'),
            'checkout_date' => $checkout->format('Y-m-d'),
        ],
        'rooms' => $rooms,
        'totalPrice' => $totalPrice,
        'numberOfNights' => $numberOfNights,
        'bookingCode' => $bookingCode,
        'booking' => $booking,
    ]);
}

    public function checkout(Request $request)
{
    $data = $request->validate([
        'room_type_id' => 'required|exists:room_types,id',
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'number_of_rooms' => 'required|integer|min:1',
        'adults' => 'required|integer|min:1',
        'children' => 'required|integer|min:0',
    ]);

    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục đặt phòng.');
    }

    $bookingCode = $this->generateBookingCode();

    // Lưu dữ liệu vào session để dùng ở bước GET
    session([
        'booking_data' => $data,
        'booking_code' => $bookingCode
    ]);

    return redirect()->route('booking.checkout.view');
}

public function showCheckoutPage()
{
    $data = session('booking_data');
    $bookingCode = session('booking_code');

    if (!$data || !$bookingCode) {
        return redirect()->route('room.index')->with('error', 'Dữ liệu đặt phòng không hợp lệ.');
    }

    $user = Auth::user();
    $roomType = RoomType::findOrFail($data['room_type_id']);
    $checkIn = Carbon::parse($data['check_in']);
    $checkOut = Carbon::parse($data['check_out']);
    $numberOfNights = $checkIn->diffInDays($checkOut);
    $pricePerRoom = $roomType->room_type_price;
    $totalPrice = $data['number_of_rooms'] * $numberOfNights * $pricePerRoom;

    return view('client.checkout.index', [
        'user' => $user,
        'roomType' => $roomType,
        'checkIn' => $checkIn->toDateString(),
        'checkOut' => $checkOut->toDateString(),
        'numberOfRooms' => $data['number_of_rooms'],
        'adults' => $data['adults'],
        'children' => $data['children'],
        'pricePerRoom' => $pricePerRoom,
        'numberOfNights' => $numberOfNights,
        'totalPrice' => $totalPrice,
        'data' => $data,
        'bookingCode' => $bookingCode,
    ]);
}
     private function getAvailableRooms($roomTypeId, $checkIn, $checkOut, $limit = null)
    {
        $roomIds = Room::where('room_type_id', $roomTypeId)
            ->where('status', 1)
            ->pluck('id');

        $bookedRoomIds = BookingRoom::whereIn('room_id', $roomIds)
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                      ->orWhere(function ($q) use ($checkIn, $checkOut) {
                          $q->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                      });
            })
            ->pluck('room_id');

        $availableQuery = Room::where('room_type_id', $roomTypeId)
            ->where('status', 1)
            ->whereNotIn('id', $bookedRoomIds);

        return $limit ? $availableQuery->limit($limit)->get() : $availableQuery->get();
    }

   public function store(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
    }

    $data = $request->validate([
        'room_type_id' => 'required|exists:room_types,id',
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'number_of_rooms' => 'required|integer|min:1',
        'adults' => 'required|integer|min:1',
        'children' => 'required|integer|min:0',
        'deposit' => 'required|numeric|min:0',
        'total_amount' => 'required|numeric|min:0',
    ]);

    $checkIn = Carbon::parse($data['check_in']);
    $checkOut = Carbon::parse($data['check_out']);
    $roomType = RoomType::findOrFail($data['room_type_id']);
    $user = Auth::user();

    $availableRooms = $this->getAvailableRooms(
        $roomType->id,
        $checkIn,
        $checkOut,
        $data['number_of_rooms']
    );

    if ($availableRooms->count() < $data['number_of_rooms']) {
        return back()->with('error', 'Không đủ phòng trống cho loại phòng này trong thời gian đã chọn.');
    }

    // Tạo booking
    $booking = Booking::create([
        'booking_code'    => $this->generateBookingCode(),
        'user_id'         => $user->id,
        'check_in_date'   => $checkIn,
        'check_out_date'  => $checkOut,
        'status'          => 0,
        'adults'          => $data['adults'],
        'children'        => $data['children'],
        'deposit'         => intval($data['deposit']),
        'total_amount'    => intval($data['total_amount']),
    ]);

    foreach ($availableRooms as $room) {
        BookingRoom::create([
            'booking_id'     => $booking->id,
            'room_id'        => $room->id,
            'check_in_date'  => $checkIn,
            'check_out_date' => $checkOut,
            'price'          => $room->price,
        ]);
    }

    return view('client.payments.auto_submit', [
        'booking_id' => $booking->id,
        'amount'     => intval($data['deposit']),
    ]);
}



    private function generateBookingCode()
    {
        $date = Carbon::now()->format('Ymd');
        $random = mt_rand(1000, 9999);
        return "BK-{$date}-{$random}";
    }
}
