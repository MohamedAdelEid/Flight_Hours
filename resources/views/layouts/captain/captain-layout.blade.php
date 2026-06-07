<?php
$flights = \App\Models\Flight::with('originAirport', 'destinationAirport', 'aircraft')->where('user_id', auth()->user()->id)->get();
?>
<!DOCTYPE html>
<html dir="rtl">

<head>
    @include('components.theme-init')
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Hours - كابتن</title>

    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

    <link rel="stylesheet" href="{{ asset('assets/css/captain/style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    @stack('style')
</head>

<body id="top">

    <header class="header" data-header>
        <div class="overlay" data-overlay></div>
        <div class="header-top">
            <div class="container">
                <div class="header-btn-group">
                    <button type="button" class="theme-toggle theme-toggle--captain" id="captain-theme-toggle" aria-label="تبديل الوضع">
                        <svg class="theme-toggle__icon theme-toggle__icon--sun" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg class="theme-toggle__icon theme-toggle__icon--moon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                    <button class="nav-open-btn" aria-label="Open Menu" data-nav-open-btn>
                        <ion-icon name="menu-outline"></ion-icon>
                    </button>
                </div>
                <a href="#" class="logo">
                    <img src="{{ asset('assets/imgs/main/logo-white.png') }}">
                </a>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <nav class="navbar" data-navbar>
                    <div class="navbar-top">
                        <a href="#" class="logo">
                            <img src="{{ asset('assets/imgs/main/logo-white.png') }}">
                        </a>
                        <button class="nav-close-btn" aria-label="Close Menu" data-nav-close-btn>
                            <ion-icon name="close-outline"></ion-icon>
                        </button>
                    </div>
                    <ul class="navbar-list">
                        <li>
                            <a href="{{ route('captain.home') }}" class="navbar-link" data-nav-link>الصفحة الرئيسية</a>
                        </li>
                        <li>
                            <a href="#" class="navbar-link" data-nav-link data-modal-target="flightsModal" data-modal-toggle="flightsModal">الرحلات</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="navbar-link" data-nav-link>تسجيل الخروج</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    @if (session('successCreate') || session('success'))
    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 mx-4 mt-4">
        <span class="block sm:inline">{{ session('successCreate') ?? session('success') }}</span>
        <span class="absolute top-0 bottom-0 left-0 px-4 py-3 cursor-pointer" onclick="this.closest('div').style.display='none'">
            <svg class="fill-current h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
    @endif

    @if ($errors->any())
    <div id="validation-alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mx-4 mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <span class="absolute top-0 bottom-0 left-0 px-4 py-3 cursor-pointer" onclick="this.closest('div').style.display='none'">
            <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
    @endif

    <main>
        <article>
            {{ $slot }}
        </article>
    </main>

    <a href="#top" class="go-top" data-go-top>
        <ion-icon name="chevron-up-outline"></ion-icon>
    </a>

    <script src="{{ asset('assets/js/captain/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    <script>
        tailwind.config = { darkMode: 'class' };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

    <script>
    setTimeout(() => {
        document.querySelectorAll('[id$="-alert"]').forEach(a => a.style.display = 'none');
    }, 5000);

    (function () {
        var btn = document.getElementById('captain-theme-toggle');
        if (!btn || !window.FlightHoursTheme) return;

        function syncIcons() {
            var dark = document.documentElement.classList.contains('dark');
            btn.querySelector('.theme-toggle__icon--sun').style.display = dark ? 'block' : 'none';
            btn.querySelector('.theme-toggle__icon--moon').style.display = dark ? 'none' : 'block';
        }

        syncIcons();
        btn.addEventListener('click', function () {
            window.FlightHoursTheme.toggle();
            syncIcons();
        });
        window.addEventListener('theme-changed', syncIcons);
    })();
    </script>

    @stack('scripts')

<!-- Flights Modal -->
<div id="flightsModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-right">
                    رحلات الكابتن {{ auth()->user()->name }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="flightsModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">إغلاق</span>
                </button>
            </div>

            <div class="max-h-[500px] overflow-y-auto">
                <ul class="border-b text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400"
                    id="flightsTab" data-tabs-toggle="#flightsTabContent" role="tablist">
                    <li class="w-full">
                        <button id="regular-flights-tab" data-tabs-target="#regular-flights" type="button"
                            role="tab" aria-controls="regular-flights" aria-selected="true"
                            class="inline-block w-full p-4 rounded-tl-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">رحلات عادية</button>
                    </li>
                    <li class="w-full">
                        <button id="simulation-flights-tab" data-tabs-target="#simulation-flights" type="button"
                            role="tab" aria-controls="simulation-flights" aria-selected="false"
                            class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">طيران تشبيهي</button>
                    </li>
                    <li class="w-full">
                        <button id="unloaded-flights-tab" data-tabs-target="#unloaded-flights" type="button"
                            role="tab" aria-controls="unloaded-flights" aria-selected="false"
                            class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">طيران غير محمل</button>
                    </li>
                    <li class="w-full">
                        <button id="test-flights-tab" data-tabs-target="#test-flights" type="button"
                            role="tab" aria-controls="test-flights" aria-selected="false"
                            class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">اختبار طائرة</button>
                    </li>
                </ul>

                <div id="flightsTabContent">
                    <div class="hidden pt-4 px-4" id="regular-flights" role="tabpanel" aria-labelledby="regular-flights-tab">
                        @if($flights->where('flight_type', 'normal_flight')->count() > 0)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">رقم الرحلة</th>
                                        <th scope="col" class="px-6 py-3">تاريخ الرحلة</th>
                                        <th scope="col" class="px-6 py-3">مطار المغادرة</th>
                                        <th scope="col" class="px-6 py-3">مطار الوصول</th>
                                        <th scope="col" class="px-6 py-3">وقت المغادرة</th>
                                        <th scope="col" class="px-6 py-3">وقت الوصول</th>
                                        <th scope="col" class="px-6 py-3">الطائرة</th>
                                        <th scope="col" class="px-6 py-3">الحالة</th>
                                        <th scope="col" class="px-6 py-3">صورة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($flights->where('flight_type', 'normal_flight') as $flight)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $flight->flight_number }}</td>
                                        <td class="px-6 py-4">{{ $flight->flight_date }}</td>
                                        <td class="px-6 py-4">{{ $flight->originAirport->airport_name ?? '—' }}</td>
                                        <td class="px-6 py-4">{{ $flight->destinationAirport->airport_name ?? '—' }}</td>
                                        <td class="px-6 py-4">{{ $flight->departure_time ? \Carbon\Carbon::parse($flight->departure_time)->format('h:i A') : '—' }}</td>
                                        <td class="px-6 py-4">{{ $flight->arrival_time ? \Carbon\Carbon::parse($flight->arrival_time)->format('h:i A') : '—' }}</td>
                                        <td class="px-6 py-4">{{ $flight->aircraft->aircraft_name ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            @if($flight->status == 'completed')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">مكتملة</span>
                                            @elseif($flight->status == 'rejected')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">مرفوضة</span>
                                            @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">قيد المراجعة</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($flight->image)
                                            <img src="{{ asset('storage/' . $flight->image) }}" alt="صورة الرحلة" class="w-12 h-12 object-cover rounded cursor-pointer" onclick="window.open('{{ asset("storage/" . $flight->image) }}', '_blank')">
                                            @else
                                            <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="flex justify-center items-center p-8">
                            <p class="text-gray-500 text-lg">لا توجد رحلات عادية متاحة حالياً</p>
                        </div>
                        @endif
                    </div>

                    <div class="hidden pt-4 px-4" id="simulation-flights" role="tabpanel" aria-labelledby="simulation-flights-tab">
                        @if($flights->where('flight_type', 'simulated_flight')->count() > 0)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">رقم الرحلة</th>
                                        <th scope="col" class="px-6 py-3">تاريخ الرحلة</th>
                                        <th scope="col" class="px-6 py-3">الطائرة</th>
                                        <th scope="col" class="px-6 py-3">الحالة</th>
                                        <th scope="col" class="px-6 py-3">صورة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($flights->where('flight_type', 'simulated_flight') as $flight)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $flight->flight_number }}</td>
                                        <td class="px-6 py-4">{{ $flight->flight_date }}</td>
                                        <td class="px-6 py-4">{{ $flight->aircraft->aircraft_name ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            @if($flight->status == 'completed')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">مكتملة</span>
                                            @elseif($flight->status == 'rejected')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">مرفوضة</span>
                                            @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">قيد المراجعة</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($flight->image)
                                            <img src="{{ asset('storage/' . $flight->image) }}" alt="صورة الرحلة" class="w-12 h-12 object-cover rounded cursor-pointer" onclick="window.open('{{ asset("storage/" . $flight->image) }}', '_blank')">
                                            @else
                                            <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="flex justify-center items-center p-8">
                            <p class="text-gray-500 text-lg">لا توجد رحلات تشبيهية متاحة حالياً</p>
                        </div>
                        @endif
                    </div>

                    <div class="hidden pt-4 px-4" id="unloaded-flights" role="tabpanel" aria-labelledby="unloaded-flights-tab">
                        @if($flights->where('flight_type', 'unloaded_flight')->count() > 0)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">رقم الرحلة</th>
                                        <th scope="col" class="px-6 py-3">تاريخ الرحلة</th>
                                        <th scope="col" class="px-6 py-3">الطائرة</th>
                                        <th scope="col" class="px-6 py-3">الحالة</th>
                                        <th scope="col" class="px-6 py-3">صورة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($flights->where('flight_type', 'unloaded_flight') as $flight)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $flight->flight_number }}</td>
                                        <td class="px-6 py-4">{{ $flight->flight_date }}</td>
                                        <td class="px-6 py-4">{{ $flight->aircraft->aircraft_name ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            @if($flight->status == 'completed')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">مكتملة</span>
                                            @elseif($flight->status == 'rejected')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">مرفوضة</span>
                                            @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">قيد المراجعة</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($flight->image)
                                            <img src="{{ asset('storage/' . $flight->image) }}" alt="صورة الرحلة" class="w-12 h-12 object-cover rounded cursor-pointer" onclick="window.open('{{ asset("storage/" . $flight->image) }}', '_blank')">
                                            @else
                                            <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="flex justify-center items-center p-8">
                            <p class="text-gray-500 text-lg">لا توجد رحلات غير محملة متاحة حالياً</p>
                        </div>
                        @endif
                    </div>

                    <div class="hidden pt-4 px-4" id="test-flights" role="tabpanel" aria-labelledby="test-flights-tab">
                        @if($flights->where('flight_type', 'airplane_test')->count() > 0)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">رقم الرحلة</th>
                                        <th scope="col" class="px-6 py-3">تاريخ الرحلة</th>
                                        <th scope="col" class="px-6 py-3">الطائرة</th>
                                        <th scope="col" class="px-6 py-3">الحالة</th>
                                        <th scope="col" class="px-6 py-3">صورة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($flights->where('flight_type', 'airplane_test') as $flight)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $flight->flight_number }}</td>
                                        <td class="px-6 py-4">{{ $flight->flight_date }}</td>
                                        <td class="px-6 py-4">{{ $flight->aircraft->aircraft_name ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            @if($flight->status == 'completed')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">مكتملة</span>
                                            @elseif($flight->status == 'rejected')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">مرفوضة</span>
                                            @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">قيد المراجعة</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($flight->image)
                                            <img src="{{ asset('storage/' . $flight->image) }}" alt="صورة الرحلة" class="w-12 h-12 object-cover rounded cursor-pointer" onclick="window.open('{{ asset("storage/" . $flight->image) }}', '_blank')">
                                            @else
                                            <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="flex justify-center items-center p-8">
                            <p class="text-gray-500 text-lg">لا توجد رحلات اختبار متاحة حالياً</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="flightsModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">إغلاق</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>