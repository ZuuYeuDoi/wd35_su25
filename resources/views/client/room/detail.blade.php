@extends('client.index')
@push('css')
<style>
    html,
    body {
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

    .room-thumbnail.border-primary {
        border: 2px solid #007bff !important;
    }

    .star-rating {
        direction: rtl;
        font-size: 2rem;
        display: inline-flex;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
        padding: 0 2px;
    }

    .star-rating input:checked~label,
    .star-rating label:hover,
    .star-rating label:hover~label {
        color: gold;
    }

    filter-rating .btn {
        margin-right: 6px;
        margin-bottom: 6px;
        min-width: 60px;
    }

    .filter-rating .btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
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
                <!-- Ảnh phòng -->
                @if ($room->images_room && $room->images_room->count())
                <!-- ẢNH CHÍNH -->
                <div class="mb-4 text-center">
                    <img id="mainRoomImage" src="{{ asset('storage/' . $room->images_room->first()->image_path) }}" class="img-fluid rounded" style="width: 100%; max-width: 800px; height: 400px; object-fit: cover;">
                </div>
                <!-- ALBUM ẢNH NHỎ -->
                @if ($room->images_room->count() > 1)
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                    @foreach ($room->images_room as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" data-src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail room-thumbnail" style="width: 90px; height: 90px; object-fit: cover; cursor: pointer;">
                    @endforeach
                </div>
                @endif
                @else
                <div class="alert alert-warning">Không có ảnh phòng nào được đăng.</div>
                @endif

                <!-- MÔ TẢ LOẠI PHÒNG -->
                <h3 class="mb-4 fw-semibold" style="font-size: 26px;">Mô tả loại phòng</h3>
                <p class="text-muted" style="line-height: 1.8; font-size: 16px;">
                    {!! $room->description ?? 'Không có mô tả cho loại phòng này.' !!}
                </p>


                @if ($room)

                    <h3 class="mb-4 fw-semibold mt-5" style="font-size: 26px;">Thông tin chi tiết phòng</h3>

                    <div class="border rounded p-4 mt-2" style="background-color: #fffefc; border: 1px solid #e7dccc;">
                        <div class="row text-center">
                            <div class="col-12 col-md-3 mb-2">
                                <small class="text-muted">Hạng phòng</small>
                                <div class="fw-bold">{{ $room->roomType->type ?? 'Chưa có hạng' }}</div>
                            </div>
                            <div class="col-12 col-md-3 mb-2">
                                <small class="text-muted">Loại phòng</small>
                                <div class="fw-bold">{{ $room->roomType->name ?? 'Chưa có loại' }}</div>
                            </div>
                            <div class="col-12 col-md-3 mb-2">
                                <small class="text-muted">Kiểu giường</small>
                                <div class="fw-bold">{{ $room->roomType->bed_type ?? 'Chưa có thông tin' }}</div>
                            </div>
                            <div class="col-12 col-md-3 mb-2">
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
                            <img src="{{ asset('storage/' . $amenity->image) }}" class="me-2 rounded" width="30" height="30">
                            <span>{{ $amenity->name }}</span>
                        </div>
                    </div>
                    @empty
                    <p><em>Không có tiện nghi</em></p>
                    @endforelse
                </div>
                <hr class="my-4">

                <!-- ĐÁNH GIÁ VÀ BÌNH LUẬN -->
                <h4 id="review" class="mb-3">Đánh giá phòng</h4>

                @php
                $fullStars = floor($avgRating);
                $halfStar = $avgRating - $fullStars >= 0.5;
                @endphp

                <div class="rating mb-3">
                    <strong>Đánh giá trung bình:</strong>
                    @for ($i = 1; $i <= $fullStars; $i++) <i class="fas fa-star text-warning"></i>
                        @endfor

                        @if ($halfStar)
                        <i class="fas fa-star-half-alt text-warning"></i>
                        @endif

                        @for ($i = 1; $i <= (5 - $fullStars - ($halfStar ? 1 : 0)); $i++) <i class="far fa-star text-warning"></i>
                            @endfor

                            <span>{{ number_format($avgRating, 1) }} / 5 ({{ $totalReviews }} đánh giá)</span>
                </div>

                <!-- Nếu user đã login và có thể bình luận -->
                @auth

    <form action="{{ route('reviews.store') }}" method="POST" class="mb-4 border rounded p-3 shadow-sm bg-light">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">
        
        <div class="mb-3">
            <label class="form-label">Đánh giá sao</label>
            <div class="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                    <label for="rating{{ $i }}" title="{{ $i }} sao">&#9733;</label>
                @endfor
            </div>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Bình luận</label>
            <textarea name="comment" id="comment" rows="3" class="form-control" placeholder="Viết cảm nhận của bạn..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>

        @if (! $canReview)
            <div class="alert alert-warning mt-2">
                Bạn chỉ có thể đánh giá sau khi đã đặt và checkout phòng.
            </div>
        @endif
    </form>
@endauth

                @guest
                <div class="alert alert-info">
                    Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để viết đánh giá.
                </div>
                @endguest

                <!-- DANH SÁCH BÌNH LUẬN -->
                <div class="mt-4">
                    <h5 class="mb-3">Bình luận từ khách hàng</h5>

                    <!-- Bộ lọc đánh giá -->
                    <div class="mb-3">
                        <strong>Lọc theo đánh giá:</strong>
                        <div class="filter-rating mt-2">
                            <button class="btn btn-sm btn-outline-primary filter-btn active" data-rating="all">Tất cả</button>
                            @for ($i = 5; $i >= 1; $i--)
                            <button class="btn btn-sm btn-outline-primary filter-btn" data-rating="{{ $i }}">
                                {{ $i }} sao
                            </button>
                            @endfor
                        </div>
                    </div>

                    <!-- Danh sách đánh giá -->
                    <div class="review-scroll-container bg-white rounded shadow-sm p-3">
                        @forelse ($reviews as $review)
                        <div class="border rounded p-3 mb-3 bg-light single-review" data-rating="{{ $review->rating }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div style="font-size: 14px;">
                                    <strong>{{ $review->user->name }}</strong>
                                    <small class="text-muted">({{ $review->created_at->format('d/m/Y') }})</small>
                                </div>
                                <div class="text-warning" style="font-size: 14px;">
                                    @for ($i = 1; $i <= 5; $i++) <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
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

                    @php
                    $cart = session('booking_cart', []);
                    $hasCart = !empty($cart);

                    $defaultCheckin = $hasCart ? $cart[0]['check_in'] : \Carbon\Carbon::tomorrow()->format('Y-m-d');
                    $defaultCheckout = $hasCart ? $cart[0]['check_out'] : \Carbon\Carbon::tomorrow()->addDay()->format('Y-m-d');
                    @endphp

                    <form action="{{ route('booking.addToCart') }}" method="POST">
                        @csrf
                        <input type="hidden" id="roomTypeId" name="room_type_id" value="{{ $roomType->id }}">

                        <div class="mb-3">
                            <label>Ngày nhận phòng</label>
                            <input type="date" id="checkin" name="check_in" class="form-control"

                                value="{{ $defaultCheckin }}"
                                min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                                @if($hasCart) readonly @endif required>

                        </div>

                        <div class="mb-3">
                            <label>Ngày trả phòng</label>
                            <input type="date" id="checkout" name="check_out" class="form-control"

                                value="{{ $defaultCheckout }}"
                                min="{{ \Carbon\Carbon::tomorrow()->addDay()->format('Y-m-d') }}"
                                @if($hasCart) readonly @endif required>

                        </div>

                        <div class="mb-3">
                            <label>Số lượng phòng</label>
                            <input type="number" id="number-of-rooms" name="number_of_rooms" class="form-control" value="1" min="1" max="{{ $availableRoomsCount }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Người lớn</label>
                            <input type="number" name="adults" class="form-control" value="1" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label>Trẻ em</label>
                            <input type="number" name="children" class="form-control" value="0" min="0" required>
                        </div>

                        <p class="mt-2 text-muted">
                            Số phòng còn trống: <span id="available-count" class="fw-bold text-success">{{ $availableRoomsCount }}</span>
                        </p>

                        <button type="submit" name="action" value="add" class="btn btn-secondary w-100 mb-2">
                            + Đặt thêm loại phòng khác
                        </button>
                        <button type="submit" name="action" value="checkout" class="btn btn-primary w-100">
                            Tiếp tục đặt phòng
                        </button>
                    </form>
</div>

                <div class="mt-5">
                    <div class="">
                        <div class="mb-3" style="border: 1px solid #dee2e6;border-radius: 5px;padding: 10px;">
                            <h5>Thời gian nhận phòng</h5>
                            <div class="">
                                <p>Thời gian nhận phòng từ 14h đến 18h.</p>
                                <p style="color: red">Nếu quá 18h sẽ có phí phụ thu thêm!</p>
                            </div>
                        </div>
                        <h5 class="mb-3">Danh sách phòng cùng loại </h5>
                        <div style="max-height: 500px; overflow-y: auto;">
                            @foreach ($roomType->rooms->take(4) as $r) {{-- 🟢 chỉ lấy 4 phòng đầu --}}
                            <div class="card mb-3" id="room-{{ $r->id }}">
                                <div class="row g-0" style="padding: 10px;">
                                    <div class="col-4">
                                        <a href="{{ route('room.detail', $r->id) }}">
                                            <img src="{{ asset('storage/' . ($r->images_room->first()->image_path ?? 'default.jpg')) }}" class="img-fluid rounded-start" alt="{{ $r->title }}">
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body py-2 px-3">
                                            <h6 class="card-title mb-1" style="font-size: 15px;">{{ $roomType->name }}</h6>
                                            @if ($r->average_rating > 0)
                                            <div class="mb-1">
                                                @for ($i = 1; $i <= 5; $i++) @if ($i <=floor($r->average_rating))
                                                    <i class="fas fa-star text-warning" style="font-size: 13px;"></i>
                                                    @elseif ($i - $r->average_rating <= 0.5) <i class="fas fa-star-half-alt text-warning" style="font-size: 13px;"></i>
                                                        @else
                                                        <i class="far fa-star text-warning" style="font-size: 13px;"></i>
                                                        @endif
                                                        @endfor
                                                        <small class="text-muted">({{ number_format($r->average_rating, 1) }})</small>
                                            </div>
                                            @endif

                                            <p class="card-text mb-1">
                                                <strong class="text-danger" style="font-size: 14px;">{{ number_format($r->price, 0, ',', '.') }} VND</strong>
                                            </p>
                                            <button type="button" class="btn btn-sm btn-success" style="font-size: 13px;" onclick="addToBooking({{ $r->id }}, '{{ $r->title }}', {{ $r->price }})">
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
    </div>
</section>
@endsection

@push('js')
<script>

document.addEventListener("DOMContentLoaded", function() {
    // Lấy ngày mai (check-in)
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const checkinMin = tomorrow.toISOString().split('T')[0];

    // Lấy ngày kia (check-out mặc định ít nhất sau check-in 1 ngày)
    const dayAfterTomorrow = new Date();
    dayAfterTomorrow.setDate(dayAfterTomorrow.getDate() + 2);
    const checkoutMin = dayAfterTomorrow.toISOString().split('T')[0];

    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    const roomTypeId = document.getElementById('roomTypeId')?.value;
    const availableSpan = document.getElementById('available-count');
    const numberOfRoomsInput = document.getElementById('number-of-rooms');

    // Set min date
    if (checkinInput) checkinInput.setAttribute('min', checkinMin);
    if (checkoutInput) checkoutInput.setAttribute('min', checkoutMin);

    if (checkinInput) {
        checkinInput.addEventListener('change', function() {
            console.log('Check-in changed:', this.value);
            const checkinDate = new Date(this.value);
            if (isNaN(checkinDate)) {
                console.log('Invalid check-in date');
                return;
            }

            // Tạo ngày checkout tối thiểu (sau check-in 1 ngày)

            const minCheckout = new Date(checkinDate);
            minCheckout.setDate(minCheckout.getDate() + 1);
            const minCheckoutStr = minCheckout.toISOString().split('T')[0];


            // Cập nhật thuộc tính min của checkout
            checkoutInput.setAttribute('min', minCheckoutStr);

            // Xóa checkout nếu nó nhỏ hơn hoặc bằng checkin
            if (checkoutInput.value && new Date(checkoutInput.value) <= checkinDate) {
                checkoutInput.value = '';
            }

            fetchAvailability();
        });
    }

    if (checkoutInput) {
        checkoutInput.addEventListener('change', function() {
            console.log('Check-out changed:', this.value);
            const checkinDate = new Date(checkinInput.value);
            const checkoutDate = new Date(this.value);

            if (isNaN(checkoutDate)) {
                console.log('Invalid check-out date');
                return;
            }

            // Xóa checkout nếu nó nhỏ hơn hoặc bằng checkin
            if (checkoutDate <= checkinDate) {
                this.value = '';
            }


            fetchAvailability();
        });
    }


    function fetchAvailability() {
        const checkIn = checkinInput?.value;
        const checkOut = checkoutInput?.value;
        console.log('fetchAvailability called with:', { checkIn, checkOut, roomTypeId });

        if (!checkIn || !checkOut || !roomTypeId) {
            console.log('Missing required fields');
            if (availableSpan) {
                availableSpan.innerText = 'Vui lòng chọn ngày';
                availableSpan.classList.add('text-danger');
            }
            if (numberOfRoomsInput) {
                numberOfRoomsInput.setAttribute('max', '0'); // Không cho phép chọn phòng nếu thiếu ngày
                numberOfRoomsInput.value = '1'; // Đặt lại về 1
            }
            return;
        }

        fetch(`{{ route('room_type.check_availability') }}?room_type_id=${roomTypeId}&check_in=${checkIn}&check_out=${checkOut}`)
            .then(res => {
                if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                return res.json();
            })
            .then(data => {
                console.log('API response:', data);
                if (availableSpan) {
                    if (data.status) {
                        availableSpan.innerText = data.available;
                        availableSpan.classList.remove('text-danger');
                        availableSpan.classList.add('text-success');

                        // Cập nhật max của number_of_rooms
                        if (numberOfRoomsInput) {
                            numberOfRoomsInput.setAttribute('max', data.available);
                            // Nếu giá trị hiện tại lớn hơn max mới, đặt lại về max
                            if (parseInt(numberOfRoomsInput.value) > parseInt(data.available)) {
                                numberOfRoomsInput.value = data.available || '1';
                            }
                        }
                    } else {
                        availableSpan.innerText = data.message ?? 'Lỗi không xác định';
                        availableSpan.classList.add('text-danger');
                        if (numberOfRoomsInput) {
                            numberOfRoomsInput.setAttribute('max', '0');
                            numberOfRoomsInput.value = '1';
                        }
                    }
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
                if (availableSpan) {
                    availableSpan.innerText = 'Lỗi kết nối';
                    availableSpan.classList.add('text-danger');
                }
                if (numberOfRoomsInput) {
                    numberOfRoomsInput.setAttribute('max', '0');
                    numberOfRoomsInput.value = '1';
                }
            });
    }

    // Gọi fetchAvailability khi trang tải nếu cả check-in và check-out đều có giá trị
    if (checkinInput?.value && checkoutInput?.value && roomTypeId) {
        fetchAvailability();
    }

    // Xử lý click ảnh phụ → đổi ảnh chính
    const thumbnails = document.querySelectorAll('.room-thumbnail');
    const mainImage = document.getElementById('mainRoomImage');

    thumbnails.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            const newSrc = this.getAttribute('data-src') || this.src;
            if (mainImage && newSrc) {
                mainImage.setAttribute('src', newSrc);
            }

            // Highlight ảnh đang chọn
            thumbnails.forEach(t => t.classList.remove('border-primary'));
            this.classList.add('border-primary');
        });
    });

    // Hàm đặt phòng
    window.addToBooking = function(id, name, price) {
        alert(`Đặt phòng: ${name} (${price.toLocaleString()} VND)`);
    };

    // Xử lý bộ lọc đánh giá

    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const selectedRating = button.dataset.rating;
            const reviews = document.querySelectorAll('.single-review');

            reviews.forEach(review => {

                if (selectedRating === 'all' || review.dataset.rating === selectedRating) {
                    review.style.display = '';
                } else {
                    review.style.display = 'none';
                }

            });
        });
    });
});
</script>

@endpush

