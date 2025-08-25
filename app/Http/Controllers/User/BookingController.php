<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomType;
use App\Models\BookingRoom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Amenitie; // theo DB hiện tại của bạn
use App\Models\Amenity; // (Giữ lại nếu dùng ở nơi khác)
// use TijsVerkoyen\CssToInlineStyles\Css\Rule\Rule;

class BookingController extends Controller
{
    /* ----------------------------------------------------------------------
     | Helpers cấu hình & giá
     * ---------------------------------------------------------------------- */
        private function occupiedStatuses(): array
    {
        // Những trạng thái Booking được xem là đang chiếm phòng
        return [0, 1, 2];
    }

    private function depositRate(): float
    {
        // Tỷ lệ đặt cọc (mặc định 50%)
        return 0.5;
    }
private function calcNights($ci, $co): int
{
    $ci = $ci instanceof Carbon ? $ci : Carbon::parse($ci);
    $co = $co instanceof Carbon ? $co : Carbon::parse($co);

    return max($ci->diffInDays($co), 1);
}


    private function nightlyPriceForRoomType(RoomType $type): int
    {
        return (int) ($type->room_type_price ?? 0);
    }

    private function nightlyPriceForRoom(Room $room): int
    {
        // Thống nhất nguồn giá: ưu tiên giá theo Room; fallback RoomType
        return (int) ($room->price ?? ($room->roomType->room_type_price ?? 0));
    }

    /* ----------------------------------------------------------------------
     | Cart APIs
     * ---------------------------------------------------------------------- */

    /** ✅ Thêm một loại phòng vào giỏ booking */
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

    $this->addItemToCart($data);

    if ($request->input('action') === 'checkout') {
        return redirect()->route('booking.cart.view');
    }

    return redirect()->route('room.indexRoom')->with('success', 'Đã thêm loại phòng vào giỏ booking.');
}

/**
 * ✅ Hàm dùng chung để thêm 1 phòng vào giỏ
 */
private function addItemToCart(array $data)
{
    $cart = session()->get('booking_cart', []);

    // Nếu giỏ đã có phòng → check ngày phải trùng
    if (!empty($cart)) {
        $first = $cart[0];
        if ($data['check_in'] !== $first['check_in'] || $data['check_out'] !== $first['check_out']) {
            throw new \Exception('Ngày nhận/trả phải giống các phòng đã chọn trước đó.');
        }
    }

    // Kiểm tra số lượng phòng trống
    $roomType = RoomType::with('rooms')->findOrFail($data['room_type_id']);

    $bookedRoomIds = BookingRoom::whereHas('booking', function ($q) use ($data) {
        $q->where(function ($sub) use ($data) {
            $sub->whereBetween('check_in_date', [$data['check_in'], $data['check_out']])
                ->orWhereBetween('check_out_date', [$data['check_in'], $data['check_out']]);
        })->whereIn('status', [0, 1]);
    })->pluck('room_id')->toArray();

    $availableRooms = $roomType->rooms()->whereNotIn('id', $bookedRoomIds)->count();

    // Tính số phòng đã có trong giỏ
    $cartRoomsSameType = collect($cart)->filter(function ($line) use ($data) {
        return (int)$line['room_type_id'] === (int)$data['room_type_id']
            && $line['check_in'] === $data['check_in']
            && $line['check_out'] === $data['check_out'];
    })->sum('number_of_rooms');

    if (($cartRoomsSameType + $data['number_of_rooms']) > $availableRooms) {
        throw new \Exception('Không đủ phòng trống cho loại phòng này.');
    }

    // Merge item cùng loại phòng & cùng ngày
    $merged = false;
    foreach ($cart as &$line) {
        if (
            (int)$line['room_type_id'] === (int)$data['room_type_id'] &&
            $line['check_in'] === $data['check_in'] &&
            $line['check_out'] === $data['check_out']
        ) {
            $line['number_of_rooms'] += (int)$data['number_of_rooms'];
            $line['adults']   = (int)$data['adults'];
            $line['children'] = (int)$data['children'];
            $merged = true;
            break;
        }
    }
    unset($line);

    if (!$merged) {
        $cart[] = $data;
    }

    session(['booking_cart' => $cart]);
}



    /** Xóa 1 item khỏi giỏ */
 public function removeCartItem($index)
{
    $cart = session('booking_cart', []);
    if (isset($cart[$index])) {
        unset($cart[$index]);
        $cart = array_values($cart); // Đánh lại chỉ số mảng
        session(['booking_cart' => $cart]);

        if (empty($cart)) {
            // Trả về view với giỏ hàng rỗng
            $summary = collect([]);
            $total = 0;
            $deposit = 0;
            return view('client.checkout.cart', compact('summary', 'total', 'deposit'))
                ->with('info', 'Giỏ hàng đã trống. Vui lòng chọn phòng.');
        }

        return redirect()->route('booking.cart.view')->with('success', 'Đã xóa phòng khỏi giỏ.');
    }

    return redirect()->route('booking.cart.view')->with('error', 'Mục không tồn tại.');
}

    /** ✅ Hiển thị giỏ booking (trang checkout tạm) */
public function viewCart()
    {
        $cart = session('booking_cart', []);
        Log::debug('Booking Cart:', [$cart]); // Debug session data

        $summary = collect($cart)->map(function ($item) {
            $roomType = RoomType::find($item['room_type_id']);
            if (!$roomType) {
                Log::warning('Invalid room type ID:', [$item['room_type_id'] ?? null]);
                return null; // Bỏ qua mục không hợp lệ
            }

            try {
                $ci = Carbon::parse($item['check_in']);
                $co = Carbon::parse($item['check_out']);
                $nights = $this->calcNights($ci, $co);
            } catch (\Exception $e) {
                Log::error('Error parsing dates:', ['error' => $e->getMessage(), 'item' => $item]);
                $nights = 0;
                $ci = now();
                $co = now();
            }

            $unit = $roomType ? $this->nightlyPriceForRoomType($roomType) : 0;
            $availableRooms = $this->getAvailableRooms($roomType->id, $ci, $co);
            $availableRoomsCount = $availableRooms->count();

            $itemData = [
                'room_type' => $roomType,
                'check_in'  => $item['check_in'] ?? now()->toDateString(),
                'check_out' => $item['check_out'] ?? now()->toDateString(),
                'qty'       => (int) ($item['number_of_rooms'] ?? 0),
                'adults'    => (int) ($item['adults'] ?? 0),
                'children'  => (int) ($item['children'] ?? 0),
                'unit'      => $unit,
                'nights'    => $nights,
                'sub_total' => (int) ($item['number_of_rooms'] ?? 0) * $nights * $unit,
                'available_rooms' => $availableRoomsCount,
            ];

            Log::debug('Cart item processed:', $itemData); // Debug each item
            return $itemData;
        })->filter();

        $total = (int) $summary->sum('sub_total');
        $deposit = (int) round($total * $this->depositRate());

        Log::debug('Cart summary:', ['summary' => $summary->toArray(), 'total' => $total, 'deposit' => $deposit]);

        return view('client.checkout.cart', compact('summary', 'total', 'deposit'));
    }

    public function updateCartItem(Request $request, $index)
    {
        Log::debug('Update cart item:', ['index' => $index, 'request' => $request->all()]);

        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session('booking_cart', []);
        if (!isset($cart[$index])) {
            Log::warning('Cart item not found:', ['index' => $index]);
            return response()->json(['success' => false, 'message' => 'Mục không tồn tại.'], 400);
        }

        $roomType = RoomType::find($cart[$index]['room_type_id']);
        if (!$roomType) {
            Log::warning('Invalid room type:', ['room_type_id' => $cart[$index]['room_type_id']]);
            return response()->json(['success' => false, 'message' => 'Loại phòng không hợp lệ.'], 400);
        }

        try {
            $ci = Carbon::parse($cart[$index]['check_in']);
            $co = Carbon::parse($cart[$index]['check_out']);
            $availableRooms = $this->getAvailableRooms($roomType->id, $ci, $co)->count();
        } catch (\Exception $e) {
            Log::error('Error parsing dates in updateCartItem:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Ngày không hợp lệ.'], 400);
        }

        $qty = (int) $request->input('qty');
        if ($qty > $availableRooms) {
            Log::warning('Quantity exceeds available rooms:', ['qty' => $qty, 'available' => $availableRooms]);
            return response()->json(['success' => false, 'message' => 'Số lượng phòng vượt quá số phòng còn lại (' . $availableRooms . ').'], 400);
        }

        $cart[$index]['number_of_rooms'] = $qty;
        session(['booking_cart' => $cart]);

        $nights = $this->calcNights($ci, $co);
        $unit = $this->nightlyPriceForRoomType($roomType);
        $sub_total = $qty * $nights * $unit;

        Log::info('Cart item updated:', ['index' => $index, 'qty' => $qty, 'sub_total' => $sub_total]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật số lượng phòng thành công.',
            'sub_total' => $sub_total,
            'qty' => $qty,
        ]);
    }

    /* ----------------------------------------------------------------------
     | Booking từ giỏ (có transaction + lock)
     * ---------------------------------------------------------------------- */
    public function storeCartBooking(Request $request)
    {
        $this->autoTerminatePendingBookings();
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt phòng.');
        }

        $cart = session('booking_cart', []);
        if (empty($cart)) {
            return redirect()->route('room.index')->with('error', 'Giỏ booking trống.');
        }

        // Optionally: server-side validate rule trẻ em/người lớn/tối đa 30 người
        $adSum = array_sum(array_column($cart, 'adults'));
        $chSum = array_sum(array_column($cart, 'children'));
        if ($chSum > 0 && $adSum < 1) {
            return back()->with('error', 'Phải có ít nhất 1 người lớn đi cùng trẻ em.');
        }
        if ($chSum > $adSum * 2) {
            return back()->with('error', 'Mỗi người lớn chỉ được đi kèm tối đa 2 trẻ em.');
        }
        if (($adSum + $chSum) > 30) {
            return back()->with('error', 'Tổng số khách tối đa là 30 người.');
        }

        $user = Auth::user();

        // Theo addToCart, mọi item trong giỏ đã cùng ngày. Lấy từ item đầu tiên.
        $ci = Carbon::parse($cart[0]['check_in']);
        $co = Carbon::parse($cart[0]['check_out']);
        $nights = $this->calcNights($ci, $co);

        try {
            return DB::transaction(function () use ($user, $cart, $ci, $co, $nights) {

                // Tạo booking code unique
                do {
                    $bookingCode = $this->generateBookingCode();
                } while (Booking::where('booking_code', $bookingCode)->exists());

                $booking = Booking::create([
                    'booking_code'   => $bookingCode,
                    'user_id'        => $user->id,
                    'check_in_date'  => $ci,
                    'check_out_date' => $co,
                    'status'         => 0, // pending theo hệ thống hiện tại của bạn
                    'adults'         => $adSum = array_sum(array_column($cart, 'adults')),
                    'children'       => $chSum = array_sum(array_column($cart, 'children')),
                    'deposit'        => 0,
                    'total_amount'   => 0,
                ]);

                $grandTotal = 0;
                $occupied = $this->occupiedStatuses();

                foreach ($cart as $item) {
                    $qty = (int) $item['number_of_rooms'];

                    // Lấy phòng trống và KHÓA bản ghi phòng để tránh race condition
                    $rooms = $this->getAvailableRooms((int) $item['room_type_id'], $ci, $co, $qty, true);

                    if ($rooms->count() < $qty) {
                        throw ValidationException::withMessages([
                            'rooms' => "Loại phòng {$item['room_type_id']} chỉ còn {$rooms->count()} phòng trong khoảng đã chọn.",
                        ]);
                    }

                    foreach ($rooms as $room) {
                        $unitPrice = $this->nightlyPriceForRoom($room);

                        BookingRoom::create([
                            'booking_id'     => $booking->id,
                            'room_id'        => $room->id,
                            'check_in_date'  => $ci,
                            'check_out_date' => $co,
                            'price'          => $unitPrice,
                        ]);

                        $grandTotal += $unitPrice * $nights;
                    }
                }

                $deposit = (int) round($grandTotal * $this->depositRate());

                $booking->update([
                    'total_amount' => $grandTotal,
                    'deposit'      => $deposit,
                ]);

                // Không xóa giỏ ngay; xóa sau khi thanh toán thành công
                // session()->forget('booking_cart');

                return view('client.payments.auto_submit', [
                    'booking_id' => $booking->id,
                    'amount'     => $deposit,
                ]);
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    /* ----------------------------------------------------------------------
     | Availability (phòng trống) – dùng join bookings để lọc theo status
     * ---------------------------------------------------------------------- */
    private function getAvailableRooms($roomTypeId, Carbon $checkIn, Carbon $checkOut, $limit = null, bool $forUpdate = false)
    {

        $this->autoTerminatePendingBookings();
        // Danh sách phòng thuộc loại & đang active
        $roomIds = Room::where('room_type_id', $roomTypeId)
            ->where('status', 1)
            ->pluck('id');

        if ($roomIds->isEmpty()) return collect();

        // Lấy danh sách phòng đã bị đặt trùng ngày với các trạng thái chiếm chỗ
        $occupiedStatuses = $this->occupiedStatuses();

        $bookedRoomIds = BookingRoom::join('bookings', 'bookings.id', '=', 'booking_rooms.booking_id')
            ->whereIn('booking_rooms.room_id', $roomIds)
            ->whereIn('bookings.status', $occupiedStatuses)
            ->where(function ($q) use ($checkIn, $checkOut) {
                // overlap: (ci < co) && (co > ci)
                $q->where('booking_rooms.check_in_date', '<', $checkOut)
                  ->where('booking_rooms.check_out_date', '>', $checkIn);
            })
            ->pluck('booking_rooms.room_id');

        $availableQuery = Room::where('room_type_id', $roomTypeId)
            ->where('status', 1)
            ->whereNotIn('id', $bookedRoomIds);

        if ($forUpdate) {
            $availableQuery->lockForUpdate();
        }

        if ($limit) {
            $availableQuery->limit($limit);
        }

        return $availableQuery->get();
    }

    /* ----------------------------------------------------------------------
     | Code & Các view khác
     * ---------------------------------------------------------------------- */
    /** ✅ Sinh mã booking unique-ish */
    private function generateBookingCode(): string
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
            $nights = $this->calcNights($ci, $co);
            $unit = $type ? $this->nightlyPriceForRoomType($type) : 0;

            return [
                'room_type' => $type,
                'check_in'  => $item['check_in'],
                'check_out' => $item['check_out'],
                'qty'       => (int) $item['number_of_rooms'],
                'adults'    => (int) $item['adults'],
                'children'  => (int) $item['children'],
                'sub_total' => (int) $item['number_of_rooms'] * $nights * $unit,
            ];
        });

        $checkIn  = $cart[0]['check_in'];
        $checkOut = $cart[0]['check_out'];
        $total = (int) $summary->sum('sub_total');
        $deposit = (int) round($total * $this->depositRate());
        $totalAdults = (int) $summary->sum('adults');
        $totalChildren = (int) $summary->sum('children');

        return view('client.checkout.index', compact('summary', 'total', 'deposit', 'checkIn', 'checkOut', 'user', 'totalAdults', 'totalChildren'));
    }

    /* ----------------------------------------------------------------------
     | Tours: suggest & search & add to cart
     * ---------------------------------------------------------------------- */

    public function suggestTours(Request $request)
    {
        // Chỉ load loại phòng có phòng active
        $roomTypes = RoomType::whereHas('rooms', function ($q) {
            $q->where('status', 1);
        })->with(['rooms.images_room'])->get();

        $checkIn  = $request->input('check_in');
        $checkOut = $request->input('check_out');
        $adults   = $request->input('adults');
        $children = $request->input('children');

        // Danh sách loại phòng để hiển thị (kèm available_count nếu có ngày)
        $roomTypesList = $roomTypes->map(function ($rt) use ($checkIn, $checkOut) {
            $firstRoom  = $rt->rooms->first();
            $firstImage = $firstRoom?->images_room->first()?->image_path;
            $imageUrl   = $firstImage ? asset('storage/' . $firstImage) : asset('client/images/no-image.png');

            $availableCount = null;
            if ($checkIn && $checkOut) {
                $available = $this->getAvailableRooms($rt->id, Carbon::parse($checkIn), Carbon::parse($checkOut));
                $availableCount = $available->count();
            }

            return [
                'id'              => $rt->id,
                'name'            => $rt->name,
                'type'            => $rt->type,
                'price'           => $rt->room_type_price,
                'bed_type'        => $rt->bed_type,
                'amenities'       => $rt->amenities ?? [],
                'image_url'       => $imageUrl,
                'available_count' => $availableCount,
            ];
        });

        return view('client.tours.index', [
            'roomTypes'     => $roomTypes->unique('type')->values(),
            'roomTypesList' => $roomTypesList,
            'allAmenities'  => Amenitie::all()->keyBy('id'),
            'check_in'      => $checkIn,
            'check_out'     => $checkOut,
            'adults'        => $adults,
            'children'      => $children,
            'nights'        => null,
            'preferred'     => null,
            'combinations'  => null,
            'tour_suggestions' => session()->get('tour_suggestions', []),
        ]);
    }
public function searchTours(Request $request)
{
    // Validate input
    $request->validate([
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'adults' => 'required|integer|min:1|max:30',
        'children' => 'nullable|integer|min:0',
        'preferred_room_type' => 'required|string',
    ], [
        'check_in.required' => 'Vui lòng chọn ngày nhận phòng.',
        'check_in.after_or_equal' => 'Ngày nhận phòng phải từ hôm nay trở đi.',
        'check_out.required' => 'Vui lòng chọn ngày trả phòng.',
        'check_out.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',
        'adults.required' => 'Vui lòng nhập số người lớn.',
        'adults.min' => 'Phải có ít nhất 1 người lớn.',
        'adults.max' => 'Tổng số khách không được vượt quá 30.',
        'children.min' => 'Số trẻ em không được âm.',
        'preferred_room_type.required' => 'Vui lòng chọn hạng phòng.',
    ]);

    // Additional validation for children
    $adults = (int) $request->input('adults');
    $children = (int) ($request->input('children') ?? 0);
    if ($children > 0 && $adults < 1) {
        return back()->withErrors(['children' => 'Phải có ít nhất 1 người lớn đi cùng trẻ em.']);
    }
    if ($children > $adults * 2) {
        return back()->withErrors(['children' => 'Mỗi người lớn chỉ được đi kèm tối đa 2 trẻ em.']);
    }
    if ($adults + $children > 30) {
        return back()->withErrors(['adults' => 'Tổng số khách tối đa là 30 người.']);
    }

    // Get inputs
    $checkIn = Carbon::parse($request->input('check_in'));
    $checkOut = Carbon::parse($request->input('check_out'));
    $preferredRoomType = $request->input('preferred_room_type');
    $nights = $this->calcNights($checkIn, $checkOut);

    // Clear tour_suggestions if dates change
    $tourSuggestions = session()->get('tour_suggestions', []);
    if (!empty($tourSuggestions)) {
        $first = $tourSuggestions[0];
        if ($first['check_in'] !== $checkIn->toDateString() || $first['check_out'] !== $checkOut->toDateString()) {
            session()->forget('tour_suggestions');
            $tourSuggestions = [];
        }
    }

    // Get room types with active rooms
    $roomTypes = RoomType::whereHas('rooms', function ($q) {
        $q->where('status', 1);
    })->with(['rooms.images_room'])->get();

    // Find preferred room type
    $preferred = $roomTypes->where('type', $preferredRoomType)->first();
    if (!$preferred) {
        return back()->withErrors(['preferred_room_type' => 'Hạng phòng mong muốn không tồn tại hoặc không có phòng trống.']);
    }

    // Collect room types (including Single for odd adults or when needed)
    $roomTypesForPlan = $this->collectRoomTypes($preferredRoomType, $adults, $roomTypes);

    // Prepare data for plan
    $roomTypesData = $roomTypesForPlan->map(function ($rt) use ($checkIn, $checkOut) {
        // Xác định sức chứa và khả năng hỗ trợ trẻ em dựa trên bed_type
        $capacity = match ($rt->bed_type) {
            '1 giường đơn' => 1,
            '2 giường đơn' => 2,
            '1 giường đôi' => 2,
            '3 giường đơn' => 3,
            '2 giường đôi' => 4,
            '1 giường đôi + 1 giường đơn' => 3,
            default => 2, // Dự phòng
        };
        $supportsChildren = in_array($rt->bed_type, ['2 giường đơn', '1 giường đôi', '2 giường đôi', '1 giường đôi + 1 giường đơn']);
        $available = $this->getAvailableRooms($rt->id, $checkIn, $checkOut)->count();
        $unitPrice = $this->nightlyPriceForRoomType($rt);

        return [
            'model' => $rt,
            'capacity' => $capacity,
            'supports_children' => $supportsChildren,
            'available' => $available,
            'unit_price' => $unitPrice,
        ];
    })->toArray();

    // Generate single plan
    $plan = $this->planAdultsByCapacity($roomTypesData, $adults, $children, $preferredRoomType);

    // Format plan to match combinations structure for view
    $combinations = [];
    if (!empty($plan)) {
        foreach ($plan as $item) {
            $roomType = $item['room_type'];
            $qty = $item['qty'];
            $subTotal = $this->nightlyPriceForRoomType($roomType) * $qty * $nights;

            $combinations[] = [
                'room_type' => $roomType,
                'rooms_needed' => $qty,
                'available_cnt' => $this->getAvailableRooms($roomType->id, $checkIn, $checkOut)->count(),
                'sub_total' => $subTotal,
            ];
        }
    }

    // Merge with tour_suggestions from session
    foreach ($tourSuggestions as $suggestion) {
        $roomType = RoomType::find($suggestion['room_type_id']);
        if ($roomType && $suggestion['check_in'] === $checkIn->toDateString() && $suggestion['check_out'] === $checkOut->toDateString()) {
            $subTotal = $roomType->room_type_price * $suggestion['qty'] * $nights;
            $combinations[] = [
                'room_type' => $roomType,
                'rooms_needed' => $suggestion['qty'],
                'available_cnt' => $this->getAvailableRooms($roomType->id, $checkIn, $checkOut)->count(),
                'sub_total' => $subTotal,
            ];
        }
    }

    // Build room types list for display
    $roomTypesList = $roomTypes->map(function ($rt) use ($checkIn, $checkOut) {
        $firstRoom = $rt->rooms->first();
        $firstImage = $firstRoom?->images_room->first()?->image_path;
        $imageUrl = $firstImage ? asset('storage/' . $firstImage) : asset('client/images/no-image.png');

        $available = $this->getAvailableRooms($rt->id, $checkIn, $checkOut);
        $availableCount = $available->count();

        return [
            'id' => $rt->id,
            'name' => $rt->name,
            'type' => $rt->type,
            'price' => $rt->room_type_price,
            'bed_type' => $rt->bed_type,
            'amenities' => $rt->amenities ?? [],
            'image_url' => $imageUrl,
            'available_count' => $availableCount,
        ];
    });

    return view('client.tours.index', [
        'roomTypes' => $roomTypes->unique('type')->values(),
        'roomTypesList' => $roomTypesList,
        'allAmenities' => Amenitie::all()->keyBy('id'),
        'check_in' => $checkIn->toDateString(),
        'check_out' => $checkOut->toDateString(),
        'adults' => $adults,
        'children' => $children,
        'nights' => $nights,
        'preferred' => $preferred,
        'combinations' => $combinations,
        'tour_suggestions' => $tourSuggestions,
    ]);
}

private function planAdultsByCapacity(array $roomTypes, int $adults, int $children, string $preferredRoomType): array
{
    // Sắp xếp: ưu tiên phòng thuộc preferred_room_type, sau đó capacity desc, giá asc
    usort($roomTypes, function ($a, $b) use ($preferredRoomType) {
        $aIsPreferred = $a['model']->type === $preferredRoomType ? -1 : 1;
        $bIsPreferred = $b['model']->type === $preferredRoomType ? -1 : 1;
        return [$aIsPreferred, -$a['capacity'], $a['unit_price']] <=> [$bIsPreferred, -$b['capacity'], $b['unit_price']];
    });

    $plan = [];
    $remainingAdults = $adults;
    $remainingChildren = $children;

    // Nếu có trẻ em, lọc ra các phòng hỗ trợ trẻ em
    $availableRoomTypes = $children > 0
        ? array_filter($roomTypes, fn($rt) => $rt['supports_children'])
        : $roomTypes;

    if (empty($availableRoomTypes)) {
        return []; // Không có phòng phù hợp
    }

    // Trường hợp đặc biệt 1: adults=1, children=0 -> ưu tiên 1 đơn
    if ($adults === 1 && $children === 0) {
        foreach ($availableRoomTypes as $rt) {
            if ($rt['capacity'] === 1 && $rt['available'] >= 1 && $rt['model']->type === $preferredRoomType) {
                $plan[] = ['room_type' => $rt['model'], 'qty' => 1];
                $remainingAdults -= 1;
                break;
            }
        }
        if (empty($plan)) {
            foreach ($availableRoomTypes as $rt) {
                if ($rt['capacity'] === 1 && $rt['available'] >= 1) {
                    $plan[] = ['room_type' => $rt['model'], 'qty' => 1];
                    $remainingAdults -= 1;
                    break;
                }
            }
        }
    }
    // Trường hợp đặc biệt 2: adults=1, children > 0 -> ưu tiên 2 đơn hoặc 1 đôi
    elseif ($adults === 1 && $children > 0) {
        foreach ($availableRoomTypes as $rt) {
            if ($rt['capacity'] >= 2 && $rt['available'] >= 1 && $rt['model']->type === $preferredRoomType) {
                $plan[] = ['room_type' => $rt['model'], 'qty' => 1];
                $remainingAdults -= 1;
                $remainingChildren = 0; // Giả sử trẻ em được chứa trong phòng này
                break;
            }
        }
        if (empty($plan)) {
            foreach ($availableRoomTypes as $rt) {
                if ($rt['capacity'] >= 2 && $rt['available'] >= 1) {
                    $plan[] = ['room_type' => $rt['model'], 'qty' => 1];
                    $remainingAdults -= 1;
                    $remainingChildren = 0;
                    break;
                }
            }
        }
    }
    // Trường hợp đặc biệt 3: adults lẻ >= 3 -> ưu tiên phân bổ tối ưu với phòng lớn
    elseif ($remainingAdults >= 3) {
        // Ưu tiên phòng lớn (2 đôi, 3 đơn) trước
        foreach ($availableRoomTypes as $rt) {
            if ($remainingAdults <= 0) break;
            $capacity = $rt['capacity'];
            $need = (int) ceil($remainingAdults / $capacity);
            $use = min($need, $rt['available']);
            if ($use > 0 && ($rt['supports_children'] || $remainingChildren === 0)) {
                $plan[] = ['room_type' => $rt['model'], 'qty' => $use];
                $remainingAdults -= $use * $capacity;
                if ($rt['supports_children']) {
                    $remainingChildren = 0; // Giả sử trẻ em được chứa trong các phòng này
                }
            }
        }
    }

    // Phân bổ còn lại (nếu remainingAdults > 0)
    foreach ($availableRoomTypes as $rt) {
        if ($remainingAdults <= 0) break;
        $capacity = max(1, $rt['capacity']);
        $need = (int) ceil($remainingAdults / $capacity);
        $use = min($need, $rt['available']);
        if ($use > 0 && ($rt['supports_children'] || $remainingChildren === 0)) {
            $plan[] = ['room_type' => $rt['model'], 'qty' => $use];
            $remainingAdults -= $use * $capacity;
            if ($rt['supports_children']) {
                $remainingChildren = 0;
            }
        }
    }

    // Kiểm tra xem tất cả người lớn và trẻ em có được phân bổ không
    return ($remainingAdults <= 0 && $remainingChildren <= 0) ? $plan : [];
}

    protected function collectRoomTypes($preferredRoomType, $adults, $roomTypes)
    {
        $roomTypesFiltered = $roomTypes->where('type', $preferredRoomType);

        // If adults is odd, include Single rooms
        if ($adults % 2 === 1) {
            $singleRooms = $roomTypes->filter(function ($rt) {
                return stripos($rt->name, 'Single') !== false || stripos($rt->bed_type, '1 giường đơn') !== false;
            });
            $roomTypesFiltered = $roomTypesFiltered->merge($singleRooms)->unique('id');
        }

        return $roomTypesFiltered;
    }

    /**
     * Build combinations of rooms for the given adults
     */
    protected function buildCombinations($roomTypes, $adults, $checkIn, $checkOut, $nights)
    {
        $combinations = [];

        foreach ($roomTypes as $roomType) {
            $capacity = stripos($roomType->name, 'Single') !== false ? 1 : 2; // Assume Single=1, others=2
            $roomsNeeded = ceil($adults / $capacity);

            // Get available rooms
            $availableRooms = $this->getAvailableRooms($roomType->id, $checkIn, $checkOut);

            if ($availableRooms->count() >= $roomsNeeded) {
                $subTotal = $roomType->room_type_price * $roomsNeeded * $nights;

                $combinations[] = [
                    'room_type' => $roomType,
                    'rooms_needed' => (int) $roomsNeeded,
                    'available_cnt' => $availableRooms->count(),
                    'sub_total' => $subTotal,
                ];
            }
        }

        // Sort by price
        usort($combinations, function ($a, $b) {
            return $a['sub_total'] <=> $b['sub_total'];
        });

        return $combinations;
    }


    public function addTourToCart(Request $request)
    {
        $data = $request->validate([
            'check_in'  => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults'    => 'required|integer|min:1',
            'children'  => 'required|integer|min:0',
            'rooms'     => 'required|array|min:1',
            'rooms.*.room_type_id' => 'required|exists:room_types,id',
            'rooms.*.qty'          => 'required|integer|min:1',
            'rooms.*.selected'     => 'nullable|boolean',
        ]);

        $checkIn  = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        $lines = collect($data['rooms'])->filter(fn($r) => empty($r['selected']) ? true : (bool)$r['selected']);

        // Re-check tồn
        foreach ($lines as $i => $roomData) {
            $available = $this->getAvailableRooms((int)$roomData['room_type_id'], $checkIn, $checkOut);
            $maxAvail  = $available->count();
            if ($maxAvail <= 0) {
                return back()->withErrors([
                    "rooms.$i.qty" => "Loại phòng đã hết trong khoảng ngày chọn."
                ])->withInput();
            }
            if ((int)$roomData['qty'] > $maxAvail) {
                return back()->withErrors([
                    "rooms.$i.qty" => "Chỉ còn $maxAvail phòng khả dụng cho loại phòng này."
                ])->withInput();
            }
        }

        // Kiểm tra ngày đồng bộ với cart hiện tại
        $cart = session('booking_cart', []);
        if (!empty($cart)) {
            $first = $cart[0];
            if ($data['check_in'] !== $first['check_in'] || $data['check_out'] !== $first['check_out']) {
                return back()->with('error', 'Ngày nhận/trả phải giống các phòng đã chọn trước đó.');
            }
        }

        // Merge an toàn
        foreach ($lines as $roomData) {
            $found = false;
            foreach ($cart as &$line) {
                if ((int)$line['room_type_id'] === (int)$roomData['room_type_id']
                    && $line['check_in'] === $data['check_in']
                    && $line['check_out'] === $data['check_out']) {
                    $line['number_of_rooms'] += (int)$roomData['qty'];
                    $line['adults']   = (int)$data['adults'];
                    $line['children'] = (int)$data['children'];
                    $found = true; break;
                }
            }
            unset($line);

            if (!$found) {
                $cart[] = [
                    'room_type_id'    => (int)$roomData['room_type_id'],
                    'number_of_rooms' => (int)$roomData['qty'],
                    'check_in'        => $data['check_in'],
                    'check_out'       => $data['check_out'],
                    'adults'          => (int)$data['adults'],
                    'children'        => (int)$data['children'],
                ];
            }
        }

        session(['booking_cart' => $cart]);
        return redirect()->route('booking.cart.view')->with('success', 'Đã thêm vào giỏ đặt phòng.');
    }

        private function autoTerminatePendingBookings(): void
    {
        $expiredTime = now()->subMinutes(15);

        Booking::where('status', 0)
            ->where('created_at', '<', $expiredTime)
            ->update(['status' => -1]); // -1 = terminated/canceled
    }


public function addToSuggestion(Request $request)
{
    // Validate input
    $data = $request->validate([
        'room_type_id' => 'required|exists:room_types,id',
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'adults' => 'required|integer|min:1',
        'children' => 'required|integer|min:0',
        'qty' => 'required|integer|min:1',
    ], [
        'room_type_id.required' => 'Vui lòng chọn loại phòng.',
        'room_type_id.exists' => 'Loại phòng không tồn tại.',
        'check_in.required' => 'Vui lòng chọn ngày nhận phòng.',
        'check_in.after_or_equal' => 'Ngày nhận phòng phải từ hôm nay trở đi.',
        'check_out.required' => 'Vui lòng chọn ngày trả phòng.',
        'check_out.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',
        'adults.required' => 'Vui lòng nhập số người lớn.',
        'adults.min' => 'Phải có ít nhất 1 người lớn.',
        'children.min' => 'Số trẻ em không được âm.',
        'qty.required' => 'Vui lòng nhập số phòng.',
        'qty.min' => 'Số phòng phải ít nhất là 1.',
    ]);

    // Additional validation for children and capacity
    $adults = (int) $data['adults'];
    $children = (int) $data['children'];
    if ($children > 0 && $adults < 1) {
        return back()->withErrors(['children' => 'Phải có ít nhất 1 người lớn đi cùng trẻ em.']);
    }
    if ($children > $adults * 2) {
        return back()->withErrors(['children' => 'Mỗi người lớn chỉ được đi kèm tối đa 2 trẻ em.']);
    }
    if ($adults + $children > 30) {
        return back()->withErrors(['adults' => 'Tổng số khách tối đa là 30 người.']);
    }

    // Check room type and capacity
    $roomType = RoomType::findOrFail($data['room_type_id']);
    $capacity = stripos($roomType->name, 'Single') !== false ? 1 : 2;
    // if ($capacity * $data['qty'] < $adults) {
    //     return back()->withErrors(['qty' => "Số phòng {$roomType->name} không đủ chứa {$adults} người lớn (sức chứa tối đa: {$capacity} người/phòng)."]);
    // }
    if (stripos($roomType->name, 'Single') !== false && $children > 0) {
        return back()->withErrors(['room_type_id' => 'Phòng Single không hỗ trợ trẻ em (không kê được giường phụ).']);
    }

    // Check available rooms
    $checkIn = Carbon::parse($data['check_in']);
    $checkOut = Carbon::parse($data['check_out']);
    $availableRooms = $this->getAvailableRooms($data['room_type_id'], $checkIn, $checkOut)->count();
    if ($data['qty'] > $availableRooms) {
        return back()->withErrors(['qty' => "Chỉ còn {$availableRooms} phòng {$roomType->name} khả dụng trong khoảng ngày đã chọn."]);
    }

    // Check date synchronization with existing suggestions
    $suggestions = session()->get('tour_suggestions', []);
    if (!empty($suggestions)) {
        $first = $suggestions[0];
        if ($data['check_in'] !== $first['check_in'] || $data['check_out'] !== $first['check_out']) {
            return back()->withErrors(['check_in' => 'Ngày nhận/trả phải giống các gợi ý phòng đã chọn trước đó.']);
        }
    }

    // Merge item with same room_type_id and dates
    $merged = false;
    foreach ($suggestions as &$line) {
        if (
            (int) $line['room_type_id'] === (int) $data['room_type_id'] &&
            $line['check_in'] === $data['check_in'] &&
            $line['check_out'] === $data['check_out']
        ) {
            $line['qty'] += (int) $data['qty'];
            $line['adults'] = max((int) $line['adults'], (int) $data['adults']); // Use max adults
            $line['children'] = max((int) $line['children'], (int) $data['children']); // Use max children
            $merged = true;
            break;
        }
    }
    unset($line);

    // If not merged, add new item
    if (!$merged) {
        $suggestions[] = [
            'room_type_id' => (int) $data['room_type_id'],
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'adults' => (int) $data['adults'],
            'children' => (int) $data['children'],
            'qty' => (int) $data['qty'],
        ];
    }

    // Save suggestions to session
    session(['tour_suggestions' => $suggestions]);
    \Illuminate\Support\Facades\Log::info('Tour suggestions saved:', $suggestions);

    return back()->with('success', 'Đã thêm ' . $data['qty'] . ' phòng ' . $roomType->name . ' vào gợi ý tour.');
}
public function removeFromSuggestion(Request $request)
{
    $data = $request->validate([
        'room_type_id' => 'required|exists:room_types,id',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
    ]);

    $suggestions = session()->get('tour_suggestions', []);
    $roomTypeId = (int) $data['room_type_id'];
    $checkIn = $data['check_in'];
    $checkOut = $data['check_out'];

    // Tìm và xóa mục khớp với room_type_id, check_in, check_out
    $suggestions = array_filter($suggestions, function ($suggestion) use ($roomTypeId, $checkIn, $checkOut) {
        return !(
            (int) $suggestion['room_type_id'] === $roomTypeId &&
            $suggestion['check_in'] === $checkIn &&
            $suggestion['check_out'] === $checkOut
        );
    });

    // Re-index và lưu lại session
    $suggestions = array_values($suggestions);
    if (empty($suggestions)) {
        session()->forget('tour_suggestions');
    } else {
        session(['tour_suggestions' => $suggestions]);
    }

    return back()->with('success', 'Đã xóa gợi ý khỏi tour.');
}

}
