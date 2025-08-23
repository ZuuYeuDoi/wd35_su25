@extends('layouts.admin')
@section('title1', 'Tạo đơn đặt phòng mới')

@section('content')
<section role="main" class="content-body content-body-modern mt-0">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📝 Tạo đơn đặt phòng mới</h4>
        </div>
        <div class="card-body p-4">
            <h5 class="mb-3 text-secondary">Thông tin khách vãng lai</h5>
            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tên khách hàng</label>
                        <input type="text" name="guest_name" class="form-control rounded-2" placeholder="Nguyễn Văn A" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Số điện thoại</label>
                        <input type="text" name="guest_phone" class="form-control rounded-2" placeholder="090xxxxxxx" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày check-in</label>
                        <input type="date" name="check_in" class="form-control rounded-2" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày check-out</label>
                        <input type="date" name="check_out" class="form-control rounded-2" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Số người lớn</label>
                        <input type="number" name="adults" class="form-control rounded-2" min="1" value="1" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Số trẻ em</label>
                        <input type="number" name="children" class="form-control rounded-2" min="0" value="0">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Loại phòng</label>
                        <select name="room_type_id" class="form-select rounded-2" required>
                            <option value="">-- Chọn loại phòng --</option>
                            @foreach($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success rounded-2 shadow-sm">✅ Đặt phòng</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
