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
            content: "✓ ";
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
    @if(count($rooms))
    @foreach($rooms as $room)
        {{-- Hiển thị thông tin phòng --}}
    @endforeach
@else
    <p>Không tìm thấy phòng phù hợp với yêu cầu của bạn.</p>
@endif


    <!-- rooms-section -->
    <section class="rooms-section pb-100">
        <div class="auto-container">
            <div class="row">
                @foreach ($rooms as $item)
                    <div class="room-block col-lg-6 col-md-6">
                        <div class="inner-box wow fadeIn">
                            <div class="image-box">
                                @php
                                    $image = $item->images_room->first();
                                @endphp
                                <a href="{{ route('room.detail', ['id' => $item->id]) }}">
                                    <img src="{{ $image ? asset('storage/' . $image->image_path) : asset('client/images/no-image.png') }}"
                                         alt="Room Image">
                                </a>
                            </div>

                            @php
                                $bed = match ($item->max_people) {
                                    1 => '1 giường đơn',
                                    2 => '2 giường đơn',
                                    3 => '1 giường đôi',
                                    4 => '1 giường đôi + 1 giường đơn',
                                    default => 'Không rõ',
                                };
                            @endphp

                            <div class="content-box">
                                <h6 class="title">
                                    <a href="{{ route('room.detail', ['id' => $item->id]) }}">{{ $item->title }}</a>
                                </h6>
                                <span class="price">{{ $item->roomType->name }}</span>
                                <span class="price">{{ number_format($item->price, 0, ',', '.') }} VND / đêm</span>
                                <span class="price"><i class="fal fa-bed me-2"></i>{{ $bed }}</span>
                            </div>

                            <div class="box-caption">
                                <a href="{{ route('room.detail', ['id' => $item->id]) }}" class="book-btn">Đặt phòng</a>
                                <ul class="bx-links">
                                    @if (!empty($item->amenities) && is_array($item->amenities))
                                        @foreach ($item->amenities as $amenityId)
                                            @if ($allAmenities->has($amenityId))
                                                <li>{{ $allAmenities[$amenityId]->name }}</li>
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
@endsection
