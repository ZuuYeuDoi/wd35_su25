@extends('layouts.admin')

@section('title1', 'Hóa đơn tạm tính')

@section('content')
<section role="main" class="content-body">
    <header class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-6 mb-0">Hóa đơn tạm tính</h2>
    </header>

    <div class="card shadow rounded-4 p-4 mb-5">
        {{-- Thông tin khách hàng --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="fw-bold">Thông tin khách hàng</h5>
                <p class="mb-1"><strong>Tên:</strong> {{ $booking->user->name }}</p>
                <p class="mb-1"><strong>Số điện thoại:</strong> {{ $booking->user->phone }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $booking->user->email }}</p>
                <p class="mb-1"><strong>Địa chỉ:</strong> {{ $booking->user->address ?? '---' }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5 class="fw-bold">Chi tiết hóa đơn</h5>
                <p class="mb-1"><strong>Mã hóa đơn:</strong> HD{{ $booking->id }}</p>
                <p class="mb-1"><strong>Ngày lập:</strong> {{ $booking->created_at->format('d/m/Y') }}</p>
                <p class="mb-1"><strong>Trạng thái:</strong> Tạm tính</p>
            </div>
        </div>

        {{-- Bảng hóa đơn --}}
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Dịch vụ / Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        use Carbon\Carbon;
                        $nights = Carbon::parse($booking->check_in_date)->diffInDays(Carbon::parse($booking->check_out_date));
                        if ($nights == 0) $nights = 1;
                    @endphp
                    @php $total = 0; $i = 1; @endphp

                    {{-- Phòng --}}
                    @foreach ($booking->bookingRooms as $bookingRoom)
                        @php
                            $room = $bookingRoom->room;
                            $roomPrice = $room->price;
                            $roomTotal = $roomPrice * $nights;
                            $total += $roomTotal;
                        @endphp
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $room->title }} ({{ $room->roomType->name }})</td>
                            <td>{{ $nights }} đêm</td>
                            <td>{{ number_format($roomPrice, 0, ',', '.') }}đ / đêm</td>
                            <td>{{ number_format($roomTotal, 0, ',', '.') }}đ</td>
                        </tr>
                    @endforeach

                    {{-- Dịch vụ từ tất cả cart --}}
                    @if ($groupedItems->count())
                        @foreach ($groupedItems as $item)
                            @php
                                $service = $item->service;
                            @endphp
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($item->total_price, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    @endif


                    {{-- Phụ phí --}}
                    @if ($booking->feeIncurreds->count())
                        <tr class="table-secondary">
                            <td colspan="5" class="fw-bold">Phụ phí phát sinh</td>
                        </tr>
                        @foreach ($booking->feeIncurreds as $fee)
                            @php $total += $fee->amount; @endphp
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $fee->name }}</td>
                                <td>1 lần</td>
                                <td>{{ number_format($fee->amount, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($fee->amount, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Tổng cộng</td>
                        <td class="fw-bold text-danger">{{ number_format($total, 0, ',', '.') }}đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Box thêm dịch vụ --}}
    <div class="card shadow rounded-4 p-4 mb-5">
        <div class="row g-3 mb-4 text-center">
            @foreach ($services as $service)
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm rounded-4 service-box position-relative" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <h6 class="fw-bold">{{ $service->name }}</h6>
                            <p class="text-muted mb-2">
                                {{ $service->price > 0 ? number_format($service->price, 0, ',', '.') . 'đ' : 'Miễn phí' }}
                            </p>
                            <button class="btn btn-primary btn-sm rounded-pill">Chọn</button>
                        </div>
                        <div class="quantity-box p-3 bg-light rounded-3 position-absolute w-100 bottom-0 start-0 d-none">
                            <h6 class="fw-bold mb-2">{{ $service->name }}</h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <button class="btn btn-outline-secondary btn-sm minus">-</button>
                                <input type="number" class="form-control w-50 text-center mx-2" value="1" min="1">
                                <button class="btn btn-outline-secondary btn-sm plus">+</button>
                            </div>
                            <button class="btn btn-success btn-sm rounded-pill w-100 confirm-service"
                                data-service-id="{{ $service->id }}"
                                data-service-name="{{ $service->name }}"
                                data-service-price="{{ $service->price }}">
                                Xác nhận
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="alert alert-info rounded-3">
        Đây là hóa đơn tạm tính, chưa phải hóa đơn xuất chính thức. Mọi thông tin sẽ được xác nhận khi thanh toán.
    </div>

    <div class="text-end">
        <form action="{{ route('bills.confirm', $booking->id) }}" method="POST"
              onsubmit="return confirm('Xác nhận thanh toán đơn này?');">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-primary rounded-pill px-4">Xác nhận & Thanh toán</button>
        </form>
    </div>
</section>
@endsection

@section('script')
{{-- script nhỏ để demo mở box + cộng trừ số lượng --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const boxes = document.querySelectorAll('.service-box');
        boxes.forEach(box => {
            box.querySelector('.btn-primary').addEventListener('click', () => {
                document.querySelectorAll('.quantity-box').forEach(q => q.classList.add('d-none'));
                box.querySelector('.quantity-box').classList.remove('d-none');
            });

            box.querySelector('.plus').addEventListener('click', () => {
                const input = box.querySelector('input[type="number"]');
                input.value = parseInt(input.value) + 1;
            });

            box.querySelector('.minus').addEventListener('click', () => {
                const input = box.querySelector('input[type="number"]');
                if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
            });
        });


        document.querySelectorAll('.confirm-service').forEach(button => {
            button.addEventListener('click', function () {
                const serviceBox = this.closest('.service-box');
                const serviceId = this.dataset.serviceId;
                const serviceName = this.dataset.serviceName;
                const servicePrice = parseInt(this.dataset.servicePrice);
                const quantity = parseInt(serviceBox.querySelector('input[type="number"]').value);

                fetch("{{ route('cart.add') }}", {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    body: JSON.stringify({
        booking_id: {{ $booking->id }},
        service_id: serviceId,
        quantity: quantity
    })
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        const tbody = document.querySelector('table tbody');
        const totalCell = document.querySelector('tfoot td.text-danger');
        const totalPrice = servicePrice * quantity;

        // 🔍 Kiểm tra xem dịch vụ đã có trong bảng chưa
        let existingRow = Array.from(tbody.querySelectorAll('tr')).find(tr => {
            return tr.querySelector('td:nth-child(2)')?.innerText.trim() === serviceName;
        });

        if (existingRow) {
            // ✅ Nếu có -> cộng dồn số lượng và thành tiền
            let qtyCell = existingRow.querySelector('td:nth-child(3)');
            let priceCell = existingRow.querySelector('td:nth-child(5)');

            let currentQty = parseInt(qtyCell.innerText) || 0;
            let newQty = currentQty + quantity;
            qtyCell.innerText = newQty;

            let newTotal = servicePrice * newQty;
            priceCell.innerText = newTotal.toLocaleString() + 'đ';
        } else {
            // ❌ Nếu chưa có -> thêm dòng mới
            const newRow = document.createElement('tr');
            const currentIndex = tbody.querySelectorAll('tr').length + 1;

            newRow.innerHTML = `
                <td>${currentIndex}</td>
                <td>${serviceName}</td>
                <td>${quantity}</td>
                <td>${servicePrice.toLocaleString()}đ</td>
                <td>${totalPrice.toLocaleString()}đ</td>
            `;
            tbody.appendChild(newRow);
        }

        // ✅ Cập nhật tổng cộng
        const currentTotal = parseInt(totalCell.textContent.replace(/\D/g, '')) || 0;
        totalCell.textContent = (currentTotal + totalPrice).toLocaleString() + 'đ';

        // Ẩn box sau khi thêm
        serviceBox.querySelector('.quantity-box').classList.add('d-none');
    } else {
        alert(data.message || 'Thêm dịch vụ thất bại!');
    }
})
.catch(error => {
    console.error(error);
    alert('Có lỗi xảy ra!');
});

            });
        });
    });
</script>


@endsection