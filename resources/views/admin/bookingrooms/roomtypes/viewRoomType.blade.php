@extends('layouts.admin')
@section('title1', 'Loại Phòng')
@push("css")
    <style>
    .d-flex img {
        border-radius: 4px;
        box-shadow: 0 0 3px rgba(0,0,0,0.2);
    }
</style>
@endpush
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Danh sách loại phòng</h2>
    </header>
    <div class="row">
        <div class="col">
            <div class="card card-modern">
                <div class="card-body">
                    <div class="datatables-header-footer-wrapper">
                        <div class="datatable-header">
                            <div class="row align-items-center mb-3">
                                <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                    <a href="{{ route('room_types.create') }}">
                                        <button class="btn btn-primary">Thêm loại phòng</button>
                                    </a>
                                </div>
                                <div class="col-12 col-lg-auto ms-auto">
                                    <div class="search search-style-1 search-style-1-lg mx-lg-auto">
                                        <div class="input-group">
                                            <input type="text" class="search-term form-control" placeholder="Tìm kiếm loại phòng">
                                            <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-ecommerce-simple table-borderless table-striped mb-0" style="min-width: 1000px;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên loại phòng</th>
                                    <th>Loại (type)</th>
                                    <th>Giá mặc định</th>
                                    <th>Hình ảnh</th>
                                    <th>Tiện ích</th>
                                
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roomTypes as $type)
                                <tr>
                                    <td>{{ $type->id }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>{{ $type->type }}</td>
                                    <td>{{ number_format($type->room_type_price) }} VNĐ</td>
                                    <td>
                                        @if ($type->images->count())
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($type->images as $img)
                                                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $type->name }}" width="60" height="40" style="object-fit:cover;">
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">Chưa có</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if(!empty($type->amenities))
                                            <ul class="list-unstyled mb-0">
                                                @foreach($type->amenities as $amenityId)
                                                    @php
                                                        $amenity = \App\Models\Amenitie::find($amenityId);
                                                    @endphp
                                                    @if($amenity)
                                                        <li>{{ $amenity->name }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            
                                        @else
                                            <span class="text-muted">Không có</span>
                                        @endif
                                    </td>

                                    
                                    <td>
                                        <a href="{{ route('room_types.edit', $type->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                        <form action="{{ route('room_types.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr class="solid mt-5 opacity-4">
                        <div class="datatable-footer">
                            <div class="row align-items-center justify-content-between mt-3">
                                <div class="col-lg-auto text-center order-3 order-lg-2">
                                    {{ $roomTypes->links() }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- datatables-wrapper -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
