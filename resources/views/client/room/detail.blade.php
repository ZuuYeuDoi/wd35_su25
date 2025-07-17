@extends('client.index')
@push('css')
<style>
    html, body {
        height: auto !important;
        min-height: 100vh !important;
        overflow: visible !important;
    }

    .page-wrapper {
        min-height: 100vh !important;
        height: auto !important;
        overflow: visible !important;
    }

    .preloader {
        display: none !important;
    }

    /* Force fix nội dung */
    section.pt-120.pb-120 {
        padding-bottom: 200px !important;
    }
    .review-scroll-container {
        max-height: 500px;
        overflow-y: auto;
        border: 1px solid #ddd;
    }
    small.text-muted {
        margin-left: 4px;
        font-size: 13px;
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
            <!-- LEFT -->
            <div class="col-lg-8">
                <div class="mb-4">
                    <!-- Ảnh chính: lấy ảnh đầu tiên trong danh sách ảnh của phòng -->
                    <img id="mainRoomImage"
                        src="{{ asset('storage/' . ($room->images_room->first()->image_path ?? 'default.jpg')) }}"
                        alt="{{ $room->title }}"
                        class="img-fluid rounded shadow mb-3"
                        style="width: 100%; max-height: 400px; object-fit: cover;">

                    <!-- Album ảnh: duyệt tất cả ảnh của phòng -->
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($roomType->rooms->flatMap->images_room->take(5) as $thumb)
                            <img src="{{ asset('storage/' . $thumb->image_path) }}" class="img-thumbnail" style="width: 100px; height: 70px; cursor:pointer;" onclick="changeMainImage('{{ asset('storage/' . $thumb->image_path) }}')">
                        @endforeach
                    </div>
                </div>



                <!-- MÔ TẢ LOẠI PHÒNG -->
                <h3 class="mb-4 fw-semibold" style="font-size: 26px;">Mô tả loại phòng</h3>
                <p class="text-muted" style="line-height: 1.8; font-size: 16px;">
                    {{ $room->description ?? 'Không có mô tả cho loại phòng này.' }}
                </p>

                @if ($room)
                    <h3 class="mb-4 fw-semibold mt-5" style="font-size: 26px;">Thông tin chi tiết một phòng</h3>

                    <div class="border rounded p-4 mt-2" style="background-color: #fffefc; border: 1px solid #e7dccc;">
                        <div class="row text-center">
                            <div class="col-12 col-md-4 mb-2">
                                <small class="text-muted">Tên phòng</small>
                                <div class="fw-bold">{{ $room->title }}</div>
                            </div>
                            <div class="col-12 col-md-4 mb-2">
                                <small class="text-muted">Loại phòng</small>
                                <div class="fw-bold">{{ $room->roomType->name ?? 'Chưa có loại' }}</div>
                            </div>
                            <div class="col-12 col-md-4 mb-2">
                                <small class="text-muted">Giá</small>
                                <div class="fw-bold text-danger">{{ number_format($room->price, 0, ',', '.') }} VND</div>
                            </div>
                        </div>
                    </div>
                @endif

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
<hr class="my-4">

<!-- ĐÁNH GIÁ VÀ BÌNH LUẬN -->
<h4 class="mb-3">Đánh giá phòng</h4>

<!-- Nếu user đã login và có thể bình luận -->
@auth
    @if ($canReview)
        <form action="{{ route('reviews.store') }}" method="POST" class="mb-4 border rounded p-3 shadow-sm bg-light">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <div class="mb-3">
                <label for="rating" class="form-label">Đánh giá sao</label>
                <select name="rating" id="rating" class="form-select" required>
                    <option value="">Chọn số sao</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} sao</option>
                    @endfor
                </select>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Bình luận</label>
                <textarea name="comment" id="comment" rows="3" class="form-control" placeholder="Viết cảm nhận của bạn..." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
        </form>
    @else
        <div class="alert alert-warning">
            Bạn chỉ có thể đánh giá khi đã đặt và trả phòng này.
        </div>
    @endif
@endauth

@guest
    <div class="alert alert-info">
        Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để viết đánh giá.
    </div>
@endguest

<!-- DANH SÁCH BÌNH LUẬN -->

    <div class="mt-4">
        <h5 class="mb-3">Bình luận từ khách hàng</h5>
    <div class="review-scroll-container bg-white rounded shadow-sm p-3">
            @forelse ($reviews as $review)
                <div class="border rounded p-3 mb-3 bg-light">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div style="font-size: 14px;">
                            <strong>{{ $review->user->name }}</strong>
                            <small class="text-muted">({{ $review->created_at->format('d/m/Y') }})</small>
                        </div>
                        <div class="text-warning" style="font-size: 14px;">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                    </div>

                    <p class="mb-0" style="font-size: 15px;">{{ $review->comment }}</p>
                </div>
            @empty
                <p class="text-muted">Chưa có đánh giá nào cho phòng này.</p>
            @endforelse
        </div>
    </div>
</div>

            <!-- RIGHT -->
            <div class="col-lg-4">
                <div class="p-4 bg-light rounded shadow-sm">
                    <h5 class="mb-3">Đặt phòng</h5>

                    <form action="{{ route('booking.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="room_type_id" id="room_type_id" value="{{ $roomType->id }}">

                        <div class="mb-3">
                            <label>Ngày nhận phòng</label>
                            <input type="date" id="checkin" name="check_in" class="form-control" value="{{ $checkIn }}" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Ngày trả phòng</label>
                            <input type="date" id="checkout" name="check_out" class="form-control" value="{{ $checkOut }}" min="{{ $checkIn }}" required>
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
                            Số phòng còn trống: <span class="fw-bold text-success" id="available-count">{{ $availableRoomsCount }}</span>
                        </p>

                        <button type="submit" class="btn btn-primary w-100">Tiếp tục đặt phòng</button>
                    </form>
                </div>

                {{-- ✅ Danh sách phòng cùng loại --}}
                <div class="mt-5">
                    <h5 class="mb-3">Danh sách phòng trong loại này</h5>
                    <div style="max-height: 500px; overflow-y: auto;">
                        @foreach ($roomType->rooms as $r)
                            <div class="card mb-3" id="room-{{ $r->id }}">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <a href="{{ route('room.detail', $r->id) }}">
                                            <img src="{{ asset('storage/' . ($r->images_room->first()->image_path ?? 'default.jpg')) }}"
                                                class="img-fluid rounded-start" alt="{{ $r->title }}">
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body py-2 px-3">
                                            <h6 class="card-title mb-1" style="font-size: 15px;">{{ $r->title }}</h6>
                                            <p class="card-text mb-1" style="font-size: 13px;">{{ $r->description }}</p>
                                            <p class="card-text mb-1">
                                                <strong class="text-danger" style="font-size: 14px;">{{ number_format($r->price, 0, ',', '.') }} VND</strong>
                                            </p>
                                            <button type="button" class="btn btn-sm btn-success" style="font-size: 13px;"
                                                    onclick="addToBooking({{ $r->id }}, '{{ $r->title }}', {{ $r->price }})">
                                                Đặt phòng
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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

            fetch({{ route('room_type.check_availability') }}?room_type_id=${roomTypeId}&check_in=${checkIn}&check_out=${checkOut})
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

    function changeMainImage(src) {
        document.getElementById('mainRoomImage').src = src;
    }

    function addToBooking(id, name, price) {
        alert(Đặt phòng: ${name} (${price.toLocaleString()} VND));
        // Có thể thêm xử lý lưu vào localStorage hoặc cart
    }
</script>
