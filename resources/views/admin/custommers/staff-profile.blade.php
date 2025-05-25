@extends('layouts.admin')
@section('title1', 'Thông tin cá nhân')
@section('content')
    <section role="main" class="content-body content-body-modern mt-0">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Thông tin cá nhân</h2>
        </header>
        <!-- start: page -->
        <div class="row">
            <div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
                <section class="card">
                    <div class="card-body">
                        <div class="thumb-info mb-3">
                            <img src="{{ asset('assets/img/%21logged-user.jpg') }}" class="rounded img-fluid" alt="John Doe">
                            <div class="thumb-info-title">
                                <span class="thumb-info-inner">HoangTaly</span>
                                <span class="thumb-info-type">Chủ tịch</span>
                            </div>
                        </div>
                        <hr class="dotted short">
                        <h5 class="mb-2 mt-3">Giới thiệu</h5>
                        <p class="text-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis vulputate
                            quam. Interdum et malesuada</p>
                        <hr class="dotted short">
                        <div class="social-icons-list">
                            <a rel="tooltip" data-bs-placement="bottom" target="_blank" href="http://www.facebook.com/"
                                data-original-title="Facebook"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
                            <a rel="tooltip" data-bs-placement="bottom" href="http://www.twitter.com/"
                                data-original-title="Twitter"><i class="fab fa-twitter"></i><span>Twitter</span></a>
                            <a rel="tooltip" data-bs-placement="bottom" href="http://www.linkedin.com/"
                                data-original-title="Linkedin"><i class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
                        </div>
                    </div>
                </section>

            </div>
            <div class="col-lg-8 col-xl-6">
                <div class="tabs">

                    <form class="p-3">
                        <h4 class="mb-3 font-weight-semibold text-dark">Thông tin</h4>
                        <div class="row row mb-4">
                            <div class="form-group col">
                                <label for="inputAddress">Họ tên</label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="HoangTaly">
                            </div>
                        </div>
                        <div class="row row mb-4">
                            <div class="form-group col">
                                <label for="inputAddress">Email</label>
                                <input type="email" class="form-control" id="inputAddress"
                                    placeholder="hoangtaly@gmail.com">
                            </div>
                        </div>
                        <div class="row row mb-4">
                            <div class="form-group col">
                                <label for="inputAddress">Địa chỉ</label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                            </div>
                        </div>
                        <div class="row row mb-4">
                            <div class="form-group col">
                                <label for="inputAddress">CCCD</label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                            </div>
                        </div>

                        <hr class="dotted tall">
                        <h4 class="mb-3 font-weight-semibold text-dark">Đổi mật khẩu</h4>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Mật khẩu">
                            </div>
                            <div class="form-group col-md-6 border-top-0 pt-0">
                                <label for="inputPassword5">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" id="inputPassword5" placeholder="Mật khẩu">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mt-3">
                                <button class="btn btn-success modal-confirm">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-3">
                <h4 class="mb-3 mt-0 font-weight-semibold text-dark">Thống kê</h4>
                <ul class="simple-card-list mb-3">
                    <li class="primary">
                        <h3>488</h3>
                        <p class="text-light">Nullam quris ris.</p>
                    </li>
                    <li class="primary">
                        <h3>$ 189,000.00</h3>
                        <p class="text-light">Nullam quris ris.</p>
                    </li>
                    <li class="primary">
                        <h3>16</h3>
                        <p class="text-light">Nullam quris ris.</p>
                    </li>
                </ul>

            </div>
        </div>
        <!-- end: page -->
    </section>
@endsection

@section('head')

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
    <script src="{{ asset('assets/vendor/autosize/autosize.js') }}"></script>
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
@endsection
