@extends('layouts.admin')
@section('title1', 'Chỉnh sửa loại phòng')

@push('css')
    <style>
        .form-group+.form-group {
            padding: 0px !important;
            border: none;
        }
        .amenitie_room {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }
        .amenitie_card {
            position: relative;
            width: 120px;
        }
        .amenitie_card input[type="checkbox"] {
            display: none;
        }
        .amenitie_card label {
            display: block;
            cursor: pointer;
            border: 2px solid transparent;
            padding: 8px;
            border-radius: 8px;
            transition: 0.3s;
            text-align: center;
        }
        .amenitie_card label:hover {
            background-color: #f9f9f9;
        }
        .amenitie_card img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }
        .amenitie_title {
            margin-top: 6px;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .amenitie_card input[type="checkbox"]:checked+label {
            border-color: #007bff;
            background-color: #eaf4ff;
        }
        .invalid-feedback {
            display: block !important;
        }
    </style>
@endpush

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Chỉnh sửa loại phòng</h2>
    </header>
    <div class="col-lg-12">
        <div class="card card-modern">
            <div class="card-body">
                <form action="{{ route('room_types.update', $roomType->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tên loại phòng</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $roomType->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hạng phòng</label>
                                <input type="text" name="type" class="form-control" value="{{ old('type', $roomType->type) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Loại giường</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @php
                                        $bedTypes = [
                                            '1 giường đơn',
                                            '2 giường đơn',
                                            '1 giường đôi',
                                            '1 giường đôi + 1 giường đơn',
                                            '2 giường đôi',
                                        ];
                                    @endphp
                                    @foreach ($bedTypes as $bed)
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="bed_type"
                                                value="{{ $bed }}" id="bed_type_{{ $loop->index }}"
                                                {{ old('bed_type', $roomType->bed_type) === $bed ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bed_type_{{ $loop->index }}">{{ $bed }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('bed_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Giá mặc định</label>
                                <input type="number" name="room_type_price" class="form-control" value="{{ old('room_type_price', $roomType->room_type_price) }}" min="0" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Album ảnh (có thể chọn nhiều)</label>
                                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                            </div>

                            @if ($roomType->images->count())
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach ($roomType->images as $img)
                                        <div style="position:relative;">
                                            <img src="{{ asset('storage/' . $img->image_path) }}" width="100" height="70" style="object-fit:cover;">
                                            <form action="{{ route('room_types.image.delete', $img->id) }}" method="POST" onsubmit="return confirm('Xóa ảnh này?')" style="position:absolute;top:0;right:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">x</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description', $roomType->description) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5>Danh sách tiện ích</h5>
                            <div class="amenitie_room">
                                @foreach ($amenities as $item)
                                    <div class="amenitie_card">
                                        <input type="checkbox" id="amenity_{{ $item->id }}" name="amenities[]" value="{{ $item->id }}"
                                            {{ in_array($item->id, old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                        <label for="amenity_{{ $item->id }}">
                                            <div class="amenitie_img">
                                                <img src="{{ asset('storage/' . $item->image) }}" class="img-thumbnail">
                                            </div>
                                            <div class="amenitie_title text-truncate" title="{{ $item->name }}">
                                                {{ $item->name }}
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('amenities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                    <a href="{{ route('room_types.index') }}" class="btn btn-secondary mt-3">Quay lại</a>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
