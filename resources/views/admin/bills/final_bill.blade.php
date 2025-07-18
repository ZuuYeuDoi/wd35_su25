@extends('layouts.admin')

@section('title1', 'Hóa đơn chính thức')

@section('content')

<div class="container">
    <section role="main" class="content-body">
        <header class="page-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="font-weight-bold text-6 mb-0">Hóa đơn chính thức</h2>
        </header>

        <div class="card-body">
            <div class="invoice p-4 border rounded">
                <header class="clearfix mb-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2 class="h2 text-dark font-weight-bold">HÓA ĐƠN</h2>
                            <h4 class="h4 text-dark font-weight-bold">#{{ $bill->bill_code }}</h4>
                        </div>
                        <div class="col-sm-6 text-end">
                            <address>
                                Khách sạn ABC<br />
                                123 Đường Nguyễn Trãi, TP Hà Nội<br />
                                Điện thoại: 0123 456 789<br />
                                <a href="mailto:info@khachsanabc.vn">info@khachsanabc.vn</a>
                            </address>
                            <img src="{{ asset('img/invoice-logo.png') }}" alt="Hotel Logo" class="mt-2" style="height:40px;">
                        </div>
                    </div>
                </header>

                <div class="bill-info mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="h5 text-dark fw-bold">Khách hàng:</p>
                            <address>
                                {{ $bill->customer_name }}<br />
                                Điện thoại: {{ $bill->customer_phone }}
                            </address>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><span class="text-dark">Ngày xuất hóa đơn:</span> {{ $bill->payment_date->format('d/m/Y') }}</p>
                            <p><span class="text-dark">Phương thức:</span> {{ $bill->payment_method }}</p>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered text-center">
                    <thead class="bg-light">
                        <tr class="text-dark">
                            <th>#</th>
                            <th>Dịch vụ / Sản phẩm</th>
                            <th>Mô tả</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp

                        {{-- Phòng đã đặt --}}
                        @foreach ($bill->rooms as $room)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="text-start">Thuê phòng</td>
                                <td>{{ $room->room_name }}</td>
                                <td>{{ number_format($room->price_per_night) }}đ</td>
                                <td>{{ $room->nights }} đêm</td>
                                <td>{{ number_format($room->total_price) }}đ</td>
                            </tr>
                        @endforeach

                        {{-- Dịch vụ đã dùng --}}
                        @foreach ($bill->services as $service)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="text-start">{{ $service->service_name }}</td>
                                <td>-</td>
                                <td>{{ number_format($service->unit_price) }}đ</td>
                                <td>{{ $service->quantity }}</td>
                                <td>{{ number_format($service->total_price) }}đ</td>
                            </tr>
                        @endforeach

                        {{-- Phụ thu --}}
                        @foreach ($bill->fees as $fee)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="text-start">{{ $fee->fee_name }}</td>
                                <td>{{ $fee->description ?? '-' }}</td>
                                <td>{{ number_format($fee->amount) }}đ</td>
                                <td>1</td>
                                <td>{{ number_format($fee->amount) }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row justify-content-end mt-4">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-end">Tiền phòng:</td>
                                    <td class="text-end">{{ number_format($bill->room_amount, 0, ',', '.') }}đ</td>
                                </tr>
                                <tr>
                                    <td class="text-end">Dịch vụ:</td>
                                    <td class="text-end">{{ number_format($bill->service_amount, 0, ',', '.') }}đ</td>
                                </tr>
                                <tr>
                                    <td class="text-end">Phụ thu:</td>
                                    <td class="text-end">{{ number_format($bill->fee_amount, 0, ',', '.') }}đ</td>
                                </tr>
                                <tr>
                                    <td class="text-end">Giảm giá:</td>
                                    <td class="text-end text-danger">-{{ number_format($bill->discount, 0, ',', '.') }}đ</td>
                                </tr>
                                <tr>
                                    <td class="text-end">VAT ({{ $bill->vat_percent }}%):</td>
                                    <td class="text-end">{{ number_format($bill->vat_amount, 0, ',', '.') }}đ</td>
                                </tr>
                                <tr class="h4">
                                    <td class="text-end fw-bold">Tổng cộng:</td>
                                    <td class="text-end fw-bold text-dark">{{ number_format($bill->final_amount, 0, ',', '.') }}đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@endsection
