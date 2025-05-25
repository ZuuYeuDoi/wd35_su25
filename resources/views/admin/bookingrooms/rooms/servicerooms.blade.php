@extends('layouts.admin')
@section('title1', 'Dịch Vụ Phòng')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Danh sách dịch vụ phòng</h2>
    </header>

    <div class="row">
        <div class="col">
            <div class="card card-modern">
                <div class="card-body">
                    <div class="datatables-header-footer-wrapper">
                        <div class="datatable-header">
                            <div class="row align-items-center mb-3">
                                <div class="col-12 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
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
                                            <input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Tìm kiếm">
                                            <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-ecommerce-simple table-borderless table-striped mb-0" id="datatable-service-room" style="min-width: 640px;">
                            <thead>
                                <tr>
                                    <th width="5%">STT</th>
                                    <th width="25%">Tên dịch vụ</th>
                                    <th width="25%">Giá</th>
                                    <th width="25%">Phòng đang sử dụng</th>
                                    <th width="20%">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dữ liệu mẫu -->
                                <tr>
                                    <td>1</td>
                                    <td>Dịch vụ giặt là</td>
                                    <td>50.000đ</td>
                                    <td>Phòng 206 - Nguyễn Văn A</td>
                                    <td><span class="ecommerce-status completed">Đang hoạt động</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Đồ ăn sáng</td>
                                    <td>80.000đ</td>
                                    <td>Phòng 305 - Trần Thị B</td>
                                    <td><span class="ecommerce-status pending">Tạm ngưng</span></td>
                                </tr>
                            </tbody>
                        </table>

                        <hr class="solid mt-5 opacity-4">

                        <div class="datatable-footer">
                            <div class="row align-items-center justify-content-between mt-3">
                                <div class="col-lg-auto text-center">
                                    <div class="results-info-wrapper"></div>
                                </div>
                                <div class="col-lg-auto">
                                    <div class="pagination-wrapper"></div>
                                </div>
                            </div>
                        </div>

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
<script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/media/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/theme.init.js') }}"></script>
<script src="{{ asset('assets/js/examples/examples.ecommerce.datatables.list.js') }}"></script>
@endsection
