@extends('client.index')

@push('css')
<style>
    .room-block {
        margin-bottom: 30px;
    }

    .image-box img {
        width: 100%;
        height: 230px;
        object-fit: cover;
        border-radius: 8px;
    }

    .content-box {
        margin-top: 15px;
    }

    .content-box .title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .content-box .price {
        font-size: 14px;
        color: #555;
        display: inline-block;
        margin-right: 10px;
    }

    .box-caption {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .book-btn {
        background-color: #d4a762;
        color: white;
        padding: 6px 14px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 10px;
    }

    ul.bx-links {
        list-style: none;
        padding-left: 0;
        font-size: 13px;
        color: #555;
    }

    ul.bx-links li::before {
        content: "\2713 ";
        color: #d4a762;
    }
</style>
@endpush

@section('content')

<section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
    <div class="auto-container">
        <div class="title-outer text-center">
            <h1 class="title">Rooms</h1>
            <ul class="page-breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Rooms</li>
            </ul>
        </div>
    </div>
</section>

<section class="rooms-section pb-100">
    <div class="auto-container">
        <div class="row">
            @foreach ($groupedRoomTypes as $type => $roomTypes)
                <div class="room-type-section">
                    <h3 class="room-type-title">{{ $type }}</h3>
                    <div class="row">
                        @foreach ($roomTypes as $roomType)
                            <div class="room-block col-lg-6 col-md-6">
                                <div class="inner-box wow fadeIn">
                                    <div class="image-box">
                                        @php
                                            // Lấy ảnh đầu tiên từ album room_type
                                            if ($roomType->images->first()?->image_path) {
                                                $image = asset('storage/' . $roomType->images->first()->image_path);
                                            } else {
                                                $image = asset('client/images/no-image.png');
                                            }
                                            $bed = $roomType->bed_type ?? 'Không rõ';
                                            $roomTypeUrl = route('room_type.detail', $roomType->id);
                                        @endphp
                                        <a href="{{ $roomTypeUrl }}">
                                            <img src="{{ $image }}" alt="Room Type Image">
                                        </a>
                                    </div>

                                    <div class="content-box">
                                        <h6 class="title">{{ $roomType->name }}</h6>
                                        <span class="price">{{ number_format($roomType->room_type_price, 0, ',', '.') }} VND / đêm</span>
                                        <span class="price"><i class="fal fa-bed me-2"></i>{{ $bed }}</span>
                                    </div>

                                    <div class="box-caption">
                                        <a href="{{ $roomTypeUrl }}" class="book-btn">Đặt phòng</a>
                                        <ul class="bx-links">
                                            @foreach ($roomType->amenities ?? [] as $amenityId)
                                                @if ($allAmenities->has($amenityId))
                                                    <li>{{ $allAmenities[$amenityId]->name }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
