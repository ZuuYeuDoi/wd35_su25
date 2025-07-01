<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function temporary($bookingId)
    {
        return view('admin.bills.temporary_bill');
    }
    public function final($bookingId)
    {
        return view('admin.bills.final_bill');
    }
}
