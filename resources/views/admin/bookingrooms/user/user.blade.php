@extends('layouts.admin')
@section('title1', 'Người dùng')
@section('content')
<section role="main" class="content-body">
	<header class="page-header">
		<h2 class="font-weight-bold text-6">Người dùng</h2>
	</header>
	<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">
                <div class="datatables-header-footer-wrapper">
                    <div class="datatable-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                <a href="add-customer.html" class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+ Thêm khách hàng</a>
                            </div>
                            <div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                    <label class="ws-nowrap me-3 mb-0">Lọc theo:</label>
                                    <select class="form-control select-style-1 filter-by" name="filter-by">
                                        <option value="all" selected>Tất cả</option>
                                        <option value="1">ID</option>
                                        <option value="2">Tên khách hàng</option>
                                        <option value="3">Số điện thoại</option>
                                        <option value="4">Email</option>
                                        <option value="5">Số phòng</option>
                                        <option value="6">Loại phòng</option>
                                        <option value="7">Tổng tiền</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 col-lg-auto ps-lg-1 mb-3 mb-lg-0">
                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                    <label class="ws-nowrap me-3 mb-0">Hiển thị:</label>
                                    <select class="form-control select-style-1 results-per-page" name="results-per-page">
                                        <option value="10" selected>10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-auto ps-lg-1">
                                <div class="search search-style-1 search-style-1-lg mx-lg-auto">
                                    <div class="input-group">
                                        <input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Tìm kiếm khách hàng">
                                        <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bảng danh sách khách hàng -->
                    <table class="table table-ecommerce-simple table-striped mb-0" style="min-width: 850px;">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="checkbox-style-1 select-all" /></th>
                                <th>ID</th>
                                <th>Họ tên</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Số phòng đã đặt</th>
                                <th>Loại phòng</th>
                                <th>Tổng thanh toán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" class="checkbox-style-1" /></td>
                                <td>#KH001</td>
                                <td>Nguyễn Văn A</td>
                                <td>0912345678</td>
                                <td>nguyenvana@gmail.com</td>
                                <td>phòng 206</td>
                                <td>Phòng đơn, Phòng đôi</td>
                                <td>5.500.000₫</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="checkbox-style-1" /></td>
                                <td>#KH002</td>
                                <td>Trần Thị B</td>
                                <td>0987654321</td>
                                <td>tranthib@gmail.com</td>
                                    <td>phòng 206</td>
                                <td>Phòng đôi</td>
                                <td>3.200.000₫</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="checkbox-style-1" /></td>
                                <td>#KH003</td>
                                <td>Lê Văn C</td>
                                <td>0901234567</td>
                                <td>levanc@gmail.com</td>
                                <td>phòng 206</td>
                                <td>Phòng đơn, Suite</td>
                                <td>9.800.000₫</td>
                            </tr>
                            <!-- Thêm dòng dữ liệu khác tại đây -->
                        </tbody>
                    </table>
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
<script data-cfasync="false" src="{{ asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/master/style-switcher/style.switcher.js') }}"></script>
<script src="{{ asset('assets/vendor/popper/umd/popper.min.js') }}"></script>
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