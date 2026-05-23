@extends('layouts.employee.main')

@section('alerts')
    @if (Session::has('successCreate'))
        <script>
            iziToast.success({
                title: "{{ session('successCreate') }}",
                position: 'topRight',
            });
            localStorage.removeItem('numOfCrew');
        </script>
    @endif
    @if (Session::has('successUpdate'))
        <script>
            iziToast.success({
                title: "{{ session('successUpdate') }}",
                position: 'topRight',
            });
            localStorage.removeItem('numOfCrew');
        </script>
    @endif
@endsection

@section('content')
    <x-employee.list-page title="الرحلات">
        @livewire('flight-table')
    </x-employee.list-page>
@endsection
