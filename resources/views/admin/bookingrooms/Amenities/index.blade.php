@extends('layouts.admin')
@section('title1', 'Danh sách tiện ích')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Danh sách tiên ích </h2>
        </header>
        <div class="row">
            <div class="col">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                        <a href="{{route('amenitie.create')}}"><button class="btn btn-primary">Thêm Tiện ích</button></a>
                                        <a href="{{route('amenitie.trash')}}"><button class="btn btn-warning">Thùng rác</button></a>
                                    </div>
                                    <div class="col-12 col-lg-auto ps-lg-1">
                                        <div class="search search-style-1 search-style-1-lg mx-lg-auto">
                                            <div class="input-group">
                                                <input type="text" class="search-term form-control" name="search-term"
                                                    id="search-term" placeholder="Tìm kiếm tiện ích">
                                                <button class="btn btn-default" type="submit"><i
                                                        class="bx bx-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-ecommerce-simple table-borderless table-striped mb-0"
                                id="datatable-room-list" style="min-width: 1000px;">
                                <thead>
                                    <tr>
                                        <th width="3%"><input type="checkbox" name="select-all"
                                                class="select-all checkbox-style-1 p-relative top-2" value="" /></th>
                                        <th >ID</th>
                                        <th >Tên tiện ích </th>
                                        <th >Mô tả </th>
                                        <th >Hình ảnh</th>
                                        <th >Trạng thái </th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($utilities  as $utility)
                                    <tr>
                                        <td><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" /></td>
                                        <td>{{$utility->id}}</td>
                                        <td>{{$utility->name}}</td>
                                        <td>{{ $utility->description }}</td>
                                        <td>
                                            @if($utility->image)
                                                <img src="{{ asset('storage/' . $utility->image) }}" alt="{{ $utility->name }}" width="80">
                                            @endif
                                        </td>
                                        <td>
                                            @if($utility->status == 1)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td>{{ $utility->created_at->format('d/m/y ') }}</td>
                                        <td>{{ $utility->updated_at->format('d/m/y ') }}</td>
                                        <td>
                                            <a href="{{ route('amenitie.edit', $utility->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                            <form action="{{ route('amenitie.destroy', $utility->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
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
                                                <select class="form-control select-style-1 bulk-action" name="bulk-action"
                                                    style="min-width: 170px;">
                                                    <option value="" selected>Thao tác hàng loạt</option>
                                                    <option value="delete">Xóa</option>
                                                </select>
                                                <a href="room-detail.html"
                                                    class="bulk-action-apply btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Áp
                                                    dụng</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto text-center order-3 order-lg-2">
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


    @endsection
</section>
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
    </script>
    <!-- Examples -->
    <script src="{{ asset('assets/js/examples/examples.header.menu.js') }}"></script>
    <script src="{{ asset('assets/js/examples/examples.ecommerce.datatables.list.js') }}"></script>
@endsection
