@extends('layouts.admin')

@section('title1', 'Chi tiết Đơn đặt phòng')

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Chi tiết Đơn đặt phòng #{{ $booking->id }}</h2>
    </header>

    <div class="row">
        <!-- Thông tin chung -->
        <div class="col-xl-4 mb-4 mb-xl-0">
            <div class="card card-modern">
                <div class="card-header">
                    <h2 class="card-title">Thông tin chung</h2>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label>Trạng thái</label>
                        <select class="form-control" disabled>
                            <option {{ $booking->status == 1 ? 'selected' : '' }}>Đã thanh toán cọc</option>
                            <option {{ $booking->status == 2 ? 'selected' : '' }}>Hoàn tất check-in</option>
                            <option {{ $booking->status == 3 ? 'selected' : '' }}>Hoàn tất thanh toán</option>
                            <option {{ $booking->status == 4 ? 'selected' : '' }}>Hoàn tất check-out</option>
                            <option {{ $booking->status == 5 ? 'selected' : '' }}>Hủy</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Ngày tạo đơn</label>
                        <input type="text" class="form-control" value="{{ $booking->created_at->format('d-m-Y H:i') }}" readonly />
                    </div>

                    <div class="form-group mb-3">
                        <label>Khách hàng</label>
                        <input type="text" class="form-control" value="{{ $booking->user->name }}" readonly />
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin liên hệ -->
        <div class="col-xl-8">
            <div class="card card-modern">
                <div class="card-header">
                    <h2 class="card-title">Thông tin liên hệ</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 mb-4">
                            <h4 class="font-weight-bold">Khách hàng</h4>
                            <p class="mb-1"><strong>Họ và tên:</strong> {{ $booking->user->name ?? '---' }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $booking->user->email ?? '---' }}</p>
                            <p class="mb-1"><strong>Điện thoại:</strong> {{ $booking->user->phone ?? '---' }}</p>
                        </div>

                        <div class="col-xl-6">
                            <h4 class="font-weight-bold">Thời gian</h4>
                            <ul class="list-unstyled mb-0">
                                <li>Dự kiến nhận phòng: {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d-m-Y') }} lúc 14:00</li>
                                <li>Dự kiến trả phòng: {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }} lúc 12:00</li>

                                @if ($booking->actual_check_in || $booking->actual_check_out)
                                    <hr>
                                    @if ($booking->actual_check_in)
                                        <li>Đã nhận phòng lúc: {{ \Carbon\Carbon::parse($booking->actual_check_in)->format('d-m-Y H:i') }}</li>
                                    @endif
                                    @if ($booking->actual_check_out)
                                        <li>Đã trả phòng lúc: {{ \Carbon\Carbon::parse($booking->actual_check_out)->format('d-m-Y H:i') }}</li>
                                    @endif
                                @endif
                                <hr>
                                <li>Tiền đã cọc: {{ number_format($booking->deposit) }}đ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin phòng -->
    <div class="row mt-4">
        <div class="col">
            <div class="card card-modern">
                <div class="card-header">
                    <h2 class="card-title">Danh sách phòng đã đặt</h2>
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

    <!-- Dịch vụ khách đã đặt -->
    <div class="row mt-4">
        <div class="col">
            <div class="card card-modern">
                <div class="card-header">
                    <h2 class="card-title">Dịch vụ khách đã đặt</h2>
                </div>
                <div class="card-body">
                    @if($booking->services && count($booking->services))
                        <ul class="list-unstyled mb-0">
                            @foreach ($booking->services as $service)
                                <li><strong>{{ $service->name }}</strong> - {{ number_format($service->price) }}đ</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-muted">Khách chưa chọn dịch vụ nào.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Phí phụ thu (Gia hạn ngày / giờ) -->
        <div class="row mt-4">
            <div class="col">
                <div class="card card-modern">
                    <div class="card-header">
                        <h2 class="card-title">Phụ thu</h2>
                    </div>
                    <div class="card-body">
                        @if($booking->feesIncurred && count($booking->feesIncurred))
                            <ul class="list-unstyled mb-0">
                                @foreach ($booking->feesIncurred as $fee)
                                    <li>
                                        <strong>{{ $fee->name }}</strong> - {{ number_format($fee->price) }}đ
                                        <div class="text-muted small">{{ $fee->description }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted">Không có phụ thu nào.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        
   <!-- Nút hành động -->
       @php
    use Carbon\Carbon;
    $now = Carbon::now();
    $checkInDate = Carbon::parse($booking->check_in_date);
    $isSameDay = $now->isSameDay($checkInDate);
    $isInTimeRange = $now->between(
        $checkInDate->copy()->setTime(14, 0),
        $checkInDate->copy()->setTime(18, 0)
    );
@endphp

@if ($booking->status == 1)
    <div>
        @if ($isSameDay && $isInTimeRange)
            <a href="{{ route('bills.temporary', $booking->id) }}" class="btn btn-secondary px-4 py-3">
                Nhận phòng
            </a>
        @else
            <button class="btn btn-secondary px-4 py-3" disabled>
                Nhận phòng (Chỉ từ 14h - 18h ngày {{ $checkInDate->format('d/m/Y') }})
            </button>
        @endif
    </div>
    <div>
        <form action="{{ route('room_order.cancel', $booking->id) }}" method="POST"
            onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn này?');">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <label for="note" class="form-label fw-bold">Lý do hủy đơn:</label>
                <textarea name="note" id="note" rows="2" class="form-control" placeholder="Nhập lý do..."></textarea>
            </div>

            <button type="submit" class="btn btn-danger px-4 py-3">Hủy đơn</button>
        </form>
    </div>




            @elseif ($booking->status == 2)
                <div>
                    <a href="{{ route('bills.temporary', $booking->id) }}" class="btn btn-success px-4 py-3">
                        Hóa đơn tạm tính
                    </a>
                </div>
                <div>
                    <a href="{{ route('room_order.extend_day', $booking->id) }}" class="btn btn-info px-4 py-3">
                        Gia hạn ngày
                    </a>
                </div>
                <div>
                    <a href="{{ route('room_order.extend_hour', $booking->id) }}" class="btn btn-warning px-4 py-3">
                        Gia hạn giờ
                    </a>
                </div>
            @elseif ($booking->status == 3)
                <div>
                    <a href="{{ route('bills.show', $booking->bill_id) }}" class="btn btn-primary px-4 py-3">
                        Xem hóa đơn
                    </a>
                </div>
            @endif

            <div>
                <a href="{{ route('room_order.index') }}" class="btn btn-secondary px-4 py-3">Quay lại</a>
            </div>
        </div>

</section>
@endsection
