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

    @php
        if (!function_exists('flightCrew')) {
            function flightCrew($flight) {
                $crew = collect();
                if (isset($flight->_isCombined) && $flight->_isCombined) {
                    $crew = $flight->crewNormalFlights ?? collect();
                } elseif ($flight->flight_source === 'flights') {
                    $crew = $flight->crewNormalFlights ?? collect();
                } elseif (isset($flight->crewFlights)) {
                    $crew = $flight->crewFlights ?? collect();
                }
                return $crew->map(fn($m) => [
                    'name' => ($m->crew->first_name ?? '') . ' ' . ($m->crew->last_name ?? ''),
                    'financial_number' => $m->crew->financial_number ?? '',
                    'job' => $m->job?->job_name ?? ($m->crew->job->job_name ?? '—'),
                ]);
            }
        }
    @endphp

    <x-employee.data-table :paginator="$flights" per-page-id="flight-per-page" class="responsive-card-table">
        <x-slot:head>
            <tr>
                <th scope="col">اسم الطائرة</th>
                <th scope="col">رقم الرحلة</th>
                <th scope="col">تاريخ الرحلة</th>
                <th scope="col">المطار</th>
                <th scope="col">نوع الرحلة</th>
                <th scope="col">طاقم الرحلة</th>
                <th scope="col">ساعات الرحلة</th>
                <th scope="col">رقم تسجيل الطائرة</th>
                <th scope="col">الحالة</th>
                <th scope="col" class="text-center">إجراءات</th>
            </tr>
        </x-slot:head>

        @forelse ($flights as $flight)
            @php
                $isCombined = isset($flight->_isCombined) && $flight->_isCombined;
                $crewMembers = flightCrew($flight);
                $crewCount = $crewMembers->count();
            @endphp
            <tr wire:key="flight-{{ $flight->flight_source }}-{{ $flight->id }}">
                <td data-label="اسم الطائرة" class="font-medium">{{ $flight->aircraft?->aircraft_name ?? '—' }}</td>
                <td data-label="رقم الرحلة">
                    @if ($isCombined)
                        <div class="text-xs leading-relaxed">
                            <span class="text-blue-600 dark:text-blue-400 font-semibold">ذهاب:</span> {{ $flight->flight_number }}<br>
                            <span class="text-emerald-600 dark:text-emerald-400 font-semibold">عودة:</span> {{ $flight->return_flight_number }}
                        </div>
                    @else
                        {{ $flight->flight_number }}
                    @endif
                </td>
                <td data-label="تاريخ الرحلة">
                    @if ($isCombined)
                        <div class="text-xs leading-relaxed">
                            <span class="text-blue-600 dark:text-blue-400">ذهاب:</span> {{ $flight->flight_date }}<br>
                            <span class="text-emerald-600 dark:text-emerald-400">عودة:</span> {{ $flight->return_flight_date }}
                        </div>
                    @else
                        {{ $flight->flight_date }}
                    @endif
                </td>
                <td data-label="المطار">
                    @if ($isCombined)
                        <div class="text-xs leading-relaxed">
                            <div class="mb-1">
                                <span class="text-blue-600 dark:text-blue-400 font-medium">ذهاب:</span>
                                {{ $flight->origin_airport?->airport_name ?? '—' }}
                                <i class="fa-solid fa-arrow-left text-xs mx-0.5"></i>
                                {{ $flight->destination_airport?->airport_name ?? '—' }}
                            </div>
                            <div>
                                <span class="text-emerald-600 dark:text-emerald-400 font-medium">عودة:</span>
                                {{ $flight->return_origin_airport?->airport_name ?? '—' }}
                                <i class="fa-solid fa-arrow-left text-xs mx-0.5"></i>
                                {{ $flight->return_destination_airport?->airport_name ?? '—' }}
                            </div>
                        </div>
                    @else
                        {{ optional($flight->originAirport ?? $flight->airport)->airport_name ?? '—' }}
                        @if ($flight->flight_source === 'flights' && !$isCombined)
                            <i class="fa-solid fa-arrow-left text-xs mx-0.5"></i>
                            {{ $flight->destinationAirport->airport_name ?? '—' }}
                        @endif
                    @endif
                </td>
                <td data-label="نوع الرحلة">
                    @if ($flight->flight_type === 'normal_flight')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">رحلة عادية</span>
                    @elseif ($flight->flight_type === 'simulated_flight')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400">طيران تشبيهي</span>
                    @elseif ($flight->flight_type === 'unloaded_flight')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-50 text-orange-700 dark:bg-orange-500/10 dark:text-orange-400">طيران غير محمل</span>
                    @elseif ($flight->flight_type === 'airplane_test')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">اختبار طائرة</span>
                    @else
                        {{ $flight->flight_type }}
                    @endif
                </td>
                <td data-label="طاقم الرحلة">
                    @if ($crewCount > 0)
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20 hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-500/20 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                {{ $crewCount }} فرد
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute z-20 mt-2 w-72 rounded-xl bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black/5 dark:ring-white/10 p-2 right-0"
                                @click.outside="open = false">
                                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 px-3 py-1.5 border-b border-gray-100 dark:border-gray-700 mb-1">طاقم الرحلة</div>
                                @foreach ($crewMembers as $member)
                                    <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                            {{ mb_substr($member['name'], 0, 1) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $member['name'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                                <span dir="ltr" class="text-gray-400 dark:text-gray-500">{{ $member['financial_number'] }}</span>
                                                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">{{ $member['job'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500 text-sm">—</span>
                    @endif
                </td>
                <td data-label="ساعات الرحلة">
                    @if ($isCombined)
                        <div class="text-xs leading-relaxed">
                            @php
                                $depHours = $flight->flightHours?->first()?->hours ?? 'N/A';
                                $retHours = $flight->returnFlightHours?->first()?->hours ?? 'N/A';
                                $total = is_numeric($depHours) && is_numeric($retHours) ? $depHours + $retHours : 'N/A';
                            @endphp
                            <span class="text-blue-600 dark:text-blue-400">ذهاب:</span> {{ is_numeric($depHours) ? number_format($depHours, 1) : $depHours }}<br>
                            <span class="text-emerald-600 dark:text-emerald-400">عودة:</span> {{ is_numeric($retHours) ? number_format($retHours, 1) : $retHours }}<br>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">المجموع:</span> {{ is_numeric($total) ? number_format($total, 1) : $total }}
                        </div>
                    @elseif ($flight->flight_source === 'flights' && $flight->flightHours?->isNotEmpty())
                        {{ $flight->flightHours->first()->hours }}
                    @else
                        N/A
                    @endif
                </td>
                <td data-label="رقم تسجيل الطائرة">{{ $isCombined ? ($flight->aircraft_number ?? '—') : ($flight->aircraft_number ?? ($flight->flight_source === 'flights' ? ($flight->aircraft_number ?? '—') : '—')) }}</td>
                <td data-label="الحالة">
                    @if ($isCombined)
                        @php $mergedStatus = $flight->status; @endphp
                        @if ($mergedStatus === 'completed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20">مكتملة</span>
                        @elseif ($mergedStatus === 'rejected')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10 dark:bg-rose-500/10 dark:text-rose-400 dark:ring-rose-500/20">مرفوضة</span>
                        @elseif ($mergedStatus === 'pending_review')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 ring-1 ring-inset ring-amber-600/10 dark:bg-amber-500/10 dark:text-amber-500 dark:ring-amber-500/20">قيد المراجعة</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/10 dark:bg-gray-500/10 dark:text-gray-400 dark:ring-gray-500/20">{{ $flight->status }}</span>
                        @endif
                    @elseif ($flight->flight_source === 'flights')
                        @if ($flight->status === 'completed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20">مكتملة</span>
                        @elseif ($flight->status === 'rejected')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10 dark:bg-rose-500/10 dark:text-rose-400 dark:ring-rose-500/20">مرفوضة</span>
                        @elseif ($flight->status === 'pending_review')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 ring-1 ring-inset ring-amber-600/10 dark:bg-amber-500/10 dark:text-amber-500 dark:ring-amber-500/20">قيد المراجعة</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/10 dark:bg-gray-500/10 dark:text-gray-400 dark:ring-gray-500/20">{{ $flight->status }}</span>
                        @endif
                    @else
                        @if ($flight->status === 'completed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20">مكتملة</span>
                        @elseif ($flight->status === 'rejected')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10 dark:bg-rose-500/10 dark:text-rose-400 dark:ring-rose-500/20">مرفوضة</span>
                        @elseif ($flight->status === 'pending_review')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 ring-1 ring-inset ring-amber-600/10 dark:bg-amber-500/10 dark:text-amber-500 dark:ring-amber-500/20">قيد المراجعة</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/10 dark:bg-gray-500/10 dark:text-gray-400 dark:ring-gray-500/20">{{ $flight->status }}</span>
                        @endif
                    @endif
                </td>
                <td data-label="إجراءات">
                    <div class="emp-actions">
                        @if ($isCombined)
                            <x-employee.table.edit-link :href="route('flight.edit', $flight->id)" />
                        @elseif ($flight->flight_source === 'flights')
                            <x-employee.table.edit-link :href="route('flight.edit', $flight->id)" />
                        @endif

                        @if ($isCombined && $flight->_depStatus === 'pending_review')
                            <form action="{{ route('flight.approve', $flight->_depId) }}" method="POST" class="inline-block" id="approve-form-{{ $flight->_depId }}">
                                @csrf
                                @method('PATCH')
                                <button type="button" class="emp-action emp-action--approve" aria-label="اعتماد"
                                    onclick="confirmApprove({{ $flight->_depId }})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                            <button type="button" class="emp-action emp-action--reject" aria-label="رفض"
                                onclick="confirmReject({{ $flight->_depId }})">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                            <form action="{{ route('flight.reject', $flight->_depId) }}" method="POST" class="inline-block" id="reject-form-{{ $flight->_depId }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="rejection_reason" id="rejection_reason_{{ $flight->_depId }}">
                            </form>
                        @elseif ($flight->flight_source === 'flights' && !$isCombined && $flight->status === 'pending_review')
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
                                    html: 'أنت تريد حذف <strong>' + @js($isCombined ? $flight->flight_number . ' / ' . $flight->return_flight_number : $flight->flight_number) + '</strong>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    cancelButtonText: 'إلغاء',
                                    confirmButtonText: 'نعم، احذفه!',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                }).then((result) => {
                                    if (result.isConfirmed) $wire.delete({{ $isCombined ? $flight->id : $flight->id }}, '{{ $isCombined ? 'combined' : ($flight->flight_source === 'flights' ? 'flights' : 'other_flights') }}');
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
