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
                    @forelse ($groupedItems as $item)
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
                    @empty
                        <tr class="no-service-row">
                            <td colspan="5" class="text-center text-muted">Chưa có dịch vụ nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Bảng chi phí phát sinh --}}
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Ảnh/ Tên</th>
                        <th>Mô tả</th>
                        <th>Đơn giá</th>
                    </tr>
                </thead>
                <tbody>
                    @php $feesTotal = 0; @endphp
                    @foreach ($costsIncurred as $key => $item)
                        @php $feesTotal += $item->price; @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="td-costs-incurred">
                                <div class="costs-incurred">
                                    <div class="image">
                                        @if(!empty($item->image))
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Ảnh chi phí phát sinh" width="80">
                                        @endif
                                    </div>
                                    <div class="name">{{ $item->name }}</div>
                                </div>
                            </td>
                            <td>{{ $item->description }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tổng cộng sau chi phí phát sinh --}}
        @php $totalWithFees = $total + $feesTotal; @endphp
        <div class="text-end fw-bold mb-4">
            Tổng cộng: <span id="total-price" class="text-danger">{{ number_format($totalWithFees, 0, ',', '.') }}đ</span>
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
            <form action="{{ route('bills.confirm', $booking->id) }}" method="POST" onsubmit="return confirm('Xác nhận thanh toán đơn này?');">
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
                            <label class="form-label">Chọn tiện ích</label>
                            <select id="amenitySelect" class="form-select">
                                <option value="">-- Chọn tiện ích --</option>
                                @foreach($amenities as $amenity)
                                    <option value="{{ $amenity->id }}"
                                        data-name="{{ $amenity->name }}"
                                        data-price="{{ $amenity->price }}">
                                        {{ $amenity->name }} ({{ number_format($amenity->price) }} đ)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tên chi phí</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" id="feeName" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hình ảnh (tùy chọn)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giá tiền</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   name="price" id="feePrice" value="{{ old('price') }}" required min="0">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success">Thêm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var feeModal = new bootstrap.Modal(document.getElementById('addFeeModal'));
            feeModal.show();
        });
    </script>
    @endif

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
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

    const totalPriceEl = document.getElementById('total-price');
    let totalPriceValue = parseInt(totalPriceEl.textContent.replace(/\D/g, '')) || 0;

    document.querySelectorAll('.confirm-service').forEach(button => {
        button.addEventListener('click', function() {
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
                    const serviceTable = document.querySelector('#service-table tbody');
                    const newServiceTotal = servicePrice * quantity;

                    const noServiceRow = serviceTable.querySelector('.no-service-row');
                    if (noServiceRow) {
                        noServiceRow.remove();
                    }
                    // Kiểm tra xem dịch vụ đã tồn tại
                    let existingRow = Array.from(serviceTable.querySelectorAll('tr')).find(tr => {
                        return tr.querySelector('td:nth-child(2)')?.innerText.trim() === serviceName;
                    });

                    if (existingRow) {
                        let qtyCell = existingRow.querySelector('td:nth-child(3)');
                        let priceCell = existingRow.querySelector('td:nth-child(5)');
                        let currentQty = parseInt(qtyCell.innerText) || 0;
                        let newQty = currentQty + quantity;
                        qtyCell.innerText = newQty;
                        let newTotal = servicePrice * newQty;
                        priceCell.innerText = newTotal.toLocaleString() + 'đ';
                    } else {
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
                    totalPriceValue += newServiceTotal;
                    totalPriceEl.textContent = totalPriceValue.toLocaleString() + 'đ';

                    // Ẩn box
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

    const amenitySelect = document.getElementById('amenitySelect');
    const feeName = document.getElementById('feeName');
    const feePrice = document.getElementById('feePrice');

    amenitySelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const name = selected.getAttribute('data-name');
        const price = selected.getAttribute('data-price');
        if (name) feeName.value = name;
        if (price) feePrice.value = price;
    });
});
</script>
@endsection
