<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán thành công</title>
  <meta http-equiv="refresh" content="2;url={{ url('/') }}">
  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
    }

    .success-icon {
      font-size: 80px; /* to hơn */
      color: #4CAF50;
      margin-bottom: 25px;
    }

    h1 {
      font-size: 28px; /* to hơn */
      color: #4CAF50;
      margin-bottom: 15px;
      font-weight: 700;
    }

    p {
      font-size: 18px; /* to hơn */
      color: #333;
      margin: 8px 0;
    }

    .btn {
      display: inline-block;
      margin-top: 25px;
      padding: 14px 30px; 
      background: #1976d2;
      color: #fff;
      text-decoration: none;
      font-size: 18px; 
      border-radius: 15px; 
    }

    .btn:hover {
      background: #1565c0;
    }
  </style>
</head>
<body>
  <div>
    <div class="success-icon">✔</div>
    <h1>THANH TOÁN THÀNH CÔNG</h1>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
    <p>Đang chuyển về trang chủ trong 3 giây...</p>
    <a href="{{ url('/') }}" class="btn">Quay về trang chủ</a>
  </div>
</body>
</html>
