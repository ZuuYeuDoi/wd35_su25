<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Cimora Hotel</title>
    <link rel="stylesheet" href="{{ asset('/client/css/auth.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-box">
                <h2>Quên mật khẩu</h2>

                @if (session('status'))
                    <div class="alert alert-success" style="margin-bottom: 15px; color: green; text-align: center;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="input-group">
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <label for="email">Email</label>

                        @error('email')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div style="text-align: center; margin-top: 20px;">
                        <button type="submit" class="btn">Gửi liên kết đặt lại mật khẩu</button>
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
