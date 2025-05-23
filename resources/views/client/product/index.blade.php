@extends('client.index')

@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Shop</h1>
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
                            <form action="https://html.kodesolution.com/2025/hoteler-html/shop-products.html" method="post"
                                class="search-form">
                                <div class="form-group">
                                    <input type="search" name="search-field" placeholder="Search..." required="">
                                    <button><i class="lnr lnr-icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="sidebar-widget category-widget">
                            <div class="widget-title">
                                <h5 class="widget-title">Categories</h5>
                            </div>
                            <div class="widget-content">
                                <ul class="category-list clearfix">
                                    <li><a href="shop-product-details.html">Cloud Solution</a></li>
                                    <li><a href="shop-product-details.html">Cyber Data</a></li>
                                    <li><a href="shop-product-details.html">SEO Marketing</a></li>
                                    <li><a href="shop-product-details.html">UI/UX Design</a></li>
                                    <li><a href="shop-product-details.html">Web Development</a></li>
                                    <li><a href="shop-product-details.html">Artifical Intelligence</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget price-filters">
                            <div class="widget-title">
                                <h5 class="widget-title">Filter by Price</h5>
                            </div>
                            <div class="range-slider clearfix">
                                <div class="price-range-slider"></div>
                                <div class="clearfix">
                                    <p>Price:</p>
                                    <div class="title"></div>
                                    <div class="input"><input type="text" class="property-amount" name="field-name"
                                            readonly></div>
                                    <input type="submit" value="Filter">
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-widget post-widget">
                            <div class="widget-title">
                                <h5 class="widget-title">Popular Products</h5>
                            </div>
                            <div class="post-inner">
                                <div class="post">
                                    <figure class="post-thumb"><a href="shop-details.html"><img
                                                src="{{ asset('client/images/resource/products/thumb-1.jpg') }}"
                                                alt=""></a></figure>
                                    <a href="shop-product-details.html">Best Headset</a>
                                    <span class="price">$45.00</span>
                                </div>
                                <div class="post">
                                    <figure class="post-thumb"><a href="shop-details.html"><img
                                                src="{{ asset('client/images/resource/products/thumb-2.jpg') }}"
                                                alt=""></a></figure>
                                    <a href="shop-product-details.html">Quality Battery</a>
                                    <span class="price">$34.00</span>
                                </div>
                                <div class="post">
                                    <figure class="post-thumb"><a href="shop-details.html"><img
                                                src="{{ asset('client/images/resource/products/thumb-3.jpg') }}"
                                                alt=""></a></figure>
                                    <a href="shop-product-details.html">Smart Watch</a>
                                    <span class="price">$29.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                    <!--MixitUp Galery-->
                    <div class="mixitup-gallery mt-5 mt-lg-0">
                        <!--Filter-->
                        <div class="filters clearfix">
                            <ul class="filter-tabs filter-btns clearfix">
                                <li class="active filter" data-role="button" data-filter="all">All</li>
                                <li class="filter" data-role="button" data-filter=".dairy">Cyber</li>
                                <li class="filter" data-role="button" data-filter=".pantry">Digital</li>
                                <li class="filter" data-role="button" data-filter=".meat">Software</li>
                                <li class="filter" data-role="button" data-filter=".fruit">Technology</li>
                                <li class="filter" data-role="button" data-filter=".vagetables">Development</li>
                            </ul>
                        </div>

                        <div class="filter-list row">
                            <!--Product Block-->
                            <div class="product-block all mix pantry fruit col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image"><a href="shop-product-details.html"><img
                                                src="{{ asset('client/images/resource/products/1.jpg') }}"
                                                alt="" /></a></div>
                                    <div class="content">
                                        <h4><a href="shop-product-details.html">Show Piece</a></h4>
                                        <span class="price">$32.00</span>
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

                            <!--Product Block-->
                            <div class="product-block all mix dairy meat fruit col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image"><a href="shop-product-details.html"><img
                                                src="{{ asset('client/images/resource/products/2.jpg') }}"
                                                alt="" /></a></div>
                                    <div class="content">
                                        <h4><a href="shop-product-details.html">Leather Belt</a></h4>
                                        <span class="price">$52.00</span>
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

                            <!--Product Block-->
                            <div class="product-block all mix pantry fruit vagetables col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image"><a href="shop-product-details.html"><img
                                                src="{{ asset('client/images/resource/products/3.jpg') }}"
                                                alt="" /></a></div>
                                    <div class="content">
                                        <h4><a href="shop-product-details.html">Sunglasses</a></h4>
                                        <span class="price">$43.00</span>
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

                            <!--Product Block-->
                            <div class="product-block all mix dairy meat vagetables col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image"><a href="shop-product-details.html"><img
                                                src="{{ asset('client/images/resource/products/4.jpg') }}"
                                                alt="" /></a></div>
                                    <div class="content">
                                        <h4><a href="shop-product-details.html">Backpack</a></h4>
                                        <span class="price">$22.00</span>
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

                            <!--Product Block-->
                            <div class="product-block all mix pantry meat fruit col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image"><a href="shop-product-details.html"><img
                                                src="{{ asset('client/images/resource/products/5.jpg') }}"
                                                alt="" /></a></div>
                                    <div class="content">
                                        <h4><a href="shop-product-details.html">Hand Watch</a></h4>
                                        <span class="price">$34.00</span>
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

                            <!--Product Block-->
                            <div class="product-block all mix dairy pantry col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image"><a href="shop-product-details.html"><img
                                                src="{{ asset('client/images/resource/products/6.jpg') }}"
                                                alt="" /></a></div>
                                    <div class="content">
                                        <h4><a href="shop-product-details.html">Party Bag</a></h4>
                                        <span class="price">$52.00</span>
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

                            <!--Product Block-->
                            <div class="product-block all mix fruit vagetables col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image"><a href="shop-product-details.html"><img
                                                src="{{ asset('client/images/resource/products/7.jpg') }}"
                                                alt="" /></a></div>
                                    <div class="content">
                                        <h4><a href="shop-product-details.html">Coffee Mug</a></h4>
                                        <span class="price">$25.00</span>
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

                            <!--Product Block-->
                            <div class="product-block all mix dairy pantry meat vagetables col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image"><a href="shop-product-details.html"><img
                                                src="{{ asset('client/images/resource/products/8.jpg') }}"
                                                alt="" /></a></div>
                                    <div class="content">
                                        <h4><a href="shop-product-details.html">Smart Watch</a></h4>
                                        <span class="price">$30.00</span>
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
@endpush
