@extends('layouts.admin')
@section('title1', 'Tạo đơn đặt phòng mới')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h4>Thông tin khách vãng lai</h4>
    <form action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label>Tên khách hàng</label>
            <input type="text" name="guest_name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="guest_phone" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Ngày check-in</label>
            <input type="date" name="check_in" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Ngày check-out</label>
            <input type="date" name="check_out" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Số người lớn</label>
            <input type="number" name="adults" class="form-control" min="1" value="1" required>
        </div>

        <div class="form-group mb-3">
            <label>Số trẻ em</label>
            <input type="number" name="children" class="form-control" min="0" value="0">
        </div>

        <div class="form-group mb-3">
            <label>Loại phòng</label>
            <select name="room_type_id" class="form-select" required>
                <option value="">-- Chọn loại phòng --</option>
                @foreach($roomTypes as $roomType)
                    <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Đặt phòng</button>
    </form>
</div>
@endsection
