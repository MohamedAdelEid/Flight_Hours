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
    <x-employee.form-page title="إضافة طائرة">
        <form action="{{ route('aircraft.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="emp-form-grid">
                <x-employee.form.input name="aircraft_name" label="اسم الطائرة" />
                <x-employee.form.input name="aircraft_code" label="طراز الطائرة" />
                <x-employee.form.input name="manufacturer" label="اسم الصانع" />
                <x-employee.form.input name="registration_number" label="رقم التسجيل" />
                <x-employee.form.select name="status" label="حالة الطائرة" class="sm:col-span-2 sm:max-w-xs">
                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>اختر الحالة</option>
                    <option value="active" @selected(old('status') == 'active')>نشطة</option>
                    <option value="inactive" @selected(old('status') == 'inactive')>غير نشطة</option>
                    <option value="maintenance" @selected(old('status') == 'maintenance')>داخل الصيانة</option>
                </x-employee.form.select>
            </div>
            <x-employee.form.submit label="إضافة" />
        </form>
    </x-employee.form-page>
@endsection
