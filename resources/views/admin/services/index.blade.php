@extends('layouts.admin')

@section('title1', 'Dịch Vụ')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Danh sách dịch vụ</h2>
        </header>

        <div class="row">
            <div class="col">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                        <a href="{{ route('services.create') }}">
                                            <button class="btn btn-success">Thêm dịch vụ</button>
                                        </a>
                                        <a href="{{ route('services.trash') }}" class="btn btn-outline-secondary">
                                            <i class="bx bx-trash"></i> Xem thùng rác
                                        </a>
                                    </div>
                                    <div class="col-12 col-lg-auto ms-auto">
                                        <div class="search search-style-1 search-style-1-lg mx-lg-auto">
                                            <div class="input-group">
                                                <input type="text" class="search-term form-control"
                                                    placeholder="Tìm kiếm dịch vụ">
                                                <button class="btn btn-default" type="submit"><i
                                                        class="bx bx-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-ecommerce-simple table-borderless table-striped mb-0"
                                style="min-width: 1000px;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên dịch vụ</th>
                                        <th>Mô tả</th>
                                        <th>Giá</th>
                                        <th>Đơn vị</th>
                                        <th>Hình ảnh</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $key => $service)
                                        <tr>
                                            <td>{{ $services->firstItem() + $key }}</td>
                                            <td><a class="service-link"
                                                    href="{{ route('services.show', $service->id) }}">{{ $service->name }}</a>
                                            </td>
                                            <td>{{ Str::limit($service->description, 50) }}</td>
                                            <td>{{ number_format($service->price, 0) }} VNĐ</td>
                                            <td>{{ $service->unit }}</td>
                                            <td>
                                                @if ($service->image)
                                                    <img src="{{ asset('storage/' . $service->image) }}"
                                                        alt="{{ $service->name }}" width="80">
                                                @else
                                                    <span class="text-muted">Chưa có</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($service->status)
                                                    <span class="badge bg-success">Hiển thị</span>
                                                @else
                                                    <span class="badge bg-secondary">Ẩn</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('services.edit', $service->id) }}"
                                                    class="btn btn-sm btn-warning">Sửa</a>
                                                <form action="{{ route('services.destroy', $service->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
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
                                        {{ $services->links() }}
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
