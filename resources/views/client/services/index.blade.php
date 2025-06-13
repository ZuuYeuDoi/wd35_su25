@extends('client.index')

@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Dịch vụ</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Trang chủ</a></li>
                    <li>Dịch vụ</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    <!-- Features Section Two -->
    <section class="feature-section-two pt-120 pb-120">
        <div class="auto-container">
            <div class="row feature-row g-0">
                <div class="image-column col-lg-6">
                    <div class="inner-column">
                        <div class="image-box">
                            <figure class="image overlay-anim wow reveal-right"><img src="{{ asset('client/images/resource/beboingoaitroi.webp') }}"
                                    alt=""></figure>
                        </div>
                    </div>
                </div>
                <div class="content-column col-lg-6">
                    <div class="inner-column">
                        <div class="content-box">
                            <div class="sec-title">
                                <span class="sub-title">Trải Nghiệm</span>
                                <h2>Bể Bơi Ngoài Trời</h2>
                                <div class="text">Thư giãn và tận hưởng không gian mát lành!</div>
                            </div>
                            <a href="{{ route('services.detail') }}" class="theme-btn btn-style-two read-more">Xem Thêm</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row feature-row g-0">
                <div class="content-column col-lg-6">
                    <div class="inner-column">
                        <div class="content-box">
                            <div class="sec-title">
                                <span class="sub-title">Trải Nghiệm</span>
                                <h2>Chăm Sóc Cơ Thể</h2>
                                <div class="text">Phục hồi cơ thể với liệu trình trị liệu chuyên nghiệp!</div>
                            </div>
                            <a href="{{ route('services.detail') }}" class="theme-btn btn-style-two read-more">Xem Thêm</a>
                        </div>
                    </div>
                </div>
                <div class="image-column col-lg-6">
                    <div class="inner-column">
                        <div class="image-box">
                            <figure class="image overlay-anim wow reveal-left"><img src="{{ asset('client/images/resource/spacaocap.jpg') }}"
                                    alt=""></figure>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row feature-row g-0">
                <div class="image-column col-lg-6">
                    <div class="inner-column">
                        <div class="image-box">
                            <figure class="image overlay-anim wow reveal-right"><img src="{{ asset('client/images/resource/feature2-3.jpg') }}"
                                    alt=""></figure>
                        </div>
                    </div>
                </div>
                <div class="content-column col-lg-6">
                    <div class="inner-column">
                        <div class="content-box">
                            <div class="sec-title">
                                <span class="sub-title">Trải Nghiệm</span>
                                <h2>Phòng GYM</h2>
                                <div class="text">Tập luyện cùng trang thiết bị hiện đại!</div>
                            </div>
                            <a href="{{ route('services.detail') }}" class="theme-btn btn-style-two read-more">Xem Thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Features Section -->
@endsection
