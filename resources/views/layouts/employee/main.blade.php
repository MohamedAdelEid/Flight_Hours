<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('components.theme-init')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ===== Header Start ===== -->
    @include('layouts.employee.partials.header')
    @stack('style')
    <!-- ===== Header End ===== -->

</head>

<body x-data="data()" x-init="init()">

    <!-- ===== Preloader Start ===== -->
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex min-h-screen app-shell" :class="{ 'overflow-hidden': isSideMenuOpen }">

        <!-- ===== Sidebar Start ===== -->
        @include('layouts.employee.partials.sidebar')
        <!-- ===== Sidebar End ===== -->


        <div class="flex flex-col flex-1 w-full">

            <!-- ===== Navbar Start ===== -->
            @include('layouts.employee.partials.navbar')
            <!-- ===== Navbar End ===== -->

            @yield('content')

            <!-- ===== Footer Start ===== -->
            @include('layouts.employee.partials.footer')
            <!-- ===== Footer End ===== -->

            <!-- ===== Footer Script  Start ===== -->
            @include('layouts.employee.partials.footer-script')
            @stack('script')
            <!-- ===== Footer Script End ===== -->

            <!-- ===== Alerts Start ===== -->
            @yield('alerts')
            <!-- ===== Alerts End ===== -->

        </div>
    </div>
    <!-- ===== Page Wrapper End ===== -->
</body>

</html>
