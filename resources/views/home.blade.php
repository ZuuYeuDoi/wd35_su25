@extends('client.index')

@push('css')
    <style>
        ul.facilities-list {
            display: grid;
            grid-template-columns: auto auto;
            margin-top: 15px;
        }

        .room-service-block-one .inner-box {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            background-color: #fff;
            margin-bottom: 0px !important;
        }

        .room-service-block-one .image-2 img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            display: block;
        }
        .image-box {
            width: 100%;
            height: 250px; /* hoặc 200px nếu bạn muốn nhỏ hơn */
            overflow: hidden;
            border-radius: 10px;
            margin-top: 15px;
        }

        .image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <!-- Banner Section -->
    <section class="banner-section-seven">
        <div class="banner-slider banner-slider-home1">
            <div class="banner-slide">
                <div class="outer-box">
                    <figure class="image-1 wow fadeInUp tm-gsap-img-parallax overflow-hidden">
                        <img src="{{ asset('client/images/banner/banner1-1.jpg') }}" alt="">
                    </figure>
                    <div class="content-box">
                        <div class="star-rating" data-animation-in="fadeInUp" data-wow-delay="300ms">
                            <i class="fa-sharp fa-solid fa-star-sharp"></i>
                            <i class="fa-sharp fa-solid fa-star-sharp"></i>
                            <i class="fa-sharp fa-solid fa-star-sharp"></i>
                            <i class="fa-sharp fa-solid fa-star-sharp"></i>
                            <i class="fa-sharp fa-solid fa-star-sharp"></i>
                        </div>
                        <h1 data-animation-in="fadeInUp" data-delay-in="0.3">Chào Mừng Bạn Đến Với Chúng Tôi <br />
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Section -->

    <!-- Form Section -->
    <!-- <div class="checkout-form-section-two">
                                                                    <div class="container">
                                                                        <div class="checkout-form">
                                                                            <div class="checkout-field">
                                                                                <h4>Check-In</h4>
                                                                                <div class="chk-field">
                                                                                    <input class="date-pick" type="text" placeholder="31 Dec 2025" />
                                                                                    <i class="fas fa-angle-down"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkout-field">
                                                                                <h4>Check-Out</h4>
                                                                                <div class="chk-field">
                                                                                    <input class="date-pick" type="text" placeholder="31 Dec 2025" />
                                                                                    <i class="fas fa-angle-down"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkout-field select-field br-0">
                                                                                <h4>Quests</h4>
                                                                                <div class="chk-field">
                                                                                    <i class="fas fa-angle-down"></i>
                                                                                    <select>
                                                                                        <option>2 </option>
                                                                                        <option>1 </option>
                                                                                        <option>2 </option>
                                                                                        <option>3 </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <a href="page-contact.html" class="theme-btn btn-style-one">
                                                                                <span class="btn-title">CHECK <br />AVAILABILITY</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
    <!-- End Form Section -->

    <!-- Service Section three -->
    <section class="service-section-three">
        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="sub-title">Những gì chúng tôi cung cấp</span>
                <h2>Nhận ưu đãi đặc biệt của chúng tôi</h2>
            </div>
            <div class="outer-box">
                <div class="row">
                    <!-- service-block -->
                    <div class="service-block-three col-lg-4 col-md-6 wow fadeInUp">
                        <div class="inner-box">
                            <figure class="image">
                                <img src="{{ asset('client/images/resource/service1-1.jpg') }}" alt="">
                            </figure>
                            <div class="content-box">
                                <h6 class="title"><a href="{{ route('room.indexRoom') }}">Phòng gia đình</a></h6>
                            </div>
                        </div>
                    </div>
                    <!-- service-block -->
                    <div class="service-block-three col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                        <div class="inner-box">
                            <figure class="image">
                                <img src="{{ asset('client/images/resource/service1-2.jpg') }}" alt="">
                            </figure>
                            <div class="content-box">
                                <h6 class="title"><a href="{{ route('room.indexRoom') }}">Phòng giường đôi</a></h6>
                            </div>
                        </div>
                    </div>
                    <!-- service-block -->
                    <div class="service-block-three col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                        <div class="inner-box">
                            <figure class="image">
                                <img src="{{ asset('client/images/resource/service1-3.jpg') }}" alt="">
                            </figure>
                            <div class="content-box">
                                <h6 class="title"><a href="{{ route('room.indexRoom') }}">Phòng Vip</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Service section -->

    <!-- About Section -->
    <section class="about-section-two pt-0">
        <div class="anim-icons">
            <img class="image-1" src="{{ asset('client/images/icons/icon-home1.png') }}" alt="">
        </div>
        <div class="auto-container">
            <div class="row">
                <!-- Content Column -->
                <div class="content-column col-lg-7 wow fadeInRight" data-wow-delay="600ms">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title style-three">Khách Sạn sang trọng</span>
                            <h2>Chúng tôi cung cấp các dịch<br />vụ và các sự kiện</h2>
                            <div class="text">Cimora chúng tôi có quang cảnh tuyệt đẹp, bờ biển,
                                đồ ăn tuyệt vời và nhiều lần được bình chọn là thành phố hạnh phúc nhất,
                                khỏe mạnh nhất và phù hợp nhất tại Việt Nam.</div>
                        </div>
                        <div class="outer-box">
                            <div class="info-block">
                                <div class="inner">
                                    <div class="icon-box"><i class="fas fa-spa"></i></div>
                                    <h4 class="title">Dịch Vụ <br />Spa</h4>
                                </div>
                            </div>
                            <div class="info-block">
                                <div class="inner">
                                    <div class="icon-box"><i class="fas fa-utensils"></i></div>
                                    <h4 class="title">Đồ ăn <br />Hảo Hạng</h4>
                                </div>
                            </div>
                        </div>
                        <ul class="list-style-two">
                            <li><i class="icon fa fa-circle-check"></i> Không gian nghỉ dưỡng tiện nghi, hiện đại bậc nhất.
                            </li>
                            <li><i class="icon fa fa-circle-check"></i>Dịch vụ chu đáo, tận tâm như ở chính ngôi nhà của
                                bạn.</li>
                            <li><i class="icon fa fa-circle-check"></i>Trải nghiệm thư giãn tuyệt vời trong từng khoảnh
                                khắc.</li>
                        </ul>
                        <div class="btn-box">
                            <a href="{{ route('booking.tour.suggest') }}" class="theme-btn btn-style-one"><span class="btn-title">Đặt Phòng Ngay 
                                </span></a>
                        </div>
                    </div>
                </div>
                <!-- Image Column -->
                <div class="image-column col-md-7 col-lg-5">
                    <div class="inner-column wow fadeInLeft">
                        <figure class="image-1 overlay-anim wow reveal-right"><img
                                src="{{ asset('client/images/resource/about2-1.jpg') }}" alt=""></figure>
                        <figure class="image-2 overlay-anim wow reveal-right"><img
                                src="{{ asset('client/images/resource/about2-2.jpg') }}" alt=""></figure>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--Emd About Section -->

    <!-- Room-section two -->
<section class="room-service-section pt-120 pb-60">
    <div class="auto-container">
        <div class="sec-title text-center">
            <span class="sub-title">DỊCH VỤ KHÁCH HÀNG</span>
            <h2>Đặt phòng và <br />thư giãn trong sự sang trọng</h2>
        </div>
        <div class="row">

            @foreach ($groupedRoomTypes as $type => $roomTypes)
                <div class="room-type-section mb-5">
                    <h3 class="room-type-title mb-4">{{ $type }}</h3>
                    <div class="row">
                        @foreach ($roomTypes as $roomType)
                            @foreach ($roomType->rooms->take(2) as $room)
                                <div class="room-block col-lg-6 col-md-6">
                                    <div class="inner-box wow fadeIn">
                                        <div class="image-box">
                                            @php
                                                $image = $room->images_room->first()?->image_path
                                                    ? asset('storage/' . $room->images_room->first()->image_path)
                                                    : asset('client/images/no-image.png');
                                                $bed = $roomType->bed_type ?? 'Không rõ';
                                                $roomDetailUrl = route('room_type.detail', $roomType->id);
                                            @endphp
                                            <a href="{{ $roomDetailUrl }}">
                                                <img src="{{ $image }}" alt="Room Image">
                                            </a>
                                        </div>

                                        <div class="content-box">
                                            <h6 class="title">{{ $roomType->name }}</h6>
                                            <span class="price">{{ number_format($roomType->room_type_price, 0, ',', '.') }} VND / đêm</span>
                                            <span class="price"><i class="fal fa-bed me-2"></i>{{ $bed }}</span>
                                        </div>

                                        <div class="box-caption">
                                            <a href="{{ $roomDetailUrl }}" class="book-btn">Đặt phòng</a>
                                            <ul class="bx-links">
                                                @foreach (collect($roomType->amenities ?? [])->take(4) as $amenityId)
                                                    @if ($allAmenities->has($amenityId))
                                                        <li>{{ $allAmenities[$amenityId]->name }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>



    <!-- End Room section -->

    <!-- Đánh giá -->
    <section class="testimonial-section-two pt-0">
        <div class="anim-icons">
            <img class="image-1" src="{{ asset('client/images/icons/shape-5.png') }}" alt="">
        </div>
        <div class="auto-container">
            <div class="row">
                <div class="testimonials overflow-hidden col-lg-12">
                    <!-- Testimonial Slider -->
                    <div class="swiper-container testimonial-slider-content">
                        <div class="swiper-wrapper">
                            <!-- Testimonial Block -->
                            <div class="testimonial-block-two swiper-slide">
                                <div class="inner-box">
                                    <div class="quote-icon"><img class="icon-img"
                                            src="{{ asset('client/images/icons/testi-shape1.png') }}" alt="">
                                    </div>
                                    <div class="text">Nghỉ tại Hoteler là một trải nghiệm khó quên.
                                        Nhân viên đã nỗ lực hết mình để đảm bảo sự thoải mái và hài lòng của chúng tôi.
                                        Phòng
                                        sạch sẽ, với tầm nhìn ngoạn mục </div>
                                    <div class="info-box">
                                        <h5 class="name">Jenny Wilson</h5>
                                        <span class="designation">Business Owner</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Testimonial Block -->
                            <div class="testimonial-block-two swiper-slide">
                                <div class="inner-box">
                                    <div class="quote-icon"><img class="icon-img"
                                            src="{{ asset('client/images/icons/testi-shape1.png') }}" alt="">
                                    </div>
                                    <div class="text">Nghỉ tại Hoteler là một trải nghiệm khó quên.
                                        Nhân viên đã nỗ lực hết mình để đảm bảo sự thoải mái và hài lòng của chúng tôi.
                                        Phòng
                                        sạch sẽ, với tầm nhìn ngoạn mục </div>
                                    <div class="info-box">
                                        <h5 class="name">Marvin McKinney</h5>
                                        <span class="designation">President of Sales</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Testimonial Block -->
                            <div class="testimonial-block-two swiper-slide">
                                <div class="inner-box">
                                    <div class="quote-icon"><img class="icon-img"
                                            src="{{ asset('client/images/icons/testi-shape1.png') }}" alt="">
                                    </div>
                                    <div class="text">Nghỉ tại Hoteler là một trải nghiệm khó quên.
                                        Nhân viên đã nỗ lực hết mình để đảm bảo sự thoải mái và hài lòng của chúng tôi.
                                        Phòng
                                        sạch sẽ, với tầm nhìn ngoạn mục </div>
                                    <div class="info-box">
                                        <h5 class="name">Jenny Wilson</h5>
                                        <span class="designation">Business Owner</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <!-- Testimonial Thumb -->
                    <div class="swiper-container testimonial-thumbs mx-auto">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="{{ asset('client/images/resource/testi2-thumb1.png') }}"
                                    alt="" />
                            </div>
                            <div class="swiper-slide"><img src="{{ asset('client/images/resource/testi2-thumb2.png') }}"
                                    alt="" />
                            </div>
                            <div class="swiper-slide"><img src="{{ asset('client/images/resource/testi2-thumb3.png') }}"
                                    alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- pricing-section -->
    <section class="pricing-section">
        <div class="auto-container">
            <div class="sec-title text-center wow fadeInUp">
                <span class="sub-title">THỰC ĐƠN KHÁCH SẠN</span>
                <h2>Thực phẩm đặc sản độc đáo</h2>
            </div>
            <div class="row gx-xl-5 wow slideInUp">
                <!-- pricing-block -->
                <div class="pricing-block-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <figure class="thumb overlay-anim"><a href="page-pricing.html"><img
                                    src="{{ asset('client/images/resource/pricing2-1.png') }}" alt=""></a>
                        </figure>
                        <div class="content-box">
                            <h6 class="title">Pasta With Fish<span>$39</span></h6>
                            <span class="designation">Lorem Ipsum is that it smt</span>
                        </div>
                        <span class="food-pack">starter</span>
                    </div>
                </div>
                <!-- pricing-block -->
                <div class="pricing-block-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <figure class="thumb overlay-anim"><a href="page-pricing.html"><img
                                    src="{{ asset('client/images/resource/pricing2-2.png') }}" alt=""></a>
                        </figure>
                        <div class="content-box">
                            <h6 class="title">Noodles<span>$16</span></h6>
                            <span class="designation">Lorem Ipsum is that it smt</span>
                        </div>
                        <span class="food-pack">new</span>
                    </div>
                </div>
                <!-- pricing-block -->
                <div class="pricing-block-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <figure class="thumb overlay-anim"><a href="page-pricing.html"><img
                                    src="{{ asset('client/images/resource/pricing2-3.png') }}" alt=""></a>
                        </figure>
                        <div class="content-box">
                            <h6 class="title">Fresh Meat<span>$26</span></h6>
                            <span class="designation">Lorem Ipsum is that it smt</span>
                        </div>
                        <span class="food-pack">new</span>
                    </div>
                </div>
                <!-- pricing-block -->
                <div class="pricing-block-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <figure class="thumb overlay-anim"><a href="page-pricing.html"><img
                                    src="{{ asset('client/images/resource/pricing2-4.png') }}" alt=""></a>
                        </figure>
                        <div class="content-box">
                            <h6 class="title">Chicken<span>$19</span></h6>
                            <span class="designation">Lorem Ipsum is that it smt</span>
                        </div>
                        <span class="food-pack">vegan</span>
                    </div>
                </div>
                <!-- pricing-block -->
                <div class="pricing-block-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <figure class="thumb overlay-anim"><a href="page-pricing.html"><img
                                    src="{{ asset('client/images/resource/pricing2-5.png') }}" alt=""></a>
                        </figure>
                        <div class="content-box">
                            <h6 class="title">Spaghetti<span>$37</span></h6>
                            <span class="designation">Lorem Ipsum is that it smt</span>
                        </div>
                        <span class="food-pack">new</span>
                    </div>
                </div>
                <!-- pricing-block -->
                <div class="pricing-block-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <figure class="thumb overlay-anim"><a href="page-pricing.html"><img
                                    src="{{ asset('client/images/resource/pricing2-6.png') }}" alt=""></a>
                        </figure>
                        <div class="content-box">
                            <h6 class="title">Vegetarian Fried<span>$34</span></h6>
                            <span class="designation">Lorem Ipsum is that it smt</span>
                        </div>
                        <span class="food-pack">new</span>
                    </div>
                </div>
                <!-- pricing-block -->
                <div class="pricing-block-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <figure class="thumb overlay-anim"><a href="page-pricing.html"><img
                                    src="{{ asset('client/images/resource/pricing2-7.png') }}" alt=""></a>
                        </figure>
                        <div class="content-box">
                            <h6 class="title">Vegetarian Soup<span>$42</span></h6>
                            <span class="designation">Lorem Ipsum is that it smt</span>
                        </div>
                        <span class="food-pack">glutan free</span>
                    </div>
                </div>
                <!-- pricing-block -->
                <div class="pricing-block-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <figure class="thumb overlay-anim"><a href="page-pricing.html"><img
                                    src="{{ asset('client/images/resource/pricing2-8.png') }}" alt=""></a>
                        </figure>
                        <div class="content-box">
                            <h6 class="title">Salmon Pasta<span>$71</span></h6>
                            <span class="designation">Lorem Ipsum is that it smt</span>
                        </div>
                        <span class="food-pack">fish</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End pricing-section -->

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="bg bg-image wow reveal-top tm-gsap-img-parallax overflow-hidden">
            <img src="{{ asset('client/images/background/bg-contact5.jpg') }}" alt="Image">
        </div>
        <div class="icon icon-contact-shape1"
            style="background-image: url({{ asset('client/images/icons/shape-4.png') }})"></div>
        <div class="auto-container">
            <div class="outer-box">
                <div class="row">

                    <!-- Form Column -->
                    <div class="form-column col-lg-8 offset-lg-4 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <!-- Contact Form -->
                            <div class="contact-form wow fadeInLeft">
                                <div class="icon-anchor-1 bounce-y"></div>
                                <div class="sec-title">
                                    <span class="sub-title style-three">LIÊN HỆ VỚI CHÚNG TÔI</span>
                                    <h2>Liên hệ</h2>
                                </div>

                                <!--Contact Form-->
                                <form method="post" action="https://html.kodesolution.com/2025/hoteler-html/get"
                                    id="contact-form">
                                    <div class="row">

                                        <div class="form-group col-lg-6 col-md-6">
                                            <input type="text" name="name" placeholder="Họ Tên" required>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6">
                                            <input type="email" name="email" placeholder="Địa Chỉ Email" required>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6">
                                            <input type="tex" name="phone" placeholder="Check In" required>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6">
                                            <input type="text" name="subject" placeholder="Check Out" required>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <textarea name="textarea" placeholder="Nội Dung" rows="2"></textarea>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <button type="submit" class="theme-btn btn-style-one bg-dark"
                                                name="submit-form"><span class="btn-title">Gửi Ngay</span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--End Contact Form -->

                            <div class="contact-block">
                                <div class="inner-box">
                                    <figure class="image icon-contact1"><img
                                            src="{{ asset('client/images/icons/icon-call-2.png') }}" alt="Image">
                                    </figure>
                                    <div class="content-box">
                                        <figure class="icon-img"><img
                                                src="{{ asset('client/images/icons/icon-call-1.png') }}" alt="">
                                        </figure>
                                        <span class="text">Hãy gọi cho chúng tôi</span>
                                        <a class="text-two" href="tel:+8801750050088">(801) 500 50 088</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->
@endsection
