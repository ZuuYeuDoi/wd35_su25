@extends('layouts.admin')
@section('title1', 'Thêm loại phòng')

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
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Thêm loại phòng</h2>
    </header>
    <div class="col-lg-12">
    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('room_types.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Cột trái: thông tin loại phòng -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên loại phòng</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Hạng phòng</label>
                            <input type="text" name="type" class="form-control" value="{{ old('type') }}" required>
                        </div>

                        <div class="mb-3">
    <label class="form-label">Loại giường</label>
    <div class="d-flex flex-wrap gap-3">
        @php
            $bedTypes = [
                '1 giường đơn',
                '2 giường đơn',
                '1 giường đôi',
                '3 giường đơn',
                '2 giường đôi',
            ];
        @endphp

        @foreach ($bedTypes as $bed)
            <div class="form-check me-3">
                <input class="form-check-input" type="radio" name="bed_type"
                    value="{{ $bed }}" id="bed_type_{{ $loop->index }}"
                    {{ old('bed_type') === $bed ? 'checked' : '' }}>
                <label class="form-check-label" for="bed_type_{{ $loop->index }}">{{ $bed }}</label>
            </div>
        @endforeach
    </div>
    @error('bed_type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                        <div class="mb-3">
                            <label for="room_type_price" class="form-label">Giá mặc định</label>
                            <input type="number" name="room_type_price" class="form-control" value="{{ old('room_type_price') }}" min="0" required>
                        </div>

                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="images" class="form-label">Album ảnh</label>
                                <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">

                                <div id="preview-images" class="mt-3 d-flex flex-wrap gap-3"></div>
                            </div>

                        </div>
                    </div>

                    <!-- Cột phải: tiện ích -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="mb-3">Danh sách tiện ích</h5>
                            <div class="amenitie_room">
                                @foreach ($amenities as $item)
                                    <div class="amenitie_card">
                                        <input type="checkbox" id="amenity_{{ $item->id }}" name="amenities[]" value="{{ $item->id }}">
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
                </div>

                <button type="submit" class="btn btn-success">Thêm mới</button>
                <a href="{{ route('room_types.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>

            
        </div>
    </div>
</div>

</section>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/media/css/dataTables.bootstrap5.css') }}" />
@endsection
@section('script')
    <!-- Vendor -->
    <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/master/style-switcher/style.switcher.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper/umd/popper.min.html') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/common/common.js') }}"></script>
    <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
    <script src="{{ asset('assets/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
    <!-- Specific Page Vendor -->
    <script src="{{ asset('assets/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/media/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Theme Base, Components aassets/nd Settings -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <!-- Theme Custom -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- Theme Initialization Files -->
    <script src="{{ asset('assets/js/theme.init.js') }}"></script>
    <!-- Analytics to Track Preview Website -->
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '../../../../www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-42715764-8', 'auto');
        ga('send', 'pageview');

    <!-- Examples -->
    <script src="{{ asset('assets/js/examples/examples.header.menu.js') }}"></script>
    <script src="{{ asset('assets/js/examples/examples.ecommerce.datatables.list.js') }}"></script>
    <script>
    document.getElementById('images').addEventListener('change', function (event) {
        let previewContainer = document.getElementById('preview-images');
        previewContainer.innerHTML = ''; // clear old preview
        Array.from(event.target.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;

            let reader = new FileReader();
            reader.onload = function (e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.width = '150px';
                img.style.height = 'auto';
                img.style.objectFit = 'cover';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>

@endsection
