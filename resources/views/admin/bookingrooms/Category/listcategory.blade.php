@extends('layouts.admin')
@section('title1', 'Danh mục')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Danh sách danh mục</h2>
    </header>
<div class="row">
	<div class="col">
		<div class="card card-modern">
			<div class="card-body">
				<div class="datatables-header-footer-wrapper mt-2">
					<div class="datatable-header">
						<div class="row align-items-center mb-3">
							<div class="col-12 col-lg-auto mb-3 mb-lg-0">
								<a href="ecommerce-category-form.html" class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+ Thêm danh mục</a>
							</div>
							<div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
								<div class="d-flex align-items-lg-center flex-column flex-lg-row">
									<label class="ws-nowrap me-3 mb-0">Lọc theo:</label>
									<select class="form-control select-style-1 filter-by" name="filter-by">
										<option value="all" selected>Tất cả</option>
										<option value="1">ID</option>
										<option value="2">Tên danh mục</option>
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
										<input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Tìm kiếm danh mục">
										<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 550px;">
						<thead>
							<tr>
								<th width="3%"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative top-2" /></th>
								<th width="8%">ID</th>
								<th width="28%">Tên danh mục</th>
								<th width="23%">###</th>
								<th width="38%">###</th>
							</tr>
						</thead>
						<tbody>
							<!-- Giữ nguyên dữ liệu ví dụ hoặc thay bằng dữ liệu động từ backend -->
							<tr>
								<td><input type="checkbox" class="checkbox-style-1" /></td>
								<td><a href="ecommerce-category-form.html"><strong>191</strong></a></td>
								<td><a href="ecommerce-category-form.html"><strong>Ví dụ danh mục</strong></a></td>
								<td>vi-du-danh-muc</td>
								<td>Danh mục cha 1</td>
							</tr>
							<!-- Các dòng tiếp theo -->
						</tbody>
					</table>

					<hr class="solid mt-5 opacity-4">

					<div class="datatable-footer">
						<div class="row align-items-center justify-content-between mt-3">
							<div class="col-md-auto order-1 mb-3 mb-lg-0">
								<div class="d-flex align-items-stretch">
									<div class="d-grid gap-3 d-md-flex justify-content-md-end me-4">
										<select class="form-control select-style-1 bulk-action" name="bulk-action" style="min-width: 170px;">
											<option value="" selected>Hành động hàng loạt</option>
											<option value="delete">Xóa</option>
										</select>
										<a href="#" class="bulk-action-apply btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Áp dụng</a>
									</div>
								</div>
							</div>
							<div class="col-lg-auto text-center order-3 order-lg-2">
								<div class="results-info-wrapper">Hiển thị kết quả...</div>
							</div>
							<div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
								<div class="pagination-wrapper">Phân trang...</div>
							</div>
						</div>
					</div>
				</div><!-- end datatables-wrapper -->
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