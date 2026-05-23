@extends('layouts.employee.main')

@section('content')
<div class="dashboard-content">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>لوحة تحكم ساعات الطيران</h1>
    </div>

    <!-- Stats Cards Grid -->
    <div class="stats-grid">
        <!-- Total Flights -->
        <div class="stat-card stat-card-indigo">
            <div class="stat-icon">
                <i class="fas fa-plane"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">إجمالي الرحلات</span>
                <span class="stat-value">{{ $totalFlights }}</span>
            </div>
        </div>

        <!-- Total Flight Hours -->
        <div class="stat-card stat-card-cyan">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">إجمالي ساعات الطيران</span>
                <span class="stat-value">{{ $totalHours }}</span>
            </div>
        </div>

        <!-- Active Pilots -->
        <div class="stat-card stat-card-green">
            <div class="stat-icon">
                <i class="fas fa-user-pilot"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">الطيارين النشطين</span>
                <span class="stat-value">{{ $activePilots }}</span>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="stat-card stat-card-amber">
            <div class="stat-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">معدل إكمال الرحلات</span>
                <span class="stat-value">{{ $completionRate }}%</span>
            </div>
        </div>

        <!-- Active Aircraft -->
        <div class="stat-card stat-card-purple">
            <div class="stat-icon">
                <i class="fas fa-plane"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">الطائرات النشطة</span>
                <span class="stat-value">{{ $activeAircraft }}</span>
            </div>
        </div>

        <!-- Average Flight Time -->
        <div class="stat-card stat-card-pink">
            <div class="stat-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">متوسط مدة الرحلة</span>
                <span class="stat-value">{{ $avgFlightTime }} ساعة</span>
            </div>
        </div>

        <!-- Flights This Month -->
        <div class="stat-card stat-card-indigo">
            <div class="stat-icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">رحلات هذا الشهر</span>
                <span class="stat-value">{{ $monthlyFlightsData[date('n')] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <div class="chart-card">
            <h3 class="chart-title">ساعات الطيران حسب الشهر</h3>
            @if(array_sum($monthlyHoursData) > 0)
            <div class="chart-container">
                <canvas id="flightHoursChart"></canvas>
            </div>
            @else
            <div class="empty-chart">لا توجد بيانات متاحة</div>
            @endif
        </div>

        <div class="chart-card">
            <h3 class="chart-title">توزيع أنواع الرحلات</h3>
            @if(array_sum($flightTypes) > 0)
            <div class="chart-container chart-pie">
                <canvas id="flightTypesChart"></canvas>
            </div>
            <div class="chart-legend">
                <span><i class="fas fa-circle text-primary"></i> رحلات عادية</span>
                <span><i class="fas fa-circle text-success"></i> طيران تشبيهي</span>
                <span><i class="fas fa-circle text-info"></i> طيران غير محمل</span>
                <span><i class="fas fa-circle text-warning"></i> اختبار طائرة</span>
            </div>
            @else
            <div class="empty-chart">لا توجد بيانات متاحة</div>
            @endif
        </div>
    </div>

    <!-- Aircraft Utilization Chart -->
    <div class="section-card">
        <h3 class="section-title">استخدام الطائرات (ساعات)</h3>
        @if(count($aircraftUtilization) > 0)
        <div class="chart-container chart-bar">
            <canvas id="aircraftUtilizationChart"></canvas>
        </div>
        @else
        <div class="empty-chart">لا توجد بيانات متاحة</div>
        @endif
    </div>

    <!-- Recent Flights Table -->
    <div class="section-card">
        <h3 class="section-title">آخر الرحلات</h3>
        @if(count($recentFlights) > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>رقم الرحلة</th>
                        <th>نوع الرحلة</th>
                        <th>الطائرة</th>
                        <th>من</th>
                        <th>إلى</th>
                        <th>تاريخ الرحلة</th>
                        <th>ساعات الطيران</th>
                        <th>الحالة</th>
                        <th>الصورة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentFlights as $flight)
                    <tr>
                        <td>{{ $flight->flight_number }}</td>
                        <td>
                            @if($flight->flight_type == 'normal_flight')
                                رحلة عادية
                            @elseif($flight->flight_type == 'simulated_flight')
                                طيران تشبيهي
                            @elseif($flight->flight_type == 'unloaded_flight')
                                طيران غير محمل
                            @elseif($flight->flight_type == 'airplane_test')
                                اختبار طائرة
                            @endif
                        </td>
                        <td>{{ $flight->aircraft_name }}</td>
                        <td>{{ $flight->origin }}</td>
                        <td>{{ $flight->destination }}</td>
                        <td>{{ date('Y-m-d', strtotime($flight->flight_date)) }}</td>
                        <td>{{ $flight->hours }}</td>
                        <td>
                            @if($flight->status == 'completed')
                                <span class="badge badge-success">مكتملة</span>
                            @elseif($flight->status == 'pending')
                                <span class="badge badge-warning">قيد التنفيذ</span>
                            @elseif($flight->status == 'cancelled')
                                <span class="badge badge-danger">ملغية</span>
                            @endif
                        </td>
                        <td>
                            @if($flight->image)
                            <a href="{{ asset('storage/' . $flight->image) }}" download target="_blank" class="btn-download-image" title="تحميل الصورة">
                                <i class="fas fa-download"></i>
                            </a>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-table">لا توجد رحلات متاحة</div>
        @endif
    </div>

    <!-- Pilots and Routes Row -->
    <div class="two-columns">
        <!-- Top Pilots -->
        <div class="section-card">
            <h3 class="section-title">أفضل الطيارين (ساعات طيران)</h3>
            @if(count($topPilots) > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>اسم الطيار</th>
                            <th>ساعات الطيران</th>
                            <th>عدد الرحلات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topPilots as $pilot)
                        <tr>
                            <td>{{ $pilot->first_name }} {{ $pilot->last_name }}</td>
                            <td>{{ $pilot->total_hours }}</td>
                            <td>{{ $pilot->flight_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-table">لا توجد بيانات متاحة</div>
            @endif
        </div>

        <!-- Top Routes -->
        <div class="section-card">
            <h3 class="section-title">أكثر المسارات نشاطاً</h3>
            @if(count($topRoutes) > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>المسار</th>
                            <th>عدد الرحلات</th>
                            <th>إجمالي الساعات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topRoutes as $route)
                        <tr>
                            <td>{{ $route->origin }} - {{ $route->destination }}</td>
                            <td>{{ $route->count }}</td>
                            <td>{{ $route->total_hours }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-table">لا توجد بيانات متاحة</div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function chartThemeColors() {
        var root = getComputedStyle(document.documentElement);
        return {
            grid: root.getPropertyValue('--theme-chart-grid').trim() || 'rgba(0,0,0,0.06)',
            tick: root.getPropertyValue('--theme-chart-tick').trim() || 'rgba(0,0,0,0.45)',
            pointBorder: root.getPropertyValue('--theme-bg-card').trim() || '#ffffff',
        };
    }

    var colors = chartThemeColors();
    // Flight Hours by Month Chart
    var flightHoursCanvas = document.getElementById('flightHoursChart');
    if (flightHoursCanvas) {
        var monthlyData = {
            @for($i = 1; $i <= 12; $i++)
                {{ $i }}: {{ $monthlyHoursData[$i] ?? 0 }}{{ $i < 12 ? ',' : '' }}
            @endfor
        };

        new Chart(flightHoursCanvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                datasets: [{
                    label: 'ساعات الطيران',
                    data: [
                        monthlyData[1], monthlyData[2], monthlyData[3],
                        monthlyData[4], monthlyData[5], monthlyData[6],
                        monthlyData[7], monthlyData[8], monthlyData[9],
                        monthlyData[10], monthlyData[11], monthlyData[12]
                    ],
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: colors.pointBorder,
                    pointHoverBackgroundColor: colors.pointBorder,
                    pointHoverBorderColor: '#6366f1',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: colors.grid },
                        ticks: { color: colors.tick }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: colors.tick }
                    }
                }
            }
        });
    }

    // Flight Types Chart
    var flightTypesCanvas = document.getElementById('flightTypesChart');
    if (flightTypesCanvas) {
        new Chart(flightTypesCanvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['رحلات عادية', 'طيران تشبيهي', 'طيران غير محمل', 'اختبار طائرة'],
                datasets: [{
                    data: [
                        {{ $flightTypes['normal_flight'] ?? 0 }},
                        {{ $flightTypes['simulated_flight'] ?? 0 }},
                        {{ $flightTypes['unloaded_flight'] ?? 0 }},
                        {{ $flightTypes['airplane_test'] ?? 0 }}
                    ],
                    backgroundColor: ['#6366f1', '#10b981', '#06b6d4', '#f59e0b'],
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '65%'
            }
        });
    }

    // Aircraft Utilization Chart
    var aircraftCanvas = document.getElementById('aircraftUtilizationChart');
    if (aircraftCanvas) {
        var aircraftLabels = [];
        var aircraftData = [];

        @foreach($aircraftUtilization as $aircraft)
            aircraftLabels.push("{{ $aircraft->aircraft_name }}");
            aircraftData.push({{ $aircraft->total_hours }});
        @endforeach

        new Chart(aircraftCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: aircraftLabels,
                datasets: [{
                    label: 'ساعات الاستخدام',
                    data: aircraftData,
                    backgroundColor: '#10b981',
                    borderRadius: 4
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: colors.grid },
                        ticks: { color: colors.tick }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: colors.tick }
                    }
                }
            }
        });
    }
});
</script>
@endpush