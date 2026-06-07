<div>
    <div class="flex overflow-x-auto scrollbar-none gap-1 mb-6 p-1.5 bg-gray-100 dark:bg-gray-800/60 rounded-xl max-w-full">
        <button type="button"
            @click="$wire.set('flightType', '')"
            class="segmented-control-btn {{ $flightType === '' ? 'segmented-control-btn--active' : 'segmented-control-btn--inactive' }}">
            الكل
        </button>
        <button type="button"
            @click="$wire.set('flightType', 'normal_flight')"
            class="segmented-control-btn {{ $flightType === 'normal_flight' ? 'segmented-control-btn--active' : 'segmented-control-btn--inactive' }}">
            رحلة عادية
        </button>
        <button type="button"
            @click="$wire.set('flightType', 'simulated_flight')"
            class="segmented-control-btn {{ $flightType === 'simulated_flight' ? 'segmented-control-btn--active' : 'segmented-control-btn--inactive' }}">
            طيران تشبيهي
        </button>
        <button type="button"
            @click="$wire.set('flightType', 'unloaded_flight')"
            class="segmented-control-btn {{ $flightType === 'unloaded_flight' ? 'segmented-control-btn--active' : 'segmented-control-btn--inactive' }}">
            طيران غير محمل
        </button>
        <button type="button"
            @click="$wire.set('flightType', 'airplane_test')"
            class="segmented-control-btn {{ $flightType === 'airplane_test' ? 'segmented-control-btn--active' : 'segmented-control-btn--inactive' }}">
            اختبار طائرة
        </button>
    </div>

    <x-employee.data-table :paginator="$flights" per-page-id="flight-per-page" class="responsive-card-table">
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
                <th scope="col">الحالة</th>
                <th scope="col" class="text-center">إجراءات</th>
            </tr>
        </x-slot:head>

        @forelse ($flights as $flight)
            @php $isNormal = $flight->flight_type === 'normal_flight'; @endphp
            <tr wire:key="flight-{{ $flight->flight_source }}-{{ $flight->id }}">
                <td data-label="اسم الطائرة" class="font-medium">{{ $flight->aircraft?->aircraft_name ?? '—' }}</td>
                <td data-label="رقم الرحلة">{{ $flight->flight_number }}</td>
                <td data-label="تاريخ الرحلة">{{ $flight->flight_date }}</td>
                <td data-label="مطار القيام">{{ optional($flight->originAirport ?? $flight->airport)->airport_name ?? '—' }}</td>
                <td data-label="مطار الوصول">{{ $isNormal ? ($flight->destinationAirport->airport_name ?? '—') : '—' }}</td>
                <td data-label="نوع الرحلة">
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
                <td data-label="ساعات الرحلة">
                    @if ($isNormal && $flight->flightHours?->isNotEmpty())
                        {{ $flight->flightHours->first()->hours }}
                    @else
                        N/A
                    @endif
                </td>
                <td data-label="رقم تسجيل الطائرة">{{ $isNormal ? ($flight->aircraft_number ?? '—') : '—' }}</td>
                <td data-label="الحالة">
                    @if ($flight->status === 'completed')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20">مكتملة</span>
                    @elseif ($flight->status === 'rejected')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10 dark:bg-rose-500/10 dark:text-rose-400 dark:ring-rose-500/20">مرفوضة</span>
                    @elseif ($flight->status === 'pending_review')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 ring-1 ring-inset ring-amber-600/10 dark:bg-amber-500/10 dark:text-amber-500 dark:ring-amber-500/20">قيد المراجعة</span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/10 dark:bg-gray-500/10 dark:text-gray-400 dark:ring-gray-500/20">{{ $flight->status }}</span>
                    @endif
                </td>
                <td data-label="إجراءات">
                    <div class="emp-actions">
                        @if ($isNormal && $flight->flight_source === 'flights')
                            <x-employee.table.edit-link :href="route('flight.edit', $flight->id)" />
                        @endif

                        @if ($flight->flight_source === 'flights' && $flight->status === 'pending_review')
                            <form action="{{ route('flight.approve', $flight->id) }}" method="POST" class="inline-block" id="approve-form-{{ $flight->id }}">
                                @csrf
                                @method('PATCH')
                                <button type="button" class="emp-action emp-action--approve" aria-label="اعتماد"
                                    onclick="confirmApprove({{ $flight->id }})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>

                            <button type="button" class="emp-action emp-action--reject" aria-label="رفض"
                                onclick="confirmReject({{ $flight->id }})">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>

                            <form action="{{ route('flight.reject', $flight->id) }}" method="POST" class="inline-block" id="reject-form-{{ $flight->id }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="rejection_reason" id="rejection_reason_{{ $flight->id }}">
                            </form>
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
                <td colspan="10" class="emp-data-table__empty">لا يوجد رحلات</td>
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

    <script>
        function confirmApprove(id) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'سيتم اعتماد هذه الرحلة كمكتملة',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم، اعتماد',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approve-form-' + id).submit();
                }
            });
        }

        function confirmReject(id) {
            Swal.fire({
                title: 'رفض الرحلة',
                input: 'textarea',
                inputLabel: 'سبب الرفض',
                inputPlaceholder: 'اكتب سبب الرفض...',
                inputAttributes: {
                    'required': true,
                    'maxlength': 1000,
                },
                showCancelButton: true,
                confirmButtonText: 'رفض',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                inputValidator: (value) => {
                    if (!value) return 'يجب كتابة سبب الرفض';
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('rejection_reason_' + id).value = result.value;
                    document.getElementById('reject-form-' + id).submit();
                }
            });
        }
    </script>
</div>
