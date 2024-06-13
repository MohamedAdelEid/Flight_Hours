@extends('layouts.employee.main')

@section('alerts')
    {{-- alert add job success --}}
    @if (Session::has('successCreate'))
        <script>
            iziToast.success({
                title: "{{ session('successCreate') }}",
                position: 'topRight',
            });
        </script>
    @endif
    {{-- alert update job success --}}
    @if (Session::has('successUpdate'))
        <script>
            iziToast.success({
                title: "{{ session('successUpdate') }}",
                position: 'topRight',
            });
        </script>
    @endif

    <script>
        window.addEventListener('swalConfirm', event =>     {
            Swal.fire({
                title: event.title,
                // html: event.detail.html,
                icon: "warning",
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "إلغاء",
                confirmButtonText: "نعم  , احذفة!",
                allowOutSideClick: false,
            }).then(function(result) {
                if (result.value) {
                    console.log(window.livewire);

                    window.livewire.emit('delete', event.detail.id);
                }
            });
        });

        window.addEventListener('deleted', function(event) {
            iziToast.success({
                title: "تم حذف الوظيفة بنجاح",
                position: 'topRight',
            });
        })
    </script>
@endsection

@section('content')
    <main class="h-full pb-16 overflow-y-auto scrollbar-hide">
        <div class="container grid px-6 mx-auto">

            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                الوظائف
            </h2>

            @livewire('job-table')

        </div>
    </main>
@endsection
