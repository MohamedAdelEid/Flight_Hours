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
    <x-employee.list-page title="المطارات">
        @livewire('airport-table')
    </x-employee.list-page>
@endsection
