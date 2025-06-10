@extends('layouts.admin')
@section('title1', 'Sơ đồ phòng')
@section('content')
<section role="main" class="content-body">

    <header class="page-header">
        <h2 class="font-weight-bold text-6 mb-0">Sơ đồ phòng</h2>
    </header>

<!-- Search Bar with Enhanced Date Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

<div class="bg-white shadow rounded px-4 py-3 mb-4">
    <form action="{{ route('room.map') }}" method="GET">
        <div class="row g-2 align-items-center">
            <!-- Search type toggle -->
            <div class="col-auto">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="stay_type" id="overnight" value="overnight" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="overnight">Chỗ ở Qua Đêm</label>

                    <input type="radio" class="btn-check" name="stay_type" id="dayuse" value="dayuse" autocomplete="off">
                    <label class="btn btn-outline-primary" for="dayuse">Chỗ ở Trong Ngày</label>
                </div>
            </div>

            <!-- Date pickers -->
            <div class="col-md-auto">
                <input type="text" name="check_in" id="check_in" class="form-control" placeholder="Ngày nhận phòng">
            </div>
            <div class="col-md-auto" id="checkout_container">
                <input type="text" name="check_out" id="check_out" class="form-control" placeholder="Ngày trả phòng">
            </div>

            <!-- Guest picker dropdown -->
            <div class="col-md-auto position-relative">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <span id="guestSummary">2 người lớn, 1 trẻ em</span>
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 270px;">
                        <div class="mb-2">
                            <label>Phòng</label>
                            <div class="input-group">
                                <button class="btn btn-light" type="button" onclick="adjustGuest('rooms', -1)">-</button>
                                <input type="number" name="rooms" id="rooms" value="1" min="1" class="form-control text-center" readonly>
                                <button class="btn btn-light" type="button" onclick="adjustGuest('rooms', 1)">+</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Người lớn</label>
                            <div class="input-group">
                                <button class="btn btn-light" type="button" onclick="adjustGuest('adults', -1)">-</button>
                                <input type="number" name="adults" id="adults" value="2" min="1" class="form-control text-center" readonly>
                                <button class="btn btn-light" type="button" onclick="adjustGuest('adults', 1)">+</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Trẻ em</label>
                            <div class="input-group">
                                <button class="btn btn-light" type="button" onclick="adjustGuest('children', -1, true)">-</button>
                                <input type="number" name="children" id="children" value="1" min="0" class="form-control text-center" readonly>
                                <button class="btn btn-light" type="button" onclick="adjustGuest('children', 1, true)">+</button>
                            </div>
                            <small class="form-text text-muted mt-1">Nhập độ tuổi trẻ để xác định giá</small>
                            <div id="children-ages"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <div class="col-md-auto">
                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
            </div>
        </div>
    </form>
</div>


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
     function adjustGuest(field, delta, isChild = false) {
        const input = document.getElementById(field);
        let value = parseInt(input.value);
        value += delta;
        if (value < parseInt(input.min || 0)) value = parseInt(input.min || 0);
        input.value = value;
        updateGuestSummary();
        if (isChild) updateChildAgeInputs(value);
    }

    function updateGuestSummary() {
        const adults = document.getElementById('adults').value;
        const children = document.getElementById('children').value;
        document.getElementById('guestSummary').innerText = `${adults} người lớn, ${children} trẻ em`;
    }

    function updateChildAgeInputs(count) {
        const container = document.getElementById('children-ages');
        container.innerHTML = '';
        for (let i = 1; i <= count; i++) {
            const label = document.createElement('label');
            label.textContent = `Tuổi của Trẻ ${i}`;
            label.classList.add('mt-2');

            const select = document.createElement('select');
            select.name = 'children_ages[]';
            select.classList.add('form-select', 'mt-1');

            for (let age = 0; age <= 17; age++) {
                const option = document.createElement('option');
                option.value = age;
                option.textContent = `${age} tuổi`;
                select.appendChild(option);
            }

            container.appendChild(label);
            container.appendChild(select);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateGuestSummary();
        updateChildAgeInputs(parseInt(document.getElementById('children').value));

        // Toggle check-out input visibility
        document.getElementById('overnight').addEventListener('change', function () {
            document.getElementById('checkout_container').style.display = 'block';
        });
        document.getElementById('dayuse').addEventListener('change', function () {
            document.getElementById('checkout_container').style.display = 'none';
        });

        // Flatpickr for beautiful date picker
        flatpickr.localize(flatpickr.l10ns.vn);

        const checkIn = flatpickr("#check_in", {
            dateFormat: "d/m/Y",
            minDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length) {
                    checkOut.set('minDate', new Date(selectedDates[0].getTime() + 86400000));
                }
            }
        });

        const checkOut = flatpickr("#check_out", {
            dateFormat: "d/m/Y",
            minDate: new Date().fp_incr(1)
        });
    });
</script>
@endsection
