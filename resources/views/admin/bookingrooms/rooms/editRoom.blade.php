@extends('layouts.admin')
@section('title1', 'Chỉnh sửa phòng')
@push('css')
    <style>
        .form-group+.form-group {
            padding: 0px !important;
            border: none;
        }



        .img-thumbnail {
            height: 80px;
        }

        .img-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: scale-down;
        }

        .thumbnail-room {
            display: grid;
            gap: 5px;
            grid-template-columns: repeat(4, 120px);
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

        /* Hiệu ứng chọn */
        .amenitie_card input[type="checkbox"]:checked+label {
            border-color: #007bff;
            background-color: #eaf4ff;
        }
    </style>
@endpush

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Chỉnh sửa phòng</h2>
        </header>
        <div class="row">
            <div class="col">
                <div class="card card-modern">
                    <div class="card-body">
                        <form action="{{ route('room.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group mb-4">
                                        <label for="room_type_id" class="form-label">Loại phòng <span
                                                class="text-danger">*</span></label>
                                        <select name="room_type_id" id="room_type_id"
                                            class="form-select @error('room_type_id') is-invalid @enderror">
                                            <option value="">Chọn loại phòng</option>
                                            @foreach ($roomTypes as $roomType)
                                                <option value="{{ $roomType->id }}"
                                                    {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}>
                                                    {{ $roomType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('room_type_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="title" class="form-label">Tên phòng <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title', $room->title) }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="price" class="form-label">Giá phòng <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" name="price" id="price"
                                                class="form-control @error('price') is-invalid @enderror"
                                                value="{{ old('price', $room->price) }}">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="max_people" class="form-label">Số người tối đa <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="max_people" id="max_people"
                                            class="form-control @error('max_people') is-invalid @enderror"
                                            value="{{ old('max_people', $room->max_people) }}">
                                        @error('max_people')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="status" class="form-label">Trạng thái <span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                            <option value="1"
                                                {{ old('status', $room->status) == 1 ? 'selected' : '' }}>Hoạt động
                                            </option>
                                            <option value="0"
                                                {{ old('status', $room->status) == 0 ? 'selected' : '' }}>Không hoạt động
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-4  image-room">
                                        <div class="thumbnail-room">
                                            @foreach ($room->images_room as $value)
                                                <div class="img-thumbnail">
                                                    <img src="{{ asset('storage/' . $value->image_path) }}"
                                                        alt="Room Image" class="">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="">
                                            <label for="image_room" class="form-label">Hình ảnh phòng</label>
                                            <input type="file" name="image_room[]" id="image_room"
                                                class="form-control @error('image_room') is-invalid @enderror" multiple>
                                            @error('image_room')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="description" class="form-label">Mô tả <span
                                                class="text-danger">*</span></label>
                                        <textarea name="description" id="description" rows="4"
                                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $room->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                            </div>
                            <div class="row mt-4">
                                <h3>Danh sách tiện ích</h3>
                                @foreach ($amenities as $item)
                                    <div class="amenitie_card">
                                        <input type="checkbox" id="amenity_{{ $item->id }}" name="amenities[]"
                                            value="{{ $item->id }}"
                                            {{ is_array($room->amenities) && in_array($item->id, $room->amenities) ? 'checked' : '' }}>
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

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Cập nhật
                                    </button>
                                    <a href="{{ route('room.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
