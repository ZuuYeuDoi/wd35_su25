@extends('client.index')
@push('css')
    <style>
        .checkout-title{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .checkout-title h3 {
            margin: 0px !important;
        }
        .payment-options {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            justify-content: center;
        }
        .payment-option {
            border: 2px solid transparent;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
            transition: 0.3s;
            width: 150px;
            text-align: center;
        }
        .payment-option img {
            width: 100%;
            height: auto;
            max-height: 60px;
            object-fit: contain;
        }
        .payment-option.active {
            border-color: #28a745;
            background-color: #e6f4ea;
        }
    </style>
    </style>
@endpush

@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Checkout</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    <!--checkout Start-->
    <section>
        <div class="container pt-70 pb-120">
            <div class="section-content">
                <form action="{{ route('booking.store') }}" method="post">
                    @csrf
                    <div class="row mt-30">
                        <div class="col-md-6">
                            <div class="billing-details">
                                <div class="checkout-title">
                                    <h3>Thanh Toán</h3>
                                    <div class="booking_code">Đơn đặt phòng: {{ $bookingCode }}</div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="checkuot-form-fname">Họ và tên</label>
                                        <input id="checkuot-form-fname" type="name" class="form-control"
                                            value="{{ $user->name ?? null }}" placeholder="Họ và tên" name="name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="checkuot-form-lname">Số điện thoại</label>
                                        <input id="checkuot-form-lname" type="number" class="form-control"
                                            value="{{ $user->phone ?? null }}" placeholder="Số điện thoại" name="phone">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="checkuot-form-email">Địa chỉ Email</label>
                                            <input id="checkuot-form-email" type="email" class="form-control"
                                                name="email" value="{{ $user->email ?? null }}"
                                                placeholder="Địa chỉ Email">
                                        </div>
                                        <div class="mb-3">
                                            <label for="checkuot-form-cc">Số CCCD</label>
                                            <input id="checkuot-form-cc" type="cc" class="form-control"
                                                name="cccd" value="{{ $user->cccd ?? null }}" placeholder="CCCD">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="checkuot-form-checkin">Ngày Nhận phòng</label>
                                        <input id="checkuot-form-checkin" type="date" class="form-control" readonly name="checkin_date"
                                            value="{{ $data['checkin_date'] }}">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="checkuot-form-checkout">Ngày Trả phòng</label>
                                        <input id="checkuot-form-checkout" type="date" class="form-control" readonly name="checkout_date"
                                            value="{{ $data['checkout_date'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="mb-3">Thông tin phòng</h3>
                            @if ($room->images_room->isNotEmpty())
                                <div id="roomCarousel" class="carousel slide mb-4" data-bs-ride="carousel"
                                    data-bs-interval="5000">
                                    <div class="carousel-inner">
                                        @foreach ($room->images_room as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                    class="d-block w-100" alt="Ảnh phòng"
                                                    style="height: 400px; object-fit: scale-down    ;">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Trước</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Tiếp</span>
                                    </button>
                                </div>
                            @endif

                            <div class="border rounded p-4 mb-4" style="background-color: #fff;">
                                <div class="row text-center small">
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">Tên phòng</div>
                                        <div><strong>{{ $room->title }}</strong></div>
                                    </div>
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">Loại phòng</div>
                                        <div><strong>{{ $room->roomType->name }}</strong></div>
                                    </div>
                                     <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">Loại giường</div>
                                        @php
                                            $bed = match ($room->max_people) {
                                                1 => '1 giường đơn',
                                                2 => '2 giường đơn',
                                                3 => '1 giường đôi',
                                                4 => '1 giường đôi + 1 giường đơn',
                                                default => 'Không rõ',
                                            };
                                        @endphp
                                        <div><strong>{{ $bed }}</strong></div>
                                    </div>
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">Giá phòng (1 đêm)</div>
                                        <div>
                                            <strong id="room-price">{{ number_format($room->price, 0, ',', '.') }}    VND</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-30">
                            <h4>Tổng Thanh Toán:</h4>
                            <div class="p-3 border rounded" style="background-color: #f8f9fa; font-size: 1.25rem;">
                                <strong id="total-price">{{ number_format($totalPrice, 0, ',', '.') }} VND</strong>
                            </div>
                        </div>

                        <div class="col-md-12 mt-60">
                            <div class="payment-method">
                                <h3>Chọn phương thức thanh toán</h3>
                                <div class="payment-options">
                                    <div class="payment-option active" data-method="vnpay">
                                        <img src="{{ asset('client/images/payments/vnpay.png') }}" alt="VNPAY">
                                    </div>
                                    <div class="payment-option" data-method="momo">
                                        <img src="{{ asset('client/images/payments/momo.png') }}" alt="MoMo">
                                    </div>
                                    <div class="payment-option" data-method="visa">
                                        <img src="{{ asset('client/images/payments/visa.png') }}" alt="Visa">
                                    </div>
                                </div>

                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <input type="hidden" name="amount" value="{{ $booking->total_price }}">
                                <input type="hidden" name="method" id="selected-method" value="vnpay">

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success">Thanh toán</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--checkout Start-->
@endsection
@push('js')
<script>
    const options = document.querySelectorAll('.payment-option');
    const selectedInput = document.getElementById('selected-method');
    const form = document.getElementById('payment-form');

    options.forEach(opt => {
        opt.addEventListener('click', function() {
            options.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            selectedInput.value = this.dataset.method;
        });
    });

    form.addEventListener('submit', function(e) {
        const method = selectedInput.value;
        if (method !== 'vnpay') {
            e.preventDefault();
            alert('Cổng thanh toán ' + method.toUpperCase() + ' đang được phát triển.');
        }
    });
</script>
@endpush
