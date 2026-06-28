<div>
    <x-employee.data-table :paginator="$aircrafts" per-page-id="aircraft-per-page" class="responsive-card-table">
        <x-slot:head>
            <tr>
                <th scope="col">اسم الطائرة</th>
                <th scope="col">طراز الطائرة</th>
                <th scope="col">الصانع</th>
                <th scope="col">الحالة</th>
                <th scope="col">رقم التسجيل</th>
                <th scope="col">اسم الموظف</th>
                <th scope="col">وقت الإضافة</th>
                <th scope="col" class="text-center">إجراءات</th>
            </tr>
        </x-slot:head>

        @forelse ($aircrafts as $aircraft)
            <tr wire:key="aircraft-{{ $aircraft->id }}">
                <td data-label="اسم الطائرة" class="font-medium">{{ $aircraft->aircraft_name }}</td>
                <td data-label="طراز الطائرة">{{ $aircraft->aircraft_code }}</td>
                <td data-label="الصانع">{{ $aircraft->manufacturer }}</td>
                <td data-label="الحالة">
                    <x-employee.table.status-badge :status="$aircraft->status" active-label="نشطة" inactive-label="غير نشطة" maintenance-label="صيانة" />
                </td>
                <td data-label="رقم التسجيل">{{ $aircraft->registration_number }}</td>
                <td data-label="اسم الموظف">{{ $aircraft->user->name }}</td>
                <td data-label="وقت الإضافة">{{ $aircraft->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                <td data-label="إجراءات">
                    <div class="emp-actions">
                        <x-employee.table.edit-link :href="route('aircraft.edit', $aircraft->id)" />
                        <x-employee.table.delete-button :id="$aircraft->id" :name="$aircraft->aircraft_name" />
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="emp-data-table__empty">لا يوجد طائرات</td>
            </tr>
        @endforelse
    </x-employee.data-table>

    @script
        <script>
            $wire.on('deleted', () => {
                iziToast.success({
                    title: 'تم حذف الطائرة بنجاح',
                    position: 'topRight',
                });
            });
            $wire.on('delete-failed', () => {
                iziToast.error({
                    title: 'لا يمكن حذف الطائرة لأنها مرتبطة برحلات أو ساعات طيران',
                    position: 'topRight',
                });
            });
        </script>
    @endscript
</div>
