<div>
    <x-employee.data-table :paginator="$jobs" per-page-id="job-per-page" class="responsive-card-table">
        <x-slot:toolbar>
            <label for="job-type-filter" class="emp-data-table__filter-label">نوع الوظيفة</label>
            <select id="job-type-filter" wire:model.live="job_type" class="emp-data-table__filter-select">
                <option value="">الكل</option>
                @foreach ($jobTypes as $jobType)
                    <option value="{{ $jobType->id }}">{{ $jobType->job_type }}</option>
                @endforeach
            </select>
        </x-slot:toolbar>

        <x-slot:head>
            <tr>
                <th scope="col">الاسم</th>
                <th scope="col">نوع الوظيفة</th>
                <th scope="col">حالة الوظيفة</th>
                <th scope="col">تحسب بالساعة</th>
                <th scope="col">الموظف</th>
                <th scope="col">وقت الإضافة</th>
                <th scope="col" class="text-center">إجراءات</th>
            </tr>
        </x-slot:head>

        @forelse ($jobs as $job)
            <tr wire:key="job-{{ $job->id }}">
                <td data-label="الاسم" class="font-medium">{{ $job->job_name }}</td>
                <td data-label="نوع الوظيفة">{{ $job->job_type->job_type }}</td>
                <td data-label="حالة الوظيفة">
                    <x-employee.table.status-badge :status="$job->status" active-label="نشطة" inactive-label="غير نشطة" />
                </td>
                <td data-label="تحسب بالساعة">{{ $job->hourly_calculation ? 'نعم' : 'لا' }}</td>
                <td data-label="الموظف">{{ $job->user->name }}</td>
                <td data-label="وقت الإضافة">{{ $job->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                <td data-label="إجراءات">
                    <div class="emp-actions">
                        <x-employee.table.edit-link :href="route('job.edit', $job->id)" />
                        <x-employee.table.delete-button :id="$job->id" :name="$job->job_name" />
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="emp-data-table__empty">لا يوجد وظائف</td>
            </tr>
        @endforelse
    </x-employee.data-table>

    @script
        <script>
            $wire.on('deleted', () => {
                iziToast.success({
                    title: 'تم حذف الوظيفة بنجاح',
                    position: 'topRight',
                });
            });
        </script>
    @endscript
</div>
