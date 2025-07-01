@extends('client.index')
@push('css')
    <style>
        .image {
            width: 100%;
            height: 180px;
        }
    </style>
@endpush

@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Cửa Hàng Đồ Ăn</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>Products</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="shop-sidebar">
                        <div class="sidebar-search">
                            <form action="{{ route('services.indexFood') }}" method="GET"
                                class="search-form">
                                <div class="form-group">
                                    <input type="search" name="search" placeholder="Tìm Kiếm..." required="" value="{{ request('search') }}" >
                                    <button type="submit"><i class="lnr lnr-icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <form action="{{ route('services.indexFood') }}" method="GET">
                            <div class="sidebar-widget price-filters">
                                <div class="widget-title">
                                    <h5 class="widget-title">Lọc Theo Giá</h5>
                                </div>

                                <div class="range-slider clearfix">
                                    <div class="price-range-slider" id="price-range-slider"></div>

                                    <div class="clearfix">
                                        <p>Giá:</p>
                                        <div class="title" id="price-range-text"></div>

                                        <div class="input">
                                            <input type="text" class="property-amount" id="price-range-display" readonly>
                                        </div>

                                        {{-- Input ẩn để gửi min và max về controller --}}
                                        <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price', 0) }}">
                                        <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price', 1000000) }}">

                                        <input type="submit" value="Filter">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                    <!--MixitUp Galery-->
                    <div class="mixitup-gallery mt-5 mt-lg-0">
                        <!--Filter-->
                        <div class="filter-list row">
                            <!--Product Block-->
                            @foreach ($product as $item)
                                <div class="product-block all mix pantry fruit col-lg-4 col-md-6 col-sm-12">
                                    <div class="inner-box">
                                        <div class="image"><a href="{{ route('services.showClient', $item->id) }}"><img
                                                    src="{{ asset('storage/' . $item->image) }}" alt="" /></a>
                                        </div>
                                        <div class="content">
                                            <h4><a
                                                    href="{{ route('services.showClient', $item->id) }}">{{ $item->name }}</a>
                                            </h4>
                                            <span class="price">{{ number_format($item->price, 0, ',', '.') }} đ</span>
                                            <span class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i></span>
                                        </div>
                                        <div class="icon-box">
                                            <a href="shop-product-details.html" class="ui-btn like-btn"><i
                                                    class="fa fa-heart"></i></a>
                                            <a href="shop-cart.html" class="ui-btn add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i></a>
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
    <!-- End Featured Products -->
@endsection

@push('js')
    <script src="{{ asset('client/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('client/js/script.js') }}"></script>
    <script>
    $(function () {
        const min = 0;
        const max = {{ $maxPrice }};
        const minInit = {{ request('min_price', 0) }};
        const maxInit = {{ request('max_price', $maxPrice) }};

        $("#price-range-slider").slider({
            range: true,
            min: min,
            max: max,
            step: 500, // cho phép lọc giá lẻ như 23.500đ
            values: [minInit, maxInit],
            slide: function (event, ui) {
                $("#price-range-text").text(ui.values[0].toLocaleString() + " đ - " + ui.values[1].toLocaleString() + " đ");
                $("#price-range-display").val(ui.values[0].toLocaleString() + " đ - " + ui.values[1].toLocaleString() + " đ");
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);
            }
        });

        // Hiển thị ban đầu
        $("#price-range-text").text(minInit.toLocaleString() + " đ - " + maxInit.toLocaleString() + " đ");
        $("#price-range-display").val(minInit.toLocaleString() + " đ - " + maxInit.toLocaleString() + " đ");
    });
</script>
@endpush
