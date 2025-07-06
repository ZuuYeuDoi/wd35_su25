<?php

namespace App\Http\Controllers\Payment;

// app/Http/Controllers/PaymentController.php

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        // session(['cost_id' => $request->booking_id]);


        session(['url_prev' => url()->previous()]);
        $vnp_TmnCode = "O0VNLD6K"; 
        $vnp_HashSecret = "E5B82HAN2P1L7HEXOAAN2Q4D20TVIRYJ"; 
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/payment/return";
        // $vnp_TxnRef = date("YmdHis"); 
        $vnp_TxnRef = $request->booking_id . '-' . date("YmdHis");
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->input('amount') * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        //     $inputData['vnp_BankCode'] = $vnp_BankCode;
        // }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
           // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHashType=SHA512&vnp_SecureHash=' . $vnpSecureHash;

        }
        return redirect($vnp_Url);
    }

    public function paymentReturn(Request $request)
    {
        $txnRef = $request->input('vnp_TxnRef');
        $parts = explode('-', $txnRef);
        $bookingId = $parts[0] ?? null;

        if (!$bookingId) {
            return view('client.payments.failed');
        }

        if ($request->vnp_ResponseCode === "00") {
            // Thanh toán thành công
            Payment::create([
                'booking_id' => $bookingId,
                'pay_date' => now(),
                'total_price' => $request->vnp_Amount / 100,
                'payment_status' => 1,
                'payment_method' => 'VNPAY',
                'vnp_bankcode' => $request->vnp_BankCode ?? null,
            ]);

            Booking::where('id', $bookingId)->update(['status' => 1]); 

            return view('client.payments.success');
        } else {
            Booking::where('id', $bookingId)->update(['status' => 2]);

            return view('client.payments.failed');
        }
    }
}
