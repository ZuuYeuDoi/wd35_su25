@extends('client.index')

@push('css')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        #quantity-input {
            text-align: center;
            border-radius: 6px;
            width: 60px;
            height: 40px;
            font-size: 18px;
        }
    </style>
@endpush

@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Chi tiết sản phẩm</h1>
                <ul class="page-breadcrumb">
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li>Sản phẩm</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End main-content -->

    <!--Product Details Start-->
    <section class="product-details pt-120">
        <div class="container pb-70">
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="bxslider">
                        <div class="slider-content">
                            <figure class="image-box">
                                <a href="{{ asset('storage/' . $product->image) }}" class="lightbox-image"
                                    data-fancybox="gallery">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                </a>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6 product-info">
                    <div class="product-details__top">
                        <h3 class="product-details__title">
                            {{ $product->name }}
                            <span>{{ number_format($product->price, 0, ',', '.') }} đ</span>
                        </h3>
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $product->id }}">
                        <input type="hidden" name="booking_id" value="{{ $booking?->id }}">

                        <div class="product-details__quantity">
                            <h4 class="product-details__quantity-title">Số lượng</h4>
                            <div class="d-flex align-items-center">
                                <button type="button" class="sub btn btn-outline-secondary px-3">−</button>
                                <input type="number" name="quantity" id="quantity-input" value="1" min="1"
                                    max="{{ $product->quantity }}" class="form-control mx-2 text-center"
                                    style="width: 80px;" />
                                <button type="button" class="add btn btn-outline-secondary px-3">+</button>
                            </div>
                        </div>

                        <div class="mt-2">
                            <p class="text-muted">Còn lại: {{ $product->quantity }} sản phẩm</p>
                        </div>

                        <div class="product-details__buttons mt-4">
                            @if ($booking)
                                <button type="submit" class="theme-btn btn-style-one">
                                    <span class="btn-title">Thêm vào giỏ hàng</span>
                                </button>
                            @else
                                <div class="alert alert-warning">
                                    Vui lòng <a href="{{ route('login') }}">đăng nhập</a> và đặt phòng để sử dụng dịch vụ
                                    này.
                                </div>
                            @endif
                        </div>
                    </form>

                    <div class="product-details__content mt-4">
                        <div>{!! $product->description !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Product Details End-->
@endsection

@push('js')
    <script src="{{ asset('client/js/bxslider.js') }}"></script>
    <script src="{{ asset('client/js/script.js') }}"></script>
    <script>
        document.querySelector('.add').onclick = function() {
            let input = document.getElementById('quantity-input');
            let max = parseInt(input.getAttribute('max')) || 99;

            if (parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
            }
        }

        document.querySelector('.sub').onclick = function() {
            let input = document.getElementById('quantity-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
@endpush
