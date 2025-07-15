@extends('layouts.admin')
@section('title1', 'Chi tiết phòng')
@section('content')
<section role="main" class="content-body">
    <header class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-6 mb-0">Chi tiết phòng #{{ $room->id }}</h2>
        <a href="{{ route('room.index') }}" class="btn btn-secondary btn-sm">Quay lại danh sách</a>
    </header>

    <div class="card card-modern shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Ảnh phòng -->
                <div class="col-md-5 text-center border-end">
                    @if($room->images_room && $room->images_room->count())
                        {{-- Ảnh chính --}}
                        <div class="mb-3">
                            <img id="main-room-image"
                                src="{{ asset('storage/' . $room->images_room->first()->image_path) }}"
                                alt="{{ $room->title }}" class="img-fluid rounded"
                                style="max-height: 300px; object-fit: cover; width: 100%;">
                        </div>

                        <div class="d-flex gap-2" style="overflow-x: auto; white-space: nowrap;">
                            @foreach($room->images_room as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $room->title }}"
                                    class="img-thumbnail room-thumbnail"
                                    style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;">
                            @endforeach
                        </div>

                    @else
                        <div class="alert alert-warning">Không có album ảnh phòng</div>
                    @endif
                </div>


                <!-- Thông tin phòng -->
                <div class="col-md-7">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th>Số phòng</th>
                                <td>{{ $room->title }}</td>
                            </tr>
                            <tr>
                                <th>Loại phòng</th>
                                <td>{{ $room->roomType->name ?? 'Chưa có' }}</td>
                            </tr>
                            <tr>
                                <th>Giá phòng</th>
                                <td class="text-primary fw-bold">{{ number_format($room->price) }} VNĐ</td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>
                                    @if($room->status == 1)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Không hoạt động</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Mô tả</th>
                                <td style="white-space: pre-line;">{{ $room->description ?? 'Chưa có mô tả' }}</td>
                            </tr>
                            <tr>
                                <th>Ngày tạo</th>
                                <td>{{ $room->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Ngày cập nhật</th>
                                <td>{{ $room->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Tiện ích -->
<div class="card card-modern shadow-sm mt-4">
    <div class="card-body">
        <h5 class="mb-3">Tiện ích của phòng</h5>

        @if($amenityList->isEmpty())
            <div class="text-muted">Không có tiện ích nào được chọn cho phòng này.</div>
        @else
            <div class="row">
                @foreach($amenityList as $amenity)
                    <div class="col-6 col-md-4 col-lg-3 mb-3 text-center">
                        <img src="{{ asset('storage/' . $amenity->image) }}" alt="{{ $amenity->name }}"
                             class="img-thumbnail mb-1" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="small fw-semibold">{{ $amenity->name }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mainImage = document.getElementById('main-room-image');
        const thumbnails = document.querySelectorAll('.room-thumbnail');

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function () {
                mainImage.src = this.src;
            });
        });
    });
</script>


</section>
@endsection
