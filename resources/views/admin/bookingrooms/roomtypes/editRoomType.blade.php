@extends('layouts.admin')
@section('title1', 'Chỉnh sửa loại phòng')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Chỉnh sửa loại phòng</h2>
    </header>
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-modern">
                <div class="card-body">
                    <form action="{{ route('room_types.update', $roomType->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên loại phòng</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $roomType->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Tên loại (type)</label>
                            <input type="text" name="type" class="form-control" value="{{ old('type', $roomType->type) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="room_type_price" class="form-label">Giá mặc định</label>
                            <input type="number" name="room_type_price" class="form-control" value="{{ old('room_type_price', $roomType->room_type_price) }}" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh đại diện</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if ($roomType->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $roomType->image) }}" alt="{{ $roomType->name }}" width="100">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $roomType->description) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('room_types.index') }}" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
