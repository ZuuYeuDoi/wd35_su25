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

        <!-- Flash Messages -->
        <div class="flash-messages-container"
            style="position: fixed; top: 100px; right: 20px; z-index: 9999; max-width: 400px;">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show custom-alert" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show custom-alert" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>


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
