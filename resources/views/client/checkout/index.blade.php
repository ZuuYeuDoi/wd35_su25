@extends('client.index')

@push('css')
<style>
    .checkout-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .checkout-title h3 {
        margin: 0 !important;
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
@endpush

@section('content')
<section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
    <div class="auto-container text-center">
        <h1 class="title">Xác nhận đặt phòng</h1>
        <ul class="page-breadcrumb">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>
            <li>Checkout</li>
        </ul>
    </div>
</section>

<section>
    <div class="container pt-70 pb-120">
        <form action="{{ route('booking.store') }}" method="POST" id="payment-form">
            @csrf
            <div class="row mt-30">
                <div class="col-md-6">
                    <div class="billing-details">
                        <div class="checkout-title">
                            <h3>Thông tin khách hàng</h3>
                            <div class="booking_code">Mã đặt: {{ $bookingCode }}</div>
                        </div>

                        <div class="border p-3 mb-3 rounded bg-light">
                            <p><strong>Họ tên:</strong> {{ $user->name }}</p>
                            <p><strong>Điện thoại:</strong> {{ $user->phone }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>CCCD:</strong> {{ $user->cccd }}</p>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>Ngày Nhận phòng</label>
                                <input type="date" class="form-control" readonly name="check_in" value="{{ $checkIn }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>Ngày Trả phòng</label>
                                <input type="date" class="form-control" readonly name="check_out" value="{{ $checkOut }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>Số lượng phòng</label>
                                <input type="number" class="form-control" readonly name="number_of_rooms" value="{{ $numberOfRooms }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label>Người lớn</label>
                                <input type="number" class="form-control" readonly name="adults" value="{{ $adults }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label>Trẻ em</label>
                                <input type="number" class="form-control" readonly name="children" value="{{ $children }}">
                            </div>
                        </div>
                        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <h3 class="mb-3">Thông tin phòng</h3>
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $roomType->image) }}" alt="{{ $roomType->name }}" class="img-fluid rounded shadow">
                    </div>

                    <div class="border rounded p-4 mb-4 bg-white">
                        <div class="row text-center small">
                            <div class="col-6 mb-3">
                                <div class="text-muted">Loại phòng</div>
                                <div><strong>{{ $roomType->name }}</strong></div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="text-muted">Giá / đêm</div>
                                <div><strong>{{ number_format($pricePerRoom, 0, ',', '.') }} VND</strong></div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="text-muted">Số đêm</div>
                                <div><strong>{{ $numberOfNights }}</strong></div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="text-muted">Tổng tiền</div>
                                <div><strong>{{ number_format($totalPrice, 0, ',', '.') }} VND</strong></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4>Tổng Thanh Toán:</h4>
                    <div class="p-3 border rounded bg-light" style="font-size: 1.25rem;">
                        <div name = "total_amount">Tổng tiền phòng: <strong>{{ number_format($totalPrice, 0, ',', '.') }} VND</strong></div>
                        <div name = "deposit">Tiền cọc (10%): <strong class="text-danger">{{ number_format($totalPrice * 0.1, 0, ',', '.') }} VND</strong></div>
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

                        <input type="hidden" name="method" id="selected-method" value="vnpay">

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">Thanh toán</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('js')
<script>
    const options = document.querySelectorAll('.payment-option');
    const selectedInput = document.getElementById('selected-method');
    const form = document.getElementById('payment-form');

    options.forEach(opt => {
        opt.addEventListener('click', function () {
            options.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            selectedInput.value = this.dataset.method;
        });
    });

    form.addEventListener('submit', function (e) {
        const method = selectedInput.value;
        if (method !== 'vnpay') {
            e.preventDefault();
            alert('Cổng thanh toán ' + method.toUpperCase() + ' đang được phát triển.');
        }
    });
</script>
@endpush
