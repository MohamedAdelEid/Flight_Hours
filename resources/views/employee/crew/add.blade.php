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
    <x-employee.form-page title="إضافة عضو طاقم" wide>
        <form action="{{ route('crew.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="emp-form-grid">
                <x-employee.form.input name="first_name" label="الاسم" placeholder="أدخل اسم الموظف" />
                <x-employee.form.input name="last_name" label="اسم الأب" placeholder="أدخل اسم الأب" />
                <x-employee.form.input name="nickname" label="اللقب" placeholder="أدخل لقب الموظف" />
                <x-employee.form.input type="date" name="date_of_birth" label="تاريخ الميلاد" />
                <x-employee.form.input name="financial_number" label="الرقم المالي" placeholder="أدخل الرقم المالي" />
                <x-employee.form.input name="license_number" label="رقم الرخصة" placeholder="أدخل رقم الرخصة" />
                <x-employee.form.select name="status" label="حالة الموظف">
                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>اختر الحالة</option>
                    <option value="active" @selected(old('status') == 'active')>فعال</option>
                    <option value="inactive" @selected(old('status') == 'inactive')>غير فعال</option>
                </x-employee.form.select>
                <x-employee.form.select name="job_type" id="job_type" label="نوع الموظف">
                    @forelse ($job_types as $job_type)
                        <option value="{{ $job_type->id }}" @selected(old('job_type') == $job_type->id)>
                            {{ $job_type->job_type }}
                        </option>
                    @empty
                        <option disabled>لا يوجد نوع وظيفة</option>
                    @endforelse
                </x-employee.form.select>
                <x-employee.form.select name="job_id" id="job_id" label="الوظيفة">
                    <option disabled selected>اختر نوع الموظف أولاً</option>
                </x-employee.form.select>
            </div>
            <x-employee.form.submit label="إضافة" />
        </form>
    </x-employee.form-page>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#job_type').change(function() {
                var type_id = $(this).val();
                if (type_id) {
                    $.ajax({
                        url: '/jobs-by-type/' + type_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#job_id').empty();
                            $('#job_id').append('<option disabled selected>اختر الوظيفة</option>');
                            $.each(data, function(key, job) {
                                $('#job_id').append('<option value="' + job.id + '">' + job.job_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#job_id').empty();
                    $('#job_id').append('<option disabled selected>اختر نوع الموظف أولاً</option>');
                }
            });
        });
    </script>
@endpush
