<div class="nav-outer">
    <nav class="nav main-menu">
        <ul class="navigation">
            <li class=""><a href="/">Trang Chủ</a>
            </li>
            <li class="dropdown"><a href="#">Phòng</a>
                <ul>
                    <li><a href="page-rooms.html">Danh Sách Phòng</a></li>
                    <li><a href="page-rooms-suite.html">Đặt Phòng</a></li>
                </ul>
            </li>
            <li class="dropdown"><a href="#">Đặt tiệc & sự kiện</a>
                <ul>
                    <li><a href="page-about.html">Danh sách sự kiện</a></li>
                    <li><a href="page-faq.html">Đặt sự kiện</a></li>
                </ul>
            </li>
            <li class="dropdown"><a href="#">Dịch vụ</a>
                <ul>
                    <li><a href="news-grid.html">Đặt đồ ăn</a></li>
                    <li><a href="news-details.html">Gọi dọn phòng</a></li>
                    <li><a href="news-details.html">Dịch vụ giặt ủi</a></li>
                    <li><a href="news-details.html">Spa / Gym</a></li>
                    <li><a href="news-details.html">Đưa đón sân bay</a></li>
                </ul>
            </li>
            <li><a href="page-contact.html">Liên Hệ</a></li>
            <li class="dropdown"><a href="#">{{ Auth::user()->name }}</a>
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                <li>
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                    <li>
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <ul>
                    <li><a href="/account">Thông tin cá nhân</a></li>
                    <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Đăng
                            xuất</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            @endguest
            </li>
        </ul>
    </nav>
    <!-- Main Menu End-->
</div>
