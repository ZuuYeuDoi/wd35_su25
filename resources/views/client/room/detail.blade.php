@extends('client.index')
@push('css')
    <style>
        .room-image-gallery .thumbnail-list img:hover {
            border: 2px solid #007bff;
        }

        /* Gallery phòng */
        .room-image-gallery {
            margin-bottom: 30px;
        }

        /* Ảnh lớn */
        .room-image-gallery .main-image-container {
            text-align: center;
        }

        .room-image-gallery .main-image-container img {
            width: 100%;
            max-width: 800px;
            height: 500px;
            object-fit: scale-down;
            border-radius: 8px;
            /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
        }

        /* Danh sách ảnh nhỏ */
        .room-image-gallery .thumbnail-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 10px;
            margin-top: 15px;
        }

        .room-image-gallery .thumbnail-list img {
            width: 100px;
            height: 70px;
            object-fit: scale-down;
            border-radius: 4px;
            border: 2px solid #ccc;
            cursor: pointer;
            transition: border 0.3s ease;
        }

        .room-image-gallery .thumbnail-list img:hover {
            border: 2px solid #007bff;
        }

        .sidebar__post {
            padding: 16px !important;
        }

        .time-checkin {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
    </style>
@endpush
@section('content')
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">{{ $room->title }}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li>Chi tiết phòng</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="blog-details pt-120 pb-120">
        <div class="container">
            <div class="row">
                <!-- LEFT: Thông tin chi tiết -->
                <div class="col-xl-8 col-lg-7 product-details rd-page">
                    <!-- Hình ảnh -->
                    <div class="room-image-gallery">
                        @if ($room->images_room->isNotEmpty())
                            <div class="main-image-container text-center mb-3">
                                <a id="main-link" href="{{ asset('storage/' . $room->images_room->first()->image_path) }}"
                                    data-fancybox="gallery">
                                    <img id="main-image"
                                        src="{{ asset('storage/' . $room->images_room->first()->image_path) }}"
                                        alt="Ảnh chính">
                                </a>
                            </div>

                            <div class="thumbnail-list">
                                @foreach ($room->images_room as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}')"
                                        alt="Ảnh nhỏ"
                                        style="width: 100px; height: 70px; object-fit: scale-down; border: 2px solid #ccc; border-radius: 4px; cursor: pointer; transition: border 0.3s;">
                                @endforeach
                            </div>
                        @endif
                    </div>



                    <!-- Mô tả và thông tin -->
                    <div class="room-details__left">
                        <div class="wrapper">


                            <div class="row justify-content-center mb-2">
                                <div class="col-xl-12">
                                    <div class="room-details__content-right mb-40">
                                        <div class="room-details__details-box">
                                            <div class="row">
                                                <div class="col-6 col-md-3">
                                                    <p class="text mb-0">Tên phòng</p>
                                                    <h6>{{ $room->title }}</h6>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <p class="text mb-0">Loại phòng</p>
                                                    <h6>{{ $room->roomType->name }}</h6>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <p class="text mb-0">Giá</p>
                                                    <h6>{{ number_format($room->price, 0, ',', '.') }} VND</h6>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <p class="text mb-0">Loại giường</p>
                                                    @php
                                                        $bed = match ($room->max_people) {
                                                            1 => '1 giường đơn',
                                                            2 => '2 giường đơn',
                                                            3 => '1 giường đôi',
                                                            4 => '1 giường đôi + 1 giường đơn',
                                                            default => 'Không rõ',
                                                        };
                                                    @endphp

                                                    <h6>{{ $bed }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3>Mô tả phòng</h3>
                            <div class="text">{!! $room->description ?? 'Không có mô tả' !!}</div>
                        </div>

                        <!-- Tiện nghi -->
                        <div class="mt-40">
                            <h4>Tiện nghi phòng</h4>
                            <div class="row room-facility-list mb-40">
                                @forelse ($allAmenities as $amenity)
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="list-one d-flex align-items-center me-sm-4 mb-3">
                                            <div class="me-3">
                                                <img src="{{ asset('storage/' . $amenity->image) }}"
                                                    alt="{{ $amenity->name }}"
                                                    style="width: 40px; height: 40px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); object-fit: cover;">
                                            </div>
                                            <h6 class="title m-0">{{ $amenity->name }}</h6>
                                        </div>
                                    </div>
                                @empty
                                    <p><em>Không có tiện ích</em></p>
                                @endforelse
                            </div>
                        </div>
                        <div class="d-sm-flex align-items-sm-center justify-content-sm-between pt-40 pb-40 border-top">
                            <h6 class="my-sm-0">Bình Luận</h6>

                        </div>
                        <div class="p-4 p-lg-5 bg-light">
                            <h4 class="mt-0">Gửi câu hỏi của bạn cho chúng tôi</h4>
                            <form id="contact_form" name="contact_form" class=""
                                action="https://html.kodesolution.com/2025/hoteler-html/includes/sendmail.php"
                                method="post">
                                <div class="row">
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb-3">
                                            <input name="form_name" class="form-control bg-white" type="text"
                                                placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb-3">
                                            <input name="form_email" class="form-control bg-white required email"
                                                type="email" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <input name="form_phone" class="form-control bg-white required phone"
                                                type="number" placeholder="Enter Phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <textarea name="form_message" class="form-control bg-white required" rows="5" placeholder="Enter Message"></textarea>
                                </div>
                                <div class="mb-0">
                                    <input name="form_botcheck" class="form-control" type="hidden" value="">
                                    <button type="submit" class="theme-btn btn-style-one"
                                        data-loading-text="Please wait..."><span class="btn-title">Gửi bình
                                            luận</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar">
                        <div class="sidebar__post ">
                            <form id="contact_form2" name="contact_form" action="{{ route('booking.index') }}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <div class="time-checkin mb-3">
                                        <i class="bi bi-alarm" style="margin-right: 5px;"></i>
                                        Check-in: 14:00PM | Check-out: 12:00PM
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Check-in</label>
                                            <input id="checkin" name="checkin_date" type="date"
                                                class="form-control bg-white" value="{{ old('checkin_date') }}">
                                            @error('checkin_date')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Check-out</label>
                                            <input id="checkout" name="checkout_date" type="date"
                                                class="form-control bg-white" value="{{ old('checkout_date') }}">
                                            @error('checkout_date')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="room_id" value="{{ $room->id }}">

                                <div class="mb-3">
                                    <button type="submit" class="theme-btn btn-style-one w-100"
                                        data-loading-text="Please wait...">
                                        <span class="btn-title">Đặt Ngay</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="sidebar__single sidebar__post">
                            <h3 class="sidebar__title">Phòng liên quan</h3>
                            <ul class="sidebar__post-list list-unstyled">
                                @forelse ($relatedRooms as $related)
                                    <li>
                                        <div class="sidebar__post-image">
                                            <img src="{{ asset('storage/' . ($related->images_room->first()->image_path ?? 'default.jpg')) }}"
                                                alt=""
                                                style="width: 100px; height: 80px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                        </div>
                                        <div class="sidebar__post-content">
                                            <h3>
                                                <span class="sidebar__post-content-meta">
                                                    <i class="fas fa-door-open"></i> {{ $related->roomType->name }}
                                                </span>
                                                <a href="{{ route('room.detail', $related->id) }}">
                                                    {{ number_format($related->price, 0, ',', '.') }} VND
                                                </a>
                                            </h3>
                                        </div>
                                    </li>
                                @empty
                                    <li><em>Không có phòng cùng loại</em></li>
                                @endforelse
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('js')
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('client/js/jquery-ui.js') }} "></script>
    <script src="{{ asset('client/js/bxslider.js') }}"></script>
    <script src="{{ asset('client/js/owl.js') }} "></script>
    <script src="{{ asset('client/js/script.js') }}"></script>
    <!-- form submit -->
    <script src="{{ asset('client/js/jquery.validate.min.js') }} "></script>
    <script src="{{ asset('client/js/jquery.form.min.js') }}"></script>
    <script>
        (function($) {
            $("#contact_form").validate({
                submitHandler: function(form) {
                    var form_btn = $(form).find('button[type="submit"]');
                    var form_result_div = '#form-result';
                    $(form_result_div).remove();
                    form_btn.before(
                        '<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>'
                    );
                    var form_btn_old_msg = form_btn.html();
                    form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
                    $(form).ajaxSubmit({
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 'true') {
                                $(form).find('.form-control').val('');
                            }
                            form_btn.prop('disabled', false).html(form_btn_old_msg);
                            $(form_result_div).html(data.message).fadeIn('slow');
                            setTimeout(function() {
                                $(form_result_div).fadeOut('slow')
                            }, 6000);
                        }
                    });
                }
            });
        })(jQuery);

        function changeMainImage(src) {
            document.getElementById('main-image').src = src;
            document.getElementById('main-link').href = src;
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            const todayStr = today.toISOString().split('T')[0];

            const checkinInput = document.getElementById('checkin');
            const checkoutInput = document.getElementById('checkout');

            // Set ngày tối thiểu cho check-in là hôm nay
            checkinInput.setAttribute('min', todayStr);

            // Khi chọn ngày check-in → set ngày check-out là ít nhất +1 ngày
            checkinInput.addEventListener('change', function() {
                const checkinDate = new Date(this.value);
                const checkoutMinDate = new Date(checkinDate);
                checkoutMinDate.setDate(checkinDate.getDate() + 1); // ngày hôm sau

                const checkoutMinStr = checkoutMinDate.toISOString().split('T')[0];
                checkoutInput.value = ''; // reset nếu người dùng chọn lại check-in
                checkoutInput.setAttribute('min', checkoutMinStr);
            });

            // Không cho chọn checkout trước hôm nay nếu chưa chọn checkin
            checkoutInput.setAttribute('min', todayStr);
        });
    </script>
@endpush
