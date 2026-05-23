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

@push('style')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .dashboard-content {
        background: #0f1117;
        min-height: 100vh;
        padding: 24px;
        font-family: 'Tajawal', sans-serif;
        direction: rtl;
        text-align: right;
    }

    .dashboard-header {
        margin-bottom: 24px;
    }

    .dashboard-header h1 {
        font-size: 22px;
        font-weight: 600;
        color: #fff;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #1a1d2e;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 20px 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 3px;
    }

    .stat-card-indigo::before { background: #6366f1; }
    .stat-card-cyan::before { background: #06b6d4; }
    .stat-card-green::before { background: #10b981; }
    .stat-card-amber::before { background: #f59e0b; }
    .stat-card-purple::before { background: #8b5cf6; }
    .stat-card-pink::before { background: #ec4899; }

    .stat-icon {
        font-size: 32px;
        line-height: 1;
    }

    .stat-card-indigo .stat-icon { color: #6366f1; }
    .stat-card-cyan .stat-icon { color: #06b6d4; }
    .stat-card-green .stat-icon { color: #10b981; }
    .stat-card-amber .stat-icon { color: #f59e0b; }
    .stat-card-purple .stat-icon { color: #8b5cf6; }
    .stat-card-pink .stat-icon { color: #ec4899; }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 13px;
        color: rgba(255,255,255,0.5);
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #fff;
    }

    /* Charts Grid */
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 1024px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-card, .section-card {
        background: #1a1d2e;
        border-radius: 12px;
        padding: 24px;
    }

    .chart-title, .section-title {
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 16px;
    }

    .chart-container {
        position: relative;
        min-height: 200px;
    }

    .chart-container.chart-pie {
        min-height: 180px;
        max-height: 200px;
    }

    .chart-container.chart-bar {
        min-height: 200px;
    }

    .chart-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        margin-top: 16px;
        font-size: 12px;
        color: rgba(255,255,255,0.6);
    }

    .chart-legend i {
        margin-left: 4px;
    }

    .empty-chart {
        color: rgba(255,255,255,0.3);
        font-size: 14px;
        padding: 60px 0;
        text-align: center;
    }

    /* Two Columns */
    .two-columns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 768px) {
        .two-columns {
            grid-template-columns: 1fr;
        }
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .data-table thead th {
        background: rgba(255,255,255,0.04);
        color: rgba(255,255,255,0.5);
        font-weight: 500;
        padding: 10px 16px;
        text-align: right;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .data-table tbody td {
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding: 12px 16px;
        color: #e2e8f0;
    }

    .data-table tbody tr:nth-child(even) {
        background: rgba(255,255,255,0.02);
    }

    .data-table tbody tr:hover {
        background: rgba(255,255,255,0.04);
    }

    /* Badges */
    .badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }

    .badge-success {
        background: rgba(16,185,129,0.15);
        color: #10b981;
    }

    .badge-warning {
        background: rgba(245,158,11,0.15);
        color: #f59e0b;
    }

    .badge-danger {
        background: rgba(239,68,68,0.15);
        color: #ef4444;
    }

    .empty-table {
        color: rgba(255,255,255,0.3);
        font-size: 14px;
        padding: 40px 0;
        text-align: center;
    }

    /* Section spacing */
    .section-card {
        background: #1a1d2e;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .section-card .section-title {
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        margin-bottom: 0;
    }

    .section-card .table-responsive,
    .section-card .chart-container {
        padding: 0 20px 20px;
    }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
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
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: 'rgba(255,255,255,0.5)' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: 'rgba(255,255,255,0.5)' }
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
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: 'rgba(255,255,255,0.5)' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: 'rgba(255,255,255,0.5)' }
                    }
                }
            }
        });
    }
});
</script>
@endpush