@extends('layouts.admin')

@section('title1', 'Gia hạn giờ')

@section('content')
<section class="content-body">
    <h2 class="font-weight-bold">Gia hạn giờ cho Đơn #{{ $booking->id }}</h2>

    <form method="POST" action="{{ route('room_order.extend_hour.handle', $booking->id) }}">
        @csrf
        <div class="mb-3">
            <label>Chọn thời gian muốn gia hạn</label>
            <select name="extend_hour" class="form-control" required>
                <option value="2">+ 2 giờ (100.000đ)</option>
                <option value="4">+ 4 giờ (200.000đ)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Xác nhận gia hạn giờ</button>
        <a href="{{ route('room_order.show', $booking->id) }}" class="btn btn-secondary">Hủy</a>
    </form>
</section>
@endsection
