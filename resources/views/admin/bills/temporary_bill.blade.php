@extends('layouts.admin')

@section('title1', 'Hóa đơn tạm tính')

@push('css')
    <style>
        .costs-incurred{
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .costs-incurred .image{
            width: 100px;
            height: 70px;
        }
        .costs-incurred .image img{
            width: 100%;
            height: 100%;
            object-fit: scale-down;
        }
        .td-costs-incurred {
            width: 40%;
        }
    </style>
@endpush
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
            {{-- Bảng phòng --}}
<div class="table-responsive mb-4">
    <table class="table table-bordered align-middle">
        <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Phòng</th>
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
                $total = 0;
                $i = 1;
            @endphp

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
        </tbody>
    </table>
</div>

{{-- Bảng dịch vụ --}}
@if ($groupedItems->count())
<div class="table-responsive mb-4">
    <table id="service-table" class="table table-bordered align-middle">
        <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Dịch vụ</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedItems as $item)
                @php
                    $service = $item->service;
                    $total += $item->total_price;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $service->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
                    <td>{{ number_format($item->total_price, 0, ',', '.') }}đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Tổng cộng --}}
<div class="text-end fw-bold mb-4">
    Tổng cộng: <span id="total-price" class="text-danger">{{ number_format($total, 0, ',', '.') }}đ</span>
</div>


            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Ảnh/ Tên</th>
                            <th>mô tả</th>
                            <th>Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($costsIncurred as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="td-costs-incurred">
                                    <div class="costs-incurred">
                                        <div class="image">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Ảnh chi phí phát sinh">
                                        </div>
                                        <div class="name">{{ $item->name }}</div>
                                    </div>
                                </td>
                                <td>{{$item->description}}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach

                    </tbody>
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
                            <div
                                class="quantity-box p-3 bg-light rounded-3 position-absolute w-100 bottom-0 start-0 d-none">
                                <h6 class="fw-bold mb-2">{{ $service->name }}</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <button class="btn btn-outline-secondary btn-sm minus">-</button>
                                    <input type="number" class="form-control w-50 text-center mx-2" value="1"
                                        min="1">
                                    <button class="btn btn-outline-secondary btn-sm plus">+</button>
                                </div>
                                <button class="btn btn-success btn-sm rounded-pill w-100 confirm-service"
                                    data-service-id="{{ $service->id }}" data-service-name="{{ $service->name }}"
                                    data-service-price="{{ $service->price }}">
                                    Xác nhận
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mb-3 text-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFeeModal">
                Chi phí phát sinh
            </button>
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

    <!-- Modal Thêm Chi Phí Phát Sinh -->
    <div class="modal fade" id="addFeeModal" tabindex="-1" aria-labelledby="addFeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('fees.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm chi phí phát sinh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên chi phí</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hình ảnh (tùy chọn)</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá tiền</label>
                            <input type="number" class="form-control" name="price" required min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('script')
    {{-- script nhỏ để demo mở box + cộng trừ số lượng --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const boxes = document.querySelectorAll('.service-box');
            boxes.forEach(box => {
                box.querySelector('.btn-primary').addEventListener('click', () => {
                    document.querySelectorAll('.quantity-box').forEach(q => q.classList.add(
                        'd-none'));
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
                button.addEventListener('click', function() {
                    const serviceBox = this.closest('.service-box');
                    const serviceId = this.dataset.serviceId;
                    const serviceName = this.dataset.serviceName;
                    const servicePrice = parseInt(this.dataset.servicePrice);
                    const quantity = parseInt(serviceBox.querySelector('input[type="number"]')
                        .value);

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
                    const serviceTable = document.querySelector('#service-table tbody');
                    const totalPriceEl = document.querySelector('#total-price');
                    const totalPriceValue = parseInt(totalPriceEl.textContent.replace(/\D/g, '')) || 0;
                    const newServiceTotal = servicePrice * quantity;

                    // Kiểm tra xem dịch vụ đã tồn tại trong bảng chưa
                    let existingRow = Array.from(serviceTable.querySelectorAll('tr')).find(tr => {
                        return tr.querySelector('td:nth-child(2)')?.innerText.trim() === serviceName;
                    });

                    if (existingRow) {
                        // Cộng dồn số lượng và thành tiền
                        let qtyCell = existingRow.querySelector('td:nth-child(3)');
                        let priceCell = existingRow.querySelector('td:nth-child(5)');

                        let currentQty = parseInt(qtyCell.innerText) || 0;
                        let newQty = currentQty + quantity;
                        qtyCell.innerText = newQty;

                        let newTotal = servicePrice * newQty;
                        priceCell.innerText = newTotal.toLocaleString() + 'đ';
                    } else {
                        // Thêm dòng mới
                        const newRow = document.createElement('tr');
                        const currentIndex = serviceTable.querySelectorAll('tr').length + 1;
                        newRow.innerHTML = `
                            <td>${currentIndex}</td>
                            <td>${serviceName}</td>
                            <td>${quantity}</td>
                            <td>${servicePrice.toLocaleString()}đ</td>
                            <td>${newServiceTotal.toLocaleString()}đ</td>
                        `;
                        serviceTable.appendChild(newRow);
                    }

                    // Cập nhật tổng cộng
                    totalPriceEl.textContent = (totalPriceValue + newServiceTotal).toLocaleString() + 'đ';

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
