@extends('layouts.admin')

@section('title1', 'Chi tiết Đơn đặt')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Chi tiết Đơn đặt</h2>
        </header>
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
                                <select class="form-control" name="status" disabled>
                                    <option value="1" {{ $booking->status == 1 ? 'selected' : '' }}>
                                        Đã thanh toán cọc
                                    </option>
                                    <option value="2" {{ $booking->status == 2 ? 'selected' : '' }}>
                                        Hoàn tất checkin
                                    </option>
                                    <option value="3" {{ $booking->status == 3 ? 'selected' : '' }}>
                                        Hoàn tất thanh toán
                                    </option>
                                    <option value="4" {{ $booking->status == 4 ? 'selected' : '' }}>
                                        Hoàn tất check out
                                    </option>
                                    <option value="5" {{ $booking->status == 5 ? 'selected' : '' }}>
                                        Huỷ
                                    </option>
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
                        <div class="form-row">
                            <div class="form-group col mb-3">
                                <label>Khách hàng</label>
                                <input type="text" class="form-control form-control-modern"
                                    value="{{ $booking->user->name }}" readonly>
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
                                <strong class="d-block text-color-dark">Họ và tên:</strong>
                                <li>{{ $booking->user->name ?? '---' }}</li>

                                <strong class="d-block text-color-dark">Email:</strong>
                                <li>{{ $booking->user->email ?? '---' }}</li>

                                <strong class="d-block text-color-dark mt-3">Điện thoại:</strong>
                                <li>{{ $booking->user->phone ?? '---' }}</li>

                            </div>

                            <!-- Nhận phòng -->
                            <div class="col-xl-6">
                                <h3 class="font-weight-bold text-color-dark text-4 line-height-1 mt-0 mb-3">THỜI GIAN DỰ
                                    KIẾN
                                </h3>
                                <ul class="list list-unstyled list-item-bottom-space-0">
                                    <li>Ngày nhận dự kiến:
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d-m-Y') }} lúc 14h
                                    </li>
                                    <li>Ngày trả dự kiến:
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }} lúc 12h
                                    </li>

                                </ul>
                                <ul class="list list-unstyled list-item-bottom-space-0">
                                    <li>
                                        Tiền đã đặt cọc: {{ number_format($booking->deposit) }}đ
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
                                        <th>Loại phòng</th>
                                        <th class="text-end">Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($booking->bookingRooms as $bookingRoom)
                                        <tr>
                                            <td>{{ $bookingRoom->room->id }}</td>
                                            <td>{{ $bookingRoom->room->title }}</td>
                                            <td>{{ $bookingRoom->room->roomType->name }}</td>
                                            <td class="text-end">{{ number_format($bookingRoom->room->price) }}đ</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Không có phòng nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút -->
        <div class="row action-buttons mt-4">
            @if ($booking->status == 1)
                <div class="col-12 col-md-auto mt-3 mt-md-0">
                    <a href="{{ route('room_order.index') }}" class="btn btn-secondary px-4 py-3">
                        Quay lại
                    </a>
                </div>
            @elseif ($booking->status == 2)
                <div class="col-12 col-md-auto mt-3 mt-md-0">
                    <a href="{{ route('bills.temporary', $booking->id) }}" class="btn btn-success px-4 py-3">
                        Hóa đơn tạm tính
                    </a>
                </div>
                <div class="col-12 col-md-auto mt-3 mt-md-0">
                    <a href="{{ route('room_order.index') }}" class="btn btn-secondary px-4 py-3">
                        Quay lại
                    </a>
                </div>
            @elseif ($booking->status == 3)
                <div class="col-12 col-md-auto mt-3 mt-md-0">
                    <a href="{{ route('bills.show', $booking->id) }}" class="btn btn-primary px-4 py-3">
                        Xem hóa đơn
                    </a>
                </div>
                <div class="col-12 col-md-auto mt-3 mt-md-0">
                    <a href="{{ route('room_order.index') }}" class="btn btn-secondary px-4 py-3">
                        Quay lại
                    </a>
                </div>
            @else
                <div class="col-12 col-md-auto mt-3 mt-md-0">
                    <a href="{{ route('room_order.index') }}" class="btn btn-secondary px-4 py-3">
                        Quay lại
                    </a>
                </div>
            @endif
           @if ($booking->status != 5 && $booking->status != 4 && $booking->status != 2)
        <form action="{{ route('room_order.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn này?');">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <label for="note" class="form-label fw-bold">Lý do hủy đơn:</label>
                <textarea name="note" id="note" rows="2" class="form-control" placeholder="Nhập lý do..."></textarea>
            </div>

            <button type="submit" class="btn btn-danger px-4 py-3">
                Hủy đơn
            </button>
        </form>
@endif

        </div>

    </section>
@endsection
