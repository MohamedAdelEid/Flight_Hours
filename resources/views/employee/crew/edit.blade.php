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

            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                تعديل علي موظف
            </h2>

            <div class="px-7 pt-8 pb-10 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <form action="{{ route('crew.update', $crew->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-x-6 gap-y-4">

                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">الاسم</span>
                                <input name="first_name" value="{{ $crew->first_name }}"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            </label>
                            @error('first_name')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">اسم الاب </span>
                                <input name="last_name" value="{{ $crew->last_name }}"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            </label>
                            @error('last_name')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">اللقب </span>
                                <input name="nickname" value="{{ $crew->nickname }}"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            </label>
                            @error('nickname')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">تاريخ الميلاد</span>
                                <input name="date_of_birth" type="date" value="{{ $crew->date_of_birth }}"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            </label>
                            @error('date_of_birth')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">الرقم المالي </span>
                                <input name="financial_number" value="{{ $crew->financial_number}}"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            </label>
                            @error('financial_number')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2"> رقم الرخصة </span>
                                <input name="license_number" value="{{ $crew->license_number }}"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            </label>
                            @error('license_number')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">
                                    حالة الموظف
                                </span>
                                <select id="job-status" name="status"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                    <option disabled selected>اختر الحالة</option>
                                    <option value="active" {{ $crew->status === 'active' ? 'selected' : '' }}>فعال</option>
                                    <option value="inactive" {{ $crew->status === 'inactive' ? 'selected' : '' }}>غير فعال
                                    </option>
                                </select>
                            </label>
                            @error('status')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">
                                    نوع الموظف
                                </span>
                                <select name="job_type" id="job_type"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                    @foreach ($job_types as $jobType)
                                        <option value="{{ $jobType->id }}"
                                            {{  $jobType->id === $crew->job_type ? 'selected' : '' }}>{{ $jobType->job_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            @error('job_type')
                            <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">
                                    الوظيفة
                                </span>
                                <select name="job_id" id="job_id"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job->id }}"
                                            {{ $job->id === $crew->job_id ? 'selected' : '' }}>{{ $job->job_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            @error('job_id')
                            <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button
                        class="px-9 py-3 mt-6 font-medium leading-5 text-white transition duration-200 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue focus:ring-2 focus:ring-offset-2 focus:ring-custom-blue">
                        تعديل
                    </button>

                </form>
            </div>

        </div>
    </main>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#job_type').change(function() {
                var type_id = $(this).val();
                if (type_id) {
                    $.ajax({
                        url: '/jobs-by-type/' + type_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#job_id').empty();
                            $('#job_id').append(
                                '<option disabled selected>اختر الوظيفة</option>');
                            $.each(data, function(key, job) {
                                $('#job_id').append('<option value="' + job.id + '">' +
                                    job.job_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#job_id').empty();
                    $('#job_id').append('<option disabled selected>اختر نوع الموظف أولا</option>');
                }
            });
        });
    </script>
@endpush
