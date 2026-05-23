<div>
    <x-employee.data-table :paginator="$flights" per-page-id="flight-per-page">
        <x-slot:head>
            <tr>
                <th scope="col">اسم الطائرة</th>
                <th scope="col">رقم الرحلة</th>
                <th scope="col">تاريخ الرحلة</th>
                <th scope="col">مطار القيام</th>
                <th scope="col">مطار الوصول</th>
                <th scope="col">نوع الرحلة</th>
                <th scope="col">ساعات الرحلة</th>
                <th scope="col">رقم تسجيل الطائرة</th>
                <th scope="col" class="text-center">إجراءات</th>
            </tr>
        </x-slot:head>

        @forelse ($flights as $flight)
            <tr wire:key="flight-{{ $flight->id }}">
                <td class="font-medium">{{ $flight->aircraft->aircraft_name }}</td>
                <td>{{ $flight->flight_number }}</td>
                <td>{{ $flight->flight_date }}</td>
                <td>{{ $flight->originAirport->airport_name }}</td>
                <td>{{ $flight->destinationAirport->airport_name }}</td>
                <td>{{ $flight->flight_type }}</td>
                <td>
                    @if ($flight->flightHours->isNotEmpty())
                        {{ $flight->flightHours->first()->hours }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $flight->aircraft_number }}</td>
                <td>
                    <div class="emp-actions">
                        <x-employee.table.edit-link :href="route('flight.edit', $flight->id)" />
                        <x-employee.table.delete-button :id="$flight->id" :name="'رحلة ' . $flight->flight_number" />
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="emp-data-table__empty">لا يوجد رحلات</td>
            </tr>
        @endforelse
    </x-employee.data-table>

    @script
        <script>
            $wire.on('deleted', () => {
                iziToast.success({
                    title: 'تم حذف الرحلة بنجاح',
                    position: 'topRight',
                });
            });
        </script>
    @endscript
</div>
