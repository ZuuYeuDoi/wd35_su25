@extends('layouts.admin')
@section('title1', 'Hóa đơn chính thức')
@section('content')

<section role="main" class="content-body">
    <header class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-6 mb-0">Hóa đơn chính thức</h2>
    </header>

    <div class="card-body">
        <div class="invoice">
            <header class="clearfix">
                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">HÓA ĐƠN</h2>
                        <h4 class="h4 m-0 text-dark font-weight-bold">#{{ $bill->bill_code }}</h4>
                    </div>
                    <div class="col-sm-6 text-end mt-3 mb-3">
                        <address class="ib me-5">
                            Khách sạn ABC<br />
                            123 Đường Nguyễn Trãi, TP Hà Nội<br />
                            Điện thoại: 0123 456 789<br />
                            <a href="mailto:info@khachsanabc.vn">info@khachsanabc.vn</a>
                        </address>
                        <div class="ib">
                            <img src="{{ asset('img/invoice-logo.png') }}" alt="Hotel Logo" />
                        </div>
                    </div>
                </div>
            </header>

            <div class="bill-info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="bill-to">
                            <p class="h5 mb-1 text-dark font-weight-semibold">Khách hàng:</p>
                            <address>
                                {{ $bill->customer_name }}<br />
                                Điện thoại: {{ $bill->customer_phone }}
                            </address>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bill-data text-end">
                            <p class="mb-0">
                                <span class="text-dark">Ngày xuất hóa đơn:</span>
                                <span class="value">{{ $bill->payment_date->format('d/m/Y') }}</span>
                            </p>
                            <p class="mb-0">
                                <span class="text-dark">Phương thức:</span>
                                <span class="value">{{ $bill->payment_method }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-responsive-md invoice-items">
                <thead>
                    <tr class="text-dark">
                        <th class="font-weight-semibold">#</th>
                        <th class="font-weight-semibold">Dịch vụ / Sản phẩm</th>
                        <th class="font-weight-semibold">Mô tả</th>
                        <th class="text-center font-weight-semibold">Đơn giá</th>
                        <th class="text-center font-weight-semibold">Số lượng</th>
                        <th class="text-center font-weight-semibold">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp

                    {{-- Phòng đã đặt --}}
                    @foreach ($bill->rooms as $room)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td class="font-weight-semibold text-dark">Thuê phòng</td>
                            <td>{{ $room->room_name }}</td>
                            <td class="text-center">{{ number_format($room->price_per_night) }}đ</td>
                            <td class="text-center">{{ $room->nights }} đêm</td>
                            <td class="text-center">{{ number_format($room->total_price) }}đ</td>
                        </tr>
                    @endforeach

                    {{-- Dịch vụ đã dùng --}}
                    @foreach ($bill->services as $service)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td class="font-weight-semibold text-dark">{{ $service->service_name }}</td>
                            <td>-</td>
                            <td class="text-center">{{ number_format($service->unit_price) }}đ</td>
                            <td class="text-center">{{ $service->quantity }}</td>
                            <td class="text-center">{{ number_format($service->total_price) }}đ</td>
                        </tr>
                    @endforeach

                    {{-- Phụ thu --}}
                    @foreach ($bill->fees as $fee)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td class="font-weight-semibold text-dark">{{ $fee->fee_name }}</td>
                            <td>{{ $fee->description ?? '-' }}</td>
                            <td class="text-center">{{ number_format($fee->amount) }}đ</td>
                            <td class="text-center">1</td>
                            <td class="text-center">{{ number_format($fee->amount) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="invoice-summary">
                <div class="row justify-content-end">
                    <div class="col-sm-4">
                        <table class="table h6 text-dark">
                            <tbody>
                                <tr>
                                    <td colspan="2">Tiền phòng</td>
                                    <td class="text-start">{{ number_format($bill->room_amount) }}đ</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Dịch vụ</td>
                                    <td class="text-start">{{ number_format($bill->service_amount) }}đ</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Phụ thu</td>
                                    <td class="text-start">{{ number_format($bill->fee_amount) }}đ</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Giảm giá</td>
                                    <td class="text-start text-danger">-{{ number_format($bill->discount) }}đ</td>
                                </tr>
                                <tr>
                                    <td colspan="2">VAT ({{ $bill->vat_percent }}%)</td>
                                    <td class="text-start">{{ number_format($bill->vat_amount) }}đ</td>
                                </tr>
                                <tr class="h4">
                                    <td colspan="2">Tổng cộng</td>
                                    <td class="text-start text-dark">{{ number_format($bill->final_amount) }}đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
