@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-6 mb-3">
            <section class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="chart-data-selector" id="salesSelectorWrapper">
                                <h2>
                                    Sales:
                                    <strong>
                                        <select class="form-control" id="salesSelector">
                                            <option value="Porto Admin" selected>Porto Admin</option>
                                            <option value="Porto Drupal">Porto Drupal</option>
                                            <option value="Porto Wordpress">Porto Wordpress</option>
                                        </select>
                                    </strong>
                                </h2>
                                <div id="salesSelectorItems" class="chart-data-selector-items mt-3">
                                    <!-- Flot: Sales Porto Admin -->
                                    <div class="chart chart-sm" data-sales-rel="Porto Admin" id="flotDashSales1"
                                        class="chart-active" style="height: 203px;">
                                    </div>
                                    <script>
                                        var flotDashSales1Data = [{
                                            data: [
                                                ["Jan", 140],
                                                ["Feb", 240],
                                                ["Mar", 190],
                                                ["Apr", 140],
                                                ["May", 180],
                                                ["Jun", 320],
                                                ["Jul", 270],
                                                ["Aug", 180]
                                            ],
                                            color: "pink"
                                        }];
                                        // See: js/examples/examples.dashboard.js for more settings.
                                    </script>
                                    <!-- Flot: Sales Porto Drupal -->
                                    <div class="chart chart-sm" data-sales-rel="Porto Drupal" id="flotDashSales2"
                                        class="chart-hidden"></div>
                                    <script>
                                        var flotDashSales2Data = [{
                                            data: [
                                                ["Jan", 240],
                                                ["Feb", 240],
                                                ["Mar", 290],
                                                ["Apr", 540],
                                                ["May", 480],
                                                ["Jun", 220],
                                                ["Jul", 170],
                                                ["Aug", 190]
                                            ],
                                            color: "pink"
                                        }];
                                        // See: js/examples/examples.dashboard.js for more settings.
                                    </script>
                                    <!-- Flot: Sales Porto Wordpress -->
                                    <div class="chart chart-sm" data-sales-rel="Porto Wordpress" id="flotDashSales3"
                                        class="chart-hidden"></div>
                                    <script>
                                        var flotDashSales3Data = [{
                                            data: [
                                                ["Jan", 840],
                                                ["Feb", 740],
                                                ["Mar", 690],
                                                ["Apr", 940],
                                                ["May", 1180],
                                                ["Jun", 820],
                                                ["Jul", 570],
                                                ["Aug", 780]
                                            ],
                                            color: "pink"
                                        }];
                                        // See: js/examples/examples.dashboard.js for more settings.
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 text-center">
                            <h2 class="card-title mt-3">Sales Goal</h2>
                            <div class="liquid-meter-wrapper liquid-meter-sm mt-3">
                                <div class="liquid-meter">
                                    <meter min="0" max="100" value="100" id="meterSales"></meter>
                                </div>
                                <div class="liquid-meter-selector mt-4 pt-1" id="meterSalesSel">
                                    <a href="#" data-val="35" class="active">Monthly Goal</a>
                                    <a href="#" data-val="28">Annual Goal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <div class="row mb-3">
                <div class="col-xl-6">
                    <section class="card card-featured-left card-featured-primary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-primary">
                                        <i class="fas fa-life-ring"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Support Questions</h4>
                                        <div class="info">
                                            <strong class="amount">1281</strong>
                                            <span class="text-primary">(14 unread)</span>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="#">(view all)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-6">
                    <section class="card card-featured-left card-featured-secondary">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-secondary">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Profit</h4>
                                        <div class="info">
                                            <strong class="amount">$ 14,890.30</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="#">(withdraw)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <section class="card card-featured-left card-featured-tertiary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-tertiary">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Today's Orders</h4>
                                        <div class="info">
                                            <strong class="amount">38</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="#">(statement)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-6">
                    <section class="card card-featured-left card-featured-quaternary">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-quaternary">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Today's Visitors</h4>
                                        <div class="info">
                                            <strong class="amount">3765</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="#">(report)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-4 mt-1">

        <section class="card">
            <header class="card-header card-header-transparent">
                <div class="card-actions">
                    <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                </div>
                <h2 class="card-title">Projects Stats</h2>
            </header>
            <div class="card-body">
                <table class="table table-responsive-md table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Porto - Responsive HTML5 Template</td>
                            <td><span class="badge badge-success">Success</span></td>
                            <td>
                                <div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                        100%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Porto - Responsive Drupal 7 Theme</td>
                            <td><span class="badge badge-success">Success</span></td>
                            <td>
                                <div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                        100%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Tucson - Responsive HTML5 Template</td>
                            <td><span class="badge badge-warning">Warning</span></td>
                            <td>
                                <div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                        60%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Tucson - Responsive Business WordPress Theme</td>
                            <td><span class="badge badge-success">Success</span></td>
                            <td>
                                <div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                                        90%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Porto - Responsive Admin HTML5 Template</td>
                            <td><span class="badge badge-warning">Warning</span></td>
                            <td>
                                <div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
                                        45%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Porto - Responsive HTML5 Template</td>
                            <td><span class="badge badge-danger">Danger</span></td>
                            <td>
                                <div class="progress progress-sm progress-half-rounded m-0 mt-1 light">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                                        40%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Porto - Responsive Drupal 7 Theme</td>
                            <td><span class="badge badge-success">Success</span></td>
                            <td>
                                <div class="progress progress-sm progress-half-rounded mt-1 light">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 95%;">
                                        95%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
