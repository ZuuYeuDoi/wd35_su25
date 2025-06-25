@extends('client.index')

@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Chi Tiết Dịch Vụ</h1>
                <ul class="page-breadcrumb">
                    <li><a href="/">Trang chủ</a></li>
                    <li><a href="{{ route('services.list') }}">Dịch vụ</a></li>
                    <li>Chi tiết dịch vụ</li>
                </ul>
            </div>
        </div>
    </section>

    <!--Start Services Details-->
    <section class="services-details pt-120 pb-120">
        <div class="container">
            <div class="row">
                <!--Start Services Details Sidebar-->
                <div class="col-xl-4 col-lg-4">
                    <div class="service-sidebar">
                        <!--Start Services Details Sidebar Single-->
                        <div class="sidebar-widget service-sidebar-single">
                            <div class="sidebar-service-list">
                                <ul>
                                    @foreach ($services as $service)
                                        <li
                                            class="{{ isset($selectedService) && $selectedService->id === $service->id ? 'current' : '' }}">
                                            <a href="{{ route('services.detail', ['id' => $service->id]) }}">
                                                <i class="fas fa-angle-right"></i>
                                                <span>{{ $service->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="service-details-help">
                                <div class="help-shape-1"></div>
                                <div class="help-shape-2"></div>
                                <h2 class="help-title">Liên hệ với <br /> chúng tôi <br /> qua</h2>
                                <div class="help-icon">
                                    <span class=" lnr-icon-phone-handset"></span>
                                </div>
                                <div class="help-contact">
                                    <p>Bạn cần giúp đỡ? Gọi ngay</p>
                                    <a href="tel:12463330079">+8498765432</a>
                                </div>
                            </div>
                        </div>
                        <!--End Services Details Sidebar-->
                    </div>
                </div>

                <!--Start Services Details Content-->
                <div class="col-xl-8 col-lg-8">
                    <div class="services-details__content">
                        @if ($selectedService)
                            <img src="{{ asset('storage/' . $selectedService->image) }}" alt="{{ $selectedService->name }}"
                                 style="width: 100%; max-width: 800px; max-height: 400px; object-fit: cover; display: block;"/>
                            <h3 class="mt-4"> {{ $selectedService->name }}</h3>
                            <p>{!! $selectedService->description !!}</p>
                        @else
                            <p>Vui lòng chọn một dịch vụ từ danh sách bên trái!</p>
                        @endif


                    </div>
                </div>
                <!--End Services Details Content-->
            </div>
        </div>
    </section>
@endsection
