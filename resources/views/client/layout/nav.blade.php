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
            <li class=""><a href="/services">Dịch vụ</a>
            </li>
            <li><a href="page-contact.html">Liên Hệ</a></li>
            <li class="dropdown">
                <a href="#">
                    {{ Auth::check() ? Auth::user()->name : 'Tài khoản' }}
                </a>
                <ul>
                    @guest
                        @if (Route::has('login'))
                            <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @endif
                    @else
                        <li><a href="/account">Thông tin cá nhân</a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </li>
        </ul>
    </nav>
    <!-- Main Menu End-->
</div>
