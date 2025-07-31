@extends('layouts.admin')
@section('title1', 'Danh sách đơn đặt phòng')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Danh sách đơn đặt phòng</h2>
        </header>

        <div class="row">
            <div class="col">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="bg-white shadow rounded px-4 py-3 mb-4">
                            <form action="{{ route('room_order.index') }}" method="GET">
                                <div class="row g-2 align-items-center">

                                    {{-- Loại ở --}}
                                    <div class="col-auto">
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="stay_type" id="overnight"
                                                value="overnight" autocomplete="off"
                                                {{ request('stay_type') === 'overnight' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="overnight">Qua đêm</label>

                                            <input type="radio" class="btn-check" name="stay_type" id="dayuse"
                                                value="dayuse" autocomplete="off"
                                                {{ request('stay_type') === 'dayuse' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="dayuse">Trong ngày</label>

                                            <input type="radio" class="btn-check" name="stay_type" id="all"
                                                value="" autocomplete="off"
                                                {{ request('stay_type') == '' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-secondary" for="all">Tất cả</label>
                                        </div>
                                    </div>

                                    {{-- Ngày nhận/trả --}}
                                    <div class="col-md-auto">
                                        <input type="date" name="check_in_date" class="form-control"
                                            value="{{ request('check_in_date') }}" >
                                    </div>
                                    <div class="col-md-auto">
                                        <input type="date" name="check_out_date" class="form-control"
                                            value="{{ request('check_out_date') }}"
                                            min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>

                                    {{-- Nút submit --}}
                                    <div class="col-md-auto">
                                        <button class="btn btn-primary" type="submit">Lọc đơn</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <table class="table table-ecommerce-simple table-borderless table-striped mb-0"
                            id="datatable-ecommerce-list" style="min-width: 720px;">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Khách hàng</th>
                                    <th>Ngày nhận phòng dự kiến</th>
                                    <th>Ngày trả phòng dự kiến</th>
                                    <th>Loại ở</th>
                                    <th>Tiền cọc</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    @php
                                        $checkIn = \Carbon\Carbon::parse($booking->check_in_date);
                                        $checkOut = \Carbon\Carbon::parse($booking->check_out_date);
                                        $stayType = $checkIn->isSameDay($checkOut) ? 'Trong ngày' : 'Qua đêm';
                                        $statusText = match ((int) $booking->status) {
                                            1 => 'Đã thanh toán cọc',
                                            2 => 'Hoàn tất check-in',
                                            3 => 'Hoàn tất thanh toán',
                                            4 => 'Hoàn tất check-out',
                                            5 => 'Đã hủy',
                                            default => 'Thanh toán Không thành công!',
                                        };

                                        $now = \Carbon\Carbon::now();
                                        $today = $now->toDateString();
                                        $currentHour = (int) $now->format('H');

                                        $isCheckinToday = $booking->check_in_date === $today;
                                        $isCheckoutToday = $booking->check_out_date === $today;

                                        $isCheckoutLate = $booking->status == 2 && $isCheckoutToday && $currentHour >= 6 && $currentHour <= 12;
                                        $isLateCheckin = $booking->status == 1 && $isCheckinToday && $currentHour >= 18;
                                    @endphp


                                    <tr>
                                        <td><strong>{{ $booking->id }}</strong></a></td>
                                        <td>{{ $booking->user->name ?? '---' }}</td>
                                        <td>{{ $checkIn->format('d/m/Y') }} lúc 14:00</td>
                                        <td>{{ $checkOut->format('d/m/Y') }} lúc 12:00</td>
                                        <td><span class="badge bg-info">{{ $stayType }}</span></td>
                                        <td>{{ number_format($booking->deposit, 0, ',', '.') }}đ</td>
                                        <td>
                                            @if ($isCheckoutLate)
                                                <span class="badge bg-danger"><i class="fas fa-clock"></i> Đến hạn check-out</span>
                                            @elseif ($isLateCheckin)
                                                <span class="badge bg-warning"><i class="fas fa-user-clock"></i> Khách chưa check-in</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $statusText }}</span>
                                            @endif
                                        </td>
                                       <td class="d-flex flex-row flex-wrap gap-2">
                                            <a href="{{ route('room_order.show', $booking->id) }}" class="btn btn-sm btn-warning">Chi tiết</a>

                                            @switch($booking->status)
                                                @case(2)
                                                    <a href="{{ route('bills.temporary', $booking->id) }}" class="btn btn-sm btn-success">Hóa đơn tạm tính</a>
                                                    @break

                                                @case(4)
                                                    @if ($booking->finalBill)
                                                        <a href="{{ route('bills.final', $booking->finalBill->id) }}" class="btn btn-sm btn-primary">Xem hóa đơn</a>
                                                    @endif
                                                    @break
                                            @endswitch
                                        </td>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Không có đơn đặt phòng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInInput = document.querySelector('input[name="check_in_date"]');
            const checkOutInput = document.querySelector('input[name="check_out_date"]');
            const stayTypeOvernight = document.getElementById('overnight');
            const stayTypeDayuse = document.getElementById('dayuse');

            // Cấm chọn ngày check_out trước hoặc bằng check_in
            checkInInput.addEventListener('change', function() {
                if (checkInInput.value) {
                    const minCheckoutDate = new Date(checkInInput.value);
                    minCheckoutDate.setDate(minCheckoutDate.getDate() + 1);
                    const minDateStr = minCheckoutDate.toISOString().split('T')[0];
                    checkOutInput.setAttribute('min', minDateStr);
                }
            });

            // Ẩn hiện trường ngày trả phòng nếu chọn "Trong ngày"
            function toggleCheckoutField() {
                const checkOutCol = checkOutInput.closest('.col-md-auto');
                if (stayTypeDayuse.checked) {
                    checkOutCol.style.display = 'none';
                    checkOutInput.value = ''; // Xoá giá trị cũ nếu có
                } else {
                    checkOutCol.style.display = '';
                }
            }

            stayTypeOvernight.addEventListener('change', toggleCheckoutField);
            stayTypeDayuse.addEventListener('change', toggleCheckoutField);

            // Gọi khi trang load để thiết lập ban đầu
            toggleCheckoutField();
        });
    </script>

@endsection
