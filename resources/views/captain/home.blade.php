@section('alerts')

@if (session('successCreate') || session('success'))
    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        <span class="block sm:inline">{{ session('successCreate') ?? session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
@endif

@if (session('error'))
    <div id="error-alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <span class="block sm:inline">{{ session('error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
@endif

@if ($errors->any())
    <div id="validation-alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle alert close buttons
    const closeButtons = document.querySelectorAll('[role="button"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.closest('div[id$="-alert"]').style.display = 'none';
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('[id$="-alert"]');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    });
});
</script>

@endsection

<x-captain-layout>
    <main>
        <article>

            <section class="hero" id="home">
                <div class="container">

                    <h2 class="h1 hero-title">احجز رحلتك</h2>

                    <div class="btn-group">
                        <button data-modal-target="add-user-modal" data-modal-toggle="add-user-modal"
                            class="btn btn-primary">اضافة رحلة</button>

                            <button class="btn btn-secondary" data-modal-target="flightsModal" data-modal-toggle="flightsModal">عرض الرحلات</button>
                            </div>

                </div>
            </section>

        </article>

        <div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full"
            id="add-user-modal">
            <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-semibold dark:text-white">
                            اضافة رحلة
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 mr-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                            data-modal-toggle="add-user-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="max-h-[500px] overflow-y-auto">
                        <ul class="border-b text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400"
                            id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                            <li class="w-full">
                                <button id="main-flight-tab" data-tabs-target="#main-flight" type="button"
                                    role="tab" aria-controls="main-flight" aria-selected="true"
                                    class="inline-block w-full p-4 rounded-tl-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">رحلة
                                    عادية</button>
                            </li>
                            <li class="w-full">
                                <button id="simulate-flight-tab" data-tabs-target="#simulate-flight" type="button"
                                    role="tab" aria-controls="simulate-flight" aria-selected="false"
                                    class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">طيران
                                    تشبيهي</button>
                            </li>
                            <li class="w-full">
                                <button id="unloaded-flight-tab" data-tabs-target="#unloaded-flight" type="button"
                                    role="tab" aria-controls="unloaded-flight" aria-selected="false"
                                    class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">طيران
                                    غير محمل</button>
                            </li>
                            <li class="w-full">
                                <button id="plane-test-tab" data-tabs-target="#plane-test" type="button" role="tab"
                                    aria-controls="plane-test" aria-selected="false"
                                    class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">اختبار
                                    طائرة</button>
                            </li>
                        </ul>

                        {{-- main flight --}}
                        <div class="hidden pt-4" id="main-flight" role="tabpanel" aria-labelledby="main-flight-tab">
    <div class="p-6 pt-0 space-y-6">
        <form action="{{route('captain.addNormalFlight')}}" method="post">
            @csrf
            <div class="grid grid-cols-1 gap-x-6 gap-y-4">
                {{-- departure flight --}}
                <div>
                    <div c  lass="px-7 pt-6 pb-10 mb-7 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="text-gray-700 dark:text-white block mb-5">
                            <p class="text-center text-xl font-bold">ذهاب</p>
                        </div>

                        <div class="flex items-center mt-2">
                            <div class="relative w-full me-1 lg:me-0 xl:me-0">
                                <select id="from-airport-going" name="departure_origin_airport_id"
                                    class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                    focus:pt-7
                                    focus:pb-2
                                    [&:not(:placeholder-shown)]:pt-7
                                    [&:not(:placeholder-shown)]:pb-2
                                    autofill:pt-6">
                                    <option value="" disabled>اختر مطار المغادرة ...</option>
                                    @forelse($airports as $airport)
                                        <option value="{{ $airport->id }}"
                                            {{ old('departure_origin_airport_id') == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->airport_name }}</option>
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
                                    <i class="fa-solid fa-plane-departure text-blue-500 ms-2 transform -scale-x-100"></i></label>
                                @error('departure_origin_airport_id')
                                    <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="lg:flex items-center justify-center lg:w-3/4 xl:w-1/2 hidden">
                                <i class="fa-solid fa-plane transform -scale-x-100 text-xl text-blue-500 mx-1"></i>
                            </div>

                            <div class="relative w-full ms-1 lg:ms-0 xl:ms-0">
                                <select id="to-airport-going" name="departure_destination_airport_id"
                                    class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                    focus:pt-7
                                    focus:pb-2
                                    [&:not(:placeholder-shown)]:pt-7
                                    [&:not(:placeholder-shown)]:pb-2
                                    autofill:pt-6">
                                    <option value="" disabled>اختر مطار الوصول ...</option>
                                    @forelse($airports as $airport)
                                        <option value="{{ $airport->id }}"
                                            {{ old('departure_destination_airport_id') == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->airport_name }}</option>
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
                                    <i class="fa-solid fa-plane-arrival text-blue-500 ms-2 transform -scale-x-100"></i>
                                </label>
                                @error('departure_destination_airport_id')
                                    <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="pt-6 bg-white rounded-lg dark:bg-gray-800">
                        {{-- date of flight --}}
                        <div class="mb-3">
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block">تاريخ الرحلة</span>
                                <input name="departure_flight_date" type="date" value="{{ old('departure_flight_date') }}"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            </label>
                            @error('departure_flight_date')
                                <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                            {{-- flight number --}}
                            <div>
                                <label class="block text-xl">
                                    <span class="text-gray-700 dark:text-white block">رقم الرحلة</span>
                                    <input name="departure_flight_number" type="number" value="{{ old('departure_flight_number') }}"
                                        placeholder="ادخل رقم الرحلة"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                @error('departure_flight_number')
                                    <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                            {{-- departure time --}}
                            <div>
                                <label class="block text-xl">
                                    <span class="text-gray-700 dark:text-white block">وقت المغادرة</span>
                                    <input name="departure_time" type="time" value="{{ old('departure_time') }}"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                @error('departure_time')
                                    <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- arrival time --}}
                            <div>
                                <label class="block text-xl">
                                    <span class="text-gray-700 dark:text-white block">وقت الوصول</span>
                                    <input name="arrival_time" type="time" value="{{ old('arrival_time') }}"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                @error('arrival_time')
                                    <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- aircraft dropdown --}}
                        <div class="mb-3">
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block">نوع الطائرة</span>
                                <select name="aircraft_id"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-select">
                                    <option value="" disabled selected>اختر نوع الطائرة ...</option>
                                    @forelse($aircrafts as $aircraft)
                                        <option value="{{ $aircraft->id }}"
                                            {{ old('aircraft_id') == $aircraft->id ? 'selected' : '' }}>
                                            {{ $aircraft->aircraft_name }}</option>
                                    @empty
                                        <option disabled>لا يوجد طائرات </option>
                                    @endforelse
                                </select>
                            </label>
                            @error('aircraft_id')
                                <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition duration-200"
                type="submit">اضافة</button>
        </form>
    </div>
</div>

                        {{-- simulate flight --}}
                        <div class="hidden pt-4" id="simulate-flight" role="tabpanel"
                            aria-labelledby="simulate-flight-tab">
                            <div class="p-6 pt-0 space-y-6">
                                <form action="{{route('captain.addSimulateFlight')}}" method="post">
                                    @csrf
                                    <div class="grid grid-cols-1 gap-x-6 gap-y-4">
                                        <div>

                                            <div
                                                class="px-7 pt-6 pb-10 mb-7 bg-white rounded-lg shadow-md dark:bg-gray-800">

                                                <p>الطائرة</p>
                                                <div class="flex items-center mt-2">
                                                    <div class="relative w-full me-1 lg:me-0 xl:me-0">
                                                        <select id="from-airport-going"
                                                            name="aircraft_id"
                                                            class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                                            focus:pt-7
                                                            focus:pb-2
                                                            [&:not(:placeholder-shown)]:pt-7
                                                            [&:not(:placeholder-shown)]:pb-2
                                                            autofill:pt-6">
                                                            <option value="" disabled>اختر الططائرة  ...
                                                            </option>
                                                             @forelse($aircrafts as $aircraft)
                                                        <option value="{{ $aircraft->id }}"
                                                            {{ old('aircraft_id') == $aircraft->id ? 'selected' : '' }}>
                                                            {{ $aircraft->aircraft_name }}</option>
                                                    @empty
                                                        <option disabled>لا يوجد طائرات </option>
                                                    @endforelse
                                                        </select>
                                                        @error('aircraft_id')
                                                            <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- date of flight --}}
                                                <div class="my-3">
                                                    <label class="block text-xl">
                                                        <span class="text-gray-700 dark:text-white block">تاريخ الرحلة
                                                        </span>
                                                        <input name="flight_date" type="date"
                                                            value="{{ old('flight_date') }}"
                                                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                                    </label>
                                                    @error('flight_date')
                                                        <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="w-full lg:me-1">
                                                    <div>
                                                        <label class="block text-xl">
                                                                <span class="text-gray-700 dark:text-white block">رقم
                                                                    الرحلة
                                                                </span>
                                                            <input name="flight_number" type="number"
                                                                   value="{{ old('flight_number') }}"
                                                                   placeholder="ادخل رقم الرحلة "
                                                                   class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                                        </label>
                                                        @error('flight_number')
                                                        <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                                    {{ $message }}
                                                                </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            <input type="hidden" name="flight_type" value="simulated_flight">
                                            </div>

                                        </div>
                                    </div>
                                    <button
                                        class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition duration-200"
                                        type="submit">اضافة</button>
                                </form>

                            </div>
                        </div>

                        {{-- unloaded flight --}}
                        <div class="hidden pt-4" id="unloaded-flight" role="tabpanel"
                            aria-labelledby="unloaded-flight-tab">
                            <div class="p-6 pt-0 space-y-6">
                                <form action="{{route('captain.addUnloadedFlight')}}" method="post">
                                    @csrf
                                    <div class="grid grid-cols-1 gap-x-6 gap-y-4">
                                        <div>

                                            <div
                                                class="px-7 pt-6 pb-10 mb-7 bg-white rounded-lg shadow-md dark:bg-gray-800">

                                                <p>الطائرة</p>
                                                <div class="flex items-center mt-2">
                                                    <div class="relative w-full me-1 lg:me-0 xl:me-0">
                                                        <select id="from-airport-going"
                                                                name="aircraft_id"
                                                                class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                                            focus:pt-7
                                                            focus:pb-2
                                                            [&:not(:placeholder-shown)]:pt-7
                                                            [&:not(:placeholder-shown)]:pb-2
                                                            autofill:pt-6">
                                                            <option value="" disabled>اختر الططائرة  ...
                                                            </option>
                                                            @forelse($aircrafts as $aircraft)
                                                                <option value="{{ $aircraft->id }}"
                                                                    {{ old('aircraft_id') == $aircraft->id ? 'selected' : '' }}>
                                                                    {{ $aircraft->aircraft_name }}</option>
                                                            @empty
                                                                <option disabled>لا يوجد طائرات </option>
                                                            @endforelse
                                                        </select>
                                                        @error('aircraft_id')
                                                        <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- date of flight --}}
                                                <div class="my-3">
                                                    <label class="block text-xl">
                                                        <span class="text-gray-700 dark:text-white block">تاريخ الرحلة
                                                        </span>
                                                        <input name="flight_date" type="date"
                                                               value="{{ old('flight_date') }}"
                                                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                                    </label>
                                                    @error('flight_date')
                                                    <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="w-full lg:me-1">
                                                    <div>
                                                        <label class="block text-xl">
                                                                <span class="text-gray-700 dark:text-white block">رقم
                                                                    الرحلة
                                                                </span>
                                                            <input name="flight_number" type="number"
                                                                   value="{{ old('flight_number') }}"
                                                                   placeholder="ادخل رقم الرحلة "
                                                                   class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                                        </label>
                                                        @error('flight_number')
                                                        <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                                    {{ $message }}
                                                                </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <input type="hidden" name="flight_type" value="unloaded_flight">

                                            </div>

                                        </div>
                                    </div>
                                    <button
                                        class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition duration-200"
                                        type="submit">اضافة</button>
                                </form>

                            </div>
                        </div>

                        {{-- test flight --}}
                        <div class="hidden pt-4" id="plane-test" role="tabpanel" aria-labelledby="plane-test-tab">
                            <div class="p-6 pt-0 space-y-6">
                                <form action="{{route('captain.addTestFlight')}}" method="post">
                                    @csrf
                                    <div class="grid grid-cols-1 gap-x-6 gap-y-4">
                                        <div>

                                            <div
                                                class="px-7 pt-6 pb-10 mb-7 bg-white rounded-lg shadow-md dark:bg-gray-800">

                                                <p>الطائرة</p>
                                                <div class="flex items-center mt-2">
                                                    <div class="relative w-full me-1 lg:me-0 xl:me-0">
                                                        <select id="from-airport-going"
                                                                name="aircraft_id"
                                                                class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                                            focus:pt-7
                                                            focus:pb-2
                                                            [&:not(:placeholder-shown)]:pt-7
                                                            [&:not(:placeholder-shown)]:pb-2
                                                            autofill:pt-6">
                                                            <option value="" disabled>اختر الططائرة  ...
                                                            </option>
                                                            @forelse($aircrafts as $aircraft)
                                                                <option value="{{ $aircraft->id }}"
                                                                    {{ old('aircraft_id') == $aircraft->id ? 'selected' : '' }}>
                                                                    {{ $aircraft->aircraft_name }}</option>
                                                            @empty
                                                                <option disabled>لا يوجد طائرات </option>
                                                            @endforelse
                                                        </select>
                                                        @error('aircraft_id')
                                                        <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- date of flight --}}
                                                <div class="my-3">
                                                    <label class="block text-xl">
                                                        <span class="text-gray-700 dark:text-white block">تاريخ الرحلة
                                                        </span>
                                                        <input name="flight_date" type="date"
                                                               value="{{ old('flight_date') }}"
                                                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                                    </label>
                                                    @error('flight_date')
                                                    <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="w-full lg:me-1">
                                                    <div>
                                                        <label class="block text-xl">
                                                                <span class="text-gray-700 dark:text-white block">رقم
                                                                    الرحلة
                                                                </span>
                                                            <input name="flight_number" type="number"
                                                                   value="{{ old('flight_number') }}"
                                                                   placeholder="ادخل رقم الرحلة "
                                                                   class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                                        </label>
                                                        @error('flight_number')
                                                        <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                                    {{ $message }}
                                                                </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <input type="hidden" name="flight_type" value="airplane_test">

                                            </div>

                                        </div>
                                    </div>
                                    <button
                                        class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition duration-200"
                                        type="submit">اضافة</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
</x-captain-layout>
