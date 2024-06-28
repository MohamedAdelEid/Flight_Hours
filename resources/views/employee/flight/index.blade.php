@extends('layouts.employee.main')

@section('alerts')
    {{-- alert add job success --}}
    @if (Session::has('successCreate'))
        <script>
            iziToast.success({
                title: "{{ session('successCreate') }}",
                position: 'topRight',
            });

            // reset num of crew
            localStorage.removeItem('numOfCrew');
        </script>
    @endif

    @if (Session::has('successUpdate'))
        <script>
            iziToast.success({
                title: "{{ session('successUpdate') }}",
                position: 'topRight',
            });

            // reset num of crew
            localStorage.removeItem('numOfCrew');
        </script>
    @endif
@endsection

@section('content')
    <main class="h-full pb-16 overflow-y-auto scrollbar-hide">
        <div class="container grid px-6 mx-auto">

            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                الرحلات
            </h2>

            @livewire('flight-table')

        </div>
    </main>
@endsection
