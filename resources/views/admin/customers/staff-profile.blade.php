@extends('layouts.admin')
@section('title1', 'Thông tin cá nhân')
@section('content')
    <section role="main" class="content-body content-body-modern mt-0">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Thông tin cá nhân</h2>
        </header>
        <!-- start: page -->
        <div class="row">
            <div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
                <section class="card">
                    <div class="card-body">
                        <div class="thumb-info mb-3">
                            <img src="{{ asset('assets/img/%21logged-user.jpg') }}" class="rounded img-fluid" alt="John Doe">
                            <div class="thumb-info-title">
                                <span class="thumb-info-inner">{{ $user->name }}</span>
                                <span class="thumb-info-type">Chủ tịch</span>
                            </div>
                        </div>
                        <hr class="dotted short">
                        <h5 class="mb-2 mt-3">Giới thiệu</h5>
                        <p class="text-2">
                            Quản trị viên hệ thống tại khách sạn – chuyên theo dõi hoạt động đặt phòng, hỗ trợ khách hàng và
                            đảm bảo hệ thống luôn vận hành ổn định. Luôn sẵn sàng hỗ trợ đội ngũ và tối ưu trải nghiệm khách
                            hàng!
                        </p>

                        <hr class="dotted short">
                        <div class="social-icons-list">
                            <a rel="tooltip" data-bs-placement="bottom" target="_blank" href="http://www.facebook.com/"
                                data-original-title="Facebook"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
                            <a rel="tooltip" data-bs-placement="bottom" href="http://www.twitter.com/"
                                data-original-title="Twitter"><i class="fab fa-twitter"></i><span>Twitter</span></a>
                            <a rel="tooltip" data-bs-placement="bottom" href="http://www.linkedin.com/"
                                data-original-title="Linkedin"><i class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
                        </div>
                    </div>
                </section>

            </div>
            <div class="col-lg-8 col-xl-6">
                <div class="tabs">
                    <form class="profile-form" method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        <h4 class="mb-3 font-weight-semibold text-dark">Thông tin</h4>

                        <div class="row mb-4">
                            <div class="form-group col">
                                <label for="inputName">Họ tên</label>
                                <input type="text" name="name" class="form-control" id="inputName"
                                    value="{{ old('name', $user->name) }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="form-group col">
                                <label for="inputEmail">Email</label>
                                <input type="email" name="email" class="form-control" id="inputEmail"
                                    value="{{ $user->email }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="form-group col">
                                <label for="inputPhone">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" id="inputPhone"
                                    value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="form-group col">
                                <label for="inputCCCD">CCCD</label>
                                <input type="text" name="cccd" class="form-control" id="inputCCCD"
                                    value="{{ old('cccd', $user->cccd ?? '---') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <a href="javascript:void(0)" id="toggle-password-fields" style="color: blue">
                                Đổi mật khẩu
                            </a>
                        </div>

                        {{-- Trường mật khẩu ẩn mặc định --}}
                        <div id="password-fields" style="display: none;">
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <label for="currentPassword">Mật khẩu hiện tại</label>
                                    <input type="password" name="current_password" class="form-control"
                                        id="currentPassword">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newPassword">Mật khẩu mới</label>
                                        <input type="password" name="password" class="form-control" id="newPassword">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirmPassword">Xác nhận mật khẩu</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="confirmPassword">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-end mt-3">
                                <button class="btn btn-success" type="submit" id="submit-btn"
                                    style="display: none;">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-3">
                <h4 class="mb-3 mt-0 font-weight-semibold text-dark">🎖️ Thành tích cá nhân</h4>

                <ul class="simple-card-list mb-3">
                    <li class="success">
                        <h3 class="mb-0">32</h3>
                        <p class="text-light mb-0">Bài viết đã đăng</p>
                    </li>
                    <li class="info">
                        <h3 class="mb-0">145</h3>
                        <p class="text-light mb-0">Lượt đánh giá 5⭐</p>
                    </li>
                    <li class="warning">
                        <h3 class="mb-0">6</h3>
                        <p class="text-light mb-0">Sự kiện đã tổ chức</p>
                    </li>
                </ul>
            </div>
        </div>
        <!-- end: page -->
    </section>
@endsection

@section('head')

@endsection
@push('js')
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
