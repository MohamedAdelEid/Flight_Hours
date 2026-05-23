<div>
    <x-employee.data-table :paginator="$airports" per-page-id="airport-per-page">
        <x-slot:head>
            <tr>
                <th scope="col">اسم المطار</th>
                <th scope="col">كود المطار</th>
                <th scope="col">الموظف</th>
                <th scope="col">وقت الإضافة</th>
                <th scope="col" class="text-center">إجراءات</th>
            </tr>
        </x-slot:head>

        @forelse ($airports as $airport)
            <tr wire:key="airport-{{ $airport->id }}">
                <td class="font-medium">{{ $airport->airport_name }}</td>
                <td>{{ $airport->airport_code }}</td>
                <td>{{ $airport->user->name }}</td>
                <td>{{ $airport->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                <td>
                    <div class="emp-actions">
                        <x-employee.table.edit-link :href="route('airport.edit', $airport->id)" />
                        <x-employee.table.delete-button :id="$airport->id" :name="$airport->airport_name" />
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="emp-data-table__empty">لا يوجد مطارات</td>
            </tr>
        @endforelse
    </x-employee.data-table>

    @script
        <script>
            $wire.on('deleted', () => {
                iziToast.success({
                    title: 'تم حذف المطار بنجاح',
                    position: 'topRight',
                });
            });

            $wire.on('delete-failed', () => {
                iziToast.error({
                    title: 'لا يمكن حذف المطار لأنه مرتبط برحلات',
                    position: 'topRight',
                });
            });
        </script>
    @endscript
</div>
