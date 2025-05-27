@section('content')
    <section class="body-sign body-locked">
        <div class="center-sign">
            <div class="panel card-sign">
                <div class="card-body">
                    <form action="#">
                        <div class="current-user text-center">
                            <img src="{{ asset('assets/img/%21logged-user.jpg') }}" alt="HoangTaly"
                                class="rounded-circle user-image" />
                            <h2 class="user-name text-dark m-0">HoangTaly</h2>
                            <p class="user-email m-0">hoangtaly@gmail.com</p>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <input id="pwd" type="password" class="form-control form-control-lg"
                                    placeholder="Password" />
                                <span class="input-group-text">
                                    <i class="bx bx-lock"></i>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="mt-1 mb-3">
                                    <a href="#">không phải HoangTaly?</a>
                                </p>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary pull-right">Mở khóa</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
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
