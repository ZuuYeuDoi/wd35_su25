@extends('client.index')

@push('css')
    <style>
        .tour-summary {
            background-color: #f8f5f0;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')

<section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
    <div class="auto-container">
        <div class="title-outer text-center">
            <h1 class="title">Tour gợi ý</h1>
            <ul class="page-breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Gợi ý tour</li>
            </ul>
        </div>
    </div>
</section>

<section class="rooms-section pb-100">
    <div class="auto-container">

        <div class="tour-summary mb-4">
            <p><strong>Thời gian:</strong> {{ $check_in }} → {{ $check_out }} ({{ $nights }} đêm)</p>
            <p><strong>Số khách:</strong> {{ $adults }} người lớn, {{ $children }} trẻ em</p>
        </div>

        <form action="{{ route('booking.tour.addToCart') }}" method="post">
            @csrf
            <input type="hidden" name="check_in" value="{{ $check_in }}">
            <input type="hidden" name="check_out" value="{{ $check_out }}">
            <input type="hidden" name="adults" value="{{ $adults }}">
            <input type="hidden" name="children" value="{{ $children }}">

            <div class="row">
                @forelse($combinations as $index => $combo)
                    <div class="room-block col-lg-6 col-md-6">
                        <div class="inner-box wow fadeIn">
                            <div class="image-box">
                                @php
                                    $roomType = $combo['room_type'];
                                    $image = $roomType->rooms->first()?->images_room->first()?->image_path
                                        ? asset('storage/' . $roomType->rooms->first()->images_room->first()->image_path)
                                        : asset('client/images/no-image.png');
                                @endphp
                                <a href="{{ route('room_type.detail', $roomType->id) }}">
                                    <img src="{{ $image }}" alt="Room Image">
                                </a>
                            </div>

                            <div class="content-box">
                                <h6 class="title">{{ $roomType->name }}</h6>
                                <span class="price">{{ number_format($roomType->room_type_price, 0, ',', '.') }} VND / đêm</span>
                                <span class="price"><i class="fal fa-bed me-2"></i>{{ $roomType->bed_type ?? 'Không rõ' }}</span>
                                <p class="mt-2">Số phòng đề xuất: {{ $combo['quantity'] }}</p>
                                <p>Tổng tạm tính: <strong>{{ number_format($combo['sub_total']) }} VND</strong></p>
                            </div>

                            <div class="box-caption">
                                <input type="hidden" name="rooms[{{ $index }}][room_type_id]" value="{{ $roomType->id }}">
                                <input type="hidden" name="rooms[{{ $index }}][qty]" value="{{ $combo['quantity'] }}">
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
                @empty
                    <p class="text-center">Không tìm thấy tour phù hợp.</p>
                @endforelse
            </div>

            @if(count($combinations))
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">Đặt tour ngay</button>
                </div>
            @endif
        </form>
    </div>
</section>

@endsection
