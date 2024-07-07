<main class="h-full pb-16 overflow-y-auto scrollbar-hide">
    <div class="container px-6 mx-auto grid">

        <h2 class="mt-10 px-7 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ $title }}
        </h2>

        <div class="px-7 pt-8 pb-10 mb-8 ">


            <form action="{{ route($route) }}" method="POST" id="flight">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 gap-x-6 gap-y-4">

                    {{-- departure flight --}}
                    <div>

                        <div class="px-7 pt-6 pb-10 mb-7 bg-white rounded-lg shadow-md dark:bg-gray-800">

                            <div class="text-gray-700 dark:text-white block mb-5">
                                <p class="text-xl font-bold">مكان التدريب</p>
                            </div>

                            <div class="flex items-center mt-2 mb-5">

                                <div class="relative w-full me-1 lg:me-0 xl:me-0">
                                    <select id="from-airport-going" name="airport_id"
                                        class="peer p-4 block w-full rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-700 bg-gray-200 dark:border-blue-700 dark:text-white dark:focus:ring-blue-600
                                                focus:pt-7
                                                focus:pb-2
                                                [&:not(:placeholder-shown)]:pt-7
                                                [&:not(:placeholder-shown)]:pb-2
                                                autofill:pt-6">
                                        <option value="" disabled>اختر مطار ... </option>
                                        @forelse($airports as $airport)
                                            <option value="{{ $airport->id }}"
                                                {{ old('airport_id') == $airport->id ? 'selected' : '' }}>
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
                                                dark:peer-[:not(:placeholder-shown)]:text-neutral-500 font-semibold">مطار
                                        <i
                                            class="fa-solid fa-plane-departure text-blue-500 ms-2 transform -scale-x-100"></i></label>
                                    @error('airport_id')
                                        <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                             {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            {{-- date of flight --}}
                            <div class="mb-3">
                                <label class="block text-xl">
                                    <span class="text-gray-700 dark:text-white block">تاريخ الرحلة </span>
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

                            <div class="lg:flex xl:flex md:block items-center mb-5">

                                {{-- aircraft --}}
                                <div class="w-full lg:me-1">
                                    <label class="text-gray-700 dark:text-white block text-lg"> الطائرة
                                        <select name="aircraft_id"
                                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                            <option disabled> اختر طائرة</option>
                                            @forelse($aircrafts as $aircraft)
                                                <option value="{{ $aircraft->id }}"
                                                    {{ old('aircraft_id') == $aircraft->id ? 'selected' : '' }}>
                                                    {{ $aircraft->aircraft_name }}
                                                </option>
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

                                {{-- number aircraft --}}
                                <div class="w-full lg:ms-1 mt-3 lg:mt-0">
                                    <div>
                                        <label class="block text-xl">
                                            <span class="text-gray-700 dark:text-white block">رقم تسجيل الطائرة</span>
                                            <input name="flight_number" type="number"
                                                value="{{ old('flight_number') }}"
                                                placeholder="ادخل رقم تسجيل الطائرة "
                                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                        </label>
                                        @error('flight_number')
                                            <span class="text-xs text-red-600 dark:text-red-400 ms-3">
                                                 {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <button id="submit_flight_crew"
                                class="px-9 py-3 font-medium leading-5 text-white transition duration-200 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue focus:ring-2 focus:ring-offset-2 focus:ring-custom-blue">
                                إضافة
                            </button>

                        </div>

                    </div>

                    <div>
                        <div class="px-7 pt-4 pb-10 mb-7 bg-white rounded-lg shadow-md dark:bg-gray-800">

                            {{-- number of craw --}}
                            <div class="me-1 mb-5">
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
                            </div>
                            <div id="icontainer-inputs-crew">
                                {{-- Dynamic crew inputs will be added here --}}
                            </div>

                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
</main>
