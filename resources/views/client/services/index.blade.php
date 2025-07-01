@extends('client.index')

@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Dịch Vụ Chăm Sóc</h1>
                <ul class="page-breadcrumb">
                    <li><a href="/">Trang chủ</a></li>
                    <li>Dịch vụ</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    <!-- Features Section Two -->
    <section class="feature-section-two pt-120 pb-120">
        <div class="auto-container">
            @foreach ($services as $index => $service)
                <div class="row feature-row g-0">
                    {{-- Nếu là hàng chẵn, hiển thị ảnh bên trái --}}
                    @if ($index % 2 == 0)
                        <div class="image-column col-lg-6">
                            <div class="inner-column">
                                <div class="image-box">
                                    <figure class="image overlay-anim wow reveal-right">
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                            style="width: 100%; height: 350px; object-fit: cover;">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="content-column col-lg-6">
                            <div class="inner-column">
                                <div class="content-box">
                                    <div class="sec-title">
                                        <span class="sub-title">Trải Nghiệm</span>
                                        <h2>{{ $service->name }}</h2>
                                    </div>
                                    <a href="{{ route('services.detail', ['id' => $service->id]) }}"
                                        class="theme-btn btn-style-two read-more">Xem Thêm</a>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Nếu là hàng lẻ, đổi vị trí ảnh và nội dung --}}
                        <div class="content-column col-lg-6">
                            <div class="inner-column">
                                <div class="content-box">
                                    <div class="sec-title">
                                        <span class="sub-title">Trải Nghiệm</span>
                                        <h2>{{ $service->name }}</h2>
                                    </div>
                                    <a href="{{ route('services.detail', ['id' => $service->id]) }}"
                                        class="theme-btn btn-style-two read-more">Xem Thêm</a>
                                </div>
                            </div>
                        </div>
                        <div class="image-column col-lg-6">
                            <div class="inner-column">
                                <div class="image-box">
                                    <figure class="image overlay-anim wow reveal-left">
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                            style="width: 100%; height: 350px; object-fit: cover;">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <!-- End Features Section -->
@endsection
