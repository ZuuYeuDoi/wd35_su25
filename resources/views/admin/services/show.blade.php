@extends('layouts.admin')
@section('title1', 'Chi tiết dịch vụ')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="font-weight-bold text-6 mb-0">Chi tiết dịch vụ #{{ $service->id }}</h2>
            <a href="{{ route('services.index') }}" class="btn btn-secondary btn-sm">Quay lại danh sách</a>
        </header>

        <div class="card card-modern shadow-sm">
            <div class="card-body">
                <div class="row">
                    <!-- Ảnh dịch vụ -->
                    <div class="col-md-5 text-center border-end">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                        @else
                            <div class="alert alert-warning">Không có hình ảnh</div>
                        @endif
                    </div>

                    <!-- Thông tin dịch vụ -->
                    <div class="col-md-7">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 35%;">ID</th>
                                    <td>{{ $service->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên dịch vụ</th>
                                    <td>{{ $service->name }}</td>
                                </tr>
                                <tr>
                                    <th>Giá</th>
                                    <td class="text-primary fw-bold">{{ number_format($service->price) }} VNĐ</td>
                                </tr>
                                <tr>
                                    <th>Đơn vị</th>
                                    <td>{{ $service->unit }}</td>
                                </tr>
                                <tr>
                                    <th>Loại dịch vụ</th>
                                    <td>{{ \App\Models\Service::TYPE[$service->type] ?? 'Không xác định' }}</td>
                                </tr>

                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if ($service->status == 1)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-secondary">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mô tả</th>
                                    <td style="white-space: pre-line;">{!! $service->description ?? 'Chưa có mô tả' !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
