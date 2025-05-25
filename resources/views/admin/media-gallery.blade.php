@extends('layouts.admin')
@section('title1', 'Kho ảnh')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="font-weight-bold text-6">Kho ảnh</h2>
        </header>
        <section class="content-with-menu content-with-menu-has-toolbar media-gallery">
            <div class="content-with-menu-container">
                <div class="inner-menu-toggle">
                    <a href="#" class="inner-menu-expand" data-open="inner-menu">
                        Show Bar <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                <menu id="content-menu" class="inner-menu" role="menu">
                    <div class="nano">
                        <div class="nano-content">
                            <div class="inner-menu-toggle-inside">
                                <a href="#" class="inner-menu-collapse">
                                    <i class="fas fa-chevron-up visible-xs-inline"></i><i
                                        class="fas fa-chevron-left hidden-xs-inline"></i> Hide Bar
                                </a>
                                <a href="#" class="inner-menu-expand" data-open="inner-menu">
                                    Show Bar <i class="fas fa-chevron-down"></i>
                                </a>
                            </div>
                            <div class="inner-menu-content">
                                <div class="d-grid gap-1">
                                    <a class="btn btn-block btn-success btn-md pt-2 pb-2 text-3" href="#">
                                        <i class="fas fa-upload me-1"></i>
                                        Tải ảnh lên
                                    </a>
                                </div>
                                <hr class="separator" />
                                <div class="sidebar-widget m-0">
                                    <div class="widget-header clearfix">
                                        <h6 class="title float-start mt-1">Danh sách thư mục</h6>
                                    </div>
                                    <div class="widget-content">
                                        <ul class="mg-folders">
                                            <li>
                                                <a href="#" class="menu-item"><i class="fas fa-folder"></i> Ảnh Phòng</a>
                                                <div class="item-options">
                                                    <a href="#">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="text-danger">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="#" class="menu-item"><i class="fas fa-folder"></i>
                                                    Ảnh sự kiện</a>
                                                <div class="item-options">
                                                    <a href="#">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="text-danger">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="#" class="menu-item"><i class="fas fa-folder"></i> Ảnh đại diện</a>
                                                <div class="item-options">
                                                    <a href="#">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="text-danger">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </div>
                                        </ul>
                                    </div>
                                </div>
                                <hr class="separator" />
                            </div>
                        </div>
                    </div>
                </menu>
                <div class="inner-body mg-main">
                    <div class="inner-toolbar clearfix">
                        <ul>
                            <li>
                                <a href="#" id="mgSelectAll"><i class="fas fa-check-square me-1"></i> <span
                                        data-all-text="Select All" data-none-text="Select None">Chọn tất cả</span></a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-pencil-alt me-1"></i> Cập nhật</a>
                            </li>
                            <li>
                                <a href="#"><i class="far fa-trash-alt me-1"></i> Xóa</a>
                            </li>
                            <li class="right" data-sort-source data-sort-id="media-gallery">
                                <ul class="nav nav-pills nav-pills-primary">
                                    <li class="nav-item">
                                        <label>Lọc:</label>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="nav-link" data-option-value="*" href="#all">Tất cả</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-option-value=".document" href="#document">Ảnh phòng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-option-value=".image" href="#image">Ảnh sự kiện</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-option-value=".video" href="#video">Ảnh đại diện</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="row mg-files" data-sort-destination data-sort-id="media-gallery">
                        <div class="isotope-item document col-sm-6 col-md-4 col-lg-3">
                            <div class="thumbnail">
                                <div class="thumb-preview">
                                    <a class="thumb-image" href="img/projects/project-1.jpg">
                                        <img src="{{ asset('assets/img/projects/project-1.jpg') }}" class="img-fluid" alt="Project">
                                    </a>
                                    <div class="mg-thumb-options">
                                        <div class="mg-zoom"><i class="bx bx-search"></i></div>
                                        <div class="mg-toolbar">
                                            <div class="mg-option checkbox-custom checkbox-inline">
                                                <input type="checkbox" id="file_1" value="1">
                                                <label for="file_1">SELECT</label>
                                            </div>
                                            <div class="mg-group float-end">
                                                <a href="#">EDIT</a>
                                                <button class="dropdown-toggle mg-toggle" data-bs-toggle="dropdown"><span
                                                        class="caret"></span></button>
                                                <div class="dropdown-menu mg-dropdown" role="menu">
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="fas fa-download"></i> Download</a>
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="far fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mg-title font-weight-semibold">SEO<small>.png</small></h5>
                                <div class="mg-description">
                                    <small class="float-start text-muted">Design, Websites</small>
                                    <small class="float-end text-muted">07/10/2023</small>
                                </div>
                            </div>
                        </div>
                        <div class="isotope-item col-sm-6 col-md-4 col-lg-3">
                            <div class="thumbnail">
                                <div class="thumb-preview">
                                    <a class="thumb-image" href="img/projects/project-2.jpg">
                                        <img src="{{ asset('assets/img/projects/project-2.jpg') }}" class="img-fluid" alt="Project">
                                    </a>
                                    <div class="mg-thumb-options">
                                        <div class="mg-zoom"><i class="bx bx-search"></i></div>
                                        <div class="mg-toolbar">
                                            <div class="mg-option checkbox-custom checkbox-inline">
                                                <input type="checkbox" id="file_2" value="1">
                                                <label for="file_2">SELECT</label>
                                            </div>
                                            <div class="mg-group float-end">
                                                <a href="#">EDIT</a>
                                                <button class="dropdown-toggle mg-toggle" data-bs-toggle="dropdown"><span
                                                        class="caret"></span></button>
                                                <div class="dropdown-menu mg-dropdown" role="menu">
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="fas fa-download"></i> Download</a>
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="far fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mg-title font-weight-semibold">Blog<small>.png</small></h5>
                                <div class="mg-description">
                                    <small class="float-start text-muted">PSDs, Projects</small>
                                    <small class="float-end text-muted">07/10/2023</small>
                                </div>
                            </div>
                        </div>
                        <div class="isotope-item video col-sm-6 col-md-4 col-lg-3">
                            <div class="thumbnail">
                                <div class="thumb-preview">
                                    <a class="thumb-image" href="img/projects/project-5.jpg">
                                        <img src="{{ asset('assets/img/projects/project-5.jpg') }}" class="img-fluid" alt="Project">
                                    </a>
                                    <div class="mg-thumb-options">
                                        <div class="mg-zoom"><i class="bx bx-search"></i></div>
                                        <div class="mg-toolbar">
                                            <div class="mg-option checkbox-custom checkbox-inline">
                                                <input type="checkbox" id="file_3" value="1">
                                                <label for="file_3">SELECT</label>
                                            </div>
                                            <div class="mg-group float-end">
                                                <a href="#">EDIT</a>
                                                <button class="dropdown-toggle mg-toggle" data-bs-toggle="dropdown"><span
                                                        class="caret"></span></button>
                                                <div class="dropdown-menu mg-dropdown" role="menu">
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="fas fa-download"></i> Download</a>
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="far fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mg-title font-weight-semibold">Friends<small>.png</small></h5>
                                <div class="mg-description">
                                    <small class="float-start text-muted">Projects, Vacation</small>
                                    <small class="float-end text-muted">07/10/2023</small>
                                </div>
                            </div>
                        </div>
                        <div class="isotope-item image col-sm-6 col-md-4 col-lg-3">
                            <div class="thumbnail">
                                <div class="thumb-preview">
                                    <a class="thumb-image" href="img/projects/project-4.jpg">
                                        <img src="{{ asset('assets/img/projects/project-4.jpg') }}" class="img-fluid" alt="Project">
                                    </a>
                                    <div class="mg-thumb-options">
                                        <div class="mg-zoom"><i class="bx bx-search"></i></div>
                                        <div class="mg-toolbar">
                                            <div class="mg-option checkbox-custom checkbox-inline">
                                                <input type="checkbox" id="file_4" value="1">
                                                <label for="file_4">SELECT</label>
                                            </div>
                                            <div class="mg-group float-end">
                                                <a href="#">EDIT</a>
                                                <button class="dropdown-toggle mg-toggle" data-bs-toggle="dropdown"><span
                                                        class="caret"></span></button>
                                                <div class="dropdown-menu mg-dropdown" role="menu">
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="fas fa-download"></i> Download</a>
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="far fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mg-title font-weight-semibold">Life<small>.png</small></h5>
                                <div class="mg-description">
                                    <small class="float-start text-muted">Images, Photos</small>
                                    <small class="float-end text-muted">07/10/2023</small>
                                </div>
                            </div>
                        </div>
                        <div class="isotope-item video col-sm-6 col-md-4 col-lg-3">
                            <div class="thumbnail">
                                <div class="thumb-preview">
                                    <a class="thumb-image" href="img/projects/project-5.jpg">
                                        <img src="{{ asset('assets/img/projects/project-5.jpg') }}" class="img-fluid" alt="Project">
                                    </a>
                                    <div class="mg-thumb-options">
                                        <div class="mg-zoom"><i class="bx bx-search"></i></div>
                                        <div class="mg-toolbar">
                                            <div class="mg-option checkbox-custom checkbox-inline">
                                                <input type="checkbox" id="file_5" value="1">
                                                <label for="file_5">SELECT</label>
                                            </div>
                                            <div class="mg-group float-end">
                                                <a href="#">EDIT</a>
                                                <button class="dropdown-toggle mg-toggle" data-bs-toggle="dropdown"><span
                                                        class="caret"></span></button>
                                                <div class="dropdown-menu mg-dropdown" role="menu">
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="fas fa-download"></i> Download</a>
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="far fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mg-title font-weight-semibold">Poetry<small>.png</small></h5>
                                <div class="mg-description">
                                    <small class="float-start text-muted">Websites</small>
                                    <small class="float-end text-muted">07/10/2023</small>
                                </div>
                            </div>
                        </div>
                        <div class="isotope-item document col-sm-6 col-md-4 col-lg-3">
                            <div class="thumbnail">
                                <div class="thumb-preview">
                                    <a class="thumb-image" href="img/projects/project-6.jpg">
                                        <img src="{{ asset('assets/img/projects/project-6.jpg') }}" class="img-fluid" alt="Project">
                                    </a>
                                    <div class="mg-thumb-options">
                                        <div class="mg-zoom"><i class="bx bx-search"></i></div>
                                        <div class="mg-toolbar">
                                            <div class="mg-option checkbox-custom checkbox-inline">
                                                <input type="checkbox" id="file_6" value="1">
                                                <label for="file_6">SELECT</label>
                                            </div>
                                            <div class="mg-group float-end">
                                                <a href="#">EDIT</a>
                                                <button class="dropdown-toggle mg-toggle" data-bs-toggle="dropdown"><span
                                                        class="caret"></span></button>
                                                <div class="dropdown-menu mg-dropdown" role="menu">
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="fas fa-download"></i> Download</a>
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="far fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mg-title font-weight-semibold">Fun<small>.png</small></h5>
                                <div class="mg-description">
                                    <small class="float-start text-muted">Documentation</small>
                                    <small class="float-end text-muted">07/10/2023</small>
                                </div>
                            </div>
                        </div>
                        <div class="isotope-item col-sm-6 col-md-4 col-lg-3">
                            <div class="thumbnail">
                                <div class="thumb-preview">
                                    <a class="thumb-image" href="img/projects/project-7.jpg">
                                        <img src="{{ asset('assets/img/projects/project-7.jpg') }}" class="img-fluid" alt="Project">
                                    </a>
                                    <div class="mg-thumb-options">
                                        <div class="mg-zoom"><i class="bx bx-search"></i></div>
                                        <div class="mg-toolbar">
                                            <div class="mg-option checkbox-custom checkbox-inline">
                                                <input type="checkbox" id="file_7" value="1">
                                                <label for="file_7">SELECT</label>
                                            </div>
                                            <div class="mg-group float-end">
                                                <a href="#">EDIT</a>
                                                <button class="dropdown-toggle mg-toggle" data-bs-toggle="dropdown"><span
                                                        class="caret"></span></button>
                                                <div class="dropdown-menu mg-dropdown" role="menu">
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="fas fa-download"></i> Download</a>
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="far fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mg-title font-weight-semibold">Family<small>.png</small></h5>
                                <div class="mg-description">
                                    <small class="float-start text-muted">Documentation</small>
                                    <small class="float-end text-muted">07/10/2023</small>
                                </div>
                            </div>
                        </div>
                        <div class="isotope-item image col-sm-6 col-md-4 col-lg-3">
                            <div class="thumbnail">
                                <div class="thumb-preview">
                                    <a class="thumb-image" href="img/projects/project-1.jpg">
                                        <img src="{{asset('assets/img/projects/project-1.jpg')}}" class="img-fluid" alt="Project">
                                    </a>
                                    <div class="mg-thumb-options">
                                        <div class="mg-zoom"><i class="bx bx-search"></i></div>
                                        <div class="mg-toolbar">
                                            <div class="mg-option checkbox-custom checkbox-inline">
                                                <input type="checkbox" id="file_8" value="1">
                                                <label for="file_8">SELECT</label>
                                            </div>
                                            <div class="mg-group float-end">
                                                <a href="#">EDIT</a>
                                                <button class="dropdown-toggle mg-toggle" data-bs-toggle="dropdown"><span
                                                        class="caret"></span></button>
                                                <div class="dropdown-menu mg-dropdown" role="menu">
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="fas fa-download"></i> Download</a>
                                                    <a class="dropdown-item text-1" href="#"><i
                                                            class="far fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mg-title font-weight-semibold">Hapiness<small>.png</small></h5>
                                <div class="mg-description">
                                    <small class="float-start text-muted">Websites</small>
                                    <small class="float-end text-muted">07/10/2023</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <!-- end: page -->
@endsection

@section('head')

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
    <script src="{{ asset('assets/vendor/isotope/isotope.js') }}"></script>
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
    <script src="{{ asset('assets/js/examples/examples.mediagallery.js') }}"></script>
@endsection
