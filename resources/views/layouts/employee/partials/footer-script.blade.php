{{-- include script init  --}}
<script src="{{ asset('assets/js/admin/init-alpine.js') }}"></script>

{{-- include script main  --}}
<script src="{{ asset('assets/js/main.js') }}"></script>

{{-- include script main "employee"  --}}
<script src="{{ asset('assets/js/employee/main.js') }}"></script>

<script src="https://cdn.tailwindcss.com"></script>

<!-- script chart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>

{{-- cdn iziToast "alerts" --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
    integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- cdn sweetAlert "alerts" --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.11.1/sweetalert2.min.js"
    integrity="sha512-Ozu7Km+muKCuIaPcOyNyW8yOw+KvkwsQyehcEnE5nrr0V4IuUqGZUKJDavjSCAA/667Dt2z05WmHHoVVb7Bi+w=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- include scripts livewire --}}
@livewireScripts