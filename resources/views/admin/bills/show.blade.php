@extends('layouts.admin')

@section('title1', 'Chi tiết hóa đơn')

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Chi tiết hóa đơn</h2>
    </header>

    <div class="row">
        <!-- Thông tin chung -->
        <div class="col-xl-4 mb-4 mb-xl-0">
            <div class="card card-modern">
                <div class="card-header">
                    <h2 class="card-title">Thông tin chung</h2>
                </div>
                <div class="card-body">
                    <!-- Ngày tạo -->
                    <div class="form-group mb-3">
                        <label>Ngày tạo</label>
                        <div class="d-flex">
                            <input type="text" class="form-control me-1" value="{{ $bill->created_at->format('d-m-Y') }}" readonly>
                            <input type="text" class="form-control text-center ms-1" style="width: 80px;" value="{{ $bill->created_at->format('H:i') }}" readonly>
                        </div>
                    </div>

                    <!-- Khách hàng -->
                    <div class="form-group mb-3">
                        <label>Khách hàng</label>
                        <input type="text" class="form-control" value="{{ $bill->customer_name }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" value="{{ $bill->customer_phone }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin thanh toán -->
        <div class="col-xl-8">
            <div class="card card-modern">
                <div class="card-header">
                    <h2 class="card-title">Thông tin thanh toán</h2>
                </div>
                <div class="card-body">
                    <ul class="list list-unstyled">
                        <li><strong>Mã hóa đơn:</strong> {{ $bill->bill_code }}</li>
                        <li><strong>Phương thức thanh toán:</strong> {{ $bill->payment_method }}</li>
                        <li><strong>Ngày thanh toán:</strong> {{ \Carbon\Carbon::parse($bill->payment_date)->format('d/m/Y') }}</li>
                        <li><strong>VAT:</strong> {{ $bill->vat_percent }}% ({{ number_format($bill->vat_amount) }}đ)</li>
                        <li><strong>Tổng thanh toán:</strong> <span class="text-danger h5">{{ number_format($bill->final_amount) }}đ</span></li>
                        <li><strong>Ghi chú:</strong> {{ $bill->note ?? '---' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin phòng -->
    <div class="row mt-4">
        <div class="col">
            <div class="card card-modern">
                <div class="card-header">
                    <h2 class="card-title">Phòng đã thuê</h2>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Tên phòng</th>
                                <th>Giá/đêm</th>
                                <th>Số đêm</th>
                                <th>Người lớn</th>
                                <th>Trẻ em</th>
                                <th>Ghi chú</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bill->billRooms as $room)
                            <tr>
                                <td>{{ $room->room_name }}</td>
                                <td>{{ number_format($room->price_per_night) }}đ</td>
                                <td>{{ $room->nights }}</td>
                                <td>{{ $room->adults }}</td>
                                <td>{{ $room->children }}</td>
                                <td>{{ $room->note ?? '---' }}</td>
                                <td>{{ number_format($room->total_price) }}đ</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có dữ liệu</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Dịch vụ -->
    <div class="row mt-4">
        <div class="col">
            <div class="card card-modern">
                <div class="card-header">
                    <h2 class="card-title">Dịch vụ sử dụng</h2>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Tên dịch vụ</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bill->billServices as $service)
                            <tr>
                                <td>{{ $service->service_name }}</td>
                                <td>{{ number_format($service->unit_price) }}đ</td>
                                <td>{{ $service->quantity }}</td>
                                <td>{{ number_format($service->total_price) }}đ</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Không có dịch vụ nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Phụ phí -->
    <div class="row mt-4">
        <div class="col">
            <div class="card card-modern">
                <div class="card-header">
                    <h2 class="card-title">Phụ phí</h2>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Tên phụ phí</th>
                                <th>Mô tả</th>
                                <th>Số tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bill->billFees as $fee)
                            <tr>
                                <td>{{ $fee->fee_name }}</td>
                                <td>{{ $fee->description }}</td>
                                <td>{{ number_format($fee->amount) }}đ</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Không có phụ phí nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút -->
    <div class="row action-buttons mt-4">
        <div class="col-12 col-md-auto mt-3 mt-md-0">
            <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-secondary px-4 py-3">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
</section>
@endsection