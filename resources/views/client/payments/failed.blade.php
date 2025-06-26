<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán thất bại</title>
    <meta http-equiv="refresh" content="5;url={{ url('/') }}">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #ffebee, #ffffff);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            animation: fadeIn 1s ease-in;
        }

        .error-box {
            text-align: center;
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            animation: shake 0.5s;
        }

        .error-icon {
            font-size: 60px;
            color: #f44336;
        }

        h1 {
            color: #333;
            margin-top: 20px;
        }

        p {
            color: #666;
        }

        .home-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #f44336;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .home-link:hover {
            background: #d32f2f;
        }

        @keyframes shake {
            0% { transform: translateX(-5px); }
            25% { transform: translateX(5px); }
            50% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="error-box">
        <div class="error-icon">❌</div>
        <h1>Thanh toán thất bại!</h1>
        <p>Đã có lỗi trong quá trình thanh toán. Vui lòng thử lại.</p>
        <p>Đang chuyển về trang chủ trong 5 giây...</p>
        <a class="home-link" href="{{ url('/') }}">Quay về ngay</a>
    </div>
</body>
</html>
