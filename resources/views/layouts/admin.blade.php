<!doctype html>
<html class="fixed">

<!-- Mirrored from www.okler.net/previews/porto-admin/4.3.0/layouts-default.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 May 2025 14:54:30 GMT -->

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
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Dashboard</h2>
                </header>
                <!-- start: page -->
               @yield('content')
                <!-- end: page -->
            </section>
        </div>

    </section>
    @include('layouts.partials.script')
</body>

<!-- Mirrored from www.okler.net/previews/porto-admin/4.3.0/layouts-default.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 May 2025 14:55:13 GMT -->

</html>
