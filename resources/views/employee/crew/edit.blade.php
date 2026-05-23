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
    <x-employee.form-page title="تعديل عضو طاقم" wide>
        <form action="{{ route('crew.update', $crew->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="emp-form-grid">
                <x-employee.form.input name="first_name" label="الاسم" :value="$crew->first_name" />
                <x-employee.form.input name="last_name" label="اسم الأب" :value="$crew->last_name" />
                <x-employee.form.input name="nickname" label="اللقب" :value="$crew->nickname" />
                <x-employee.form.input type="date" name="date_of_birth" label="تاريخ الميلاد" :value="$crew->date_of_birth" />
                <x-employee.form.input name="financial_number" label="الرقم المالي" :value="$crew->financial_number" />
                <x-employee.form.input name="license_number" label="رقم الرخصة" :value="$crew->license_number" />
                <x-employee.form.select name="status" label="حالة الموظف">
                    <option value="active" @selected(old('status', $crew->status) === 'active')>فعال</option>
                    <option value="inactive" @selected(old('status', $crew->status) === 'inactive')>غير فعال</option>
                </x-employee.form.select>
                <x-employee.form.select name="job_type" id="job_type" label="نوع الموظف">
                    @foreach ($job_types as $jobType)
                        <option value="{{ $jobType->id }}" @selected(old('job_type', $crew->job_type) == $jobType->id)>
                            {{ $jobType->job_type }}
                        </option>
                    @endforeach
                </x-employee.form.select>
                <x-employee.form.select name="job_id" id="job_id" label="الوظيفة">
                    @foreach ($jobs as $job)
                        <option value="{{ $job->id }}" @selected(old('job_id', $crew->job_id) == $job->id)>
                            {{ $job->job_name }}
                        </option>
                    @endforeach
                </x-employee.form.select>
            </div>
            <x-employee.form.submit label="تعديل" />
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
                }
            });
        });
    </script>
@endpush
