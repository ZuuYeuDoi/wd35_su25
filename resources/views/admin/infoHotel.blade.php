@extends('layouts.admin')
@section('title1', 'Thông tin khách sạn')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Thông tin khách sạn</h2>
        </header>
        <!-- start: page -->
        <form class="ecommerce-form action-buttons-fixed" action="#" method="post">
            <div class="row mt-2">
                <div class="col">
                    <section class="card card-modern card-big-info">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2-5 col-xl-1-5">
                                    <i class="card-big-info-icon bx bx-camera"></i>
                                    <h2 class="card-big-info-title">Ảnh logo</h2>
                                    <p class="card-big-info-desc">Sửa Logo khách sạn tại đây</p>
                                </div>
                                <div class="col-lg-3-5 col-xl-4-5">
                                    <div class="form-group row align-items-center">
                                        <div class="col">
                                            <div id="dropzone-form-image" class="dropzone-modern dz-square">
                                                <span class="dropzone-upload-message text-center">
                                                    <i class="bx bxs-cloud-upload"></i>
                                                    <b class="text-color-primary">Kéo/ Tải</b> ảnh của bạn tại đây.
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <section class="card card-modern card-big-info">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2-5 col-xl-1-5">
                                    <i class="card-big-info-icon bx bx-slider"></i>
                                    <h2 class="card-big-info-title">Thông tin</h2>
                                    <p class="card-big-info-desc">Sửa tất cả thông tin khách sạn tại đây.</p>
                                </div>
                                <div class="col-lg-3-5 col-xl-4-5">
                                    <div class="form-group row align-items-center mb-3">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Địa chỉ</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="text" class="form-control form-control-modern"
                                                name="" value="" required />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-3">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Email</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="text" class="form-control form-control-modern"
                                                name="" value="" required />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-3">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Hotline</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="text" class="form-control form-control-modern"
                                                name="" value="" />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-3">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Thời gian tiếp khách</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="text" class="form-control form-control-modern"
                                                name="" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row action-buttons">
                <div class="col-12 col-md-auto">
                    <button type="submit"
                        class="submit-button btn btn-success btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                        data-loading-text="Loading...">
                        <i class="bx bx-save text-4 me-2"></i> Lưu
                    </button>
                </div>
                <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                    <a href="ecommerce-category-list.html"
                        class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Hủy</a>
                </div>
            </div>
        </form>
        <!-- end: page -->
    </section>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/vendor/dropzone/basic.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
@endsection

@section('script')
    <!-- Vendor -->
    <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/master/style-switcher/style.switcher.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper/umd/popper.min.html') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/common/common.js') }}"></script>
    <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
    <script src="{{ asset('assets/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
    <!-- Specific Page Vendor -->
    <script src="{{ asset('assets/vendor/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <!-- Theme Custom -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- Theme Initialization Files -->
    <script src="{{ asset('assets/js/theme.init.js') }}"></script>
    <!-- Analytics to Track Preview Website -->
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '../../../../www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-42715764-8', 'auto');
        ga('send', 'pageview');
    </script>
    <!-- Examples -->
    <script src="{{ asset('assets/js/examples/examples.header.menu.js') }}"></script>
    <script src="{{ asset('assets/js/examples/examples.ecommerce.form.js') }}"></script>
@endsection
