<head>
    <meta charset="utf-8">
    <title>Hoteler - Hotel Booking HTML Template</title>
    <!-- Stylesheets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('client/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/css/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/slick.css') }}">

    <link rel="shortcut icon" href="{{ asset('client/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('client/images/favicon.png') }}" type="image/x-icon">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @stack('css')
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
</head>
