<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Cimora Hotel</title>
    <link rel="stylesheet" href="{{ asset('/client/css/auth.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="form-box">
                <h2>Đăng nhập</h2>
                @if (session('success'))
                    <div class="alert alert-success" style="color: green; margin-bottom: 10px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <div class="input-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <div class="invalid-feedback">
                                <span style="color: red">{{ $message }}</span>
                            </div>
                        @enderror
                        <label for="email">Email</label>
                    </div>
                    <div class="input-group">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">
                                <span style="color: red">{{ $message }}</span>
                            </div>
                        @enderror
                        <label for="password">Mật khẩu</label>
                    </div>
                    <div class="remember-forgot">
                        <label class="form-check-label" for="remember">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            Ghi nhớ đăng nhập
                        </label>

                    </div>
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn">Đăng nhập</button>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                        @endif
                    </div>
                </form>
                <p class="switch-form">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
