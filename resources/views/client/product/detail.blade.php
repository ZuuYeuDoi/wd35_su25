@extends('client.index')

@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Product Deatils</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>Shop</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    <!--Product Details Start-->
    <section class="product-details pt-120">
        <div class="container pb-70">
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="bxslider">
                        <div class="slider-content">
                            <figure class="image-box"><a
                                    href="{{ asset('client/images/resource/products/product-details.jpg') }}"
                                    class="lightbox-image" data-fancybox="gallery"><img
                                        src="{{ asset('client/images/resource/products/product-details.jpg') }}"
                                        alt=""></a></figure>
                            <div class="slider-pager">
                                <ul class="thumb-box">
                                    <li> <a class="active" data-slide-index="0" href="#">
                                            <figure><img
                                                    src="{{ asset('client/images/resource/products/product-details.jpg') }}"
                                                    alt="">
                                            </figure>
                                        </a> </li>
                                    <li> <a data-slide-index="1" href="#">
                                            <figure><img
                                                    src="{{ asset('client/images/resource/products/product-details2.jpg') }}"
                                                    alt="">
                                            </figure>
                                        </a> </li>
                                    <li> <a data-slide-index="2" href="#">
                                            <figure><img
                                                    src="{{ asset('client/images/resource/products/product-details3.jpg') }}"
                                                    alt="">
                                            </figure>
                                        </a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="slider-content">
                            <figure class="image-box"><a
                                    href="{{ asset('client/images/resource/products/product-details2.jpg') }}"
                                    class="lightbox-image" data-fancybox="gallery"><img
                                        src="{{ asset('client/images/resource/products/product-details2.jpg') }}"
                                        alt=""></a></figure>
                            <div class="slider-pager">
                                <ul class="thumb-box">
                                    <li> <a class="active" data-slide-index="0" href="#">
                                            <figure><img
                                                    src="{{ asset('client/images/resource/products/product-details.jpg') }}"
                                                    alt="">
                                            </figure>
                                        </a> </li>
                                    <li> <a data-slide-index="1" href="#">
                                            <figure><img
                                                    src="{{ asset('client/images/resource/products/product-details2.jpg') }}"
                                                    alt="">
                                            </figure>
                                        </a> </li>
                                    <li> <a data-slide-index="2" href="#">
                                            <figure><img
                                                    src="{{ asset('client/images/resource/products/product-details3.jpg') }}"
                                                    alt="">
                                            </figure>
                                        </a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="slider-content">
                            <figure class="image-box"><a
                                    href="{{ asset('client/images/resource/products/product-details3.jpg') }}"
                                    class="lightbox-image" data-fancybox="gallery"><img
                                        src="{{ asset('client/images/resource/products/product-details3.jpg') }}"
                                        alt=""></a></figure>
                            <div class="slider-pager">
                                <ul class="thumb-box">
                                    <li> <a class="active" data-slide-index="0" href="#">
                                            <figure><img
                                                    src="{{ asset('client/images/resource/products/product-details.jpg') }}"
                                                    alt="">
                                            </figure>
                                        </a> </li>
                                    <li> <a data-slide-index="1" href="#">
                                            <figure><img
                                                    src="{{ asset('client/images/resource/products/product-details2.jpg') }}"
                                                    alt="">
                                            </figure>
                                        </a> </li>
                                    <li> <a data-slide-index="2" href="#">
                                            <figure><img
                                                    src="{{ asset('client/images/resource/products/product-details3.jpg') }}"
                                                    alt="">
                                            </figure>
                                        </a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6 product-info">
                    <div class="product-details__top">
                        <h3 class="product-details__title">Backpack <span>$76.00</span> </h3>
                    </div>
                    <div class="product-details__reveiw">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <span>2 Customer Reviews</span>
                    </div>
                    <div class="product-details__content">
                        <p class="product-details__content-text1">Aliquam hendrerit a augue insuscipit. Etiam
                            aliquam massa quis des mauris commodo venenatis ligula commodo leez sed blandit
                            convallis dignissim onec vel pellentesque neque.</p>
                        <p class="product-details__content-text2"><strong>REF.</strong> 4231/406 <br />
                            Available in store</p>
                    </div>

                    <div class="product-details__quantity">
                        <h3 class="product-details__quantity-title">Số lượng</h3>
                        <div class="quantity-box">
                            <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                            <input type="number" id="1" value="1" />
                            <button type="button" class="add"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>


                    <div class="product-details__buttons">
                        <div class="product-details__buttons-1">
                            <a href="shop-cart.html" class="theme-btn btn-style-one"><span class="btn-title">Thêm vào giỏ hàng</span></a>
                        </div>
                        <div class="product-details__buttons-2">
                            <a href="shop-product-details.html" class="theme-btn btn-style-one"><span
                                    class="btn-title">Đặt ngay</span></a>
                        </div>
                    </div>
                    <div class="product-details__social">
                        <div class="title mt-10">
                            <h3>Share with friends</h3>
                        </div>
                        <ul class="social-icon-one product-share">
                            <li><a href="#"><i class="fab fa-x-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        </ul>
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
    <!-- form submit -->
    <script src="{{ asset('client/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.form.min.js') }}"></script>
    <script>
        (function($) {
            $("#contact_form").validate({
                submitHandler: function(form) {
                    var form_btn = $(form).find('button[type="submit"]');
                    var form_result_div = '#form-result';
                    $(form_result_div).remove();
                    form_btn.before(
                        '<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>'
                    );
                    var form_btn_old_msg = form_btn.html();
                    form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
                    $(form).ajaxSubmit({
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 'true') {
                                $(form).find('.form-control').val('');
                            }
                            form_btn.prop('disabled', false).html(form_btn_old_msg);
                            $(form_result_div).html(data.message).fadeIn('slow');
                            setTimeout(function() {
                                $(form_result_div).fadeOut('slow')
                            }, 6000);
                        }
                    });
                }
            });
        })(jQuery);
    </script>
@endpush
