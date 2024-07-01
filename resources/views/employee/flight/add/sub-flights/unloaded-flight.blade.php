@extends('layouts.employee.main')

@section('alerts')
    {{-- alert add AirCraft success --}}
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
    @include('employee/flight/add/sub-flight-layout' , ['title' => 'إضافة رحلة طيران غير محمل' , 'route' => 'flight.store'])
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('employee/flight/add/crew-section/addCrewByJs')
    <script src="{{ asset('assets/js/employee/ajax/getCrewByJob.js') }}"></script>
@endpush
