@extends('layouts.employee.main')

@section('alerts')
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
    <x-employee.form-page title="إضافة وظيفة">
        <form action="{{ route('job.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="emp-form-grid">
                <x-employee.form.input name="job_name" label="اسم الوظيفة" />
                <x-employee.form.select name="type_id" label="نوع الوظيفة">
                    @forelse ($job_types as $job_type)
                        <option value="{{ $job_type->id }}" @selected(old('type_id') == $job_type->id)>
                            {{ $job_type->job_type }}
                        </option>
                    @empty
                        <option disabled>لا يوجد نوع وظيفة</option>
                    @endforelse
                </x-employee.form.select>
                <x-employee.form.select name="status" label="حالة الوظيفة">
                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>اختر الحالة</option>
                    <option value="active" @selected(old('status') == 'active')>نشطة</option>
                    <option value="inactive" @selected(old('status') == 'inactive')>غير نشطة</option>
                </x-employee.form.select>
                <x-employee.form.field name="hourly_calculation" label="تحسب بالساعة">
                    <label class="emp-checkbox-label">
                        <input type="checkbox" name="hourly_calculation" value="1" @checked(old('hourly_calculation'))
                            class="rounded border-gray-600 text-sky-600 focus:ring-sky-500">
                        <span>نعم، تُحسب بالساعة</span>
                    </label>
                </x-employee.form.field>
            </div>
            <x-employee.form.submit label="إضافة" />
        </form>
    </x-employee.form-page>
@endsection
