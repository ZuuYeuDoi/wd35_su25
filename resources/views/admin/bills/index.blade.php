@extends('layouts.admin')
@section('title1', 'Danh sách hóa đơn')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Danh sách hóa đơn</h2>
    </header>


    <div class="row">
        <div class="col">
            <div class="card card-modern">
                <div class="card-body">
                    <!-- Bộ lọc nâng cao -->
                    <form action="{{ route('bills.index') }}" method="GET" class="row g-3 align-items-end mb-4">

                        <!-- Tìm theo tên khách hàng -->
                        <div class="col-md-auto">
                            <label for="customer_name" class="form-label fw-bold">Tên khách hàng</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control"
                                value="{{ request('customer_name') }}" placeholder="Nhập tên...">
                        </div>

                        <!-- Tìm theo số điện thoại -->
                        <div class="col-md-auto">
                            <label for="customer_phone" class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="customer_phone" id="customer_phone" class="form-control"
                                value="{{ request('customer_phone') }}" placeholder="Nhập SĐT...">
                        </div>

                           <!-- Tìm theo cccd -->
                        <div class="col-md-auto">
                            <label for="customer_cccd" class="form-label fw-bold">CCCD</label>
                            <input type="text" name="customer_cccd" id="customer_cccd" class="form-control"
                                value="{{ request('customer_cccd') }}" placeholder="Nhập CCCD...">
                        </div>

                        <!-- Lọc trạng thái -->
                        <div class="col-md-auto">
                            <label for="status" class="form-label fw-bold">Trạng thái</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">-- Tất cả --</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã huỷ</option>
                            </select>
                        </div>

                        <!-- Lọc theo ngày thanh toán -->
                        <div class="col-md-auto">
                            <label for="payment_date" class="form-label fw-bold">Ngày thanh toán</label>
                            <input type="date" name="payment_date" id="payment_date" class="form-control"
                                value="{{ request('payment_date') }}">
                        </div>

                        <!-- Nút tìm kiếm và reset -->
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <a href="{{ route('bills.index') }}" class="btn btn-outline-secondary">Xoá lọc</a>
                        </div>
                    </form>
                    <table class="table table-ecommerce-simple table-borderless table-striped mb-0"
                        id="datatable-ecommerce-list" style="min-width: 720px;">
                        <thead>
                            <tr>
                                <th>Mã HĐ</th>
                                <th>CCCD</th>
                                <th>Khách hàng</th>
                                <th>SĐT</th>
                                <th>Ngày thanh toán</th>
                                <th>Thành tiền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bills as $bill)
                            <tr>
                                <td><strong>{{ $bill->bill_code }}</strong></td>
                                <td>{{ $bill->customer_cccd }}</td>
                                <td>{{ $bill->customer_name }}</td>
                                <td>{{ $bill->customer_phone }}</td>
                                <td>
                                    {{ $bill->payment_date ? \Carbon\Carbon::parse($bill->payment_date)->format('d/m/Y') : '---' }}
                                </td>
                                <td>{{ number_format($bill->final_amount, 0, ',', '.') }}đ</td>
                                <td>
                                    @php
                                    $statusClass = [
                                    'pending' => 'warning',
                                    'paid' => 'success',
                                    'cancelled' => 'danger'
                                    ];
                                    @endphp

                                    <span class="badge bg-{{ $statusClass[$bill->status] ?? 'secondary' }}">
                                        {{ match($bill->status) {
                                            'pending' => 'Chờ xử lý',
                                            'paid' => 'Đã thanh toán',
                                            'cancelled' => 'Đã huỷ',
                                            default => 'Không xác định'
                                        } }}
                                    </span>
                                </td>

                                <td class="d-flex flex-column gap-1">
                                    <a href="{{ route('bills.show', $bill->id) }}"
                                        class="btn btn-sm btn-warning">Chi tiết</a>
                                    {{-- Thêm nút khác nếu cần, ví dụ: --}}
                                    {{-- <a href="#" class="btn btn-sm btn-success">In hóa đơn</a> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có hóa đơn nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $bills->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection