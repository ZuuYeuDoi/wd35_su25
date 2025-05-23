@extends('layouts.admin')
@section('title1', 'Người dùng')
@section('content')
<section role="main" class="content-body">
	<header class="page-header">
		<h2 class="font-weight-bold text-6">Người dùng</h2>
	</header>
	<form class="ecommerce-form action-buttons-fixed" action="#" method="post">
		<div class="row">
			<div class="col">
				<section class="card card-modern card-big-info">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-2-5 col-xl-1-5">
								<i class="card-big-info-icon bx bx-dollar-circle"></i>
								<h2 class="card-big-info-title">Billing Info</h2>
								<p class="card-big-info-desc">Add here the customer billing info with all details and necessary information.</p>
							</div>
							<div class="col-lg-3-5 col-xl-4-5">
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">First Name</label>
									<div class="col-lg-7 col-xl-6">
										<input type="text" class="form-control form-control-modern" name="customerBillingFirstName" value="" required />
									</div>
								</div>
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Last Name</label>
									<div class="col-lg-7 col-xl-6">
										<input type="text" class="form-control form-control-modern" name="customerBillingLastName" value="" required />
									</div>
								</div>
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Company</label>
									<div class="col-lg-7 col-xl-6">
										<input type="text" class="form-control form-control-modern" name="customerBillingCompany" value="" />
									</div>
								</div>
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Address Line 1</label>
									<div class="col-lg-7 col-xl-6">
										<input type="text" class="form-control form-control-modern" name="customerBillingAddressLine1" value="" required />
									</div>
								</div>
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Address Line 2</label>
									<div class="col-lg-7 col-xl-6">
										<input type="text" class="form-control form-control-modern" name="customerBillingAddressLine2" value="" />
									</div>
								</div>
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">City</label>
									<div class="col-lg-7 col-xl-6">
										<input type="text" class="form-control form-control-modern" name="customerBillingCity" value="" required />
									</div>
								</div>
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Postcode / ZIP</label>
									<div class="col-lg-7 col-xl-6">
										<input type="text" class="form-control form-control-modern" name="customerBillingPostCodeZip" value="" required />
									</div>
								</div>
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Country / Region</label>
									<div class="col-lg-7 col-xl-6">
										<select class="form-control form-control-modern" name="customerBillingCountryRegion">
											<option value="">Select a country / region</option>
											<option value="country1">Country 1</option>
											<option value="country2">Country 2</option>
											<option value="country3">Country 3</option>
											<option value="country4">Country 4</option>
										</select>
									</div>
								</div>
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">State / Country</label>
									<div class="col-lg-7 col-xl-6">
										<select class="form-control form-control-modern" name="customerBillingStateCountry">
											<option value="">Select a State</option>
											<option value="state1">State 1</option>
											<option value="state2">State 2</option>
											<option value="state3">State 3</option>
											<option value="state4">State 4</option>
										</select>
									</div>
								</div>
								<div class="form-group row align-items-center">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Phone</label>
									<div class="col-lg-7 col-xl-6">
										<input type="text" class="form-control form-control-modern" name="customerBillingPhone" value="" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<section class="card card-modern card-big-info">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-2-5 col-xl-1-5">
								<i class="card-big-info-icon bx bx-mail-send"></i>
								<h2 class="card-big-info-title">Shipping Info</h2>
								<p class="card-big-info-desc">Add here the customer shipping info with all details and necessary information.</p>
							</div>
							<div class="col-lg-3-5 col-xl-4-5">
								<div class="form-group row align-items-center">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Same as billing</label>
									<div class="col-lg-7 col-xl-6">
										<div class="checkbox">
											<label class="my-2">
												<input name="customerShippingSameAsBilling" type="checkbox" value="" data-bs-toggle="collapse" data-bs-target=".shipping-fields-wrapper">
												Check this box to use same information as billing for shipping.
											</label>
										</div>
									</div>
								</div>
								<div class="shipping-fields-wrapper collapse show">
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">First Name</label>
										<div class="col-lg-7 col-xl-6">
											<input type="text" class="form-control form-control-modern" name="customerShippingFirstName" value="" required />
										</div>
									</div>
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Last Name</label>
										<div class="col-lg-7 col-xl-6">
											<input type="text" class="form-control form-control-modern" name="customerShippingLastName" value="" required />
										</div>
									</div>
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Company</label>
										<div class="col-lg-7 col-xl-6">
											<input type="text" class="form-control form-control-modern" name="customerShippingCompany" value="" />
										</div>
									</div>
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Address Line 1</label>
										<div class="col-lg-7 col-xl-6">
											<input type="text" class="form-control form-control-modern" name="customerShippingAddressLine1" value="" required />
										</div>
									</div>
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Address Line 2</label>
										<div class="col-lg-7 col-xl-6">
											<input type="text" class="form-control form-control-modern" name="customerShippingAddressLine2" value="" />
										</div>
									</div>
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">City</label>
										<div class="col-lg-7 col-xl-6">
											<input type="text" class="form-control form-control-modern" name="customerShippingCity" value="" required />
										</div>
									</div>
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Postcode / ZIP</label>
										<div class="col-lg-7 col-xl-6">
											<input type="text" class="form-control form-control-modern" name="customerShippingPostCodeZip" value="" required />
										</div>
									</div>
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Country / Region</label>
										<div class="col-lg-7 col-xl-6">
											<select class="form-control form-control-modern" name="customerShippingCountryRegion">
												<option value="">Select a country / region</option>
												<option value="country1">Country 1</option>
												<option value="country2">Country 2</option>
												<option value="country3">Country 3</option>
												<option value="country4">Country 4</option>
											</select>
										</div>
									</div>
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">State / Country</label>
										<div class="col-lg-7 col-xl-6">
											<select class="form-control form-control-modern" name="customerShippingStateCountry">
												<option value="">Select a State</option>
												<option value="state1">State 1</option>
												<option value="state2">State 2</option>
												<option value="state3">State 3</option>
												<option value="state4">State 4</option>
											</select>
										</div>
									</div>
									<div class="form-group row align-items-center">
										<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Phone</label>
										<div class="col-lg-7 col-xl-6">
											<input type="text" class="form-control form-control-modern" name="customerShippingPhone" value="" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<section class="card card-modern card-big-info">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-2-5 col-xl-1-5">
								<i class="card-big-info-icon bx bx-user-circle"></i>
								<h2 class="card-big-info-title">Account Info</h2>
								<p class="card-big-info-desc">Add here the customer account info with all details and necessary information.</p>
							</div>
							<div class="col-lg-3-5 col-xl-4-5">
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Email / Username</label>
									<div class="col-lg-7 col-xl-6">
										<input type="email" class="form-control form-control-modern" name="customerEmailUsername" value="" required />
									</div>
								</div>
								<div class="form-group row align-items-center pb-3">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Password</label>
									<div class="col-lg-7 col-xl-6">
										<input type="password" class="form-control form-control-modern" name="customerPassword" value="" required />
									</div>
								</div>
								<div class="form-group row align-items-center">
									<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Password Confirm</label>
									<div class="col-lg-7 col-xl-6">
										<input type="password" class="form-control form-control-modern" name="customerPasswordConfirm" value="" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="row action-buttons">
			<div class="col-12 col-md-auto">
				<button type="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
					<i class="bx bx-save text-4 me-2"></i> Save Customer
				</button>
			</div>
			<div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
				<a href="ecommerce-customers-list.html" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Cancel</a>
			</div>
		</div>
	</form>
</section>
@endsection
@section('head')
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />

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
<script src="{{ asset('assets/vendor/jquery-validation/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>

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
<script src="{{ asset('assets/js/examples/examples.ecommerce.form.js') }}"></script>
@endsection