@extends('layouts.admin')
@section('title1', 'Hóa Đơn')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Hóa đơn</h2>
    </header>
<div class="row">
						<div class="col">
							<div class="card card-modern">
								<div class="card-body">
									<div class="datatables-header-footer-wrapper">
										<div class="datatable-header">
											<div class="row align-items-center mb-3">
												<div class="col-12 col-lg-auto mb-3 mb-lg-0">
													<a href="ecommerce-orders-detail.html" class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+ Add Order</a>
												</div>
												<div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
													<div class="d-flex align-items-lg-center flex-column flex-lg-row">
														<label class="ws-nowrap me-3 mb-0">Filter By:</label>
														<select class="form-control select-style-1 filter-by" name="filter-by">
															<option value="all" selected>All</option>
															<option value="1">ID</option>
															<option value="2">Customer Name</option>
															<option value="3">Date</option>
															<option value="4">Total</option>
															<option value="5">Status</option>
														</select>
													</div>
												</div>
												<div class="col-4 col-lg-auto ps-lg-1 mb-3 mb-lg-0">
													<div class="d-flex align-items-lg-center flex-column flex-lg-row">
														<label class="ws-nowrap me-3 mb-0">Show:</label>
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
															<input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Search Order">
															<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
														</div>
													</div>
												</div>
											</div>
										</div>
										<table class="table table-ecommerce-simple table-borderless table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 640px;">
											<thead>
												<tr>
													<th width="3%"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative top-2" value="" /></th>
													<th width="8%">ID</th>
													<th width="28%">Customer Name</th>
													<th width="18%">Date</th>
													<th width="18%">Total</th>
													<th width="15%">Status</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>191</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example</strong></a></td>
													<td>Nov 21, 2019</td>
													<td>$200</td>
													<td><span class="ecommerce-status on-hold">On Hold</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>192</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 2</strong></a></td>
													<td>Nov 22, 2019</td>
													<td>$70</td>
													<td><span class="ecommerce-status on-hold">On Hold</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>193</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 3</strong></a></td>
													<td>Nov 23, 2019</td>
													<td>$20</td>
													<td><span class="ecommerce-status processing">Processing</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>194</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 4</strong></a></td>
													<td>Nov 24, 2019</td>
													<td>$399</td>
													<td><span class="ecommerce-status on-hold">On Hold</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>195</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 5</strong></a></td>
													<td>Nov 25, 2019</td>
													<td>$1.000</td>
													<td><span class="ecommerce-status processing">Processing</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>196</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 6</strong></a></td>
													<td>Nov 26, 2019</td>
													<td>$1.300</td>
													<td><span class="ecommerce-status on-hold">On Hold</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>197</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 7</strong></a></td>
													<td>Nov 27, 2019</td>
													<td>$50</td>
													<td><span class="ecommerce-status processing">Processing</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>198</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 8</strong></a></td>
													<td>Nov 28, 2019</td>
													<td>$879</td>
													<td><span class="ecommerce-status on-hold">On Hold</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>199</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 9</strong></a></td>
													<td>Nov 29, 2019</td>
													<td>$621</td>
													<td><span class="ecommerce-status completed">Completed</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>200</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 10</strong></a></td>
													<td>Nov 30, 2019</td>
													<td>$245</td>
													<td><span class="ecommerce-status canceled">Canceled</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>201</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 11</strong></a></td>
													<td>Nov 11, 2019</td>
													<td>$178</td>
													<td><span class="ecommerce-status completed">Completed</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>202</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 12</strong></a></td>
													<td>Nov 12, 2019</td>
													<td>$63</td>
													<td><span class="ecommerce-status canceled">Canceled</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>203</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 13</strong></a></td>
													<td>Nov 13, 2019</td>
													<td>$91</td>
													<td><span class="ecommerce-status on-hold">On Hold</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>204</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 14</strong></a></td>
													<td>Nov 14, 2019</td>
													<td>$568</td>
													<td><span class="ecommerce-status processing">Processing</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>205</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 15</strong></a></td>
													<td>Nov 15, 2019</td>
													<td>$796</td>
													<td><span class="ecommerce-status on-hold">On Hold</span></td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="ecommerce-orders-detail.html"><strong>206</strong></a></td>
													<td><a href="ecommerce-orders-detail.html"><strong>Customer Name Example 16</strong></a></td>
													<td>Nov 16, 2019</td>
													<td>$213</td>
													<td><span class="ecommerce-status completed">Completed</span></td>
												</tr>
											</tbody>
										</table>
										<hr class="solid mt-5 opacity-4">
										<div class="datatable-footer">
											<div class="row align-items-center justify-content-between mt-3">
												<div class="col-md-auto order-1 mb-3 mb-lg-0">
													<div class="d-flex align-items-stretch">
														<div class="d-grid gap-3 d-md-flex justify-content-md-end me-4">
															<select class="form-control select-style-1 bulk-action" name="bulk-action" style="min-width: 170px;">
																<option value="" selected>Bulk Actions</option>
																<option value="delete">Delete</option>
															</select>
															<a href="ecommerce-orders-detail.html" class="bulk-action-apply btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Apply</a>
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
									</table>
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