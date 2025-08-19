@extends('client.index')

@push('css')
    <link rel="stylesheet" href="{{ asset('client/css/account.css') }}">
@endpush

@section('content')
    <section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">Thông tin tài khoản</h1>
            </div>
        </div>
    </section>

    <div class="container d-flex gap-4 mt-4">
        <div class="sidebar">
            <div class="user-info text-center">
                <div class="avatar mb-2">
                    <img src="{{ asset('client/images/default-avatar.png') }}" alt="Avatar">
                </div>
                <h3 class="user-name">{{ $user->name }}</h3>
                <p class="user-email">{{ $user->email }}</p>
            </div>
            <nav class="menu mt-4">
                <a href="#profile" class="menu-item active"><i class="fas fa-user"></i> Thông tin cá nhân</a>
                <a href="#bookings" class="menu-item"><i class="fas fa-bed"></i> Đơn đã đặt</a>
                {{-- <a href="#services" class="menu-item"><i class="fas fa-concierge-bell"></i> Dịch vụ đã đặt</a>
                {{-- <a href="#foods" class="menu-item"><i class="fas fa-utensils"></i> Đồ ăn đã đặt</a> --}}
            </nav>
        </div>

        <div class="main-content flex-grow-1">

            <!-- Thông tin cá nhân -->
            <section id="profile" class="content-section active">
                <h2>Thông tin cá nhân</h2>
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="profile-form mt-4" method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="form-group">
                        <label>CCCD</label>
                        <input type="text" name="cccd" value="{{ old('cccd', $user->cccd ?? '---') }}">
                    </div>
                    <!--link bật đổi mật khẩu -->
                    <div class="form-group">
                        <a href="javascript:void(0)" id="toggle-password-fields" style="color: blue">
                            Đổi mật khẩu
                        </a>
                    </div>

                    <!-- Form đổi mật khẩu (ẩn mặc định) -->
                    <div id="password-fields" style="display: none;">
                        <div class="form-group">
                            <label for="current_password">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn-save" id="submit-btn" style="display: none;">
                        Lưu thay đổi
                    </button>
                </form>

            </section>

            <!-- Phòng đã đặt -->
            <section id="bookings" class="content-section">
                <h2 class="mb-4">Phòng đã đặt</h2>

                @forelse ($bookings as $booking)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <span>
                                Mã booking: <strong>{{ $booking->booking_code }}</strong><br>
                                <small>
                                    Check-in: 14h {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                                    →
                                    Check-out: 12h {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}
                                </small>
                            </span>
                        </div>

                        {{-- Kiểm tra xem booking này có phòng không --}}
                        @if ($booking->bookingRooms->isEmpty())
                            <div class="card-body">
                                <p>Booking này chưa có phòng nào.</p>
                            </div>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($booking->bookingRooms as $br)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">

                                            <div class="col">
                                                <h6 class="mb-1">{{ $br->room->title ?? '---' }} - {{ $br->room->roomType->type ?? '---' }}</h6>
                                                <small>Giá: {{ number_format($br->price, 0, ',', '.') }}đ / đêm</small>
                                            </div>
                                        </div>
                                        <a href="{{ route('user.booking.detail', $booking->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Xem chi tiết
                                        </a>
                                        <a href="{{ route('room.detail', $br->room->id) }}#review"
                                            class="btn btn-sm btn-warning ms-2 text-white">
                                            <i class="fas fa-star"></i> Bình luận & Đánh giá
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @empty
                    <p>Bạn chưa đặt phòng nào.</p>
                @endforelse
            </section>

            {{-- ========= DỊCH VỤ ĐÃ ĐẶT ========= --}}
            {{-- <section id="services" class="content-section mt-5">
            <h2 class="mb-4">Dịch vụ đã đặt</h2>

            @forelse ($serviceItems as $item)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-1">{{ $item->service->name }}</h5>
                            <small class="text-muted">
                                Đặt lúc:{{ \Carbon\Carbon::parse($item->created_at)->format('H:i d/m/Y') }}
                            </small>
                        </div>
                        <div class="text-end">
                            <p class="mb-1 fw-semibold">
                                {{ number_format($item->service->price, 0, ',', '.') }}đ
                            </p>
                            <span class="badge bg-info">{{ ucfirst($item->status) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p>Bạn chưa đặt dịch vụ nào.</p>
            @endforelse
        </section> --}}

            {{-- ========= ĐỒ ĂN ĐÃ ĐẶT ========= --}}
            {{-- <section id="foods" class="content-section mt-5">
            <h2 class="mb-4">Đồ ăn đã đặt</h2>

            @forelse ($foodItems as $item)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-1">{{ $item->service->name }}</h5>
                            <small>Số lượng: {{ $item->quantity }}</small><br>
                            <small>Ghi chú: {{ $item->note ?? '(Không có)' }}</small>
                        </div>
                        <div class="text-end">
                            <p class="mb-1 fw-semibold">
                                {{ number_format($item->service->price, 0, ',', '.') }}đ
                            </p>
                            <span class="badge bg-warning text-dark">
                                Đặt lúc: {{ $item->created_at->format('H:i d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <p>Bạn chưa đặt món ăn nào.</p>
            @endforelse
        </section> --}}
        </div>
    </div>
@endsection


@push('js')
    <script src="{{ asset('client/js/account.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-password-fields');
            const fields = document.getElementById('password-fields');
            let isVisible = false;

            toggleBtn.addEventListener('click', function() {
                isVisible = !isVisible;
                fields.style.display = isVisible ? 'block' : 'none';
                toggleBtn.innerText = isVisible ? 'Hủy đổi mật khẩu' : 'Đổi mật khẩu';
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.profile-form');
            const submitBtn = document.getElementById('submit-btn');

            if (!form || !submitBtn) return;

            const initialData = new FormData(form);

            const checkShouldShowButton = () => {
                const currentData = new FormData(form);
                let isChanged = false;
                let hasEmptyField = false;

                for (let [key, value] of currentData.entries()) {
                    const originalValue = initialData.get(key) ?? '';
                    const currentValue = value.trim();

                    // Nếu có sự thay đổi
                    if (currentValue !== originalValue) {
                        isChanged = true;
                    }

                    // Nếu input không phải là mật khẩu và bị bỏ trống
                    if (
                        key !== 'password' &&
                        key !== 'password_confirmation' &&
                        key !== 'current_password' &&
                        currentValue === ''
                    ) {
                        hasEmptyField = true;
                    }
                }

                // Chỉ hiện nút nếu có thay đổi và không có ô bắt buộc nào rỗng
                submitBtn.style.display = (isChanged && !hasEmptyField) ? 'inline-block' : 'none';
            };

            form.querySelectorAll('input, textarea, select').forEach(input => {
                input.addEventListener('input', checkShouldShowButton);
            });
        });
    </script>
@endpush
