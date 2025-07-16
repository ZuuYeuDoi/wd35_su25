@extends('layouts.admin')

@section('title1', 'Quản lý Bình luận')

@section('content')
<section role="main" class="content-body content-body-modern mt-0">
    <header class="page-header">
        <h2 class="font-weight-bold text-6">Quản lý Bình luận</h2>
    </header>

    <div class="row">
        <div class="col">
            <div class="card card-modern">
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="GET" action="{{ route('admin.comment.index') }}" class="mb-4">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label">Tìm kiếm (Tên khách hoặc phòng)</label>
                                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nhập từ khoá...">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Số sao</label>
                                    <select name="rating" class="form-control">
                                        <option value="">-- Tất cả --</option>
                                        @for ($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} ★</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Ngày bình luận</label>
                                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-primary w-50">Lọc</button>
                                    <a href="{{ route('admin.comment.index') }}" class="btn btn-secondary w-50">Làm mới</a>
                                </div>
                            </div>
                        </form>

                        <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Tên phòng</th>
                                    <th>Số sao</th>
                                    <th>Bình luận</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>{{ $review->user->name ?? 'Ẩn danh' }}</td>
                                    <td>{{ $review->room->title ?? 'Không rõ' }}</td>
                                    <td>{{ $review->rating }} ★</td>
                                    <td>{{ $review->comment }}</td>
                                    <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                       <form action="{{ route('admin.comment.toggle', $review->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            @if(!$review->status)
                                                <button class="btn btn-success btn-sm" title="Hiện lại bình luận">Hiện</button>
                                            @else
                                                <button class="btn btn-warning btn-sm" title="Ẩn bình luận">Ẩn</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
<script src="{{ asset('assets/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#datatable-ecommerce-list').DataTable({
            "language": {
                "search": "Tìm kiếm:",
                "lengthMenu": "Hiển thị _MENU_ bản ghi",
                "zeroRecords": "Không tìm thấy bình luận nào",
                "info": "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "→",
                    "previous": "←"
                }
            }
        });
    });
</script>
@endsection
