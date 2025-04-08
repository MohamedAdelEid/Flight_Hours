<!-- Desktop sidebar -->
<aside class="z-20 sticky top-0 hidden w-65 h-screen overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="mr-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
            logo
        </a>

        <!-- dashboard -->
        <ul class="mt-6">
            <li class="relative px-6">
                <span class="absolute inset-y-0 right-0 w-1 bg-blue-600 rounded-tl-lg rounded-bl-lg"
                    aria-hidden="true"></span>
                <a href="{{ route('employee.index') }}"
                    class="block py-2.5 px-4 flex items-center space-x-2 bg-gray-800 text-white hover:bg-gray-800 transition duration-200 transform hover:text-white rounded">
                    <svg class="w-6 h-6 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>الصفحة الرئيسية</span>
                </a>
            </li>
        </ul>

        <!-- controls -->
        <ul>
            <li class="relative px-6 mt-2">
                <span class="absolute inset-y-0 right-0 w-1 bg-blue-600 rounded-tl-lg rounded-bl-lg"
                    aria-hidden="true"></span>
                <!-- DROPDOWN LINK -->
                <div class="block" x-data="{ open: false }">
                    <div @click="open = !open"
                        class="flex items-center justify-between hover:bg-gray-800 transition duration-200 transform hover:text-white cursor-pointer py-2.5 px-4 rounded">
                        <div class="flex items-center space-x-2">
                            <svg class="w-6 h-6 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>البيانات الاساسية</span>
                        </div>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7">
                            </path>
                        </svg>
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div x-show="open"
                        class="text-sm border-r-2 border-gray-800 mr-6 my-2.5 pr-2.5 flex flex-col gap-y-1">

                        <!--control employees-->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open"
                                class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 pl-4 pr-2 rounded transition duration-200 transform">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-users me-2"></i>
                                    <span>الوظائف</span>
                                </div>
                                <svg x-show="open" class="w-5 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7">
                                    </path>
                                </svg>
                                <svg x-show="!open" class="w-5 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </div>
                            <div x-show="open"
                                class="text-sm border-r-2 border-gray-800 mr-3.5 ml-4 mb-2 mt-1 pr-2 flex flex-col gap-y-1">
                                <a href="{{ route('job.create') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    اضافة وظيفة
                                </a>
                                <a href="{{ route('job.index') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    عرض الوظائف
                                </a>
                            </div>
                        </div>

                        <!--control airports -->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open"
                                class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 pl-4 pr-2 rounded transition duration-200 transform">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-plane-departure me-2"></i>
                                    <span>المطارات</span>
                                </div>
                                <svg x-show="open" class="w-5 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7">
                                    </path>
                                </svg>
                                <svg x-show="!open" class="w-5 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </div>
                            <div x-show="open"
                                class="text-sm border-r-2 border-gray-800 mr-3.5 ml-4 mb-2 mt-1 pr-2 flex flex-col gap-y-1">
                                <a href="{{ route('airport.create') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    اضافة مطار
                                </a>
                                <a href="{{ route('airport.index') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    عرض المطارات
                                </a>
                            </div>
                        </div>

                        <!--control planes -->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open"
                                class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 pl-4 pr-2 rounded transition duration-200 transform">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-plane me-2"></i>
                                    <span>الطائرات</span>
                                </div>
                                <svg x-show="open" class="w-5 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7">
                                    </path>
                                </svg>
                                <svg x-show="!open" class="w-5 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </div>
                            <div x-show="open"
                                class="text-sm border-r-2 border-gray-800 mr-3.5 ml-4 mb-2 mt-1 pr-2 flex flex-col gap-y-1">
                                <a href="{{ route('aircraft.create') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    اضافة طائرة
                                </a>
                                <a href="{{ route('aircraft.index') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    عرض الطائرات
                                </a>
                            </div>
                        </div>

                        <!-- add item in frist control -->

                    </div>
                </div>

                <!-- add item -->

            </li>

            {{-- بيانات الموظفين --}}
            <li class="relative px-6 mt-2">
                <span class="absolute inset-y-0 right-0 w-1 bg-blue-600 rounded-tl-lg rounded-bl-lg"
                    aria-hidden="true"></span>
                <!-- DROPDOWN LINK -->
                <div class="block" x-data="{ open: false }">
                    <div @click="open = !open"
                        class="flex items-center justify-between hover:bg-gray-800 transition duration-200 transform hover:text-white cursor-pointer py-2.5 px-4 rounded">
                        <div class="flex items-center space-x-2">
                            <i class="icon-nav text-xl fa-solid fa-file me-2"></i>
                            <span>بيانات الموظفين </span>
                        </div>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7">
                            </path>
                        </svg>
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div x-show="open"
                        class="text-sm border-r-2 border-gray-800 mr-6 my-2.5 pr-2.5 flex flex-col gap-y-1">
                        <a href="{{ route('crew.create') }}"
                            class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                            اضافة موظف
                        </a>
                        <a href="{{ route('crew.index') }}"
                            class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                            عرض الموظفين
                        </a>
                    </div>
                </div>
            </li>

            <li class="relative px-6 mt-2">
                <span class="absolute inset-y-0 right-0 w-1 bg-blue-600 rounded-tl-lg rounded-bl-lg"
                    aria-hidden="true"></span>
                <!-- DROPDOWN LINK -->
                <div class="block" x-data="{ open: false }">
                    <div @click="open = !open"
                        class="flex items-center justify-between hover:bg-gray-800 transition duration-200 transform hover:text-white cursor-pointer py-2.5 px-4 rounded">
                        <div class="flex items-center space-x-2">
                            <i class="icon-nav text-xl fas fa-edit me-2"></i>
                            <span>الرحلات</span>
                        </div>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7">
                            </path>
                        </svg>
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div x-show="open"
                        class="text-sm border-r-2 border-gray-800 mr-6 my-2.5 pr-2.5 flex flex-col gap-y-1">

                        {{-- Add Flight --}}
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open"
                                class="flex items-center justify-between hover:bg-gray-800 transition duration-200 transform hover:text-white cursor-pointer py-2.5 px-4 rounded">
                                <div class="flex items-center space-x-2">
                                    <span>إضافة رحلة</span>
                                </div>
                                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7">
                                    </path>
                                </svg>
                                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </div>
                            <div x-show="open"
                                class="text-sm border-r-2 border-gray-800 mr-6 my-2.5 pr-2.5 flex flex-col gap-y-1">

                                <a href="{{ route('flight.createNormalFlight') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    رحلة عادية
                                </a>

                                <a href="{{ route('flight.createSimulatedFlight') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    طيران تشبيهي
                                </a>

                                <a href="{{ route('flight.createUnloadedFlight') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    طيران غير محمل
                                </a>
                                
                                <a href="{{ route('flight.createFlyingTest') }}"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    اختبار طائرة
                                </a>

                            </div>
                        </div>

                        <a href="{{ route('flight.index') }}"
                            class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                            عرض الرحلات
                        </a>

                    </div>
                </div>
            </li>

        </ul>

        <!-- my profile -->
        <ul class="mt-2 mb-4">
            <li class="relative px-6">
                <span class="absolute inset-y-0 right-0 w-1 bg-blue-600 rounded-tl-lg rounded-bl-lg"
                    aria-hidden="true"></span>
                <a href="{{ route('employee.profile') }}"
                    class="block py-2.5 px-4 flex items-center space-x-2 hover:bg-gray-800 transition duration-200 transform hover:text-white rounded">
                    <i class="fa-solid fa-user me-2"></i>
                    <span>الصفحة الشخصية</span>
                </a>
            </li>
        </ul>

        <div class=" border-b border-gray-300"></div>

        <!-- Logout -->
        <div class="px-6 my-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" href="Logout.php"
                    class="flex items-center w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple hover:text-red-500">
                    <svg class="w-6 h-6 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <p class="mb-1 ml-2">تسجيل الخروج</p>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile sidebar -->
<!-- Backdrop -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>

<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform translate-x-20" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform translate-x-20" @click.away="closeSideMenu"
    @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
            logo
        </a>

        <!-- dashboard -->
        <ul class="mt-6">
            <li class="relative px-6">
                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <a href="<?php __DIR__ . '\..\..\..\Admin\main-admin\index.php'; ?>"
                    class="block py-2.5 px-4 flex items-center space-x-2 bg-gray-800 text-white hover:bg-gray-800 transition duration-200 transform hover:text-white rounded">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>

        <!-- controls -->
        <ul>
            <li class="relative px-6 mt-2">
                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <!-- DROPDOWN LINK -->
                <div class="block" x-data="{ open: false }">
                    <div @click="open = !open"
                        class="flex items-center justify-between hover:bg-gray-800 transition duration-200 transform hover:text-white cursor-pointer py-2.5 px-4 rounded">
                        <div class="flex items-center space-x-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Control</span>
                        </div>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7">
                            </path>
                        </svg>
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div x-show="open"
                        class="text-sm border-l-2 border-gray-800 ml-6 my-2.5 pl-2.5 flex flex-col gap-y-1">

                        <!--control category-->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open"
                                class="item-nav flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 pl-4 pr-2 rounded transition duration-200 transform">
                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-nav" width="24"
                                        height="24" viewBox="0 0 24 24" id="category">
                                        <g transform="translate(2 2)">
                                            <path
                                                d="M14.0755097,2.66453526e-15 L17.4614756,2.66453526e-15 C18.8637443,2.66453526e-15 20,1.1458518 20,2.55996321 L20,5.97452492 C20,7.38863633 18.8637443,8.53448813 17.4614756,8.53448813 L14.0755097,8.53448813 C12.673241,8.53448813 11.5369853,7.38863633 11.5369853,5.97452492 L11.5369853,2.55996321 C11.5369853,1.1458518 12.673241,2.66453526e-15 14.0755097,2.66453526e-15"
                                                opacity=".4"></path>
                                            <path
                                                d="M5.9244903,11.4655119 C7.32675901,11.4655119 8.46301469,12.6113637 8.46301469,14.0254751 L8.46301469,17.4400368 C8.46301469,18.8531901 7.32675901,20 5.9244903,20 L2.53852439,20 C1.13625568,20 8.8817842e-16,18.8531901 8.8817842e-16,17.4400368 L8.8817842e-16,14.0254751 C8.8817842e-16,12.6113637 1.13625568,11.4655119 2.53852439,11.4655119 L5.9244903,11.4655119 Z M17.4614756,11.4655119 C18.8637443,11.4655119 20,12.6113637 20,14.0254751 L20,17.4400368 C20,18.8531901 18.8637443,20 17.4614756,20 L14.0755097,20 C12.673241,20 11.5369853,18.8531901 11.5369853,17.4400368 L11.5369853,14.0254751 C11.5369853,12.6113637 12.673241,11.4655119 14.0755097,11.4655119 L17.4614756,11.4655119 Z M5.9244903,7.99360578e-15 C7.32675901,7.99360578e-15 8.46301469,1.1458518 8.46301469,2.55996321 L8.46301469,5.97452492 C8.46301469,7.38863633 7.32675901,8.53448813 5.9244903,8.53448813 L2.53852439,8.53448813 C1.13625568,8.53448813 8.8817842e-16,7.38863633 8.8817842e-16,5.97452492 L8.8817842e-16,2.55996321 C8.8817842e-16,1.1458518 1.13625568,7.99360578e-15 2.53852439,7.99360578e-15 L5.9244903,7.99360578e-15 Z">
                                            </path>
                                        </g>
                                    </svg>
                                    <span>Category</span>
                                </div>
                                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7">
                                    </path>
                                </svg>
                                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </div>
                            <div x-show="open"
                                class="text-sm border-l-2 border-gray-800 ml-6 my-2.5 pl-2.5 flex flex-col gap-y-1">
                                <a href="#" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    Add
                                </a>
                                <a href="#" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    View
                                </a>
                            </div>
                        </div>

                        <!--control sub category-->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open"
                                class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 pl-4 pr-2 rounded transition duration-200 transform">
                                <div class="flex items-center space-x-2">
                                    <i class="icon-nav fa-solid fa-layer-group text-xl"></i>
                                    <span>Sub Category</span>
                                </div>
                                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7">
                                    </path>
                                </svg>
                                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </div>
                            <div x-show="open"
                                class="text-sm border-l-2 border-gray-800 ml-6 my-2.5 pl-2.5 flex flex-col gap-y-1">
                                <a href="#" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    Add
                                </a>
                                <a href="#" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    View
                                </a>
                            </div>
                        </div>

                        <!--control Brand-->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open"
                                class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 pl-4 pr-2 rounded transition duration-200 transform">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-chart-simple text-lg"></i>
                                    <span>Brand</span>
                                </div>
                                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7">
                                    </path>
                                </svg>
                                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </div>
                            <div x-show="open"
                                class="text-sm border-l-2 border-gray-800 ml-6 my-2.5 pl-2.5 flex flex-col gap-y-1">
                                <a href="#" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    Add
                                </a>
                                <a href="#" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    View
                                </a>
                            </div>
                        </div>

                        <!--control sub admin-->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open"
                                class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 pl-4 pr-2 rounded transition duration-200 transform">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-users"></i>
                                    <span>Sub Admins</span>
                                </div>
                                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7">
                                    </path>
                                </svg>
                                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </div>
                            <div x-show="open"
                                class="text-sm border-l-2 border-gray-800 ml-6 my-2.5 pl-2.5 flex flex-col gap-y-1">
                                <a href="#" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    Add
                                </a>
                                <a href="#" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    View
                                </a>
                            </div>
                        </div>

                        <!-- add item -->
        </ul>

        <!-- my profile -->
        <ul class="mt-2">
            <li class="relative px-6">
                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <a href=""
                    class="block py-2.5 px-4 flex items-center space-x-2 hover:bg-gray-800 transition duration-200 transform hover:text-white rounded">
                    <i class="fa-solid fa-user"></i>
                    <span>الصفحة الشخصية</span>
                </a>
            </li>
        </ul>

        <!-- Logout -->
        <div class="px-6 my-6">
            <a href="{{ route('logout') }}"
                class="flex items-center w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple hover:text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                <p class="mb-1 ml-2">تسجيل الخروج</p>
            </a>
        </div>

    </div>
</aside>
