@extends('client.index')

@push('css')
<style>
    .tour-summary {
        background-color: #f8f5f0;
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 8px;
    }
    .room-block { margin-bottom: 30px; }
    .image-box img {
        width: 100%; height: 230px; object-fit: cover; border-radius: 8px;
    }
    .content-box .title { font-size: 18px; font-weight: bold; }
    .price { font-size: 14px; color: #555; display: block; }
    .box-caption { margin-top: 10px; }
    .bx-links { list-style: none; padding-left: 0; font-size: 13px; }
    .bx-links li::before { content: "✔ "; color: #d4a762; }
    .muted { color: #888; font-style: italic; }
    .badge-amenity { display: inline-block; padding: 2px 8px; border: 1px solid #eee; border-radius: 12px; margin: 2px 4px; font-size: 12px;}
    .title-divider { border-top: 1px solid #eee; margin: 24px 0; }
    .search-box {
        background: #ffffff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    .search-box label {
        font-weight: 500;
        font-size: 14px;
        color: #444;
        margin-bottom: 5px;
    }
    .search-box .form-control, 
    .search-box select {
        font-size: 14px;
        padding: 6px 10px;
        border-radius: 6px;
    }
    .search-box button {
        padding: 6px 16px;
        font-size: 14px;
        border-radius: 6px;
        white-space: nowrap;
    }
    .room-card {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #eee;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: transform 0.2s ease;
    }
    .room-card:hover {
        transform: translateY(-3px);
    }
    .room-card img {
        width: 100%;
        height: 300px;
        object-fit: cover;
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

        {{-- 1) Form lọc --}}
        <h4 class="mb-4">Tìm tour phù hợp</h4>
        <div class="alert alert-warning py-2 mb-3" style="font-size:14px;">
            <strong>Quy định:</strong> 
            - 1 trẻ em cần có tối thiểu 1 người lớn đi cùng. 
            - 1 người lớn đi cùng không quá 2 trẻ em. 
            - Mỗi tour tối đa 30 người.
        </div>

        <form action="{{ route('booking.tour.search') }}" method="get" class="row g-2 align-items-end" id="tourForm">
            <div class="col-auto">
                <label>Ngày nhận</label>
                <input type="date" name="check_in" id="checkInMain" class="form-control"
                    value="{{ old('check_in', $check_in ?? now()->addDay()->toDateString()) }}"
                    min="{{ now()->addDay()->toDateString() }}" required>
            </div>
            <div class="col-auto">
                <label>Ngày trả</label>
                <input type="date" name="check_out" id="checkOutMain" class="form-control"
                    value="{{ old('check_out', $check_out ?? now()->addDays(2)->toDateString()) }}"
                    min="{{ old('check_in', $check_in ?? now()->addDay()->toDateString()) }}" required>
            </div>
            <div class="col-auto">
                <label>Hạng phòng</label>
                <select name="preferred_room_type" class="form-control" required>
                    <option value="">-- Chọn --</option>
                    @foreach($roomTypes as $rt)
                        <option value="{{ $rt->type }}" {{ isset($preferred) && $preferred && $preferred->type === $rt->type ? 'selected' : '' }}>
                            {{ $rt->type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label>Người lớn</label>
                <input type="number" name="adults" id="adultsInput" min="1" value="{{ old('adults', $adults ?? 1) }}" class="form-control" required>
            </div>
            <div class="col-auto">
                <label>Trẻ em</label>
                <input type="number" name="children" id="childrenInput" min="0" value="{{ old('children', $children ?? 0) }}" class="form-control" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Tìm tour</button>
            </div>
        </form>

        {{-- 2) Phần tour gợi ý (chỉ hiện khi có $combinations) --}}
@if(!empty($combinations))
    <div class="tour-summary mt-5">
        <p><strong>Thời gian:</strong> {{ $check_in }} → {{ $check_out }} ({{ $nights }} đêm)</p>
        <p><strong>Số khách:</strong> {{ $adults }} người lớn, {{ $children }} trẻ em</p>
        <p><strong>Hạng phòng mong muốn:</strong> {{ $preferred?->type }}</p>
    </div>

    <form action="{{ route('booking.tour.addToCart') }}" method="post" class="mb-5">
        @csrf
        <input type="hidden" name="check_in" value="{{ $check_in }}">
        <input type="hidden" name="check_out" value="{{ $check_out }}">
        <input type="hidden" name="adults" value="{{ $adults }}">
        <input type="hidden" name="children" value="{{ $children }}">

        <div class="row g-3">
    @foreach($combinations as $index => $combo)
        @php
            $roomType = $combo['room_type'];
            $firstRoom  = $roomType->rooms->first();
            $firstImage = $firstRoom?->images_room->first()?->image_path;
            $image = $firstImage ? asset('storage/'.$firstImage) : asset('client/images/no-image.png');
            $availableCnt = $combo['available_cnt'] ?? 0;
        @endphp
        <div class="col-md-4 col-sm-6 col-12">
            <div class="room-card p-3 h-100">
                <img src="{{ $image }}" class="img-fluid rounded mb-2" alt="Room Image">
                <h6 class="mb-1">{{ $roomType->name }}</h6>
                <span class="d-block text-danger fw-bold">{{ number_format($roomType->room_type_price) }} VND / đêm</span>
                <span class="d-block">Giường: {{ $roomType->bed_type ?? 'Không rõ' }}</span>
                <div class="mt-2">
                    Phòng trống: <strong>{{ $availableCnt }}</strong>
                </div>
                <div class="mb-2 mt-2">
                    <label class="me-2">Số phòng gợi ý:</label>
                    <input type="number"
                           name="rooms[{{ $index }}][qty]"
                           min="1"
                           max="{{ $availableCnt }}"
                           value="{{ $combo['rooms_needed'] }}"
                           class="form-control d-inline-block"
                           style="width:100px;">
                </div>
                <p class="mb-2">Tạm tính: <strong>{{ number_format($combo['sub_total']) }} VND</strong></p>
                <input type="hidden" name="rooms[{{ $index }}][room_type_id]" value="{{ $roomType->id }}">
                <div>
                    @foreach ($roomType->amenities ?? [] as $amenityId)
                        @if (!empty($allAmenities[$amenityId]))
                            <span class="badge bg-light text-dark me-1">{{ $allAmenities[$amenityId]->name }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>



        @if(count($combinations))
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">Thêm toàn bộ gợi ý vào giỏ</button>
            </div>
        @endif
    </form>
@endif

<hr class="title-divider">

{{-- 3) Danh sách tất cả loại phòng --}}
<h4 class="mb-3">Tất cả loại phòng</h4>
<p class="muted mb-3">
    @if(!empty($check_in) && !empty($check_out))
        Phòng trống được tính theo khoảng: <strong>{{ $check_in }}</strong> → <strong>{{ $check_out }}</strong>.
    @else
        Hãy nhập ngày nhận/trả phòng để xem số phòng còn trống.
    @endif
</p>

<div class="row g-3">
    @foreach($roomTypesList as $rt)
        <div class="col-md-6">
            <div class="room-card p-3 h-100">
                <img src="{{ $rt['image_url'] }}" class="img-fluid rounded mb-2" alt="{{ $rt['name'] }}">
                <h6 class="mb-1">{{ $rt['name'] }}</h6>
                <span class="d-block text-danger fw-bold">{{ number_format($rt['price'] ?? 0) }} VND / đêm</span>
                <span class="d-block">Giường: {{ $rt['bed_type'] ?? 'Không rõ' }}</span>

                <div class="mt-2">
                    @if(isset($rt['available_count']))
                        <span>Phòng trống: <strong>{{ $rt['available_count'] }}</strong></span>
                    @else
                        <span class="text-muted">Phòng trống: —</span>
                    @endif
                </div>

                {{-- Form thêm vào tour --}}
                <form action="{{ route('booking.tour.addToCart') }}" method="post" class="mt-3">
                    @csrf
                    <input type="hidden" name="check_in" value="{{ $check_in }}">
                    <input type="hidden" name="check_out" value="{{ $check_out }}">
                    <input type="hidden" name="adults" value="{{ $adults ?? 1 }}">
                    <input type="hidden" name="children" value="{{ $children ?? 0 }}">
                    <input type="hidden" name="rooms[0][room_type_id]" value="{{ $rt['id'] }}">

                    <div class="d-flex gap-2 align-items-center">
                        <label class="me-2">Số phòng:</label>
                        <input type="number" name="rooms[0][qty]" class="form-control form-control-sm"
                               style="max-width: 70px"
                               min="1"
                               @if(isset($rt['available_count'])) max="{{ max(1, $rt['available_count']) }}" @endif
                               value="1">
                        <button type="submit" class="btn btn-outline-success btn-sm"
                                @if(empty($check_in) || empty($check_out)) disabled @endif>
                            Thêm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>

    </div>
</section>

@endsection

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const checkInMain = document.getElementById("checkInMain");
    const checkOutMain = document.getElementById("checkOutMain");

    // --- Khi đổi ngày check-in thì update check-out ---
    checkInMain.addEventListener("change", function () {
        let checkInDate = new Date(this.value);
        if (!isNaN(checkInDate)) {
            let minCheckout = new Date(checkInDate);
            minCheckout.setDate(minCheckout.getDate() + 1);
            let minCheckoutStr = minCheckout.toISOString().split("T")[0];

            checkOutMain.min = minCheckoutStr;
            if (checkOutMain.value <= this.value) {
                checkOutMain.value = minCheckoutStr;
            }
        }
        syncDatesToOtherForms();
    });

    // --- Khi đổi ngày check-out thì sync sang form khác ---
    checkOutMain.addEventListener("change", syncDatesToOtherForms);

    // --- Hàm đồng bộ ngày cho tất cả form thêm phòng ---
    function syncDatesToOtherForms() {
        const checkInVal = checkInMain.value;
        const checkOutVal = checkOutMain.value;

        document.querySelectorAll("form input[name='check_in']").forEach(el => el.value = checkInVal);
        document.querySelectorAll("form input[name='check_out']").forEach(el => el.value = checkOutVal);
    }

    // --- Validate số khách ---
    document.getElementById('tourForm').addEventListener('submit', function(e) {
        let adults = parseInt(document.getElementById('adultsInput').value) || 0;
        let children = parseInt(document.getElementById('childrenInput').value) || 0;
        let total = adults + children;

        if (children > 0 && adults < 1) {
            alert("Phải có ít nhất 1 người lớn đi cùng trẻ em.");
            e.preventDefault();
            return false;
        }
        if (children > adults * 2) {
            alert("Mỗi người lớn chỉ được đi kèm tối đa 2 trẻ em.");
            e.preventDefault();
            return false;
        }
        if (total > 30) {
            alert("Tổng số khách tối đa là 30 người.");
            e.preventDefault();
            return false;
        }
    });

    // --- Đồng bộ ngay khi load ---
    syncDatesToOtherForms();
});
</script>
@endpush
