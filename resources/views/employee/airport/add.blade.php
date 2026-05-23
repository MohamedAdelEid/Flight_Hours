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
    <x-employee.form-page title="إضافة مطار">
        <form action="{{ route('airport.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="emp-form-grid">
                <x-employee.form.input name="airport_name" label="اسم المطار" />
                <x-employee.form.input name="airport_code" label="كود المطار" />
            </div>
            <x-employee.form.submit label="إضافة" />
        </form>
    </x-employee.form-page>
@endsection
