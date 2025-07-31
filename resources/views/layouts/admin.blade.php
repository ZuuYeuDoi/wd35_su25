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

    <!-- Vendor -->
    <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/master/style-switcher/style.switcher.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/common/common.js') }}"></script>
    <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
    <script src="{{ asset('assets/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

    <!-- Specific Page Vendor -->
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-appear/jquery.appear.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot.tooltip/jquery.flot.tooltip.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-sparkline/jquery.sparkline.js') }}"></script>
    <script src="{{ asset('assets/vendor/raphael/raphael.js') }}"></script>
    <script src="{{ asset('assets/vendor/morris/morris.js') }}"></script>
    <script src="{{ asset('assets/vendor/gauge/gauge.js') }}"></script>
    <script src="{{ asset('assets/vendor/snap.svg/snap.svg.js') }}"></script>
    <script src="{{ asset('assets/vendor/liquid-meter/liquid.meter.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/jquery.vmap.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/data/jquery.vmap.sampledata.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js') }}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>

    <!-- Theme Custom -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{ asset('assets/js/theme.init.js') }}"></script>

    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '../../../../www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-42715764-8', 'auto');
        ga('send', 'pageview');
    </script>
    <!-- Examples -->
    <script src="{{ asset('assets/js/examples/examples.dashboard.js') }}"></script>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        const pusher = new Pusher("b91cd41b8bd56ced440f", {
            cluster: "ap1"
        });
        const channels = [{
                name: "admin-booking",
                event: "new-booking"
            },
            {
                name: "admin-orders",
                event: "new-order"
            }
        ];

        const list = document.getElementById("notification-list");
        const toggle = document.getElementById("notificationToggle");
        const dropdown = document.getElementById("notificationDropdown");

        const showDropdown = () => {
            if (toggle && dropdown) {
                const dropdownInstance = bootstrap.Dropdown.getOrCreateInstance(toggle);
                dropdownInstance.show();
            }
        };

        const updateCount = (count = 1) => {
            document.querySelectorAll("#notification-count").forEach(el => {
                el.textContent = parseInt(el.textContent) + count;
            });
        };

        const limitNotifications = (max = 5) => {
            while (list.children.length > max) {
                list.removeChild(list.lastChild);
            }
        };

        const createNotificationItem = (iconClass, bgClass, html) => {
            const item = document.createElement("li");
            item.classList.add("notification-item", "new");
            item.innerHTML = `
            <div class="notification-icon ${bgClass}">
                <i class="${iconClass} text-white"></i>
            </div>
            <div class="notification-content">
                ${html}
                <br><small class="text-muted">Vừa xong</small>
            </div>
        `;
            return item;
        };

        channels.forEach(({
            name,
            event
        }) => {
            const channel = pusher.subscribe(name);
            channel.bind(event, data => {
                if (event === "new-booking") {
                    const html =
                        `<strong>${data.booking.name}</strong> đã đặt phòng <strong>${data.booking.room}</strong>`;
                    list.prepend(createNotificationItem("fas fa-bell", "bg-primary", html));
                    updateCount();
                    limitNotifications();
                    showDropdown();
                }

                if (event === "new-order") {
                    const user = data.order.user;
                    const services = data.order.services;

                    services.forEach(service => {
                        const html =
                            `<strong>${user}</strong> đã gọi món <strong>${service.name}</strong> x <strong>${service.quantity}</strong>`;
                        list.prepend(createNotificationItem("fas fa-utensils", "bg-success", html));
                    });
                    updateCount(services.length);
                    limitNotifications();
                    showDropdown();
                }
            });
        });
    </script>

    @stack('js')
</body>

</html>
