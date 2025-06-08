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
                            <h2 class="card-title">Thông tin chung</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col mb-3">
                                    <label>Trạng thái</label>
                                    <select class="form-control form-control-modern" name="orderStatus" required>
                                        <option value="on-hold" selected>Chờ xử lý</option>
                                        <option value="pending">Chờ thanh toán</option>
                                        <option value="processing">Đang xử lý</option>
                                        <option value="completed">Hoàn tất</option>
                                        <option value="cancelled">Đã hủy</option>
                                        <option value="refunded">Hoàn tiền</option>
                                        <option value="failed">Thất bại</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col mb-3">
                                    <label>Ngày tạo</label>
                                    <div class="date-time-field">
                                        <div class="date">
                                            <input type="text" class="form-control form-control-modern" name="orderDate"
                                                value="2019-11-21" required data-plugin-datepicker
                                                data-plugin-options='{"orientation": "bottom", "format": "yyyy-mm-dd"}' />
                                        </div>
                                        <div class="time">
                                            <span class="px-2">@</span>
                                            <input type="text" class="form-control form-control-modern text-center"
                                                name="orderTimeHour" value="10" required />
                                            <span class="px-2">:</span>
                                            <input type="text" class="form-control form-control-modern text-center"
                                                name="orderTimeMin" value="28" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col mb-3">
                                    <label>Khách hàng</label>
                                    <select class="form-control form-control-modern" name="orderCustomer" required
                                        data-plugin-selectTwo>
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
                            <h2 class="card-title">Địa chỉ</h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-auto me-xl-5 pe-xl-5 mb-4 mb-xl-0">
                                    <h3 class="text-color-dark font-weight-bold text-4 line-height-1 mt-0 mb-3">HÓA ĐƠN</h3>
                                    <ul class="list list-unstyled list-item-bottom-space-0">
                                        <li>Đường ví dụ</li>
                                        <li>1234</li>
                                        <li>Hà Nội</li>
                                        <li>Việt Nam</li>
                                        <li>100000</li>
                                    </ul>
                                    <strong class="d-block text-color-dark">Email:</strong>
                                    <a href="#"><span>[email&#160;được bảo vệ]</span></a>
                                    <strong class="d-block text-color-dark mt-3">Điện thoại:</strong>
                                    <a href="tel:+84123456789" class="text-color-dark">0123 456 789</a>
                                </div>
                                <div class="col-xl-auto ps-xl-5">
                                    <h3 class="font-weight-bold text-color-dark text-4 line-height-1 mt-0 mb-3">NHẬN PHÒNG
                                    </h3>
                                    <ul class="list list-unstyled list-item-bottom-space-0">
                                        <li>Đường ví dụ</li>
                                        <li>1234</li>
                                        <li>Hà Nội</li>
                                        <li>Việt Nam</li>
                                        <li>100000</li>
                                    </ul>
                                    <strong class="d-block text-color-dark">Email:</strong>
                                    <a href="#"><span>[email&#160;được bảo vệ]</span></a>
                                    <strong class="d-block text-color-dark mt-3">Điện thoại:</strong>
                                    <a href="tel:+84123456789" class="text-color-dark">0123 456 789</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm/Phòng -->
            <div class="row">
                <div class="col">
                    <div class="card card-modern">
                        <div class="card-header">
                            <h2 class="card-title">Danh sách phòng</h2>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-ecommerce-simple table-ecommerce-simple-border-bottom table-borderless table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th width="8%" class="ps-4">ID</th>
                                            <th width="65%">Tên phòng</th>
                                            <th width="5%" class="text-end">Giá</th>
                                            <th width="7%" class="text-end">Số lượng</th>
                                            <th width="5%" class="text-end">Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-4"><a href="#"><strong>101</strong></a></td>
                                            <td><a href="#"><strong>Phòng Đơn</strong></a></td>
                                            <td class="text-end">500,000đ</td>
                                            <td class="text-end">1</td>
                                            <td class="text-end">500,000đ</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4"><a href="#"><strong>102</strong></a></td>
                                            <td><a href="#"><strong>Phòng Đôi</strong></a></td>
                                            <td class="text-end">700,000đ</td>
                                            <td class="text-end">1</td>
                                            <td class="text-end">700,000đ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tổng tiền -->
                            <div class="row justify-content-end flex-column flex-lg-row my-3">
                                <div class="col-auto me-5">
                                    <h3 class="font-weight-bold text-color-dark text-4 mb-3">Tạm tính</h3>
                                    <span class="d-flex align-items-center">
                                        2 phòng
                                        <i class="fas fa-chevron-right text-color-primary px-3"></i>
                                        <b class="text-color-dark text-xxs">1,200,000đ</b>
                                    </span>
                                </div>
                                <div class="col-auto me-5">
                                    <h3 class="font-weight-bold text-color-dark text-4 mb-3">Phí dịch vụ</h3>
                                    <span class="d-flex align-items-center">
                                        --
                                        <i class="fas fa-chevron-right text-color-primary px-3"></i>
                                        <b class="text-color-dark text-xxs">0đ</b>
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <h3 class="font-weight-bold text-color-dark text-4 mb-3">Tổng cộng</h3>
                                    <span class="d-flex align-items-center justify-content-lg-end">
                                        <strong class="text-color-dark text-5">1,200,000đ</strong>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Ghi chú -->
            <div class="row">
                <div class="col">
                    <div class="card card-modern">
                        <div class="card-header">
                            <h2 class="card-title">Ghi chú hóa đơn</h2>
                        </div>
                        <div class="card-body">
                            <div class="ecommerce-timeline mb-3">
                                <div class="ecommerce-timeline-items-wrapper">
                                    <div class="ecommerce-timeline-item">
                                        <small>Được thêm ngày 26/06/2020 lúc 4:01 chiều bởi admin - <a href="#"
                                                class="text-color-danger">Xóa ghi chú</a></small>
                                        <p>Khách hàng yêu cầu phòng có cửa sổ hướng ra phố.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col pb-1 mb-3">
                                    <label>Thêm ghi chú</label>
                                    <textarea class="form-control form-control-modern" name="orderAddNote" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <a href="#"
                                        class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Thêm
                                        ghi chú</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút hành động -->
            <div class="row action-buttons">
                <div class="col-12 col-md-auto">
                    <button type="submit"
                        class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                        <i class="bx bx-save text-4 me-2"></i> Lưu hóa đơn
                    </button>
                </div>
                <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                    <a href="/admin/bookingrooms/order"
                        class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Hủy</a>
                </div>
                <div class="col-12 col-md-auto ms-md-auto mt-3 mt-md-0 ms-auto">
                    <a href="/admin/bookingrooms/order"
                        class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                        <i class="bx bx-trash text-4 me-2"></i> Xóa hóa đơn
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
