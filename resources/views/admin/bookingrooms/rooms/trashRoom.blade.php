@extends('layouts.admin')
@section('title1', 'Thùng rác phòng')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Thùng rác phòng</h2>
    </header>
    <div class="row">
        <div class="col">
            <div class="card card-modern">
                <div class="card-body">
                    <div class="datatables-header-footer-wrapper">
                        <div class="datatable-header">
                            <div class="row align-items-center mb-3">
                                <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                    <a href="{{ route('room.index') }}" class="btn btn-warning">Quay lại danh sách phòng</a>
                                </div>
                                <div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
                                    <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                        <label class="ws-nowrap me-3 mb-0">Lọc theo:</label>
                                        <select class="form-control select-style-1 filter-by" name="filter-by">
                                            <option value="all" selected>Tất cả</option>
                                            <option value="1">Mã phòng</option>
                                            <option value="2">Tên phòng</option>
                                            <option value="3">Loại phòng</option>
                                            <option value="4">Số giường</option>
                                            <option value="5">Trạng thái</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 col-lg-auto ps-lg-1 mb-3 mb-lg-0">
                                    <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                        <label class="ws-nowrap me-3 mb-0">Hiển thị:</label>
                                        <select class="form-control select-style-1 results-per-page" name="results-per-page">
                                            <option value="12" selected>12</option>
                                            <option value="24">24</option>
                                            <option value="36">36</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-auto ps-lg-1">
                                    <div class="search search-style-1 search-style-1-lg mx-lg-auto">
                                        <div class="input-group">
                                            <input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Tìm kiếm phòng trong thùng rác">
                                            <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-ecommerce-simple table-borderless table-striped mb-0" id="datatable-room-list" style="min-width: 1000px;">
                            <thead>
                                <tr>
                                    <th width="3%"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative top-2" value="" /></th>
                                    <th>ID</th>
                                    <th>Tên phòng</th>
                                    <th>Loại phòng</th>
                                    <th>Hình ảnh phòng</th>
                                    <th>Giá phòng</th>
                                    <th>Số người tối đa</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                <tr>
                                    <td><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" /></td>
                                    <td>{{ $room->id }}</td>
                                    <td>{{ $room->title }}</td>
                                    <td>{{ $room->roomType->name ?? 'chưa có' }}</td>
                                    <td>
                                        @if($room->image_room)
                                            <img src="{{ asset('storage/' . $room->image_room) }}" alt="{{ $room->title }}" width="80">
                                        @endif
                                    </td>
                                    <td>{{ number_format($room->price) }} VNĐ</td>
                                    <td>{{ $room->max_people }}</td>
                                    <td>
                                        @if($room->status == 1)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-secondary">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('room.restore', $room->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('PATCH') 
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Bạn có chắc muốn phục hồi phòng này?')">Phục hồi</button>
                                        </form>

                                        <form action="{{ route('room.forceDelete', $room->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn phòng này?')">Xóa vĩnh viễn</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr class="solid mt-5 opacity-4">

                        <div class="datatable-footer">
                            <div class="row align-items-center justify-content-between mt-3">
                                <div class="col-md-auto order-1 mb-3 mb-lg-0">
                                    <div class="d-flex align-items-stretch">
                                        <div class="d-grid gap-3 d-md-flex justify-content-md-end me-4">
                                            <select class="form-control select-style-1 bulk-action" name="bulk-action" style="min-width: 170px;">
                                                <option value="" selected>Thao tác hàng loạt</option>
                                                <option value="restore">Phục hồi</option>
                                                <option value="force-delete">Xóa vĩnh viễn</option>
                                            </select>
                                            <a href="#" class="bulk-action-apply btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Áp dụng</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-auto text-center order-3 order-lg-2 mb-3 mb-lg-0">
                                    <div class="results-info-wrapper"></div>
                                </div>
                                <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                    <div class="pagination-wrapper"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
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
<!-- Theme Base, Components and Settings -->
<script src="{{ asset('assets/js/theme.js') }}"></script>
<!-- Theme Custom -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
<!-- Theme Initialization Files -->
<script src="{{ asset('assets/js/theme.init.js') }}"></script>
<!-- Analytics to Track Preview Website -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-42715764-8', 'auto');
    ga('send', 'pageview');
</script>
