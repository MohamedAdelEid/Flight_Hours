<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en" dir="rtl">

<head>

    <!-- ===== Header Start ===== -->
    @include('layouts.employee.partials.header')
    @stack('style')
    <!-- ===== Header End ===== -->

</head>

<body>

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

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
