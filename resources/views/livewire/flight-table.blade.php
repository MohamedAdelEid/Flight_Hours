<div>
    <div class="flex flex-wrap gap-2 mb-4">
        <button type="button"
            @click="$wire.set('flightType', '')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200
            {{ $flightType === '' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500' }}">
            الكل
        </button>
        <button type="button"
            @click="$wire.set('flightType', 'normal_flight')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200
            {{ $flightType === 'normal_flight' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500' }}">
            رحلة عادية
        </button>
        <button type="button"
            @click="$wire.set('flightType', 'simulated_flight')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200
            {{ $flightType === 'simulated_flight' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500' }}">
            طيران تشبيهي
        </button>
        <button type="button"
            @click="$wire.set('flightType', 'unloaded_flight')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200
            {{ $flightType === 'unloaded_flight' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500' }}">
            طيران غير محمل
        </button>
        <button type="button"
            @click="$wire.set('flightType', 'airplane_test')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200
            {{ $flightType === 'airplane_test' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500' }}">
            اختبار طائرة
        </button>
    </div>

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
            @php $isNormal = $flight->flight_type === 'normal_flight'; @endphp
            <tr wire:key="flight-{{ $flight->flight_source }}-{{ $flight->id }}">
                <td class="font-medium">{{ $flight->aircraft?->aircraft_name ?? '—' }}</td>
                <td>{{ $flight->flight_number }}</td>
                <td>{{ $flight->flight_date }}</td>
                <td>{{ optional($flight->originAirport ?? $flight->airport)->airport_name ?? '—' }}</td>
                <td>{{ $isNormal ? ($flight->destinationAirport->airport_name ?? '—') : '—' }}</td>
                <td>
                    @if ($flight->flight_type === 'normal_flight')
                        رحلة عادية
                    @elseif ($flight->flight_type === 'simulated_flight')
                        طيران تشبيهي
                    @elseif ($flight->flight_type === 'unloaded_flight')
                        طيران غير محمل
                    @elseif ($flight->flight_type === 'airplane_test')
                        اختبار طائرة
                    @else
                        {{ $flight->flight_type }}
                    @endif
                </td>
                <td>
                    @if ($isNormal && $flight->flightHours?->isNotEmpty())
                        {{ $flight->flightHours->first()->hours }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $isNormal ? ($flight->aircraft_number ?? '—') : '—' }}</td>
                <td>
                    <div class="emp-actions">
                        @if ($isNormal && $flight->flight_source === 'flights')
                            <x-employee.table.edit-link :href="route('flight.edit', $flight->id)" />
                        @endif
                        <button type="button" class="emp-action emp-action--delete" aria-label="حذف"
                            @click="
                                Swal.fire({
                                    title: 'هل أنت متأكد؟',
                                    html: 'أنت تريد حذف <strong>' + @js($flight->flight_number) + '</strong>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    cancelButtonText: 'إلغاء',
                                    confirmButtonText: 'نعم، احذفه!',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                }).then((result) => {
                                    if (result.isConfirmed) $wire.delete({{ $flight->id }}, '{{ $flight->flight_source }}');
                                });
                            ">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
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
