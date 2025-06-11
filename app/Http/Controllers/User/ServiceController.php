<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
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
}
