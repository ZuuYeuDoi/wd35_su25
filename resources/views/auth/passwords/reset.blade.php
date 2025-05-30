<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - Cimora Hotel</title>
    <link rel="stylesheet" href="{{ asset('/client/css/auth.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-box">
                <h2>Đặt lại mật khẩu</h2>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group">
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        <label for="email">Email</label>

                        @error('email')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">
                        <label for="password">Mật khẩu mới</label>

                        @error('password')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password">
                        <label for="password-confirm">Xác nhận mật khẩu</label>
                    </div>

                    <div style="text-align: center; margin-top: 20px;">
                        <button type="submit" class="btn">Đặt lại mật khẩu</button>
                    </div>
                </form>

                <p class="switch-form">
                    <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Quay lại đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
