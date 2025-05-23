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
</body>

</html>
