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
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto grid">

            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                تعديل علي رحلة طيران
            </h2>

            <div class="px-7 pt-8 pb-10 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <form action="{{ route('flight.update',$flight->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-x-6 gap-y-4">

                        {{-- crew Name --}}

                        <label class="block text-xl"> اسم الطائرة
                            <select name="aircraft_id"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                @forelse($aircrafts as $aircraft)
                                    <option value="{{ $aircraft->id }}" {{ $aircraft->id == $flight->aircraft_id ? 'selected' : '' }}>
                                        {{ $aircraft->aircraft_name }}
                                    </option>
                                @empty
                                    <option disabled>لا يوجد طائرات </option>
                                @endforelse
                            </select>
                        </label>
                        @error('aircraft_id')
                        <span class="text-xs text-red-600 dark:text-red-400">
        {{ $message }}
    </span>
                        @enderror

                        <div>
                        <div>
                            <div>
                                <label class="block text-xl">
                                    <span class="text-gray-700 dark:text-white block mb-2"> رقم الرحلة </span>
                                    <input name="flight_number"
                                           value="{{$flight->flight_number}}"
                                           placeholder="ادخل رقم الرحلة "
                                           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                @error('flight_number')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                        </div>
                        <div>
                            <div>
                                <label class="block text-xl">
                                    <span class="text-gray-700 dark:text-white block mb-2"> تاريخ الرحلة  </span>
                                    <input name="flight_date"
                                           value="{{$flight->flight_date}}"
                                           type="date"
                                           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                @error('flight_date')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                        </div>

                    </div>
            </div>
            <div>
                <label class="block text-xl">
                    <span class="text-gray-700 dark:text-white block mb-2"> مطار القيام  </span>
                    <select name="origin_airport_id"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                        @forelse($airports as $airport )
                            <option value="{{ $airport->id }}" {{$flight->origin_airport_id == $airport->id ? 'selected' : '' }}>
                                {{ $airport->airport_name}}
                            </option>
                        @empty
                            <option disabled>لا يوجد مطارات </option>
                        @endforelse
                    </select>
                </label>
                @error('origin_airport_id')
                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                @enderror
            </div>
            <div>
                <label class="block text-xl">
                    <span class="text-gray-700 dark:text-white block mb-2"> مطار الوصول  </span>
                    <select name="destination_airport_id"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                        @forelse($airports as $airport )
                            <option value="{{ $airport->id }}" {{$flight->destination_airport_id == $airport->id ? 'selected' : '' }}>
                                {{ $airport->airport_name}}
                            </option>
                        @empty
                            <option disabled>لا يوجد مطارات </option>
                        @endforelse
                    </select>
                </label>
                @error('destination_airport_id')
                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                @enderror
            </div>
            <div>
                <div>
                    <label class="block text-xl">
                        <span class="text-gray-700 dark:text-white block mb-2">وقت القيام </span>
                        <input name="departure_time" type="datetime-local"
                               value="{{$flight->departure_time}}"
                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                    </label>
                    @error('departure_time')
                    <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xl">
                        <span class="text-gray-700 dark:text-white block mb-2">وقت الوصول  </span>
                        <input name="arrival_time" type="datetime-local"
                               value="{{$flight->arrival_time}}"
                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                    </label>
                    @error('arrival_time')
                    <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                    @enderror
                </div>
            </div>

            <div></div>
            <button
                class="px-9 py-3 mt-6 font-medium leading-5 text-white transition duration-200 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue focus:ring-2 focus:ring-offset-2 focus:ring-custom-blue">
                إضافة
            </button>

            </form>
        </div>

        </div>
    </main>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endpush
