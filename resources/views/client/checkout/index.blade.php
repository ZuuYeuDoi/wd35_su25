@extends('client.index')

@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Checkout</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>Shop</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    <!--checkout Start-->
    <section>
        <div class="container pt-70 pb-120">
            <div class="section-content">
                <form id="checkout-form" action="#">
                    <div class="row mt-30">
                        <div class="col-md-6">
                            <div class="billing-details">
                                <h3 class="mb-30">Thanh Toán</h3>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="checkuot-form-fname">Họ và tên</label>
                                        <input id="checkuot-form-fname" type="email" class="form-control"
                                            placeholder="Họ và tên">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="checkuot-form-lname">Số điện thoại</label>
                                        <input id="checkuot-form-lname" type="email" class="form-control"
                                            placeholder="Số điện thoại">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="checkuot-form-cname">Địa chỉ Email</label>
                                            <input id="checkuot-form-cname" type="email" class="form-control"
                                                placeholder="Địa chỉ Email">
                                        </div>
                                        <div class="mb-3">
                                            <label for="checkuot-form-email">Số CCCD</label>
                                            <input id="checkuot-form-email" type="email" class="form-control"
                                                placeholder="CCCD">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="checkuot-form-checkin">Ngày Nhận phòng</label>
                                        <input id="checkuot-form-checkin" type="date" class="form-control" readonly value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="checkuot-form-checkout">Ngày Trả phòng</label>
                                        <input id="checkuot-form-checkout" type="date" class="form-control" readonly value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="mb-3">Thông tin phòng</h3>
                            <img src="{{ asset('client/images/resource/room-1.jpg') }}" class="card-img-top" alt="Phòng Deluxe Hướng Biển">
                            <div class="border rounded p-4 mb-4" style="background-color: #fff;">
                                <div class="row text-center small">
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">Kích Thước phòng</div>
                                        <div><strong>600 Sq</strong></div>
                                    </div>
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">Loại Phòng</div>
                                        <div><strong>2 giường đơn</strong></div>
                                    </div>
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">Sức chứa</div>
                                        <div><strong>3 người</strong></div>
                                    </div>
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">View</div>
                                        <div><strong>Cảnh biển</strong></div>
                                    </div>
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">Số phòng</div>
                                        <div><strong>302</strong></div>
                                    </div>
                                    <div class="col-6 col-sm-4 mb-3">
                                        <div class="text-muted">Giá phòng (1 đêm)</div>
                                        <div><strong id="room-price" data-price="1500000">1,500,000 VND</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-30">
                            <h4>Tổng Thanh Toán:</h4>
                            <div class="p-3 border rounded" style="background-color: #f8f9fa; font-size: 1.25rem;">
                                <strong id="total-price">4,500,000 VND</strong>
                            </div>
                        </div>
                        <div class="col-md-12 mt-60">
                            <div class="payment-method">
                                <h3>Chọn phương thức thanh toán</h3>
                                <ul class="accordion-box">
                                    <li class="accordion block">
                                        <div class="acc-btn">
                                            <div class="icon-outer"><i class="lnr-icon-chevron-down"></i></div>
                                            Thanh toán qua cổng thanh toán điện tử 
                                        </div>
                                        <div class="acc-content">
                                            <div class="payment-info">
                                                <p class="mb-0">Make your payment directly into our bank account. Please
                                                    use your Order ID as the payment reference. Your order won’t be shipped
                                                    until the funds have cleared in our account.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="accordion block">
                                        <div class="acc-btn">
                                            <div class="icon-outer"><i class="lnr-icon-chevron-down"></i></div>
                                            Thanh toán khi đến nơi
                                        </div>
                                        <div class="acc-content">
                                            <div class="payment-info">
                                                <p class="mb-0">Make your payment directly into our bank account. Please
                                                    use your Order ID as the payment reference. Your order won’t be shipped
                                                    until the funds have cleared in our account.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--checkout Start-->
@endsection
