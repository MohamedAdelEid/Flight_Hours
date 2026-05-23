@extends('layouts.employee.main')

@section('content')
<x-employee.form-page title="تفاصيل الطائرة">
    <dl class="emp-show-list sm:grid-cols-2 emp-form-grid">
        <div>
            <dt>اسم الطائرة</dt>
            <dd>{{ $aircraft->aircraft_name }}</dd>
        </div>
        <div>
            <dt>طراز الطائرة</dt>
            <dd>{{ $aircraft->aircraft_code }}</dd>
        </div>
        <div>
            <dt>الصانع</dt>
            <dd>{{ $aircraft->manufacturer }}</dd>
        </div>
        <div>
            <dt>الحالة</dt>
            <dd><x-employee.table.status-badge :status="$aircraft->status" /></dd>
        </div>
        <div>
            <dt>رقم التسجيل</dt>
            <dd>{{ $aircraft->registration_number }}</dd>
        </div>
    </dl>
</x-employee.form-page>
@endsection
