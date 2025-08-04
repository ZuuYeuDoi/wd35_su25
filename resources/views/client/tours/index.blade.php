@extends('client.index')

@push('css')
    <style>
        .tour-summary {
            background-color: #f8f5f0;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .room-block {
            margin-bottom: 30px;
        }

        .image-box img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            border-radius: 8px;
        }

        .content-box .title {
            font-size: 18px;
            font-weight: bold;
        }

        .price {
            font-size: 14px;
            color: #555;
            display: block;
        }

        .box-caption {
            margin-top: 10px;
        }

        .bx-links {
            list-style: none;
            padding-left: 0;
            font-size: 13px;
        }

        .bx-links li::before {
            content: "✔ ";
            color: #d4a762;
        }
    </style>
@endpush

@section('content')

<section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
    <div class="auto-container">
        <div class="title-outer text-center">
            <h1 class="title">Gợi ý tour</h1>
            <ul class="page-breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Gợi ý tour</li>
            </ul>
        </div>
    </div>
</section>

<section class="rooms-section pb-100">
    <div class="auto-container">

        {{-- Form tìm kiếm --}}
        <h4 class="mb-4">Tìm tour phù hợp</h4>
        <form action="{{ route('booking.tour.search') }}" method="get" class="row">
            <div class="col-md-3 mb-3">
                <label>Ngày nhận phòng</label>
                <input type="date" name="check_in" class="form-control" value="{{ old('check_in', now()->toDateString()) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Ngày trả phòng</label>
                <input type="date" name="check_out" class="form-control" value="{{ old('check_out', now()->addDay()->toDateString()) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Hạng phòng mong muốn</label>
                <select name="preferred_room_type" class="form-control" required>
                    <option value="">-- Chọn hạng phòng --</option>
                    @foreach ($roomTypes->type as $Typ)
                        <option value="{{ $roomType->type }}">{{ $roomType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <label>Người lớn</label>
                <input type="number" name="adults" min="1" value="{{ old('adults', 1) }}" class="form-control" required>
            </div>
            <div class="col-md-2 mb-3">
                <label>Trẻ em</label>
                <input type="number" name="children" min="0" value="0" class="form-control" required>
            </div>
            <div class="col-md-1 mb-3 align-self-end">
                <button type="submit" class="btn btn-primary">Tìm tour</button>
            </div>
        </form>

        {{-- Kết quả gợi ý --}}
        @isset($combinations)
            <div class="tour-summary mt-5">
                <p><strong>Thời gian:</strong> {{ $check_in }} → {{ $check_out }} ({{ $nights }} đêm)</p>
                <p><strong>Số khách:</strong> {{ $adults }} người lớn, {{ $children }} trẻ em</p>
                <p><strong>Hạng phòng mong muốn:</strong> {{ $preferred->name }}</p>
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
                            <div class="inner-box">
                                <div class="image-box">
                                    @php
                                        $roomType = $combo['room_type'];
                                        $image = $roomType->rooms->first()?->images_room->first()?->image_path
                                            ? asset('storage/' . $roomType->rooms->first()->images_room->first()->image_path)
                                            : asset('client/images/no-image.png');
                                    @endphp
                                    <img src="{{ $image }}" alt="Room Image">
                                </div>

                                <div class="content-box mt-3">
                                    <h6 class="title">{{ $roomType->name }}</h6>
                                    <span class="price">{{ number_format($roomType->room_type_price) }} VND / đêm</span>
                                    <span class="price">Giường: {{ $roomType->bed_type ?? 'Không rõ' }}</span>
                                    <p class="mt-2">Số phòng đề xuất: <strong>{{ $combo['rooms_needed'] }}</strong></p>
                                    <p>Tạm tính: <strong>{{ number_format($combo['sub_total']) }} VND</strong></p>
                                </div>

                                <div class="box-caption">
                                    <input type="hidden" name="rooms[{{ $index }}][room_type_id]" value="{{ $roomType->id }}">
                                    <input type="hidden" name="rooms[{{ $index }}][qty]" value="{{ $combo['rooms_needed'] }}">
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
                        <div class="col-12 text-center mt-4">
                            <p>Không tìm thấy tour phù hợp.</p>
                        </div>
                    @endforelse
                </div>

                @if(count($combinations))
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success">Đặt tour ngay</button>
                    </div>
                @endif
            </form>
        @endisset
    </div>
</section>

@endsection
