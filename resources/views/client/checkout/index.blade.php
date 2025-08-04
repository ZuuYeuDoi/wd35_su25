@extends('client.index')

@section('content')
<section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
    <div class="auto-container text-center">
        <h1 class="title">Xác nhận đặt phòng</h1>
    </div>
</section>

<section class="pt-70 pb-120">
    <div class="container">
        <form action="{{ route('booking.cart.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h3>Thông tin khách hàng</h3>
                    <div class="border p-3 mb-3 bg-light rounded">
                        <p><strong>Họ tên:</strong> {{ $user->name }}</p>
                        <p><strong>Điện thoại:</strong> {{ $user->phone }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label>Ngày nhận</label>
                            <input type="date" class="form-control" readonly value="{{ $checkIn }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Ngày trả</label>
                            <input type="date" class="form-control" readonly value="{{ $checkOut }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label>Tổng người lớn</label>
                            <input type="number" class="form-control" readonly value="{{ $totalAdults }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Tổng trẻ em</label>
                            <input type="number" class="form-control" readonly value="{{ $totalChildren }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h3>Danh sách phòng</h3>
                    @foreach($summary as $item)
                        <div class="border p-2 mb-2 rounded bg-white">
                            <strong>{{ $item['room_type']->name }}</strong> - {{ $item['qty'] }} phòng<br>
                            {{-- {{ $item['check_in'] }} → {{ $item['check_out'] }} | --}}
                            {{ number_format($item['sub_total'], 0, ',', '.') }} VND
                        </div>
                    @endforeach

                    <div class="p-3 border rounded bg-light mt-3">
                        <div>Tổng tiền phòng: <strong>{{ number_format($total, 0, ',', '.') }} VND</strong></div>
                        <div>Tiền cọc (10%): <strong class="text-danger">{{ number_format($deposit, 0, ',', '.') }} VND</strong></div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">Thanh toán</button>
            </div>
        </form>
    </div>
</section>
@endsection
