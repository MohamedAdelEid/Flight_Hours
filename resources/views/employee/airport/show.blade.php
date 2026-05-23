@extends('layouts.employee.main')

@section('content')
<x-employee.form-page title="تفاصيل المطار">
    <dl class="emp-show-list emp-form-grid">
        <div>
            <dt>اسم المطار</dt>
            <dd>{{ $airport->airport_name }}</dd>
        </div>
        <div>
            <dt>كود المطار</dt>
            <dd>{{ $airport->airport_code }}</dd>
        </div>
    </dl>
</x-employee.form-page>
@endsection
