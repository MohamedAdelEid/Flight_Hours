@extends('layouts.employee.main')

@section('alerts')
    @if (Session::has('successUpdate'))
        <script>
            iziToast.success({
                title: "{{ session('successUpdate') }}",
                position: 'topRight',
            });
        </script>
    @endif
@endsection

@section('content')
    <x-employee.form-page title="تعديل طائرة">
        <form action="{{ route('aircraft.update', $aircraft->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="emp-form-grid">
                <x-employee.form.input name="aircraft_name" label="اسم الطائرة" :value="$aircraft->aircraft_name" />
                <x-employee.form.input name="aircraft_code" label="طراز الطائرة" :value="$aircraft->aircraft_code" />
                <x-employee.form.input name="manufacturer" label="اسم الصانع" :value="$aircraft->manufacturer" />
                <x-employee.form.input name="registration_number" label="رقم التسجيل" :value="$aircraft->registration_number" />
                <x-employee.form.select name="status" label="حالة الطائرة" class="sm:col-span-2 sm:max-w-xs">
                    <option value="active" @selected(old('status', $aircraft->status) == 'active')>نشطة</option>
                    <option value="inactive" @selected(old('status', $aircraft->status) == 'inactive')>غير نشطة</option>
                    <option value="maintenance" @selected(old('status', $aircraft->status) == 'maintenance')>داخل الصيانة</option>
                </x-employee.form.select>
            </div>
            <x-employee.form.submit label="تعديل" />
        </form>
    </x-employee.form-page>
@endsection
