<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 1)->get();
        return view('client.services.index', compact('services'));
    }

    public function detail(Request $request)
    {
        $services = Service::where('status', 1)->get();

        // Xác định dịch vụ được chọn (nếu có)
        $selectedService = null;
        if ($request->has('id')) {
            $selectedService = Service::find($request->id);
        } else {
            // Nếu không có id, lấy lấy dịch vụ đầu tiên
            $selectedService = $services->first();
        }

        return view('client.services.detail', compact('services', 'selectedService'));
    }


    public function indexFood()
    {
        $product = Service::where('type', 2)->get();

        return view('client.product.index', compact('product'));
    }

    public function showClient($id)
    {
        $product = Service::findOrFail($id);
        $booking = Booking::where('user_id', Auth::id())
            ->where('status', 2)
            ->whereDate('actual_check_in', '<=', now())
            ->whereDate('actual_check_out', '>=', now())
            ->first();
            // dd($booking);
        return view('client.product.detail', compact('product', 'booking'));
    }
}
