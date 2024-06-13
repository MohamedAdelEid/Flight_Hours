@extends('layouts.employee.main')

@section('alerts')
    {{-- alert add job success --}}
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
                تعديل علي وظيفة
            </h2>

            <div class="px-7 pt-8 pb-10 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <form action="{{ route('job.update', $job->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-x-6 gap-y-4">

                        {{-- job_name --}}
                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">اسم الوظيفة</span>
                                <input name="job_name" value="{{ $job->job_name }}"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                            </label>
                            @error('job_name')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">
                                    نوع الوظيفة
                                </span>
                                <select name="type_id"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                    @forelse($job_types as $job_type)
                                        <option value="{{ $job_type->id }}"
                                            {{ $job_type->id == $job->job_type->id ? 'selected' : '' }}>
                                            {{ $job_type->job_type }}
                                        </option>
                                    @empty
                                        <option disabled>لا يوجد نوع وظيفة</option>
                                    @endforelse
                                </select>
                            </label>
                            @error('type_id')
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xl">
                                <span class="text-gray-700 dark:text-white block mb-2">
                                    حالة الوظيفة
                                </span>
                                <select id="job-status" name="status"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
                                    <option disabled selected>اختر الحالة</option>
                                    <option value="active" {{ $job->status == 'active' ? 'selected' : '' }}>نشطة</option>
                                    <option value="inactive"{{ $job->status == 'inactive' ? 'selected' : '' }}>غير نشطة
                                    </option>
                                </select>
                            </label>
                            @error('status')
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
@endpush
