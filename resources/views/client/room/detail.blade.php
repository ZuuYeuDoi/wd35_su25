@extends('client.index')

@push('css')
<style>
    .btn-check:checked + .btn {
        background-color: #0d6efd;
        color: #fff;
    }
    .btn.active {
        background-color: #0d6efd;
        color: #fff;
    }
</style>
@endpush

@section('content')
<section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
    <div class="auto-container text-center">
        <h1 class="title">{{ $roomType->name }} - {{ $roomType->type }}</h1>
        <ul class="page-breadcrumb">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>
            <li>Loại phòng</li>
        </ul>
    </div>
</section>

<section class="pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="text-center mb-4">
                    <div style="width: 600px; height: 400px; margin: 0 auto; overflow: hidden; border-radius: 10px;">
                        <img id="main-room-image"
                             src="{{ asset('storage/' . ($roomType->images->first()->image_path ?? $roomType->image)) }}"
                             alt="Ảnh phòng chính"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>

                @if ($roomType->images->count())
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @foreach ($roomType->images as $img)
                            <div style="width: 100px; height: 70px; cursor: pointer; overflow: hidden; border-radius: 5px;">
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                     class="img-thumbnail room-thumbnail"
                                     data-src="{{ asset('storage/' . $img->image_path) }}"
                                     style="width: 100%; height: 100%; object-fit: cover; padding: 0;">
                            </div>
                        @endforeach
                    </div>
                @endif

                <h3 class="mt-5">Giới thiệu loại phòng</h3>
                <p>Loại giường: <strong>{{ $roomType->bed_type ?? 'Không rõ' }}</strong></p>
                <p>Giá từ: <strong>{{ number_format($roomType->room_type_price, 0, ',', '.') }} VND</strong></p>

                <h4 class="mt-4">Tiện nghi</h4>
                <div class="row">
                    @forelse ($allAmenities as $amenity)
                        <div class="col-md-4 col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $amenity->image) }}"
                                     class="me-2 rounded" width="30" height="30">
                                <span>{{ $amenity->name }}</span>
                            </div>
                        </div>
                    @empty
                        <p><em>Không có tiện nghi</em></p>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-4 bg-light rounded shadow-sm">
                    <h5 class="mb-3">Đặt phòng</h5>

                    <form id="booking-form" action="{{ route('booking.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" id="room_type_id" name="room_type_id" value="{{ $roomType->id }}">

                        <div class="btn-group mb-3" role="group">
                            <input type="radio" class="btn-check" name="booking_type" id="overnight" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="overnight">Chỗ ở Qua Đêm</label>

                            <input type="radio" class="btn-check" name="booking_type" id="day_use" autocomplete="off">
                            <label class="btn btn-outline-primary" for="day_use">Chỗ ở Trong Ngày</label>
                        </div>

                        <div class="mb-3">
                            <label>Ngày nhận phòng</label>
                            <input type="date" id="checkin" name="check_in" class="form-control"
                                   value="{{ $checkIn }}" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3" id="checkout-wrapper">
                            <label>Ngày trả phòng</label>
                            <input type="date" id="checkout" name="check_out" class="form-control"
                                   value="{{ $checkOut }}" min="{{ $checkIn }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Số lượng phòng</label>
                            <input type="number" name="number_of_rooms" id="number_of_rooms" class="form-control"
                                   value="1" min="1" max="{{ $availableRoomsCount }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Người lớn</label>
                            <input type="number" name="adults" id="adults" class="form-control" value="2" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label>Trẻ em</label>
                            <input type="number" name="children" id="children" class="form-control" value="0" min="0" required>
                        </div>

                        <p>Số phòng còn trống: <span id="available-count" class="fw-bold text-success">{{ $availableRoomsCount }}</span></p>
                        <p id="warning-no-room" class="text-danger fw-bold d-none">⚠ Không còn phòng trong khoảng thời gian này.</p>

                        <button type="submit" class="btn btn-primary w-100" id="submit-btn">Tiếp tục đặt phòng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mainImage = document.getElementById('main-room-image');
        const thumbnails = document.querySelectorAll('.room-thumbnail');
        const overnightBtn = document.getElementById('overnight');
        const dayUseBtn = document.getElementById('day_use');
        const checkoutWrapper = document.getElementById('checkout-wrapper');
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');
        const numberOfRoomsInput = document.getElementById('number_of_rooms');
        const availableSpan = document.getElementById('available-count');
        const warningText = document.getElementById('warning-no-room');
        const submitBtn = document.getElementById('submit-btn');
        const roomTypeId = document.getElementById('room_type_id').value;

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function () {
                mainImage.src = this.getAttribute('data-src');
            });
        });

        overnightBtn.addEventListener('change', syncDate);
        dayUseBtn.addEventListener('change', syncDate);
        checkinInput.addEventListener('change', function () {
            if (dayUseBtn.checked) checkoutInput.value = checkinInput.value;
            handleCheck();
        });
        checkoutInput.addEventListener('change', handleCheck);

        function syncDate() {
            checkoutWrapper.style.display = dayUseBtn.checked ? 'none' : '';
            if (dayUseBtn.checked) checkoutInput.value = checkinInput.value;
            handleCheck();
        }

        function handleCheck() {
            const checkIn = checkinInput.value;
            const checkOut = checkoutInput.value;

            if (!checkIn || !checkOut) return;

            fetch(`{{ route('room_type.check_availability') }}?room_type_id=${roomTypeId}&check_in=${checkIn}&check_out=${checkOut}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        availableSpan.textContent = data.available;
                        numberOfRoomsInput.max = data.available;
                        warningText.classList.add('d-none');
                        submitBtn.disabled = data.available === 0;
                        availableSpan.classList.toggle('text-danger', data.available === 0);
                        availableSpan.classList.toggle('text-success', data.available > 0);
                    } else {
                        availableSpan.textContent = 'Lỗi';
                        warningText.classList.remove('d-none');
                        submitBtn.disabled = true;
                    }
                })
                .catch(() => {
                    availableSpan.textContent = 'Lỗi';
                    warningText.classList.remove('d-none');
                    submitBtn.disabled = true;
                });
        }

        document.getElementById('booking-form').addEventListener('submit', function (e) {
            const numberOfRooms = parseInt(numberOfRoomsInput.value) || 0;
            const adults = parseInt(document.getElementById('adults').value) || 0;
            const children = parseInt(document.getElementById('children').value) || 0;
            const totalPeople = adults + children;
            const maxPeoplePerRoom = 2;
            const maxPeopleAllow = numberOfRooms * maxPeoplePerRoom;

            if (totalPeople > maxPeopleAllow) {
                alert(`Mỗi phòng tối đa ${maxPeoplePerRoom} người.\nBạn đang chọn ${numberOfRooms} phòng nhưng tới ${totalPeople} người.`);
                e.preventDefault();
            }
        });

        syncDate();
    });
</script>
@endpush
