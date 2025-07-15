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
<!-- Start main-content -->
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
<!-- end main-content -->

<!-- rooms-section -->
<section class="rooms-section pb-100">
    <div class="auto-container">
        <div class="row">

          @foreach ($groupedRoomTypes as $type => $roomTypes)
    <h3 class="room-type-title">{{ $type }}</h3>
    <div class="row">
        @foreach ($roomTypes as $roomType)
            @php
                $room = $roomType->rooms->first();
            @endphp

            @if ($room)
                <div class="room-block col-lg-4 col-md-6">
                    <div class="inner-box">
                        <div class="image-box">
                            <a href="{{ route('room_type.detail', $roomType->id) }}">
                                <img src="{{ asset('storage/' . ($room->images_room->first()->image_path ?? 'default.jpg')) }}" alt="{{ $roomType->type }}">
                            </a>
                        </div>
                        <div class="content-box">
                            <h6 class="title">{{ $roomType->type }}</h6> {{-- Chỉ hiển thị tên loại phòng --}}
                            <span class="price">{{ number_format($room->price, 0, ',', '.') }} VND / đêm</span>
                            <span class="price"><i class="fal fa-bed me-2"></i>{{ $roomType->bed_type ?? 'Không rõ' }}</span>
                        </div>
                        <div class="box-caption">
                            <a href="{{ route('room_type.detail', ['id' => $roomType->id]) }}?room_id={{ $room->id }}" class="book-btn">Xem chi tiết</a>
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
            @endif
        @endforeach
    </div>
@endforeach


        </div>
    </div>
</section>
@endsection
