<!doctype html>
<html class="fixed">

@include('layouts.partials.head')

<body>
    <section class="body">
        <!-- start: header -->
        @include('layouts.partials.header')
        <!-- end: header -->
        <div class="inner-wrapper">
            <!-- start: sidebar -->
            @include('layouts.partials.sidebar')
            <!-- end: sidebar -->
            <!-- start: page -->
            @yield('content')
            <!-- end: page -->
        </div>
    </section>
    @yield('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        #toast-container>div {
            opacity: 1;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            padding: 15px 15px 15px 50px;
            width: 300px;
            background-position: 15px center;
            background-repeat: no-repeat;
            background-size: 24px;
        }

        #toast-container>.toast-success {
            background-color: #28a745;
            color: #fff;
        }

        #toast-container>.toast-error {
            background-color: #dc3545;
            color: #fff;
        }

        #toast-container>.toast-warning {
            background-color: #ffc107;
            color: #000;
        }

        #toast-container>.toast-info {
            background-color: #17a2b8;
            color: #fff;
        }

        .toast-close-button {
            color: #fff;
            opacity: 0.8;
            text-shadow: none;
            font-weight: 400;
        }

        .toast-close-button:hover {
            color: #fff;
            opacity: 1;
        }

        .toast-progress {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .toast-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .toast-message {
            font-size: 14px;
        }
    </style>
    <script>
        // Cấu hình Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Xử lý thông báo success
        @if (session('success'))
            toastr.success('{{ session('success') }}', 'Thành công!');
        @endif

        // Xử lý thông báo error
        @if (session('error'))
            toastr.error('{{ session('error') }}', 'Lỗi!');
        @endif

        // Xử lý validation errors
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', 'Lỗi!');
            @endforeach
        @endif
    </script>
</body>
@stack('js')

</html>
