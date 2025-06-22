@extends('layouts.admin')
@section('title1', 'Thêm dịch vụ')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Thêm mới dịch vụ</h2>
        </header>
        <div class="row">
            <div class="col">
                <div class="card card-modern">
                    <div class="card-body">
                        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Cột trái -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="name" class="form-label">Tên dịch vụ <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="price" class="form-label">Giá <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" name="price" id="price" min="0"
                                                class="form-control @error('price') is-invalid @enderror"
                                                value="{{ old('price') }}">
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="unit" class="form-label">Đơn vị tính <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="unit" id="unit"
                                            class="form-control @error('unit') is-invalid @enderror"
                                            value="{{ old('unit') }}">
                                        @error('unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cột phải -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="image" class="form-label">Hình ảnh dịch vụ <span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="image" id="image"
                                            class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
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
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus me-1"></i> Thêm mới
                                    </button>
                                    <a href="{{ route('services.index') }}" class="btn btn-secondary">
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

@section('script')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{ route('services.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uploadimage',
            uploadUrl: "{{ route('services.upload', ['_token' => csrf_token()]) }}"
        });
    </script>

@endsection
