@extends('client.index')

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
                <div class="bxslider">
                    @if ($room->images_room->isNotEmpty())
                        <div class="image-container">
                            <figure class="image-box">
                                <a href="{{ asset('storage/' . $room->images_room->first()->image_path) }}" class="lightbox-image" data-fancybox="gallery">
                                    <img src="{{ asset('storage/' . $room->images_room->first()->image_path) }}"
     alt=""
     style="width: 800px; height: 600px; object-fit: cover; border-radius: 8px;">

                                </a>
                            </figure>
                        </div>
                    @endif
                </div>

                <!-- Mô tả và thông tin -->
                <div class="room-details__left">
                    <div class="wrapper">
                        <h3>Mô tả phòng</h3>
                        <p class="text">{{ $room->description ?? 'Không có mô tả' }}</p>

                        <div class="row justify-content-center mt-4">
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
                                                <p class="text mb-0">Số người</p>
                                                <h6>{{ $room->max_people }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tiện nghi -->
                    <div class="mt-40">
                        <h4>Tiện nghi phòng</h4>
                        <div class="row room-facility-list mb-40">
                            @forelse ($allAmenities as $amenity)
                                <div class="col-sm-6 col-xl-4">
                                    <div class="list-one d-flex align-items-center me-sm-4 mb-3">
                                        <div class="me-3">
                                            <img src="{{ asset('storage/' . $amenity->image) }}" alt="{{ $amenity->name }}"
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
                                        data-loading-text="Please wait..."><span class="btn-title">Gửi bình luận</span></button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                    <div class="sidebar">
                        <div class="sidebar__post mb-30">
                            <form id="contact_form2" name="contact_form" class=""
                                action="https://html.kodesolution.com/2025/hoteler-html/includes/sendmail.php"
                                method="post">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Đăng ký vào</label>
                                            <input name="form_name" class="form-control bg-white" type="text"
                                                placeholder="Arrive Date">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Kiểm tra</label>
                                            <input name="form_name" class="form-control bg-white" type="text"
                                                placeholder="Departure Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input name="form_botcheck" class="form-control" type="hidden" value="">
                                    <button type="submit" class="theme-btn btn-style-one w-100"
                                        data-loading-text="Please wait..."><span class="btn-title">Đặt Ngay</span></button>
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
    </script>
@endpush
