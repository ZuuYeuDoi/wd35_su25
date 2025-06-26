@extends('layouts.admin')
@section('title1', 'Thêm mới phòng')
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

        /* Hiệu ứng chọn */
        .amenitie_card input[type="checkbox"]:checked+label {
            border-color: #007bff;
            background-color: #eaf4ff;
        }
        .invalid-feedback {
            display: block !important;
        }
    </style>
@endpush
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomTypeSelect = document.getElementById('room_type_id');
        const priceInput = document.getElementById('price');
        const amenityCheckboxes = document.querySelectorAll('input[name="amenities[]"]');

        roomTypeSelect.addEventListener('change', function () {
            const selectedId = parseInt(this.value);
            const selectedRoomType = roomTypesData.find(rt => rt.id === selectedId);

            if (selectedRoomType) {
                // Gán giá phòng
                priceInput.value = selectedRoomType.room_type_price;

                // Reset tất cả tiện ích
                amenityCheckboxes.forEach(cb => cb.checked = false);

                // Check các tiện ích từ loại phòng
                if (selectedRoomType.amenities && Array.isArray(selectedRoomType.amenities)) {
                    selectedRoomType.amenities.forEach(id => {
                        const cb = document.querySelector(`input[name="amenities[]"][value="${id}"]`);
                        if (cb) cb.checked = true;
                    });
                }
            }
        });
    });
</script>
@section('script')

@endsection

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Thêm mới phòng</h2>
        </header>
        <div class="row">
            <div class="col">
                <div class="card card-modern">
                    <div class="card-body">
                        <form action="{{ route('room.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <h3>Thông tin phòng</h3>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="room_type_id" class="form-label">Loại phòng <span
                                                class="text-danger">*</span></label>
                                        <select name="room_type_id" id="room_type_id"
                                            class="form-select @error('room_type_id') is-invalid @enderror">
                                            <option value="">Chọn loại phòng</option>
                                            @foreach ($roomTypes as $roomType)
                                                <option value="{{ $roomType->id }}"
                                                    {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
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
                                            value="{{ old('title') }}">
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
                                                value="{{ old('price') }}">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label">Loại phòng <span class="text-danger">*</span></label>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="max_people" id="single" value="1" {{ old('max_people') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="single">Single Bedroom</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="max_people" id="twin" value="3" {{ old('max_people') == '3' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="twin">Twin Bedroom</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="max_people" id="double" value="3" {{ old('max_people') == '2' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="double">Double Bedroom</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="max_people" id="triple" value="4" {{ old('max_people') == '4' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="triple">Triple Bedroom</label>
                                        </div>

                                        @error('max_people')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="image_room" class="form-label">Hình ảnh phòng <span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="image_room[]" id="image_room"
                                            class="form-control @error('image_room') is-invalid @enderror" multiple>
                                        @error('image_room')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="description" class="form-label">Mô tả <span
                                                class="text-danger">*</span></label>
                                        <textarea name="description" id="description" rows="4"
                                            class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="status" class="form-label">Trạng thái <span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Hoạt động
                                            </option>
                                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không hoạt
                                                động</option>
                                        </select>
                                        @error('status')
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
                                            value="{{ $item->id }}">
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
                                @error('amenities')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Thêm mới
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
<script>
    const roomTypesData = @json($roomTypes);
</script>
