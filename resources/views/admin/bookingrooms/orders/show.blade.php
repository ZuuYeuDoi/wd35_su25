@extends('layouts.admin')

@section('title1', 'Chi tiết Đơn đặt')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Chi tiết Đơn đặt</h2>
        </header>

        <form action="{{ route('room_order.update', $booking->id) }}" method="POST"
            class="order-details action-buttons-fixed">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Thông tin chung -->
                <div class="col-xl-4 mb-4 mb-xl-0">
                    <div class="card card-modern">
                        <div class="card-header">
                            <h2 class="card-title">Thông tin chung</h2>
                        </div>
                        <div class="card-body">
                            <!-- Trạng thái -->
                            <div class="form-row">
                                <div class="form-group col mb-3">
                                    <label>Trạng thái</label>
                                    <select class="form-control" name="status" required>
                                        <option value="0" {{ $booking->status == 0 ? 'selected' : '' }}>Chưa xác nhận
                                        </option>
                                        <option value="1" {{ $booking->status == 1 ? 'selected' : '' }}>Đã xác nhận
                                        </option>
                                        <option value="2" {{ $booking->status == 2 ? 'selected' : '' }}>Hoàn tất
                                        </option>
                                        <option value="3" {{ $booking->status == 3 ? 'selected' : '' }}>Đã huỷ</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Ngày tạo -->
                            <div class="form-row">
                                <div class="form-group col mb-3">
                                    <label>Ngày tạo</label>
                                    <div class="date-time-field">
                                        <div class="date">
                                            <input type="text" class="form-control form-control-modern" name="orderDate"
                                                value="{{ $booking->created_at ? $booking->created_at->format('d-m-Y') : '' }}
"
                                                readonly />
                                        </div>
                                        <div class="time">
                                            <span class="px-2">@</span>
                                            <input type="text" class="form-control form-control-modern text-center"
                                                name="orderTimeHour"
                                                value="{{ $booking->created_at ? $booking->created_at->format('H') : '' }}"
                                                readonly />
                                            <span class="px-2">:</span>
                                            <input type="text" class="form-control form-control-modern text-center"
                                                name="orderTimeMin"
                                                value="{{ $booking->created_at ? $booking->created_at->format('i') : '' }}"
                                                readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Khách hàng -->
                            @php
                                $custommer = $booking->user ?? $booking->guest;
                            @endphp
                            <div class="form-row">
                                <div class="form-group col mb-3">
                                    <label>Khách hàng</label>
                                    <input type="text" class="form-control form-control-modern"
                                        value="{{ $custommer->name }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Địa chỉ -->
                <div class="col-xl-8">
                    <div class="card card-modern">
                        <div class="card-header">
                            <h2 class="card-title">Thông tin liên hệ</h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Thông tin khách -->
                                <div class="col-xl-6 mb-4">
                                    <h3 class="text-color-dark font-weight-bold text-4 line-height-1 mt-0 mb-3">KHÁCH HÀNG
                                    </h3>
                                    <li>{{ $booking->user->address ?? $booking->guest->address }}</li>
                                    <strong class="d-block text-color-dark">Email:</strong>
                                    <li>{{ $custommer->email ?? '---' }}</li>

                                    <strong class="d-block text-color-dark mt-3">Điện thoại:</strong>
                                    <li>{{ $custommer->phone ?? '---' }}</li>
                                </div>

                                <!-- Nhận phòng -->
                                <div class="col-xl-6">
                                    <h3 class="font-weight-bold text-color-dark text-4 line-height-1 mt-0 mb-3">THỜI GIAN
                                    </h3>
                                    <ul class="list list-unstyled list-item-bottom-space-0">
                                        <li>Ngày nhận:
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d-m-Y') }} lúc 14h
                                        </li>
                                        <li>Ngày trả:
                                            {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }} lúc 12h
                                        </li>

                                    </ul>
                                    <ul class="list list-unstyled list-item-bottom-space-0">
                                        <li>
                                            Tiền đặt cọc: {{ number_format($booking->deposit) }}đ
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phòng -->
            <div class="row">
                <div class="col">
                    <div class="card card-modern">
                        <div class="card-header">
                            <h2 class="card-title">Thông tin phòng</h2>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên phòng</th>
                                            <th class="text-end">Giá</th>
                                            <th class="text-end">Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td>{{ $booking->room->id }}</td>
                                            <td>{{ $booking->room->title }}</td>
                                            <td class="text-end">{{ number_format($booking->room->price) }}đ</td>
                                            <td class="text-end">{{ number_format($booking->room->price) }}đ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tổng tiền -->
                            <div class="row justify-content-end mt-4">
                                <div class="col-auto me-5">
                                    <h3 class="font-weight-bold text-color-dark text-4 mb-3">Tổng cộng</h3>
                                    <strong
                                        class="text-color-dark text-5">{{ number_format($booking->room->price) }}đ</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút -->
            <div class="row action-buttons mt-4">
                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-success px-4 py-3">
                        <i class="bx bx-save text-4 me-2"></i> Cập nhật trạng thái
                    </button>
                </div>
                <div class="col-12 col-md-auto mt-3 mt-md-0">
                    <a href="{{ route('room_order.index') }}" class="btn btn-secondary px-4 py-3">
                        Quay lại
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
