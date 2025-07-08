<?php


namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Booking;
use App\Models\Service;
use App\Models\CartService;
use App\Models\BillServices;
use Illuminate\Http\Request;
use App\Models\CartServiceItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller{
    public function add(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $bookingId = $validated['booking_id'];

        // Tạo hoặc lấy cart với status = ordered
        $cart = Cart::firstOrCreate([
            'booking_id' => $bookingId,
            'status' => 'ordered',
        ]);

        // Thêm item
        $service = Service::find($validated['service_id']);

       $existing = CartServiceItem::where('cart_id', $cart->id)
    ->where('service_id', $service->id)
    ->first();

        if ($existing) {
            $existing->quantity += $validated['quantity'];
            $existing->save();
        } else {
            CartServiceItem::create([
                'cart_id' => $cart->id,
                'service_id' => $service->id,
                'quantity' => $validated['quantity'],
                'unit_price' => $service->price,
            ]);
        }

  
        return response()->json(['success' => true]);
    }
}