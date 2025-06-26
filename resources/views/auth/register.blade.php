<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Cimora Hotel</title>
    <link rel="stylesheet" href="{{ asset('/client/css/auth.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="form-box">
                <h2>Đăng ký</h2>
                <form id="registerForm" method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <div class="input-group">

                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                <span style="color: red">{{ $message }}</span>
                            </div>
                        @enderror
                        <label for="name" class="form-label">Họ Tên</label>
                    </div>

                    <div class="input-group">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                            name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                        @error('phone')
                            <div class="invalid-feedback">
                                <span style="color: red">{{ $message }}</span>
                            </div>
                        @enderror
                        <label for="phone" class="form-label">Số điện thoại</label>
                    </div>

                    <div class="input-group">
                        <input id="cccd" type="text" class="form-control  is-invalid"
                            name="cccd" value="{{ old('cccd') }}" required autocomplete="cccd">
                        <label for="cccd" class="form-label">Số căn cước công dân</label>
                    </div>

                    <div class="input-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">
                                <span style="color: red">{{ $message }}</span>
                            </div>
                        @enderror
                        <label for="email" class="form-label">Email</label>
                    </div>

                    <div class="input-group">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">
                                <span style="color: red">{{ $message }}</span>
                            </div>
                        @enderror
                        <label for="password" class="form-label">Mật khẩu</label>
                    </div>

                    <div class="input-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                        <label for="password-confirm" class="form-label">Xác nhận mật khẩu</label>
                    </div>
                    <button type="submit" class="btn">Đăng ký</button>
                </form>
                <p class="switch-form">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
