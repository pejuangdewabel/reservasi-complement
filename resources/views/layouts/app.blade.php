<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Home Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    @include('includes.link')
    @stack('after-link')
    {!! NoCaptcha::renderJs() !!}
</head>

<body>
    <div class="pageLoader" id="pageLoader"></div>
    <!-- ======= Header ======= -->
    @include('includes.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('includes.sidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">

        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('includes.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    @include('includes.script')
    @stack('after-script')
    @include('sweetalert::alert')
</body>

</html>
