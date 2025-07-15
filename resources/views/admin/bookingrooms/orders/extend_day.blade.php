@extends('layouts.admin')

@section('title1', 'Gia hạn phòng')

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Gia hạn phòng cho Đơn #{{ $booking->id }}</h2>
    </header>

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('room_order.extend_day.handle', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Ngày trả cũ</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }}" readonly>
                    <input type="hidden" name="old_check_out_date" value="{{ $booking->check_out_date }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày trả mới</label>
                    <input type="date" class="form-control" name="new_check_out_date" min="{{ \Carbon\Carbon::parse($booking->check_out_date)->addDay()->format('Y-m-d') }}" required>
                    @error('new_check_out_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Gia hạn</button>
                <a href="{{ route('room_order.show', $booking->id) }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</section>
@endsection
