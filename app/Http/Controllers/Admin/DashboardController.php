<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);

        $revenue = Bill::whereYear('created_at', $year)->sum('final_amount');
        $room_revenue = Bill::whereYear('created_at', $year)->sum('room_amount');
        $service_revenue = Bill::whereYear('created_at', $year)->sum('service_amount');

        $number_customer = Booking::whereYear('created_at', $year)->sum('adults')
            + Booking::whereYear('created_at', $year)->sum('children');

        $total_bookings = Booking::whereYear('created_at', $year)->count();
        $total_check_out = Booking::whereYear('created_at', $year)->where('status', 3)->count();
        $total_check_in = Booking::whereYear('created_at', $year)->where('status', 2)->count();
        $total_confirm = Booking::whereYear('created_at', $year)->where('status', 1)->count();

        // Doanh thu từng tháng
        $monthlyRevenue = Bill::selectRaw('MONTH(created_at) as month, SUM(final_amount) as total')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = $monthlyRevenue[$i] ?? 0;
        }

        // Số lượng khách từng tháng
        $monthlyCustomers = Booking::selectRaw('MONTH(created_at) as month, SUM(adults + children) as total')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $customersByMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $customersByMonth[] = $monthlyCustomers[$i] ?? 0;
        }

        // Tổng khách mỗi năm (dùng cho biểu đồ số khách theo năm)
        $yearlyCustomers = Booking::selectRaw('YEAR(created_at) as year, SUM(adults + children) as total')
            ->groupByRaw('YEAR(created_at)')
            ->orderBy('year')
            ->pluck('total', 'year');

        $years = $yearlyCustomers->keys()->toArray();
        $customersByYear = $yearlyCustomers->values()->toArray();

        return view('admin.dashboard', compact(
            'revenue',
            'room_revenue',
            'service_revenue',
            'number_customer',
            'total_bookings',
            'total_check_out',
            'total_check_in',
            'total_confirm',
            'revenueData',
            'customersByMonth',
            'customersByYear',
            'years',
            'year'
        ));
    }
}
