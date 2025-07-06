@extends('client.index')

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
            <!-- LEFT -->
            <div class="col-lg-8">
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $roomType->image) }}" alt="{{ $roomType->name }}"
                         class="img-fluid rounded shadow">
                </div>
                <h3 class="mb-3">Giới thiệu loại phòng</h3>
                <p>Loại giường: <strong>{{ $roomType->bed_type ?? 'Không rõ' }}</strong></p>
                <p>Giá từ: <strong>{{ number_format($roomType->room_type_price, 0, ',', '.') }} VND</strong></p>
                <p>Số phòng còn trống: 
                   <span class="text-success fw-bold">{{ $availableRoomsCount }}</span>
                </p>

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

                <h4 class="mt-5">Danh sách phòng trong loại này</h4>
                @foreach ($roomType->rooms as $room)
                    <div class="card mb-3" id="room-{{ $room->id }}">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . ($room->images_room->first()->image_path ?? 'default.jpg')) }}"
                                    class="img-fluid rounded-start" alt="{{ $room->title }}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $room->title }}</h5>
                                    <p class="card-text">{{ $room->description }}</p>
                                    <p class="card-text"><strong>{{ number_format($room->price, 0, ',', '.') }} VND</strong></p>

                                    <button type="button" class="btn btn-sm btn-success" onclick="addToBooking({{ $room->id }}, '{{ $room->title }}', {{ $room->price }})">
                                        Đặt phòng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">
    <div class="p-4 bg-light rounded shadow-sm">
        <h5 class="mb-3">Đặt phòng</h5>

        <form action="{{ route('booking.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">

            <div class="mb-3">
                <label>Ngày nhận phòng</label>
                <input type="date" name="check_in" class="form-control" value="{{ $checkIn }}" min="{{ date('Y-m-d') }}" required>
            </div>

            <div class="mb-3">
                <label>Ngày trả phòng</label>
                <input type="date" name="check_out" class="form-control" value="{{ $checkOut }}" min="{{ $checkIn }}" required>
            </div>

            <div class="mb-3">
                <label>Số lượng phòng</label>
                <input type="number" name="number_of_rooms" class="form-control" value="1" min="1" max="{{ $availableRoomsCount }}" required>
            </div>

            <div class="mb-3">
                <label>Người lớn</label>
                <input type="number" name="adults" class="form-control" value="2" min="1" required>
            </div>

            <div class="mb-3">
                <label>Trẻ em</label>
                <input type="number" name="children" class="form-control" value="0" min="0" required>
            </div>

            <p class="mt-2 text-muted">
                Số phòng còn trống: <span class="fw-bold text-success">{{ $availableRoomsCount }}</span>
            </p>

            <button type="submit" class="btn btn-primary w-100">Tiếp tục đặt phòng</button>
        </form>
    </div>
</div>

        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const today = new Date().toISOString().split('T')[0];
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');
        const roomTypeId = document.getElementById('room_type_id').value;
        const availableSpan = document.getElementById('available-count');
        const dateRangeSpan = document.getElementById('date-range');

        // Giới hạn ngày hôm nay là min
        checkinInput.setAttribute('min', today);
        checkoutInput.setAttribute('min', today);

        checkinInput.addEventListener('change', function () {
            const checkinDate = new Date(this.value);
            const minCheckout = new Date(checkinDate);
            minCheckout.setDate(minCheckout.getDate() + 1);
            const minCheckoutStr = minCheckout.toISOString().split('T')[0];

            checkoutInput.setAttribute('min', minCheckoutStr);
            if (checkoutInput.value && checkoutInput.value <= this.value) {
                checkoutInput.value = '';
            }

            fetchAvailability();
        });

        checkoutInput.addEventListener('change', fetchAvailability);

        function fetchAvailability() {
            const checkIn = checkinInput.value;
            const checkOut = checkoutInput.value;

            if (!checkIn || !checkOut) return;

            dateRangeSpan.innerText = `${checkIn} đến ${checkOut}`;

            fetch(`{{ route('room_type.check_availability') }}?room_type_id=${roomTypeId}&check_in=${checkIn}&check_out=${checkOut}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        availableSpan.innerText = data.available;
                        availableSpan.classList.remove('text-danger');
                        availableSpan.classList.add('text-success');
                    } else {
                        availableSpan.innerText = data.message ?? 'Lỗi';
                        availableSpan.classList.add('text-danger');
                    }
                })
                .catch(err => {
                    availableSpan.innerText = 'Lỗi';
                    availableSpan.classList.add('text-danger');
                });
        }
    });
</script>
@endpush