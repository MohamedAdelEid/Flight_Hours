@extends('layouts.employee.main')

@section('content')
<div class="dashboard-content report-page">
    <!-- Page Header -->
    <div class="report-header">
        <div>
            <h1>تقرير ساعات الطيران لكل طيار</h1>
            <p class="subtitle">تحليل شامل لساعات الطيران الفعلية لكل طيار</p>
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
            <label>الحد الأدنى للساعات</label>
            <input type="number" name="min_hours" value="{{ $minHours }}" placeholder="0" min="0" step="0.5">
        </div>
        <button type="submit" class="btn-primary">
            <i class="fas fa-filter"></i> تطبيق
        </button>
        <a href="{{ route('employee.pilotHoursReport') }}" class="btn-reset">
            <i class="fas fa-refresh"></i> إعادة تعيين
        </a>
    </form>

    <!-- Summary Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="color: #6366f1;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $totalPilots }}</div>
            <div class="stat-label">إجمالي الطيارين</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="color: #06b6d4;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $totalHoursSum }} ساعة</div>
            <div class="stat-label">إجمالي ساعات الطيران</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="color: #10b981;">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-value">{{ $avgPerPilot }} ساعة</div>
            <div class="stat-label">متوسط ساعات لكل طيار</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="color: #f59e0b;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-value">{{ $topPilot['pilot_name'] ?? '—' }}</div>
            <div class="stat-label">{{ $topPilot['total_hours'] ?? 0 }} ساعة</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="charts-row">
        <div class="chart-card">
            <h3 class="chart-title">ساعات الطيران الشهرية</h3>
            <div class="chart-container">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h3 class="chart-title">توزيع الطيارين حسب الساعات</h3>
            <div class="chart-container chart-pie">
                <canvas id="distributionChart"></canvas>
            </div>
            <div class="chart-legend">
                <span><i class="fas fa-circle" style="color: #6366f1;"></i> أقل من 50</span>
                <span><i class="fas fa-circle" style="color: #06b6d4;"></i> 50 – 100</span>
                <span><i class="fas fa-circle" style="color: #10b981;"></i> 100 – 200</span>
                <span><i class="fas fa-circle" style="color: #f59e0b;"></i> أكثر من 200</span>
            </div>
        </div>
    </div>

    <!-- Main Data Table -->
    <div class="table-card">
        <div class="table-header">
            <span>تفاصيل ساعات الطيران لكل طيار</span>
            <input type="text" id="searchInput" placeholder="ابحث عن طيار...">
        </div>

        <table id="pilotsTable" class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الطيار</th>
                    <th>إجمالي الساعات</th>
                    <th>عدد الرحلات</th>
                    <th>متوسط ساعات/رحلة</th>
                    <th>نسبة من الإجمالي</th>
                    <th>التصنيف</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pilotsData as $index => $pilot)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="pilot-cell">
                            <div class="avatar">{{ substr($pilot['pilot_name'], 0, 1) }}</div>
                            {{ $pilot['pilot_name'] }}
                        </div>
                    </td>
                    <td><strong>{{ $pilot['total_hours'] }}</strong> ساعة</td>
                    <td>{{ $pilot['total_flights'] }}</td>
                    <td>{{ $pilot['avg_hours'] }}</td>
                    <td>
                        <div class="progress-wrap">
                            @php
                                $percentage = $totalHoursSum > 0 ? round(($pilot['total_hours'] / $totalHoursSum) * 100, 1) : 0;
                            @endphp
                            <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                            <span>{{ $percentage }}%</span>
                        </div>
                    </td>
                    <td>
                        @if($pilot['total_hours'] >= 200)
                            <span class="badge badge-success">خبير</span>
                        @elseif($pilot['total_hours'] >= 100)
                            <span class="badge badge-info">متقدم</span>
                        @elseif($pilot['total_hours'] >= 50)
                            <span class="badge badge-warning">متوسط</span>
                        @else
                            <span class="badge badge-neutral">مبتدئ</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-row">لا توجد بيانات متاحة</td>
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
    var distributionChart = null;

    function buildCharts() {
        colors = chartTheme();

        var monthlyCtx = document.getElementById('monthlyChart');
        if (monthlyCtx) {
            if (monthlyChart) monthlyChart.destroy();
            monthlyChart = new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: [{
                        label: 'ساعات الطيران',
                        data: @json($monthlyHours),
                        backgroundColor: 'rgba(99,102,241,0.7)',
                        borderColor: '#6366f1',
                        borderWidth: 1,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: {
                            ticks: { color: colors.tick, font: { size: 11 } },
                            grid: { color: colors.grid }
                        },
                        y: {
                            ticks: { color: colors.tick, font: { size: 11 } },
                            grid: { color: colors.grid }
                        }
                    }
                }
            });
        }

        var distributionCtx = document.getElementById('distributionChart');
        if (distributionCtx) {
            if (distributionChart) distributionChart.destroy();
            distributionChart = new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['أقل من 50', '50–100', '100–200', 'أكثر من 200'],
                    datasets: [{
                        data: @json($distribution),
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
                            labels: {
                                color: colors.legend,
                                font: { size: 11 },
                                padding: 12
                            }
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
            document.querySelectorAll('#pilotsTable tbody tr').forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }
});
</script>
@endpush