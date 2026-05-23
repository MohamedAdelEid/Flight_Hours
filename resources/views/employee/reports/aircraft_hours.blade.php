@extends('layouts.employee.main')

@section('content')
<div class="dashboard-content report-page">
    <!-- Page Header -->
    <div class="report-header">
        <div>
            <h1>تقرير ساعات الطيران لكل طائرة</h1>
            <p class="subtitle">تحليل شامل لساعات التشغيل والأداء لكل طائرة في الأسطول</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" class="filter-bar">
        <div class="filter-group">
            <label>من تاريخ</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}">
        </div>
        <div class="filter-group">
            <label>إلى تاريخ</label>
            <input type="date" name="date_to" value="{{ $dateTo }}">
        </div>
        <div class="filter-group">
            <label>الشركة المصنعة</label>
            <select name="aircraft_type">
                <option value="">الكل</option>
                @foreach($aircraftTypes as $type)
                <option value="{{ $type }}" {{ $aircraftType == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>الحالة</label>
            <select name="status">
                <option value="">الكل</option>
                <option value="active" {{ $statusFilter == 'active' ? 'selected' : '' }}>نشطة</option>
                <option value="maintenance" {{ $statusFilter == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                <option value="inactive" {{ $statusFilter == 'inactive' ? 'selected' : '' }}>موقوفة</option>
            </select>
        </div>
        <div class="filter-group">
            <label>الحد الأدنى للساعات</label>
            <input type="number" name="min_hours" value="{{ $minHours }}" placeholder="0" min="0" step="0.5">
        </div>
        <button type="submit" class="btn-primary">
            <i class="fas fa-filter"></i> تطبيق
        </button>
        <a href="{{ route('employee.aircraftHoursReport') }}" class="btn-reset">
            <i class="fas fa-refresh"></i> إعادة تعيين
        </a>
    </form>

    <!-- Summary Cards -->
    <div class="stats-grid stats-grid--aircraft">
        <div class="stat-card">
            <div class="stat-icon" style="color: #6366f1;">
                <i class="fas fa-plane"></i>
            </div>
            <div class="stat-value">{{ $totalAircraft }}</div>
            <div class="stat-label">طائرة في الأسطول</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="color: #06b6d4;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $totalHoursSum }} ساعة</div>
            <div class="stat-label">مجموع ساعات التشغيل</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="color: #10b981;">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-value">{{ $avgPerAircraft }} ساعة</div>
            <div class="stat-label">متوسط التشغيل</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="color: #f59e0b;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $activeCount }}</div>
            <div class="stat-label">طائرة نشطة حالياً</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="color: #ec4899;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-value">{{ $topAircraft['aircraft_code'] ?? '—' }}</div>
            <div class="stat-label">{{ $topAircraft['total_hours'] ?? 0 }} ساعة</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="charts-row charts-row--aircraft">
        <div class="chart-card">
            <h3 class="chart-title">ساعات الطيران الشهرية</h3>
            <div class="chart-container">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h3 class="chart-title">توزيع حسب الشركة المصنعة</h3>
            <div class="chart-container chart-pie">
                <canvas id="typeChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h3 class="chart-title">توزيع ساعات التشغيل</h3>
            <div class="chart-container chart-pie">
                <canvas id="utilizationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Main Data Table -->
    <div class="table-card">
        <div class="table-header">
            <span>تفاصيل ساعات الطيران لكل طائرة</span>
            <input type="text" id="searchInput" placeholder="ابحث برقم التسجيل أو الطراز...">
        </div>

        <table id="aircraftTable" class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم التسجيل</th>
                    <th>الطراز</th>
                    <th>إجمالي الساعات</th>
                    <th>عدد الرحلات</th>
                    <th>متوسط ساعات/رحلة</th>
                    <th>آخر رحلة</th>
                    <th>نسبة الاستخدام</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aircraftData as $index => $ac)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="aircraft-cell">
                            <div class="plane-icon">
                                <i class="fas fa-plane" style="color:#6366f1"></i>
                            </div>
                            <strong>{{ $ac['aircraft_code'] }}</strong>
                        </div>
                    </td>
                    <td>
                        <div>{{ $ac['aircraft_name'] }}</div>
                        <div class="cell-subtitle">
                            {{ $ac['manufacturer'] ?? 'غير محدد' }}
                        </div>
                    </td>
                    <td><strong>{{ $ac['total_hours'] }}</strong> ساعة</td>
                    <td>{{ $ac['total_flights'] }}</td>
                    <td>{{ $ac['avg_hours'] }}</td>
                    <td class="cell-meta">
                        {{ $ac['last_flight'] ? date('Y/m/d', strtotime($ac['last_flight'])) : '—' }}
                    </td>
                    <td>
                        @php
                            $percentage = $maxHours > 0 ? round(($ac['total_hours'] / $maxHours) * 100, 1) : 0;
                        @endphp
                        <div class="progress-wrap">
                            <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                            <span>{{ $percentage }}%</span>
                        </div>
                    </td>
                    <td>
                        @if($ac['aircraft_status'] == 'active')
                            <span class="badge badge-success">نشطة</span>
                        @elseif($ac['aircraft_status'] == 'maintenance')
                            <span class="badge badge-warning">صيانة</span>
                        @elseif($ac['aircraft_status'] == 'inactive')
                            <span class="badge badge-danger">موقوفة</span>
                        @else
                            <span class="badge badge-neutral">غير محدد</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="empty-row">لا توجد بيانات متاحة</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function chartTheme() {
        return window.FlightHoursTheme ? window.FlightHoursTheme.chartColors() : {
            grid: 'rgba(0,0,0,0.06)',
            tick: 'rgba(0,0,0,0.45)',
            legend: '#6b7280',
        };
    }

    var colors = chartTheme();
    var monthlyChart = null;
    var typeChart = null;
    var utilizationChart = null;

    function buildCharts() {
        colors = chartTheme();

        var monthlyCtx = document.getElementById('monthlyChart');
        if (monthlyCtx) {
            if (monthlyChart) monthlyChart.destroy();
            monthlyChart = new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: [
                        {
                            label: 'ساعات الطيران',
                            data: @json($monthlyHours),
                            backgroundColor: 'rgba(99,102,241,0.7)',
                            borderColor: '#6366f1',
                            borderWidth: 1,
                            borderRadius: 4,
                        },
                        {
                            label: 'عدد الرحلات',
                            data: @json($monthlyFlights),
                            type: 'line',
                            borderColor: '#06b6d4',
                            backgroundColor: 'rgba(6,182,212,0.1)',
                            borderWidth: 2,
                            pointRadius: 3,
                            tension: 0.4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { color: colors.legend, font: { size: 11 } }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: colors.tick, font: { size: 11 } },
                            grid: { color: colors.grid }
                        },
                        y: {
                            ticks: { color: colors.tick, font: { size: 11 } },
                            grid: { color: colors.grid },
                            title: { display: true, text: 'الساعات', color: colors.legend }
                        }
                    }
                }
            });
        }

        var typeCtx = document.getElementById('typeChart');
        if (typeCtx) {
            if (typeChart) typeChart.destroy();
            typeChart = new Chart(typeCtx, {
                type: 'doughnut',
                data: {
                    labels: @json(array_column($typeBreakdown, 'type')),
                    datasets: [{
                        data: @json(array_column($typeBreakdown, 'hours')),
                        backgroundColor: ['#6366f1', '#06b6d4', '#10b981', '#f59e0b', '#ec4899'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: colors.legend, font: { size: 11 }, padding: 10 }
                        }
                    }
                }
            });
        }

        var utilizationCtx = document.getElementById('utilizationChart');
        if (utilizationCtx) {
            if (utilizationChart) utilizationChart.destroy();
            utilizationChart = new Chart(utilizationCtx, {
                type: 'doughnut',
                data: {
                    labels: ['أقل من 100', '100–300', '300–600', 'أكثر من 600'],
                    datasets: [{
                        data: @json($utilization),
                        backgroundColor: ['#6366f1', '#06b6d4', '#10b981', '#f59e0b'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: colors.legend, font: { size: 11 }, padding: 10 }
                        }
                    }
                }
            });
        }
    }

    buildCharts();
    window.addEventListener('theme-changed', buildCharts);

    var searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var q = this.value.toLowerCase();
            document.querySelectorAll('#aircraftTable tbody tr').forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }
});
</script>
@endpush