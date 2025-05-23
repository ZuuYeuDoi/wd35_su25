@extends('layouts.admin')
@section('title1', 'Hóa Đơn')
@section('content')
<section role="main" class="content-body">
	<header class="page-header">
		<h2 class="font-weight-bold text-6">Hóa đơn</h2>
	</header>
	<form class="order-details action-buttons-fixed" method="post">
		<div class="row">
			<div class="col-xl-4 mb-4 mb-xl-0">
				<div class="card card-modern">
					<div class="card-header">
						<h2 class="card-title">General</h2>
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col mb-3">
								<label>Status</label>
								<select class="form-control form-control-modern" name="orderStatus" required>
									<option value="on-hold" selected>On Hold</option>
									<option value="pending">Pending Payment</option>
									<option value="processing">Processing</option>
									<option value="completed">Completed</option>
									<option value="cancelled">Cancelled</option>
									<option value="refunded">Refunded</option>
									<option value="failed">Failed</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col mb-3">
								<label>Date Created</label>
								<div class="date-time-field">
									<div class="date">
										<input type="text" class="form-control form-control-modern" name="orderDate" value="2019-11-21" required data-plugin-datepicker data-plugin-options='{"orientation": "bottom", "format": "yyyy-mm-dd"}' />
									</div>
									<div class="time">
										<span class="px-2">@</span>
										<input type="text" class="form-control form-control-modern text-center" name="orderTimeHour" value="10" required />
										<span class="px-2">:</span>
										<input type="text" class="form-control form-control-modern text-center" name="orderTimeMin" value="28" required />
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col mb-3">
								<label>Customer</label>
								<select class="form-control form-control-modern" name="orderCustomer" required data-plugin-selectTwo>
									<option value="21" selected>John Doe</option>
									<option value="33">Monica Doe</option>
									<option value="55">Robert Doe</option>
									<option value="60">Tim Doe</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-8">
				<div class="card card-modern">
					<div class="card-header">
						<h2 class="card-title">Addresses</h2>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-xl-auto me-xl-5 pe-xl-5 mb-4 mb-xl-0">
								<h3 class="text-color-dark font-weight-bold text-4 line-height-1 mt-0 mb-3">BILLING</h3>
								<ul class="list list-unstyled list-item-bottom-space-0">
									<li>Street Name Example</li>
									<li>1234</li>
									<li>Detroit</li>
									<li>Michigan</li>
									<li>93218</li>
									<li>USA</li>
								</ul>
								<strong class="d-block text-color-dark">Email address:</strong>
								<a href="https://www.okler.net/cdn-cgi/l/email-protection#5d373235333932381d3932303c3433733e3230"><span class="__cf_email__" data-cfemail="5c363334323833391c3833313d3532723f3331">[email&#160;protected]</span></a>
								<strong class="d-block text-color-dark mt-3">Phone:</strong>
								<a href="tel:+5551234" class="text-color-dark">555-1234</a>
							</div>
							<div class="col-xl-auto ps-xl-5">
								<h3 class="font-weight-bold text-color-dark text-4 line-height-1 mt-0 mb-3">SHIPPING</h3>
								<ul class="list list-unstyled list-item-bottom-space-0">
									<li>Street Name Example</li>
									<li>1234</li>
									<li>Detroit</li>
									<li>Michigan</li>
									<li>93218</li>
									<li>USA</li>
								</ul>
								<strong class="d-block text-color-dark">Email address:</strong>
								<a href="https://www.okler.net/cdn-cgi/l/email-protection#771d181f191318123713181a161e195914181a"><span class="__cf_email__" data-cfemail="2c464344424843496c4843414d4542024f4341">[email&#160;protected]</span></a>
								<strong class="d-block text-color-dark mt-3">Phone:</strong>
								<a href="tel:+5551234" class="text-color-dark">555-1234</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="card card-modern">
					<div class="card-header">
						<h2 class="card-title">Products</h2>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-ecommerce-simple table-ecommerce-simple-border-bottom table-borderless table-striped mb-0" style="min-width: 380px;">
								<thead>
									<tr>
										<th width="8%" class="ps-4">ID</th>
										<th width="65%">Name</th>
										<th width="5%" class="text-end">Cost</th>
										<th width="7%" class="text-end">Qty</th>
										<th width="5%" class="text-end">Total</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="ps-4"><a href="ecommerce-products-form.html"><strong>191</strong></a></td>
										<td><a href="ecommerce-products-form.html"><strong>Product Name Example</strong></a></td>
										<td class="text-end">$99</td>
										<td class="text-end">1</td>
										<td class="text-end">$99</td>
									</tr>
									<tr>
										<td class="ps-4"><a href="ecommerce-products-form.html"><strong>192</strong></a></td>
										<td><a href="ecommerce-products-form.html"><strong>Product Name Example 2</strong></a></td>
										<td class="text-end">$50</td>
										<td class="text-end">1</td>
										<td class="text-end">$50</td>
									</tr>
									<tr>
										<td class="ps-4"><a href="ecommerce-products-form.html"><strong>193</strong></a></td>
										<td><a href="ecommerce-products-form.html"><strong>Product Name Example 3</strong></a></td>
										<td class="text-end">$132</td>
										<td class="text-end">1</td>
										<td class="text-end">$132</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row justify-content-end flex-column flex-lg-row my-3">
							<div class="col-auto me-5">
								<h3 class="font-weight-bold text-color-dark text-4 mb-3">Items Subtotal</h3>
								<span class="d-flex align-items-center">
									3 Items
									<i class="fas fa-chevron-right text-color-primary px-3"></i>
									<b class="text-color-dark text-xxs">$298.00</b>
								</span>
							</div>
							<div class="col-auto me-5">
								<h3 class="font-weight-bold text-color-dark text-4 mb-3">Shipping</h3>
								<span class="d-flex align-items-center">
									Flat Rate
									<i class="fas fa-chevron-right text-color-primary px-3"></i>
									<b class="text-color-dark text-xxs">$20.00</b>
								</span>
							</div>
							<div class="col-auto">
								<h3 class="font-weight-bold text-color-dark text-4 mb-3">Order Total</h3>
								<span class="d-flex align-items-center justify-content-lg-end">
									<strong class="text-color-dark text-5">$318.00</strong>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="card card-modern">
					<div class="card-header">
						<h2 class="card-title">Order Notes</h2>
					</div>
					<div class="card-body">
						<div class="ecommerce-timeline mb-3">
							<div class="ecommerce-timeline-items-wrapper">
								<div class="ecommerce-timeline-item">
									<small>added on June 26, 2020 at 4:01 pm by admin - <a href="#" class="text-color-danger">Delete note</a></small>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas hendrerit augue at leo viverra, aliquam egestas lectus laoreet. Donec vehicula vestibulum ipsum, tincidunt ultrices elit suscipit ac. Sed eget risus laoreet, varius nibh id, luctus ligula. Nulla facilisi</p>
								</div>
								<div class="ecommerce-timeline-item">
									<small>added on June 26, 2020 at 4:01 pm by admin - <a href="#" class="text-color-danger">Delete note</a></small>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas hendrerit augue at leo viverra, aliquam egestas lectus laoreet. Donec vehicula vestibulum ipsum, tincidunt ultrices elit suscipit ac. Sed eget risus laoreet, varius nibh id, luctus ligula. Nulla facilisi</p>
								</div>
								<div class="ecommerce-timeline-item">
									<small>added on June 26, 2020 at 4:01 pm by admin - <a href="#" class="text-color-danger">Delete note</a></small>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas hendrerit augue at leo viverra, aliquam egestas lectus laoreet. Donec vehicula vestibulum ipsum, tincidunt ultrices elit suscipit ac. Sed eget risus laoreet, varius nibh id, luctus ligula. Nulla facilisi</p>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col pb-1 mb-3">
								<label>Add Note</label>
								<textarea class="form-control form-control-modern" name="orderAddNote" rows="6"></textarea>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<a href="#" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Add Note</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row action-buttons">
			<div class="col-12 col-md-auto">
				<button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
					<i class="bx bx-save text-4 me-2"></i> Save Order
				</button>
			</div>
			<div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
				<a href="ecommerce-orders-list.html" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Cancel</a>
			</div>
			<div class="col-12 col-md-auto ms-md-auto mt-3 mt-md-0 ms-auto">
				<a href="#" class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
					<i class="bx bx-trash text-4 me-2"></i> Delete Order
				</a>
			</div>
		</div>
	</form>
</section>
@endsection
@section('head')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />

@endsection
@section('script')
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
<script src="{{ asset('assets/vendor/select2/js/select2.js') }}"></script>

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
<script src="{{ asset('assets/js/examples/examples.ecommerce.orders.detail.js') }}"></script>

@endsection