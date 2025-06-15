@extends('client.index')
@push('css')
    <style>
        ul.bx-links {
            color: #fff;
            font-size: 13px;
        }
    </style>
@endpush
@section('content')
    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Rooms</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li>Rooms</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    <!-- rooms-section -->
    <section class="rooms-section pb-100">
        <div class="auto-container">
            <div class="row">
                <!-- room-block -->
                @foreach ($rooms as $item)
                    <div class="room-block col-lg-6 col-md-6">
                        <div class="inner-box wow fadeIn">
                            <div class="image-box">
                                @php
                                    $image = $item->images_room->first();
                                @endphp
                                <a href="{{ route('room.detail', ['id' => $item->id]) }}">
                                    <figure class="image-2 overlay-anim">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="">
                                    </figure>
                                </a>

                            </div>
                            @php
                                if ($item->max_people == 1) {
                                    $bed = '1 giường đơn';
                                } elseif ($item->max_people == 2) {
                                    $bed = '2 giường đơn';
                                } elseif ($item->max_people == 3) {
                                    $bed = '1 giường đôi';
                                } elseif ($item->max_people == 4) {
                                    $bed = '1 giường đôi + 1 giường  đơn';
                                }
                            @endphp
                            <div class="content-box">
                                <h6 class="title"><a href="room-details.html">{{ $item->title }}</a></h6>
                                <span class="price">{{ $item->roomType->name }} -</span>
                                <span class="price">{{ number_format($item->price, 0, ',', '.') }} VND / đêm -</span>
                                <span class="price"><i class="fal fa-bed me-2"></i> {{ $bed }}</span>
                            </div>
                            <div class="box-caption">
                                <a href="{{ route('room.detail', ['id' => $item->id]) }}" class="book-btn">Đặt phòng</a>
                                <ul class="bx-links">
                                    @if (!empty($item->amenities) && is_array($item->amenities))
                                        @foreach ($item->amenities as $amenityId)
                                            @if ($allAmenities->has($amenityId))
                                                <li>
                                                    {{ $allAmenities[$amenityId]->name }}
                                                </li>
                                            @endif
                                        @endforeach
                                    @else
                                        <li><em>Không có tiện ích</em></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End rooms-section -->
@endsection
@push('js')
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('client/js/jquery.js') }} "></script>
    <script src="{{ asset('client/js/popper.min.js') }} "></script>
    <script src="{{ asset('client/js/bootstrap.min.js') }} "></script>
    <script src="{{ asset('client/js/slick.min.js') }} "></script>
    <script src="{{ asset('client/js/slick-animation.min.js') }} "></script>
    <script src="{{ asset('client/js/jquery.fancybox.js') }} "></script>
    <script src="{{ asset('client/js/jquery-ui.js') }} "></script>
    <script src="{{ asset('client/js/wow.js') }} "></script>
    <script src="{{ asset('client/js/appear.js') }} "></script>
    <script src="{{ asset('client/js/owl.js') }} "></script>
    <script src="{{ asset('client/js/swiper.min.js') }} "></script>
    <script src="{{ asset('client/js/script.js') }} "></script>
@endpush
