@extends('layouts.employee.main')

@section('alerts')
    {{-- alert add AirCraft success --}}
    @if (Session::has('successCreate'))
        <script>
            iziToast.success({
                title: "{{ session('successCreate') }}",
                position: 'topRight',
            });
        </script>
    @endif
@endsection

@section('content')
    <main class="h-full pb-16 overflow-y-auto scrollbar-hide">
        <div class="container px-6 mx-auto grid">

            <h2 class="mt-10 px-7 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                اضافة رحلة طيران
            </h2>

            <div class="px-7 pt-8 pb-10 mb-8 ">


                <form action="{{ route('flight.store') }}" method="POST" id="flight">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-x-6 gap-y-4">

                        {{-- One way trip --}}
                        <div>

                            <div class="px-7 pt-6 pb-10 mb-7 bg-white rounded-lg shadow-md dark:bg-gray-800">

                                <div class="text-gray-700 dark:text-white block mb-5">
                                    <p class="text-center text-xl font-bold">ذهاب</p>
                                </div>

                                <div class="flex items-center mt-2">

                                    <div class="relative w-full me-1 lg:me-0 xl:me-0">
                                        <select id="from-airport-going"
                                            class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                                    focus:pt-7
                                                    focus:pb-2
                                                    [&:not(:placeholder-shown)]:pt-7
                                                    [&:not(:placeholder-shown)]:pb-2
                                                    autofill:pt-6">
                                            <option value="" disabled selected>اختر مطار المغادرة ... </option>
                                            @forelse($airports as $airport)
                                                <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                                            @empty
                                                <option disabled>لا يوجد مطارات </option>
                                            @endforelse
                                        </select>
                                        <label for="from-airport-going"
                                            class="absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-200 border border-transparent origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                                    peer-focus:scale-90
                                                    peer-focus:translate-x-0.5
                                                    peer-focus:-translate-y-1.5
                                                    peer-focus:text-blue-500 dark:peer-focus:text-blue-500
                                                    peer-[:not(:placeholder-shown)]:scale-90
                                                    peer-[:not(:placeholder-shown)]:translate-x-0.5
                                                    peer-[:not(:placeholder-shown)]:-translate-y-1.5
                                                    dark:peer-[:not(:placeholder-shown)]:text-neutral-500 font-semibold">من
                                            <i
                                                class="fa-solid fa-plane-departure text-blue-500 ms-2 transform -scale-x-100"></i></label>
                                        @error('origin_airport_id')
                                            <span class="absolute text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="lg:flex items-center justify-center lg:w-3/4 xl:w-1/2 hidden">
                                        <p class="m-0 ">
                                            <span class="text-blue-400">-</span>
                                            <span class="text-blue-300">-</span>
                                            <span class="text-blue-200">-</span>
                                        </p>
                                        <i class="fa-solid fa-plane transform -scale-x-100 text-xl text-blue-500 mx-1"></i>
                                        <p class="m-0"><span class="text-blue-200">-</span> <span
                                                class="text-blue-300">-</span> <span class="text-blue-400">-</span> </p>
                                    </div>

                                    <div class="relative w-full ms-1 lg:ms-0 xl:ms-0">
                                        <select id="to-airport-going"
                                            class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                                    focus:pt-7
                                                    focus:pb-2
                                                    [&:not(:placeholder-shown)]:pt-7
                                                    [&:not(:placeholder-shown)]:pb-2
                                                    autofill:pt-6">
                                            <option value="" disabled selected>اختر مطار الوصول ... </option>
                                            @forelse($airports as $airport)
                                                <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                                            @empty
                                                <option disabled>لا يوجد مطارات </option>
                                            @endforelse
                                        </select>
                                        <label for="to-airport-going"
                                            class="absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-200 border border-transparent origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                                    peer-focus:scale-90
                                                    peer-focus:translate-x-0.5
                                                    peer-focus:-translate-y-1.5
                                                    peer-focus:text-blue-500 dark:peer-focus:text-blue-500
                                                    peer-[:not(:placeholder-shown)]:scale-90
                                                    peer-[:not(:placeholder-shown)]:translate-x-0.5
                                                    peer-[:not(:placeholder-shown)]:-translate-y-1.5
                                                    dark:peer-[:not(:placeholder-shown)]:text-neutral-500 font-semibold">الي
                                            <i
                                                class="fa-solid fa-plane-arrival text-blue-500 ms-2 transform -scale-x-100"></i>
                                        </label>
                                        @error('origin_airport_id')
                                            <span class="absolute text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="px-7 pt-6 pb-10 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

                                <div class="mb-3">
                                    <label class="text-gray-700 dark:text-white block text-lg"> الطائرة
                                        <select name="aircraft_id"
                                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                            <option disabled selected> اختر طائرة</option>
                                            @forelse($aircrafts as $aircraft)
                                                <option value="{{ $aircraft->id }}">{{ $aircraft->aircraft_name }}
                                                </option>
                                            @empty
                                                <option disabled>لا يوجد طائرات </option>
                                            @endforelse
                                        </select>
                                    </label>
                                    @error('aircraft_id')
                                        <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="lg:flex xl:flex md:block items-center mb-3">
                                    <div class="w-full me-1">
                                        <div>
                                            <label class="block text-xl">
                                                <span class="text-gray-700 dark:text-white block">رقم الرحلة </span>
                                                <input name="flight_number" type="number" placeholder="ادخل رقم الرحلة "
                                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                            </label>
                                            @error('flight_number')
                                                <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="w-full ms-1">
                                        <div>
                                            <label class="block text-xl">
                                                <span class="text-gray-700 dark:text-white block">وقت الرحلة </span>
                                                <input name="flight_date" type="date"
                                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                            </label>
                                            @error('flight_date')
                                                <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="lg:flex xl:flex md:block items-center mb-3">
                                    <div class="lg:w-1/2 xg:w-1/2 w-full me-1">
                                        <label class="block text-xl">
                                            <span class="text-gray-700 dark:text-white block mb-2">وقت إغلاق الباب </span>
                                            <input name="departure_time" type="datetime-local"
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                        </label>
                                        @error('departure_time')
                                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="lg:w-1/2 xg:w-1/2 w-full ms-1">
                                        <label class="block text-xl">
                                            <span class="text-gray-700 dark:text-white block mb-2">وقت الإقلاع </span>
                                            <input name="arrival_time" type="datetime-local"
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                        </label>
                                        @error('arrival_time')
                                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xl">
                                        <span class="text-gray-700 dark:text-white block mb-2">وقت الهبوط <span
                                                class="text-blue-500 text-sm">'Landing'</span> </span>
                                        <input name="arrival_time" type="datetime-local"
                                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                    </label>
                                    @error('arrival_time')
                                        <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="lg:flex xl:flex md:block items-center mb-3">
                                    <div class="lg:w-1/2 xg:w-1/2 w-full me-1">
                                        <label class="block text-xl">
                                            <span class="text-gray-700 dark:text-white block mb-2">وقت فتح الباب </span>
                                            <input name="departure_time" type="datetime-local"
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                        </label>
                                        @error('departure_time')
                                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="lg:w-1/2 xg:w-1/2 w-full ms-1">
                                        <label class="block text-xl">
                                            <span class="text-gray-700 dark:text-white block mb-2">وقت الوصول </span>
                                            <input name="arrival_time" type="datetime-local"
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                        </label>
                                        @error('arrival_time')
                                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Return trip --}}
                        <div>

                            <div class="px-7 pt-6 pb-10 mb-7 bg-white rounded-lg shadow-md dark:bg-gray-800">

                                <div class="text-gray-700 dark:text-white block mb-5">
                                    <p class="text-center text-xl font-bold">عودة</p>
                                </div>

                                <div class="flex items-center mt-2">

                                    <div class="relative w-full me-1 lg:me-0 xl:me-0">
                                        <select id="from-airport-back"
                                            class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                                    focus:pt-7
                                                    focus:pb-2
                                                    [&:not(:placeholder-shown)]:pt-7
                                                    [&:not(:placeholder-shown)]:pb-2
                                                    autofill:pt-6">
                                            <option value="" disabled selected>اختر مطار المغادرة ... </option>
                                            @forelse($airports as $airport)
                                                <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                                            @empty
                                                <option disabled>لا يوجد مطارات </option>
                                            @endforelse
                                        </select>
                                        <label for="from-airport-back"
                                            class="absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-200 border border-transparent origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                                    peer-focus:scale-90
                                                    peer-focus:translate-x-0.5
                                                    peer-focus:-translate-y-1.5
                                                    peer-focus:text-blue-500 dark:peer-focus:text-blue-500
                                                    peer-[:not(:placeholder-shown)]:scale-90
                                                    peer-[:not(:placeholder-shown)]:translate-x-0.5
                                                    peer-[:not(:placeholder-shown)]:-translate-y-1.5
                                                    dark:peer-[:not(:placeholder-shown)]:text-neutral-500 font-semibold">من
                                            <i
                                                class="fa-solid fa-plane-departure text-blue-500 ms-2 transform -scale-x-100"></i></label>
                                        @error('origin_airport_id')
                                            <span class="absolute text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="lg:flex items-center justify-center lg:w-3/4 xl:w-1/2 hidden">
                                        <p class="m-0 ">
                                            <span class="text-blue-400">-</span>
                                            <span class="text-blue-300">-</span>
                                            <span class="text-blue-200">-</span>
                                        </p>
                                        <i class="fa-solid fa-plane transform -scale-x-100 text-xl text-blue-500 mx-1"></i>
                                        <p class="m-0"><span class="text-blue-200">-</span> <span
                                                class="text-blue-300">-</span> <span class="text-blue-400">-</span> </p>
                                    </div>

                                    <div class="relative w-full ms-1 lg:ms-0 xl:ms-0">
                                        <select id="to-airport-back"
                                            class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                                    focus:pt-7
                                                    focus:pb-2
                                                    [&:not(:placeholder-shown)]:pt-7
                                                    [&:not(:placeholder-shown)]:pb-2
                                                    autofill:pt-6">
                                            <option value="" disabled selected>اختر مطار الوصول ... </option>
                                            @forelse($airports as $airport)
                                                <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                                            @empty
                                                <option disabled>لا يوجد مطارات </option>
                                            @endforelse
                                        </select>
                                        <label for="to-airport-back"
                                            class="absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-200 border border-transparent origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                                    peer-focus:scale-90
                                                    peer-focus:translate-x-0.5
                                                    peer-focus:-translate-y-1.5
                                                    peer-focus:text-blue-500 dark:peer-focus:text-blue-500
                                                    peer-[:not(:placeholder-shown)]:scale-90
                                                    peer-[:not(:placeholder-shown)]:translate-x-0.5
                                                    peer-[:not(:placeholder-shown)]:-translate-y-1.5
                                                    dark:peer-[:not(:placeholder-shown)]:text-neutral-500 font-semibold">الي
                                            <i
                                                class="fa-solid fa-plane-arrival text-blue-500 ms-2 transform -scale-x-100"></i>
                                        </label>
                                        @error('origin_airport_id')
                                            <span class="absolute text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="px-7 pt-6 pb-10 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

                                <div class="mb-3">
                                    <label class="text-gray-700 dark:text-white block text-lg"> الطائرة
                                        <select name="aircraft_id"
                                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                            <option disabled selected> اختر طائرة</option>
                                            @forelse($aircrafts as $aircraft)
                                                <option value="{{ $aircraft->id }}">{{ $aircraft->aircraft_name }}
                                                </option>
                                            @empty
                                                <option disabled>لا يوجد طائرات </option>
                                            @endforelse
                                        </select>
                                    </label>
                                    @error('aircraft_id')
                                        <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="lg:flex xl:flex md:block items-center mb-3">
                                    <div class="lg:w-1/2 xg:w-1/2 w-full me-1">
                                        <div>
                                            <label class="block text-xl">
                                                <span class="text-gray-700 dark:text-white block">رقم الرحلة </span>
                                                <input name="flight_number" type="number" placeholder="ادخل رقم الرحلة "
                                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                            </label>
                                            @error('flight_number')
                                                <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="lg:w-1/2 xg:w-1/2 w-full ms-1">
                                        <div>
                                            <label class="block text-xl">
                                                <span class="text-gray-700 dark:text-white block">وقت الرحلة </span>
                                                <input name="flight_date" type="date"
                                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                            </label>
                                            @error('flight_date')
                                                <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="lg:flex xl:flex md:block items-center mb-3">
                                    <div class="lg:w-1/2 xg:w-1/2 w-full me-1">
                                        <label class="block text-xl">
                                            <span class="text-gray-700 dark:text-white block mb-2">وقت إغلاق الباب </span>
                                            <input name="departure_time" type="datetime-local"
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                        </label>
                                        @error('departure_time')
                                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="lg:w-1/2 xg:w-1/2 w-full ms-1">
                                        <label class="block text-xl">
                                            <span class="text-gray-700 dark:text-white block mb-2">وقت الإقلاع </span>
                                            <input name="arrival_time" type="datetime-local"
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                        </label>
                                        @error('arrival_time')
                                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xl">
                                        <span class="text-gray-700 dark:text-white block mb-2">وقت الهبوط <span
                                                class="text-blue-500 text-sm">'Landing'</span> </span>
                                        <input name="arrival_time" type="datetime-local"
                                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                    </label>
                                    @error('arrival_time')
                                        <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="lg:flex xl:flex md:block items-center mb-3">
                                    <div class="lg:w-1/2 xg:w-1/2 w-full me-1">
                                        <label class="block text-xl">
                                            <span class="text-gray-700 dark:text-white block mb-2">وقت فتح الباب </span>
                                            <input name="departure_time" type="datetime-local"
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                        </label>
                                        @error('departure_time')
                                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="lg:w-1/2 xg:w-1/2 w-full ms-1">
                                        <label class="block text-xl">
                                            <span class="text-gray-700 dark:text-white block mb-2">وقت الوصول </span>
                                            <input name="arrival_time" type="datetime-local"
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                        </label>
                                        @error('arrival_time')
                                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>

                <div class="px-7 pt-4 pb-10 mb-7 bg-white rounded-lg shadow-md dark:bg-gray-800">

                    {{-- number of craw --}}
                    <div class="me-1 mb-5">
                        <form id="crew_flight">
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">عدد طاقم الرحلة</span>
                                <div class="flex items-center relative">
                                    <input type="number" placeholder="ادخل عدد الطاقم" id="num-of-crew"
                                        class="block w-52 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 dark:text-gray-300 form-input" />
                                    <button id="submit-num-of-crew"
                                        class="p-2 font-medium text-sm leading-5 text-white transition duration-200 bg-blue-600 border border-transparent rounded-tl-lg rounded-bl-lg rounded-tr-sm rounded-br-sm active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue focus:ring-2 focus:ring-offset-2 focus:ring-custom-blue">
                                        إضافة
                                    </button>
                                </div>
                            </label>
                        </form>
                    </div>

                    <form action="" id="icontainer-inputs-crew">

                        {{-- add inputs crew here using js  --}}

                    </form>
                </div>

                <button id="submit_flight_crew"
                    class="px-9 py-3 font-medium leading-5 text-white transition duration-200 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue focus:ring-2 focus:ring-offset-2 focus:ring-custom-blue">
                    إضافة
                </button>

            </div>
        </div>
    </main>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- submit two form flight , crew_flight --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var submitFlightAndCrewFlight = document.querySelector('#submit_flight_crew');
            submitFlightAndCrewFlight.onclick = function() {
                var formFlight = document.querySelector('#flight');
                var formFlightCrew = document.querySelector('#crew_flight');
                formFlight.submit();
                formFlightCrew.submit();
            }
        });
    </script>

    {{--  select ToAirportGoing -> FromAirportBack --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toAirportGoing = document.querySelector('#to-airport-going');
            var fromAirportBack = document.querySelector('#from-airport-back');

            toAirportGoing.addEventListener('change', function() {
                fromAirportBack.value = toAirportGoing.value;
            });
        });
    </script>

    {{-- add number of crew  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var numOfCrew = document.querySelector('#num-of-crew');
            var submitOfCrew = document.querySelector('#submit-num-of-crew');
            var divInputsCrew = document.querySelector('#icontainer-inputs-crew');

            console.log('divInputsCrew:', divInputsCrew);

            submitOfCrew.addEventListener('click', function(event) {
                event.preventDefault();

                var numberOfCrew = parseInt(numOfCrew.value);

                if (isNaN(numberOfCrew) || numberOfCrew <= 0) {
                    alert('Please enter a valid number greater than 0.');
                    return;
                }

                var htmlContent = '';
                for (var i = 0; i < numberOfCrew; i++) {
                    htmlContent += `
                    <div class="block md:flex lg:flex xl:flex items-center mb-3">
                        
                        <div class="w-full me-2">
                        <label class="text-gray-700 dark:text-white block text-lg">الوظيفة
                            <select name="job_id" id="job_id"
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                <option disabled selected> اختر نوع الوظيفة</option>
                                @forelse($jobs as $job)
                                    <option value="{{ $job->id }}"> {{ $job->job_name }} </option>
                                @empty
                                    <option>لا يوجد وظائف</option>
                                @endforelse
                            </select>
                        </label>
                        @error('job_id')
                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="w-full ms-2">
                        <label class="text-gray-700 dark:text-white block text-lg">الموظف
                            <select name="crew_id" id="crew_id"
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                <option disabled selected>اختر الوظيفة اولا</option>
                            </select>
                        </label>
                        @error('')
                            <span class="absolute buttom-0 text-xs text-red-600 dark:text-red-400 ms-3">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>`;
                }

                if (divInputsCrew) {
                    divInputsCrew.innerHTML = htmlContent;
                }
            });
        });
    </script>

    {{-- add crew using ajax --}}
    <script>
        $(document).ready(function() {
            $('#job_id').change(function() {
                var job_id = $(this).val();
                if (job_id) {
                    $.ajax({
                        url: '/crews-by-job/' + job_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#crew_id').empty();
                            $('#crew_id').append(
                                '<option disabled selected>اختر الوظيفة</option>');
                            $.each(data, function(key, crew) {
                                $('#crew_id').append('<option value="' + crew.id +
                                    '">' +
                                    crew.first_name + crew.last_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#crew_id').empty();
                    $('#crew_id').append('<option disabled selected>اختر نوع الموظف أولا</option>');
                }
            });
        });
    </script>
@endpush
