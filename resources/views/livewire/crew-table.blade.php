<div>
    <x-employee.data-table :paginator="$crews" per-page-id="crew-per-page">
        <x-slot:head>
            <tr>
                <th scope="col">الاسم الأول</th>
                <th scope="col">اسم الأب</th>
                <th scope="col">اللقب</th>
                <th scope="col">الرقم المالي</th>
                <th scope="col">الوظيفة</th>
                <th scope="col">حالة فرد الطاقم</th>
                <th scope="col" class="text-center">إجراءات</th>
            </tr>
        </x-slot:head>

        @forelse ($crews as $crew)
            <tr wire:key="crew-{{ $crew->id }}">
                <td class="font-medium">{{ $crew->first_name }}</td>
                <td>{{ $crew->last_name }}</td>
                <td>{{ $crew->nickname ?: 'N/A' }}</td>
                <td>{{ $crew->financial_number }}</td>
                <td>{{ $crew->job->job_name }}</td>
                <td>
                    <x-employee.table.status-badge :status="$crew->status" active-label="فعال" inactive-label="غير فعال" />
                </td>
                <td>
                    <div class="emp-actions">
                        <x-employee.table.edit-link :href="route('crew.edit', $crew->id)" />
                        <x-employee.table.delete-button :id="$crew->id" :name="$crew->first_name . ' ' . $crew->last_name" />
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="emp-data-table__empty">لا يوجد طاقم</td>
            </tr>
        @endforelse
    </x-employee.data-table>

    @script
        <script>
            $wire.on('deleted', () => {
                iziToast.success({
                    title: 'تم حذف فرد الطاقم بنجاح',
                    position: 'topRight',
                });
            });
        </script>
    @endscript
</div>
