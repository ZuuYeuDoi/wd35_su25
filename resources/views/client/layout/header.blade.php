 <header class="main-header header-style-five">
           
            <div class="header-lower">
                <!-- Main box -->
                <div class="main-box">
                    <div class="logo-box">
                        <div class="logo"><a href="index.html"><img src="{{ asset('client/images/logo-2.png') }}"
                                    alt="" title="Hoteler"></a></div>
                    </div>

                    <!--Nav Box-->
                    @include('client.layout.nav')

                    <div class="outer-box">
                        <div class="ui-btn-outer">
                            <button class="ui-btn ui-btn search-btn">
                                <span class="icon lnr lnr-icon-search"></span>
                            </button>
                            <a href="shop-cart.html" class="ui-btn cart-btn">
                                <i class="lnr-icon-shopping-cart"></i>
                                <span class="items-count">0</span>
                            </a>
                        </div>
                        <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                        <!-- Mobile Nav toggler -->
                    </div>
                </div>
                <!-- Mobile Menu  -->
                <div class="mobile-menu">
                    <div class="menu-backdrop"></div>
                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    <nav class="menu-box">
                        <div class="upper-box">
                            <div class="nav-logo"><a href="index.html"><img
                                        src="{{ asset('client/images/logo-2.png') }}" alt=""></a></div>
                            <div class="close-btn"><i class="icon fa fa-times"></i></div>
                        </div>
                        <ul class="navigation clearfix">
                            <!--Keep This Empty / Menu will come through Javascript-->
                        </ul>
                        <ul class="contact-list-one">
                            <li>
                                <!-- Contact Info Box -->
                                <div class="contact-info-box">
                                    <i class="icon lnr-icon-phone-handset"></i>
                                    <span class="title">Gọi Ngay</span>
                                    <a href="tel:+92880098670">+92 (8800) - 98670</a>
                                </div>
                            </li>
                            <li>
                                <!-- Contact Info Box -->
                                <div class="contact-info-box">
                                    <span class="icon lnr-icon-envelope1"></span>
                                    <span class="title">Gửi Email</span>
                                    <a
                                        href="https://html.kodesolution.com/cdn-cgi/l/email-protection#95fdf0f9e5d5f6faf8e5f4fbecbbf6faf8"><span
                                            class="__cf_email__"
                                            data-cfemail="cba3aea7bb8ba8a4a6bbaaa5b2e5a8a4a6">[email&#160;protected]</span></a>
                                </div>
                            </li>
                            <li>
                                <!-- Contact Info Box -->
                                <div class="contact-info-box">
                                    <span class="icon lnr-icon-clock"></span>
                                    <span class="title">Khung Giờ</span>
                                    Thứ Hai - Thứ Bảy 8:00 - 6:30, Chủ Nhật - Đóng cửa
                                </div>
                            </li>
                        </ul>
                        <ul class="social-links">
                            <li><a href="#"><i class="fab fa-x-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </nav>
                </div><!-- End Mobile Menu -->

                <!-- Header Search -->
                <div class="search-popup">
                    <span class="search-back-drop"></span>
                    <button class="close-search"><span class="fa fa-times"></span></button>
                    <div class="search-inner">
                        <form method="post" action="https://html.kodesolution.com/2025/hoteler-html/index.html">
                            <div class="form-group">
                                <input type="search" name="search-field" value="" placeholder="Search..."
                                    required="">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Header Search -->

                <!-- Sticky Header  -->
                <div class="sticky-header">
                    <div class="auto-container">
                        <div class="inner-container">
                            <!--Logo-->
                            <div class="logo">
                                <a href="index.html"><img src="{{ asset('client/images/logo-2.png') }}"
                                        alt=""></a>
                            </div>
                            <!--Right Col-->
                            <div class="nav-outer">
                                <!-- Main Menu -->
                                <nav class="main-menu">
                                    <div class="navbar-collapse show collapse clearfix">
                                        <ul class="navigation clearfix">
                                            <!--Keep This Empty / Menu will come through Javascript-->
                                        </ul>
                                    </div>
                                </nav><!-- Main Menu End-->
                                <!--Mobile Navigation Toggler-->
                                <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Sticky Menu -->
            </div>
        </header>