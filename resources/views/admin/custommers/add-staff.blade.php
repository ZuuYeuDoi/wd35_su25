@extends('layouts.admin')
@section('title1', 'Quản lý Nhân viên')
@section('content')
    <section role="main" class="content-body content-body-modern mt-0">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Thêm Nhân viên</h2>
        </header>
        <!-- start: page -->
        <form class="ecommerce-form action-buttons-fixed" action="#" method="post">
            <div class="row">
                <div class="col">
                    <section class="card card-modern card-big-info">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2-5 col-xl-1-5">
                                    <i class="card-big-info-icon bx bx-user-circle"></i>
                                    <h2 class="card-big-info-title">Thông tin tài khoản</h2>
                                    <p class="card-big-info-desc">Thêm vào đây thông tin tài khoản khách hàng với tất cả các
                                        chi tiết và thông tin cần thiết.</p>
                                </div>
                                <div class="col-lg-3-5 col-xl-4-5">
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Họ tên</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="text" class="form-control form-control-modern"
                                                name="customerEmailUsername" value="" required />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Ảnh đại diện</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="file" class="form-control form-control-modern"
                                                name="customerEmailUsername" value="" required />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">CCCD</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="text" class="form-control form-control-modern"
                                                name="customerEmailUsername" value="" required />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Chức vụ / vị trí</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <select class="form-control form-control-modern"
                                                name="customerShippingStateCountry">
                                                <option value="">Chọn chức vụ</option>
                                                <option value="state1">Nhân viên</option>
                                                <option value="state2">Quản lý</option>
                                                <option value="state3">Sếp</option>
                                                <option value="state4">...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Email</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="email" class="form-control form-control-modern"
                                                name="customerEmailUsername" value="" required />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center pb-3">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Mật khẩu</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="password" class="form-control form-control-modern"
                                                name="customerPassword" value="" required />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Xác nhận mật
                                            khẩu</label>
                                        <div class="col-lg-7 col-xl-6">
                                            <input type="password" class="form-control form-control-modern"
                                                name="customerPasswordConfirm" value="" />
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
                        <i class="bx bx-save text-4 me-2"></i> Thêm Nhân viên
                    </button>
                </div>
                <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                    <a href="ecommerce-customers-list.html"
                        class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Hủy</a>
                </div>
            </div>
        </form>
        <!-- end: page -->
    </section>
@endsection

@section('head')
    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
@endsection
@section('script')
    <!-- Vendor -->
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
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
    <script src="{{ asset('assets/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js') }}"></script>
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
    <script src="{{ asset('assets/js/examples/examples.ecommerce.datatables.list.js') }}"></script>
@endsection
