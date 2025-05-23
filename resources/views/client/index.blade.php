<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from html.kodesolution.com/2025/hoteler-html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 May 2025 14:38:30 GMT -->

@include('client.layout.head')

<body>

    <div class="page-wrapper">

        <!-- Preloader -->
        <div class="preloader"></div>

        <!-- Main Header-->
        @include('client.layout.header')
        <!--End Main Header -->
        @yield('content')
        <!-- Main Footer -->
        @include('client.layout.footer')
        <!--End Main Footer -->

        <div class="scroll-to-top scroll-to-target" data-target="html">
            <span class="fa fa-arrow-up"></span>
        </div>
    </div>
    @include('client.layout.script')
</body>

<!-- Mirrored from html.kodesolution.com/2025/hoteler-html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 04 May 2025 14:39:28 GMT -->

</html>
