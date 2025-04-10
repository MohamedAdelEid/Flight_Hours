<?php
$flights = \App\Models\Flight::with('originAirport', 'destinationAirport', 'aircraft')->where('user_id', auth()->user()->id)->get();
?>
<!DOCTYPE html>
<html dir="rtl">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourly - Travel agancy</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

    <!-- custom css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/captain/style.css') }}">

    {{-- flowbit cdn style --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />

    <!-- link font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@100..900&display=swap" rel="stylesheet">

    @stack('style')
</head>

<body id="top">

    <!--#HEADER -->

    <header class="header" data-header>

        <div class="overlay" data-overlay></div>

        <div class="header-top">
            <div class="container">

                <div class="header-btn-group">

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
                        <!-- <li>
                            <a href="#"  class="navbar-link" data-nav-link>الصفحة الشخصية</a>
                        </li> -->
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button href="#destination" class="navbar-link" data-nav-link>تسجيل الخروج</button>
                            </form>
                        </li>


                    </ul>

                </nav>

            </div>
        </div>


    </header>

    {{ $slot }}

    </article>
    </main>


    <!-- #GO TO TOP -->
    <a href="#top" class="go-top" data-go-top>
        <ion-icon name="chevron-up-outline"></ion-icon>
    </a>


    <!-- custom js link -->
    <script src="{{ asset('assets/js/captain/script.js') }}"></script>

    {{-- ionicons link --}}
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    {{-- flowbit cdn script --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    {{-- tailwind cdn --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<!-- Flights Modal -->
<div id="flightsModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
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
            
            <!-- Modal body -->
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

                <!-- Tab content -->
                <div id="flightsTabContent">
                    <!-- Regular Flights Tab -->
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($flights->where('flight_type', 'normal_flight') as $flight)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $flight->flight_number }}</td>
                                        <td class="px-6 py-4">{{ $flight->flight_date }}</td>
                                        <td class="px-6 py-4">{{ $flight->originAirport->airport_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">{{ $flight->destinationAirport->airport_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($flight->departure_time)->format('h:i A') }}</td>
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($flight->arrival_time)->format('h:i A') }}</td>
                                        <td class="px-6 py-4">{{ $flight->aircraft->aircraft_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">
                                            @if($flight->status == 'pending')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">قيد التنفيذ</span>
                                            @elseif($flight->status == 'completed')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">مكتملة</span>
                                            @elseif($flight->status == 'cancelled')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">ملغاة</span>
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

                    <!-- Simulation Flights Tab -->
                    <div class="hidden pt-4 px-4" id="simulation-flights" role="tabpanel" aria-labelledby="simulation-flights-tab">
                        @if($flights->where('flight_type', 'simulated_flight')->count() > 0)
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($flights->where('flight_type', 'simulated_flight') as $flight)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $flight->flight_number }}</td>
                                        <td class="px-6 py-4">{{ $flight->flight_date }}</td>
                                        <td class="px-6 py-4">{{ $flight->originAirport->airport_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">{{ $flight->destinationAirport->airport_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($flight->departure_time)->format('h:i A') }}</td>
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($flight->arrival_time)->format('h:i A') }}</td>
                                        <td class="px-6 py-4">{{ $flight->aircraft->aircraft_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">
                                            @if($flight->status == 'pending')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">قيد التنفيذ</span>
                                            @elseif($flight->status == 'completed')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">مكتملة</span>
                                            @elseif($flight->status == 'cancelled')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">ملغاة</span>
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

                    <!-- Unloaded Flights Tab -->
                    <div class="hidden pt-4 px-4" id="unloaded-flights" role="tabpanel" aria-labelledby="unloaded-flights-tab">
                        @if($flights->where('flight_type', 'unloaded_flight')->count() > 0)
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($flights->where('flight_type', 'unloaded_flight') as $flight)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $flight->flight_number }}</td>
                                        <td class="px-6 py-4">{{ $flight->flight_date }}</td>
                                        <td class="px-6 py-4">{{ $flight->originAirport->airport_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">{{ $flight->destinationAirport->airport_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($flight->departure_time)->format('h:i A') }}</td>
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($flight->arrival_time)->format('h:i A') }}</td>
                                        <td class="px-6 py-4">{{ $flight->aircraft->aircraft_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">
                                            @if($flight->status == 'pending')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">قيد التنفيذ</span>
                                            @elseif($flight->status == 'completed')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">مكتملة</span>
                                            @elseif($flight->status == 'cancelled')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">ملغاة</span>
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

                    <!-- Test Flights Tab -->
                    <div class="hidden pt-4 px-4" id="test-flights" role="tabpanel" aria-labelledby="test-flights-tab">
                        @if($flights->where('flight_type', 'airplane_test')->count() > 0)
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($flights->where('flight_type', 'airplane_test') as $flight)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $flight->flight_number }}</td>
                                        <td class="px-6 py-4">{{ $flight->flight_date }}</td>
                                        <td class="px-6 py-4">{{ $flight->originAirport->airport_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">{{ $flight->destinationAirport->airport_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($flight->departure_time)->format('h:i A') }}</td>
                                        <td class="px-6 py-4">{{ Carbon\Carbon::parse($flight->arrival_time)->format('h:i A') }}</td>
                                        <td class="px-6 py-4">{{ $flight->aircraft->aircraft_name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4">
                                            @if($flight->status == 'pending')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">قيد التنفيذ</span>
                                            @elseif($flight->status == 'completed')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">مكتملة</span>
                                            @elseif($flight->status == 'cancelled')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">ملغاة</span>
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

            <!-- Modal footer -->
            <div class="flex items-center justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="flightsModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">إغلاق</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>
