@extends('client.index')

@push('css')
    <link rel="stylesheet" href="{{ asset('client/css/account.css') }}">
@endpush

@section('content')
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Thông tin tài khoản</h1>

            </div>
        </div>
    </section>
    <div class="container">
        <div class="sidebar">
            <div class="user-info">
                <div class="avatar">
                    <img src="{{ asset('client/images/default-avatar.png') }}" alt="Avatar">
                </div>
                <h3 class="user-name">Nguyễn Văn A</h3>
                <p class="user-email">nguyenvana@gmail.com</p>
            </div>
            <nav class="menu">
                <a href="#profile" class="menu-item active">
                    <i class="fas fa-user"></i>
                    Thông tin cá nhân
                </a>
                <a href="#rooms" class="menu-item">
                    <i class="fas fa-bed"></i>
                    Phòng đã đặt
                </a>
                <a href="#services" class="menu-item">
                    <i class="fas fa-concierge-bell"></i>
                    Dịch vụ đã đặt
                </a>
                <a href="#foods" class="menu-item">
                    <i class="fas fa-utensils"></i>
                    Đồ ăn đã đặt
                </a>
            </nav>
        </div>

        <div class="main-content">
            <!-- Thông tin cá nhân -->
            <section id="profile" class="content-section active">
                <h2>Thông tin cá nhân</h2>
                <form class="profile-form">
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" value="Nguyễn Văn A">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="nguyenvana@gmail.com">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="tel" value="0123456789">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" value="123 Đường ABC, Quận XYZ, TP.HCM">
                    </div>
                    <button type="submit" class="btn-save">Lưu thay đổi</button>
                </form>
            </section>

            <!-- Phòng đã đặt -->
            <section id="rooms" class="content-section">
                <h2>Phòng đã đặt</h2>
                <div class="booking-list">
                    <div class="booking-item">
                        <div class="room-info">
                            <img src="{{ asset('client/images/room-deluxe.jpg') }}" alt="Deluxe Room">
                            <div class="room-details">
                                <h3>Phòng Deluxe</h3>
                                <p>Phòng 301 - Tầng 3</p>
                                <p>Check-in: 15/03/2024</p>
                                <p>Check-out: 20/03/2024</p>
                            </div>
                        </div>
                        <div class="booking-status success">Đã xác nhận</div>
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-info-circle"></i> Xem chi tiết
                        </a>
                    </div>
                </div>
            </section>

            <!-- Dịch vụ đã đặt -->
            <section id="services" class="content-section">
                <h2>Dịch vụ đã đặt</h2>
                <div class="service-list">
                    <div class="service-item">
                        <div class="service-info">
                            <i class="fas fa-spa"></i>
                            <div class="service-details">
                                <h3>Massage thư giãn</h3>
                                <p>Ngày: 16/03/2024</p>
                                <p>Giờ: 14:00 - 15:30</p>
                            </div>
                        </div>
                        <div class="service-status pending">Đang chờ xác nhận</div>
                    </div>
                </div>
            </section>

            <!-- Đồ ăn đã đặt -->
            <section id="foods" class="content-section">
                <h2>Đồ ăn đã đặt</h2>
                <div class="food-list">
                    <div class="food-item">
                        <div class="food-info">
                            <img src="{{ asset('client/images/food-breakfast.jpg') }}" alt="Breakfast">
                            <div class="food-details">
                                <h3>Bữa sáng buffet</h3>
                                <p>Ngày: 17/03/2024</p>
                                <p>Số người: 2</p>
                            </div>
                        </div>
                        <div class="food-status completed">Đã hoàn thành</div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('client/js/account.js') }}"></script>
@endpush
