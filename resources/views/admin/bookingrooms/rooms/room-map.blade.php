@extends('layouts.admin')
@section('title1', 'Sơ đồ phòng')
@section('content')
<section role="main" class="content-body">

    <header class="page-header">
        <h2 class="font-weight-bold text-6 mb-0">Sơ đồ phòng</h2>
    </header>


    <form action="{{ route('room.map') }}" method="GET" class="bg-white shadow-sm rounded px-4 py-3 mt-4 mb-4 d-flex flex-wrap align-items-center gap-3 position-relative">


        <div class="d-flex flex-column">
            <label for="start_date" class="form-label small mb-1 text-muted">Nhận phòng</label>
            <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}" class="form-control border-0 fw-semibold">
        </div>


        <div class="d-flex flex-column">
            <label for="end_date" class="form-label small mb-1 text-muted">Trả phòng</label>
            <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}" class="form-control border-0 fw-semibold">
        </div>

        <div class="position-relative">
            <label class="form-label small mb-1 text-muted">Khách & phòng</label>
            <div class="form-control border-0 fw-semibold dropdown-toggle" id="guestToggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                <span id="guestSummary">2 người lớn, 1 phòng</span>
            </div>

            <div class="dropdown-menu p-3 shadow" aria-labelledby="guestToggle" style="min-width: 280px;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div><strong>Phòng</strong></div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="adjust('room', -1)">−</button>
                        <span id="roomCount">1</span>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="adjust('room', 1)">+</button>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div><strong>Người lớn</strong><br><small class="text-muted">18 tuổi trở lên</small></div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="adjust('adult', -1)">−</button>
                        <span id="adultCount">2</span>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="adjust('adult', 1)">+</button>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div><strong>Trẻ em</strong><br><small class="text-muted">0–17 tuổi</small></div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="adjust('child', -1)">−</button>
                        <span id="childCount">0</span>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="adjust('child', 1)">+</button>
                    </div>
                </div>

                {{-- Hidden inputs --}}
                <input type="hidden" name="room" id="roomInput" value="1">
                <input type="hidden" name="adult" id="adultInput" value="2">
                <input type="hidden" name="child" id="childInput" value="0">
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-semibold">
                Tìm kiếm
            </button>
        </div>
    </form>

    @php
        $groupedRooms = $rooms->groupBy(fn($room) => $room->roomType->name ?? 'Không xác định');
    @endphp

    @foreach($groupedRooms as $roomType => $roomList)
        <h4 class="mt-5 text-primary fw-semibold border-bottom pb-2">{{ $roomType }}</h4>
        <div class="row gx-3 gy-4">
            @foreach($roomList as $room)
                <div class="col-md-2">
                    <div class="card shadow-sm h-100 border-0" style="background-color: rgba(26, 218, 71, 0.85);">
                        <div class="card-body text-center p-3">
                            <h6 class="card-title fw-bold text-truncate">{{ $room->title }}</h6>
                            <div class=" small mb-2">{{ $room->roomType->name ?? 'Chưa xác định' }}</div>
                            <div class="mb-2">
                                <i class="fas fa-user fa-sm "></i>
                            </div>
                            <span class="badge rounded-pill bg-light text-success px-3 py-1 fw-semibold">
                                {{ $room->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

</section>

<script>
    function adjust(type, amount) {
        const countEl = document.getElementById(`${type}Count`);
        const inputEl = document.getElementById(`${type}Input`);
        let value = parseInt(countEl.innerText);
        value = Math.max(0, value + amount);
        countEl.innerText = value;
        inputEl.value = value;

        const adults = parseInt(document.getElementById('adultCount').innerText);
        const children = parseInt(document.getElementById('childCount').innerText);
        const rooms = parseInt(document.getElementById('roomCount').innerText);

        let summary = `${adults} người lớn`;
        if (children > 0) summary += `, ${children} trẻ em`;
        summary += `, ${rooms} phòng`;

        document.getElementById('guestSummary').innerText = summary;
    }
</script>
@endsection
