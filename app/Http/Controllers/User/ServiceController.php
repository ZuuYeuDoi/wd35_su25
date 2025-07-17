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
        $services = Service::where([['status', 1], ['type', 4]])->get();
        return view('client.services.index', compact('services'));
    }

    public function detail(Request $request)
    {
        $services = Service::where([['status', 1], ['type', 4]])->get();

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


    public function indexFood(Request $request)
    {
        $query = Service::where('type', 2);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [(int)$request->min_price, (int)$request->max_price]);
        }

        $product = $query->get();

        $maxPrice = Service::where('type', 2)->max('price') + 10000;

        return view('client.product.index', compact('product', 'maxPrice'));
    }


    public function showClient($id)
    {
        $product = Service::findOrFail($id);
        $booking = Booking::where('user_id', Auth::id())
            ->where('status', 2)
            ->whereDate('actual_check_in', '<=', now())
            ->whereDate('check_out_date', '>=', now())
            ->first();
        // dd($booking);
        return view('client.product.detail', compact('product', 'booking'));
    }
}
