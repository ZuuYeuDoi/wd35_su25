@component('mail::message')
# Hóa đơn đặt phòng

Xin chào **{{ $bill->customer_name }}**,

Cảm ơn bạn đã đặt phòng tại khách sạn của chúng tôi.  
Dưới đây là thông tin hóa đơn:

- Mã đơn đặt: **{{ $booking->booking_code }}**
- Mã hóa đơn: **{{ $bill->bill_code }}**
- Loại hóa đơn: {{ ucfirst($bill->bill_type) }}
- Số tiền: **{{ number_format($bill->final_amount, 0, ',', '.') }} VND**
- Hình thức thanh toán: {{ $bill->payment_method }}
- Ngày thanh toán: {{ $bill->payment_date->format('d/m/Y H:i') }}

@component('mail::button', ['url' => url('/')])
Xem chi tiết
@endcomponent

Cảm ơn bạn đã tin tưởng sử dụng dịch vụ!  
Khách sạn **Cimora**
@endcomponent
