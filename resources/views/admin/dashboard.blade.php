@extends('layouts.admin')
@section('title1', 'Thống kê')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Thống kê</h2>
        </header>
        <div class="row">
            <form method="GET" class="mt-3 search-year">
                <select name="year" id="year" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
                    @for ($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}
                        </option>
                    @endfor
                </select>
            </form>

            <div class="col-lg-12">
                <div class="row mb-3">
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-secondary">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Tổng Doanh Thu</h4>
                                            <div class="info">
                                                <strong class="amount">{{ number_format($revenue, 0, ',', '.') }}
                                                    VND</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-secondary">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Doanh thu Phòng</h4>
                                            <div class="info">
                                                <strong class="amount">{{ number_format($room_revenue, 0, ',', '.') }}
                                                    VND</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-secondary">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Doanh thu dịch vụ</h4>
                                            <div class="info">
                                                <strong class="amount">{{ number_format($service_revenue, 0, ',', '.') }}
                                                    VND</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-secondary">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Số lượng khách hàng</h4>
                                            <div class="info">
                                                <strong class="amount">{{ $number_customer }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </div>

            <div class="col-lg-12">
                <div class="row mb-3">
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-secondary">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Tổng số lượt đặt phòng</h4>
                                            <div class="info">
                                                <strong class="amount">{{ $total_bookings }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-secondary">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Đã trả phòng</h4>
                                            <div class="info">
                                                <strong class="amount">{{ $total_check_out }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-secondary">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Đã nhận phòng</h4>
                                            <div class="info">
                                                <strong class="amount">{{ $total_check_in }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-secondary">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Chờ xác nhận</h4>
                                            <div class="info">
                                                <strong class="amount">{{ $total_confirm }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </div>

            <canvas id="revenueChart" height="300"></canvas>

            <div class="customer-chart">
                <div class="">
                    <h4 class="mt-5 ">Số lượng khách theo từng tháng năm {{ $year }}</h4>
                    <canvas id="customerMonthChart" class="canvas"></canvas>
                </div>
                <div class="">
                    <h4 class="mt-5 ">Số lượng khách theo từng năm</h4>
                    <canvas id="customerYearChart" class="canvas"></canvas>
                </div>
            </div>

            <!-- Top 10 Khách hàng tiềm năng -->
            <div class="row mt-5 top-customers-table">
                <div class="col-12">
                    <section class="card">
                        <header class="card-header">
                            <h2 class="card-title">Top 10 Khách hàng tiềm năng năm {{ $year }}</h2>
                        </header>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="alert alert-info">
                                        <strong>Tổng doanh thu từ top 10 ({{ $year }}):</strong><br>
                                        <span class="h5 text-primary">
                                            {{ number_format($topCustomer->sum('total_spent'), 0, ',', '.') }} VND
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-success">
                                        <strong>Tổng số lần đặt phòng ({{ $year }}):</strong><br>
                                        <span class="h5 text-success">
                                            {{ $topCustomer->sum('booking_count') }} lần
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-warning">
                                        <strong>Khách hàng tiềm năng nhất ({{ $year }}):</strong><br>
                                        <span class="h5 text-warning">
                                            {{ $topCustomer->first()->user->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên khách hàng</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Tổng chi tiêu</th>
                                            <th>Số lần đặt phòng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($topCustomer as $index => $customer)
                                            <tr>
                                                <td>
                                                    @if ($index < 3)
                                                        <span class="badge badge-warning">{{ $index + 1 }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ $index + 1 }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $customer->user->name ?? 'Khách hàng' }}</strong>
                                                    @if ($index < 3)
                                                        <i class="fas fa-crown text-warning ml-1"
                                                            title="Top {{ $index + 1 }}"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $customer->user->email ?? 'N/A' }}</td>
                                                <td>{{ $customer->user->phone ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge badge-success">
                                                        {{ number_format($customer->total_spent, 0, ',', '.') }} VND
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        {{ $customer->booking_count ?? 0 }} lần
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Không có dữ liệu khách hàng</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/morris/morris.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/basic.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-markdown/css/bootstrap-markdown.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
    <style>
        .customer-chart {
            display: grid;
            gap: 20px;
            grid-template-columns: 1fr 1fr;
            align-items: center;
        }

        .canvas {
            width: 400px !important;
            height: 400px !important;
        }

        .search-year {
            margin-bottom: 15px;
        }

        .top-customers-table {
            margin-top: 30px;
        }

        .top-customers-table .card {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .top-customers-table .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .top-customers-table .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }

        .top-customers-table .badge-success {
            background-color: #28a745;
            color: white;
            font-weight: 500;
        }

        .top-customers-table .badge-info {
            background-color: #17a2b8;
            color: white;
            font-weight: 500;
        }

        .top-customers-table .badge-warning {
            background-color: #ffc107;
            color: #212529;
            font-weight: 600;
        }

        .top-customers-table .badge-secondary {
            background-color: #6c757d;
            color: white;
            font-weight: 500;
        }

        .top-customers-table .fa-crown {
            font-size: 14px;
        }

        .top-customers-table .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
    </style>
@endsection

@section('script')
    <!-- Vendor -->
    <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/master/style-switcher/style.switcher.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper/umd/popper.min.html') }}"></script>
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
    <script src="{{ asset('vendor/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('vendor/pnotify/pnotify.custom.js') }}"></script>
    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <!-- Theme Custom -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- Theme Initialization Files -->
    <script src="{{ asset('assets/js/theme.init.js') }}"></script>
    <!-- Analytics to Track Preview Website -->
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
    <script src="{{ asset('js/examples/examples.header.menu.js') }}"></script>
    <script src="{{ asset('js/examples/examples.ecommerce.form.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
                    'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
                    'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12',
                    'Tổng cả năm'
                ],
                datasets: [{
                    label: 'Doanh thu theo tháng (VND)',
                    data: {!! json_encode(array_merge($revenueData, [$revenue])) !!},
                    backgroundColor: [
                        ...Array(12).fill('rgba(54, 162, 235, 0.7)'),
                        'rgba(255, 99, 132, 0.7)'
                    ],
                    borderColor: [
                        ...Array(12).fill('rgba(54, 162, 235, 1)'),
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('vi-VN').format(context.raw) + ' đ';
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Biểu đồ tròn: khách theo tháng
        const customerMonthChart = new Chart(document.getElementById('customerMonthChart'), {
            type: 'pie',
            data: {
                labels: [
                    'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                ],
                datasets: [{
                    data: {!! json_encode($customersByMonth) !!},
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#E7E9ED', '#84FF63',
                        '#63B8FF', '#FFA07A', '#20B2AA', '#D2691E'
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Biểu đồ tròn: khách theo năm
        const customerYearChart = new Chart(document.getElementById('customerYearChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($years) !!},
                datasets: [{
                    data: {!! json_encode($customersByYear) !!},
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#E7E9ED'
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

@endsection
