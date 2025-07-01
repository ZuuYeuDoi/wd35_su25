@extends('layouts.admin')

@section('title1', 'Hóa đơn tạm tính')

@section('content')
<section role="main" class="content-body">
    <header class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-6 mb-0">Hóa đơn tạm tính</h2>
    </header>

    <div class="card shadow rounded-4 p-4 mb-5">
        {{-- Thông tin khách hàng --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="fw-bold">Thông tin khách hàng</h5>
                <p class="mb-1"><strong>Tên:</strong> Nguyễn Văn A</p>
                <p class="mb-1"><strong>Số điện thoại:</strong> 0123456789</p>
                <p class="mb-1"><strong>Email:</strong> nguyenvana@example.com</p>
                <p class="mb-1"><strong>Địa chỉ:</strong> 123 Đường ABC, Quận XYZ, TP.HCM</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5 class="fw-bold">Chi tiết hóa đơn</h5>
                <p class="mb-1"><strong>Mã hóa đơn:</strong> HD001</p>
                <p class="mb-1"><strong>Ngày lập:</strong> 28/06/2025</p>
                <p class="mb-1"><strong>Trạng thái:</strong> Tạm tính</p>
            </div>
        </div>

        {{-- Bảng hóa đơn --}}
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Dịch vụ / Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dịch vụ A</td>
                        <td>2</td>
                        <td>500.000đ</td>
                        <td>1.000.000đ</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Dịch vụ B</td>
                        <td>1</td>
                        <td>300.000đ</td>
                        <td>300.000đ</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Tổng cộng</td>
                        <td class="fw-bold text-danger">1.300.000đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Box thêm dịch vụ --}}
    <div class="card shadow rounded-4 p-4 mb-5">
        <div class="row g-3 mb-4 text-center">
            {{-- Box 1 --}}
            <div class="col-md-2">
                <div class="card h-100 shadow-sm rounded-4 service-box position-relative" style="cursor:pointer;">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Đồ ăn nhanh</h6>
                        <p class="text-muted mb-2">150.000đ</p>
                        <button class="btn btn-primary btn-sm rounded-pill">Chọn</button>
                    </div>
                    <div class="quantity-box p-3 bg-light rounded-3 position-absolute w-100 bottom-0 start-0 d-none">
                        <h6 class="fw-bold mb-2">Đồ ăn nhanh</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <button class="btn btn-outline-secondary btn-sm minus">-</button>
                            <input type="number" class="form-control w-50 text-center mx-2" value="1" min="1">
                            <button class="btn btn-outline-secondary btn-sm plus">+</button>
                        </div>
                        <button class="btn btn-success btn-sm rounded-pill w-100">Xác nhận</button>
                    </div>
                </div>
            </div>

            {{-- Box 2 --}}
            <div class="col-md-2">
                <div class="card h-100 shadow-sm rounded-4 service-box position-relative" style="cursor:pointer;">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Đặt taxi</h6>
                        <p class="text-muted mb-2">50.000đ</p>
                        <button class="btn btn-primary btn-sm rounded-pill">Chọn</button>
                    </div>
                    <div class="quantity-box p-3 bg-light rounded-3 position-absolute w-100 bottom-0 start-0 d-none">
                        <h6 class="fw-bold mb-2">Đặt taxi</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <button class="btn btn-outline-secondary btn-sm minus">-</button>
                            <input type="number" class="form-control w-50 text-center mx-2" value="1" min="1">
                            <button class="btn btn-outline-secondary btn-sm plus">+</button>
                        </div>
                        <button class="btn btn-success btn-sm rounded-pill w-100">Xác nhận</button>
                    </div>
                </div>
            </div>

            {{-- Box 3 --}}
            <div class="col-md-2">
                <div class="card h-100 shadow-sm rounded-4 service-box position-relative" style="cursor:pointer;">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Giặt ủi</h6>
                        <p class="text-muted mb-2">80.000đ</p>
                        <button class="btn btn-primary btn-sm rounded-pill">Chọn</button>
                    </div>
                    <div class="quantity-box p-3 bg-light rounded-3 position-absolute w-100 bottom-0 start-0 d-none">
                        <h6 class="fw-bold mb-2">Giặt ủi</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <button class="btn btn-outline-secondary btn-sm minus">-</button>
                            <input type="number" class="form-control w-50 text-center mx-2" value="1" min="1">
                            <button class="btn btn-outline-secondary btn-sm plus">+</button>
                        </div>
                        <button class="btn btn-success btn-sm rounded-pill w-100">Xác nhận</button>
                    </div>
                </div>
            </div>

            {{-- Box 4 --}}
            <div class="col-md-2">
                <div class="card h-100 shadow-sm rounded-4 service-box position-relative" style="cursor:pointer;">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Gọi lễ tân</h6>
                        <p class="text-muted mb-2">Miễn phí</p>
                        <button class="btn btn-primary btn-sm rounded-pill">Chọn</button>
                    </div>
                    <div class="quantity-box p-3 bg-light rounded-3 position-absolute w-100 bottom-0 start-0 d-none">
                        <h6 class="fw-bold mb-2">Gọi lễ tân</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <button class="btn btn-outline-secondary btn-sm minus">-</button>
                            <input type="number" class="form-control w-50 text-center mx-2" value="1" min="1">
                            <button class="btn btn-outline-secondary btn-sm plus">+</button>
                        </div>
                        <button class="btn btn-success btn-sm rounded-pill w-100">Xác nhận</button>
                    </div>
                </div>
            </div>

            {{-- Box 5 --}}
            <div class="col-md-2">
                <div class="card h-100 shadow-sm rounded-4 service-box position-relative" style="cursor:pointer;">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Dọn phòng</h6>
                        <p class="text-muted mb-2">200.000đ</p>
                        <button class="btn btn-primary btn-sm rounded-pill">Chọn</button>
                    </div>
                    <div class="quantity-box p-3 bg-light rounded-3 position-absolute w-100 bottom-0 start-0 d-none">
                        <h6 class="fw-bold mb-2">Dọn phòng</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <button class="btn btn-outline-secondary btn-sm minus">-</button>
                            <input type="number" class="form-control w-50 text-center mx-2" value="1" min="1">
                            <button class="btn btn-outline-secondary btn-sm plus">+</button>
                        </div>
                        <button class="btn btn-success btn-sm rounded-pill w-100">Xác nhận</button>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card h-100 shadow-sm rounded-4 service-box position-relative" style="cursor:pointer;">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Dọn phòng</h6>
                        <p class="text-muted mb-2">200.000đ</p>
                        <button class="btn btn-primary btn-sm rounded-pill">Chọn</button>
                    </div>
                    <div class="quantity-box p-3 bg-light rounded-3 position-absolute w-100 bottom-0 start-0 d-none">
                        <h6 class="fw-bold mb-2">Dọn phòng</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <button class="btn btn-outline-secondary btn-sm minus">-</button>
                            <input type="number" class="form-control w-50 text-center mx-2" value="1" min="1">
                            <button class="btn btn-outline-secondary btn-sm plus">+</button>
                        </div>
                        <button class="btn btn-success btn-sm rounded-pill w-100">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="alert alert-info rounded-3">
        Đây là hóa đơn tạm tính, chưa phải hóa đơn xuất chính thức. Mọi thông tin sẽ được xác nhận khi thanh toán.
    </div>
    <div class="text-end">
        <a href="#" class="btn btn-primary rounded-pill px-4">Xác nhận & Thanh toán</a>
    </div>
</section>


@endsection

@section('script')
{{-- script nhỏ để demo mở box + cộng trừ số lượng --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const boxes = document.querySelectorAll('.service-box');
        boxes.forEach(box => {
            box.querySelector('.btn-primary').addEventListener('click', () => {
                // đóng hết các box khác
                document.querySelectorAll('.quantity-box').forEach(q => q.classList.add('d-none'));
                box.querySelector('.quantity-box').classList.remove('d-none');
            });

            box.querySelector('.plus').addEventListener('click', () => {
                const input = box.querySelector('input');
                input.value = parseInt(input.value) + 1;
            });

            box.querySelector('.minus').addEventListener('click', () => {
                const input = box.querySelector('input');
                if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
            });
        });
    });
</script>
@endsection