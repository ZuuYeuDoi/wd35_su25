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
                    @if($room->image_room)
                        <img src="{{ asset('storage/' . $room->image_room) }}" alt="{{ $room->title }}" class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                    @else
                        <div class="alert alert-warning">Không có hình ảnh phòng</div>
                    @endif

                    @if($room->thumbnail)
                        <div>
                            <strong>Ảnh thumbnail:</strong>
                            <img src="{{ asset('storage/' . $room->thumbnail) }}" alt="Thumbnail {{ $room->title }}" class="img-thumbnail mt-2" style="max-width: 150px;">
                        </div>
                    @else
                        <div class="text-muted mt-2">Không có ảnh thumbnail</div>
                    @endif
                </div>

                <!-- Thông tin phòng -->
                <div class="col-md-7">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 35%;">ID</th>
                                <td>{{ $room->id }}</td>
                            </tr>
                            <tr>
                                <th>Tên phòng</th>
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
                                <th>Số người tối đa</th>
                                <td>{{ $room->max_people }}</td>
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
</section>
@endsection
