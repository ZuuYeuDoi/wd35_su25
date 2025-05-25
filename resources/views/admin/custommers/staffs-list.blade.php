@extends('layouts.admin')
@section('title1', 'Quản lý Nhân viên')
@section('content')
    <section role="main" class="content-body content-body-modern mt-0">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Quản lý Nhân viên</h2>
        </header>
        <!-- start: page -->
        <div class="row">
            <div class="col">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-3">
                                    <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                        <a href="/admin/add-staff"
                                            class="btn btn-success btn-md font-weight-semibold btn-py-2 px-4">+ Thêm Nhân viên</a>
                                    </div>
                                    <div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
                                        <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                            <label class="ws-nowrap me-3 mb-0">Lọc:</label>
                                            <select class="form-control select-style-1 filter-by" name="filter-by">
                                                <option value="all" selected>Tất cả</option>
                                                <option value="1">ID</option>
                                                <option value="2">Họ tên</option>
                                                <option value="2">CCCD</option>
                                                <option value="3">SĐT</option>
                                                <option value="4">E-mail</option>
                                                <option value="4">Chức vụ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-auto ps-lg-1 mb-3 mb-lg-0">
                                        <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                            <label class="ws-nowrap me-3 mb-0">Số bản xem:</label>
                                            <select class="form-control select-style-1 results-per-page"
                                                name="results-per-page">
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
                                                <input type="text" class="search-term form-control" name="search-term"
                                                    id="search-term" placeholder="Tìm kiếm">
                                                <button class="btn btn-default" type="submit"><i
                                                        class="bx bx-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list"
                                style="min-width: 750px;">
                                <thead>
                                    <tr>
                                        <th width="3%"><input type="checkbox" name="select-all"
                                                class="select-all checkbox-style-1 p-relative top-2" value="" /></th>
                                        <th width="8%">ID</th>
                                        <th width="15%">Họ tên</th>
                                        <th width="20%">CCCD</th>
                                        <th width="18%">SĐT</th>
                                        <th width="20%">E-mail</th>
                                        <th width="20%">Chức vụ</th>
                                        <th width="20%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="30"><input type="checkbox" name="checkboxRow1"
                                                class="checkbox-style-1 p-relative top-2" value="" /></td>
                                        <td>001</td>
                                        <td>HoangTaly</td>
                                        <td>001205******</td>
                                        <td>01234456789</td>
                                        <td>hoangtaly@gmail.com</td>
                                        <td>Sếp</td>
                                        <td>
                                            <a
                                                href="#"class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                                                <i class="bx bx-trash text-4 me-2"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <hr class="solid mt-5 opacity-4">
                            <div class="datatable-footer">
                                <div class="row align-items-center justify-content-between mt-3">
                                    <div class="col-lg-auto text-center order-3 order-lg-2">
                                        <div class="results-info-wrapper"></div>
                                    </div>
                                    <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                        <div class="pagination-wrapper"></div>
                                    </div>
                                </div>
                            </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: page -->
    </section>
@endsection

@section('head')
    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/media/css/dataTables.bootstrap5.css') }}" />
@endsection
@section('script')
    <!-- Vendor -->
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
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
    <script src="{{ asset('assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Theme Base, Components and Settings -->
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
