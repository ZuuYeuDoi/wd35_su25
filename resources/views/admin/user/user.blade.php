@extends('layouts.admin')

@section('content')
<div class="row">
						<div class="col">
							<div class="card card-modern">
								<div class="card-body">
									<div class="datatables-header-footer-wrapper">
										<div class="datatable-header">
											<div class="row align-items-center mb-3">
												<div class="col-12 col-lg-auto mb-3 mb-lg-0">
													<a href="ecommerce-customers-form.html" class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+ Add Customer</a>
												</div>
												<div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
													<div class="d-flex align-items-lg-center flex-column flex-lg-row">
														<label class="ws-nowrap me-3 mb-0">Filter By:</label>
														<select class="form-control select-style-1 filter-by" name="filter-by">
															<option value="all" selected>All</option>
															<option value="1">ID</option>
															<option value="2">Name</option>
															<option value="3">Phone</option>
															<option value="4">E-mail</option>
															<option value="5">Orders</option>
															<option value="6">Total Amount</option>
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
															<input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Search Customer">
															<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
														</div>
													</div>
												</div>
											</div>
										</div>
										<table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 750px;">
											<thead>
												<tr>
													<th width="3%"><input type="checkbox" name="select-all" class="select-all checkbox-style-1 p-relative top-2" value="" /></th>
													<th width="8%">ID</th>
													<th width="28%">Name</th>
													<th width="18%">Phone</th>
													<th width="25%">E-mail</th>
													<th width="8%">Orders</th>
													<th width="10%">Total Amount</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>191</strong></a></td>
													<td><a href="#"><strong>John Doe</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="f39c989f9681b3979c9e929a9ddd909c9e">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>192</strong></a></td>
													<td><a href="#"><strong>John Doe 2</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="27484c4b42556743484a464e490944484a">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>193</strong></a></td>
													<td><a href="#"><strong>John Doe 3</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="c4abafa8a1b684a0aba9a5adaaeaa7aba9">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>194</strong></a></td>
													<td><a href="#"><strong>John Doe 4</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="7a1511161f083a1e15171b131454191517">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>195</strong></a></td>
													<td><a href="#"><strong>John Doe 5</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="f09f9b9c9582b0949f9d91999ede939f9d">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>196</strong></a></td>
													<td><a href="#"><strong>John Doe 6</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="543b3f38312614303b39353d3a7a373b39">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>197</strong></a></td>
													<td><a href="#"><strong>John Doe 7</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="741b1f18110634101b19151d1a5a171b19">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>198</strong></a></td>
													<td><a href="#"><strong>John Doe 8</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="8de2e6e1e8ffcde9e2e0ece4e3a3eee2e0">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>199</strong></a></td>
													<td><a href="#"><strong>John Doe 9</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="0d626661687f4d6962606c6463236e6260">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>200</strong></a></td>
													<td><a href="#"><strong>John Doe 10</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d9b6b2b5bcab99bdb6b4b8b0b7f7bab6b4">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>201</strong></a></td>
													<td><a href="#"><strong>John Doe 11</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="ed828681889fad8982808c8483c38e8280">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>202</strong></a></td>
													<td><a href="#"><strong>John Doe 12</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="117e7a7d746351757e7c70787f3f727e7c">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>203</strong></a></td>
													<td><a href="#"><strong>John Doe 13</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="94fbfff8f1e6d4f0fbf9f5fdfabaf7fbf9">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>204</strong></a></td>
													<td><a href="#"><strong>John Doe 14</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="0a6561666f784a6e65676b636424696567">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>205</strong></a></td>
													<td><a href="#"><strong>John Doe 15</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="513e3a3d342311353e3c30383f7f323e3c">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
												</tr>
												<tr>
													<td width="30"><input type="checkbox" name="checkboxRow1" class="checkbox-style-1 p-relative top-2" value="" /></td>
													<td><a href="#"><strong>206</strong></a></td>
													<td><a href="#"><strong>John Doe 16</strong></a></td>
													<td>555-123-4567</td>
													<td><a href="https://www.okler.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="056a6e69607745616a68646c6b2b666a68">[email&#160;protected]</a></td>
													<td>1</td>
													<td>$198.00</td>
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
															<a href="#" class="bulk-action-apply btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Apply</a>
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