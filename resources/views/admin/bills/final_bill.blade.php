@extends('layouts.admin')
@section('title1', 'Hóa đơn chính thức')
@section('content')
<section role="main" class="content-body">
    <header class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-6 mb-0">Hóa đơn chính thức</h2>
    </header>


   <div class="card-body">
    <div class="invoice">
        <header class="clearfix">
            <div class="row">
                <div class="col-sm-6 mt-3">
                    <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">HÓA ĐƠN</h2>
                    <h4 class="h4 m-0 text-dark font-weight-bold">#76598345</h4>
                </div>
                <div class="col-sm-6 text-end mt-3 mb-3">
                    <address class="ib me-5">
                        Khách sạn ABC
                        <br />
                        123 Đường Nguyễn Trãi, TP Hà Nội
                        <br />
                        Điện thoại: 0123 456 789
                        <br />
                        <a href="mailto:info@khachsanabc.vn">info@khachsanabc.vn</a>
                    </address>
                    <div class="ib">
                        <img src="img/invoice-logo.png" alt="Hotel Logo" />
                    </div>
                </div>
            </div>
        </header>
        <div class="bill-info">
            <div class="row">
                <div class="col-md-6">
                    <div class="bill-to">
                        <p class="h5 mb-1 text-dark font-weight-semibold">Khách hàng:</p>
                        <address>
                            Nguyễn Văn A
                            <br />
                            121 Phố Huế, Hai Bà Trưng, Hà Nội
                            <br />
                            Điện thoại: 0987 654 321
                            <br />
                            <a href="mailto:nguyenvana@example.com">nguyenvana@example.com</a>
                        </address>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bill-data text-end">
                        <p class="mb-0">
                            <span class="text-dark">Ngày xuất hóa đơn:</span>
                            <span class="value">28/06/2025</span>
                        </p>
                        <p class="mb-0">
                            <span class="text-dark">Hạn thanh toán:</span>
                            <span class="value">28/06/2025</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-responsive-md invoice-items">
            <thead>
                <tr class="text-dark">
                    <th class="font-weight-semibold">#</th>
                    <th class="font-weight-semibold">Dịch vụ / Sản phẩm</th>
                    <th class="font-weight-semibold">Mô tả</th>
                    <th class="text-center font-weight-semibold">Đơn giá</th>
                    <th class="text-center font-weight-semibold">Số lượng</th>
                    <th class="text-center font-weight-semibold">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="font-weight-semibold text-dark">Thuê phòng</td>
                    <td>Phòng tiêu chuẩn</td>
                    <td class="text-center">1.200.000đ</td>
                    <td class="text-center">2 đêm</td>
                    <td class="text-center">2.400.000đ</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="font-weight-semibold text-dark">Dịch vụ giặt ủi</td>
                    <td>3 bộ quần áo</td>
                    <td class="text-center">80.000đ</td>
                    <td class="text-center">3</td>
                    <td class="text-center">240.000đ</td>
                </tr>
            </tbody>
        </table>
        <div class="invoice-summary">
            <div class="row justify-content-end">
                <div class="col-sm-4">
                    <table class="table h6 text-dark">
                        <tbody>
                            <tr>
                                <td colspan="2">Tạm tính</td>
                                <td class="text-start">2.640.000đ</td>
                            </tr>
                            <tr>
                                <td colspan="2">Thuế VAT (10%)</td>
                                <td class="text-start">264.000đ</td>
                            </tr>
                            <tr class="h4">
                                <td colspan="2">Tổng cộng</td>
                                <td class="text-start">2.904.000đ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="d-grid gap-3 d-md-flex justify-content-md-end me-4">
        <a href="#" class="btn btn-secondary">Xác nhận hóa đơn</a>
        <a href="pages-invoice-print.html" target="_blank" class="btn btn-primary ms-3"><i class="fas fa-print"></i> In hóa đơn</a>
    </div>
</div>

</section>
@endsection