@extends('client.index')

@section('content')
<section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
    <div class="auto-container text-center">
        <h1 class="title">Giỏ đặt phòng</h1>
        <ul class="page-breadcrumb">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>
            <li>Giỏ đặt phòng</li>
        </ul>
    </div>
</section>

<section class="pt-120 pb-120">
    <div class="container">
        @if($summary->isEmpty())
            <div class="alert alert-info">
                Giỏ đặt phòng trống. <a href="{{ route('room.index') }}">Quay lại chọn phòng</a>
            </div>
        @else
<div class="table-responsive mb-4">
    <table class="table table-bordered align-middle shadow-sm rounded">
        <thead class="table-primary text-center">
            <tr>
                <th>Loại phòng</th>
                <th>Ngày nhận</th>
                <th>Ngày trả</th>
                <th>Số đêm</th>
                <th>Số lượng</th>
                <th class="text-end">Thành tiền</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAdults = 0; $totalChildren = 0;
            @endphp
            @foreach($summary as $i => $item)
                @php
                    $totalAdults += $item['adults'];
                    $totalChildren += $item['children'];
                @endphp
                <tr>
                    <td>
                        <strong>{{ $item['room_type']->name }}</strong><br>
                        <small class="text-muted">
                            {{ number_format($item['room_type']->room_type_price, 0, ',', '.') }} VND / đêm
                        </small>
                    </td>
                    <td class="text-center">{{ $item['check_in'] }}</td>
                    <td class="text-center">{{ $item['check_out'] }}</td>
                    <td class="text-center">{{ $item['nights'] ?? \Carbon\Carbon::parse($item['check_in'])->diffInDays($item['check_out']) }}</td>
                    <td class="text-center">{{ $item['qty'] }}</td>
                    <td class="text-end text-danger fw-bold">
                        {{ number_format($item['sub_total'], 0, ',', '.') }} VND
                    </td>
                    <td class="text-center">
                        <a href="{{ route('booking.cart.remove', $i) }}" class="btn btn-sm btn-outline-danger rounded-circle" title="Xóa">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr class="fw-bold table-light">
                <td colspan="4" class="text-end">Tổng cộng:</td>
                <td class="text-center">{{ $totalAdults + $totalChildren }}</td>
                <td class="text-end text-primary">{{ number_format($total, 0, ',', '.') }} VND</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
            <div class="d-flex justify-content-end">
    <form action="{{ route('booking.cart.checkout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary px-4 py-2">
            Tiếp tục thanh toán
        </button>
    </form>
</div>
        @endif
    </div>
</section>
@endsection
