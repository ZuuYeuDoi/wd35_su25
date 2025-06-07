@extends('layouts.admin')
@section('title1', 'Cập nhập tiện ích')
@push('css')
    <style>
        .image {
            width: 80px;
            height: 80px;
        }

        .image img {
            width: 100%;
            height: 100%;
            object-fit: scale-down;
        }

        .input-img {
            display: flex;
            gap: 15px;
            align-items: flex-end;
        }
    </style>
@endpush

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Cập nhập tiện ích</h2>
        </header>
        <div class="row">
            <div class="col">
                <div class="card card-modern">
                    <div class="card-body">
                        <form action="{{ route('amenitie.update', $amenitie->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4 input-img">
                                        @if ($amenitie->image)
                                            <div class="image">
                                                <img src="{{ asset('storage/' . $amenitie->image) }}" class="img-thumbnail">
                                            </div>
                                        @endif
                                        <div class="">
                                            <label for="image" class="form-label">Ảnh tiện ích<span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="image" id="image"
                                                class="form-control @error('image') is-invalid @enderror">

                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="name" class="form-label">Tên tiện ích<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $amenitie->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="status" class="form-label">Trạng thái <span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                            <option value="1"
                                                {{ old('status', $amenitie->status) == 1 ? 'selected' : '' }}>Hoạt động
                                            </option>
                                            <option value="0"
                                                {{ old('status', $amenitie->status) == 0 ? 'selected' : '' }}>Không hoạt
                                                động</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="description" class="form-label">Mô tả <span
                                                class="text-danger">*</span></label>
                                        <textarea name="description" id="description" rows="4"
                                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $amenitie->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Cập nhập
                                        </button>
                                        <a href="{{ route('amenitie.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
