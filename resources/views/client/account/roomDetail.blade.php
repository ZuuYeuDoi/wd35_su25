@extends('client.index')

@push('css')
    <link rel="stylesheet" href="{{ asset('client/css/account.css') }}">
@endpush

@section('content')
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Chi tiết đặt phòng</h1>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="room-detail-wrapper">
            <!-- Thông tin cơ bản -->
            <div class="room-basic-info">
                <div class="room-image">
                    <img src="{{ asset('client/images/room-deluxe.jpg') }}" alt="Deluxe Room">
                </div>
                <div class="room-info">
                    <h2>Phòng Deluxe</h2>
                    <div class="room-meta">
                        <span><i class="fas fa-door-open"></i> Phòng 301</span>
                        <span><i class="fas fa-building"></i> Tầng 3</span>
                        <span><i class="fas fa-users"></i> 2 người</span>
                        <span><i class="fas fa-ruler-combined"></i> 45m²</span>
                    </div>
                    <div class="booking-status success">
                        <i class="fas fa-check-circle"></i> Đã xác nhận
                    </div>
                </div>
            </div>

            <!-- Thông tin đặt phòng -->
            <div class="booking-details">
                <div class="detail-section">
                    <h3><i class="fas fa-calendar-alt"></i> Thông tin đặt phòng</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Mã đặt phòng</label>
                            <span>DLX-2024-001</span>
                        </div>
                        <div class="detail-item">
                            <label>Ngày đặt</label>
                            <span>10/03/2024</span>
                        </div>
                        <div class="detail-item">
                            <label>Check-in</label>
                            <span>15/03/2024</span>
                        </div>
                        <div class="detail-item">
                            <label>Check-out</label>
                            <span>20/03/2024</span>
                        </div>
                        <div class="detail-item">
                            <label>Số đêm</label>
                            <span>5 đêm</span>
                        </div>
                    </div>
                </div>

                <!-- Tiện ích phòng -->
                <div class="detail-section">
                    <h3><i class="fas fa-concierge-bell"></i> Tiện ích phòng</h3>
                    <div class="amenities-grid">
                        <div class="amenity-item">
                            <i class="fas fa-wifi"></i>
                            <span>WiFi miễn phí</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-snowflake"></i>
                            <span>Điều hòa</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-tv"></i>
                            <span>TV màn hình phẳng</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-glass-martini-alt"></i>
                            <span>Minibar</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-bath"></i>
                            <span>Bồn tắm</span>
                        </div>
                        <div class="amenity-item">
                            <i class="fas fa-briefcase"></i>
                            <span>Bàn làm việc</span>
                        </div>
                    </div>
                </div>

                <!-- Thông tin thanh toán -->
                <div class="detail-section">
                    <h3><i class="fas fa-money-bill-wave"></i> Thông tin thanh toán</h3>
                    <div class="payment-details">
                        <div class="payment-item">
                            <label>Giá phòng/đêm</label>
                            <span>2,500,000 VNĐ</span>
                        </div>
                        <div class="payment-item">
                            <label>Phí dịch vụ</label>
                            <span>500,000 VNĐ</span>
                        </div>
                        <div class="payment-item total">
                            <label>Tổng tiền</label>
                            <span>13,000,000 VNĐ</span>
                        </div>
                        <div class="payment-status">
                            <i class="fas fa-check-circle"></i>
                            <span>Đã thanh toán</span>
                        </div>
                    </div>
                </div>

                <!-- Các nút thao tác -->
                <div class="action-buttons">
                    <button class="btn btn-primary">
                        <i class="fas fa-edit"></i> Yêu cầu thay đổi
                    </button>
                    <button class="btn btn-danger">
                        <i class="fas fa-times"></i> Hủy đặt phòng
                    </button>
                    <button class="btn btn-secondary" onclick="window.history.back()">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
