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
    <x-employee.form-page title="تعديل مطار">
        <form action="{{ route('airport.update', $airport->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="emp-form-grid">
                <x-employee.form.input name="airport_name" label="اسم المطار" :value="$airport->airport_name" />
                <x-employee.form.input name="airport_code" label="كود المطار" :value="$airport->airport_code" />
            </div>
            <x-employee.form.submit label="تعديل" />
        </form>
    </x-employee.form-page>
@endsection
