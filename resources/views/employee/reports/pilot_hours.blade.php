@extends('layouts.employee.main')

@section('content')
<div class="dashboard-content">
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

@push('style')
<style>
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }

    .report-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .report-header .subtitle {
        font-size: 13px;
        color: rgba(255,255,255,0.4);
        margin: 4px 0 0;
    }

    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: flex-end;
        background: #1a1d2e;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .filter-group label {
        font-size: 12px;
        color: rgba(255,255,255,0.5);
    }

    .filter-bar input {
        background: #0f1117;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 8px 12px;
        color: #fff;
        font-size: 13px;
        min-width: 150px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: #1a1d2e;
        border-radius: 12px;
        padding: 20px 24px;
        border: 1px solid rgba(255,255,255,0.06);
    }

    .stat-card .stat-icon {
        font-size: 28px;
        margin-bottom: 12px;
    }

    .stat-card .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #fff;
        line-height: 1;
    }

    .stat-card .stat-label {
        font-size: 12px;
        color: rgba(255,255,255,0.45);
        margin-top: 6px;
    }

    .charts-row {
        display: grid;
        grid-template-columns: 3fr 2fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    @media (max-width: 1024px) {
        .charts-row {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: #1a1d2e;
        border-radius: 12px;
        padding: 20px 24px;
    }

    .chart-title {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        margin: 0 0 16px;
    }

    .chart-container {
        position: relative;
        min-height: 200px;
    }

    .chart-container.chart-pie {
        min-height: 180px;
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

    .table-card {
        background: #1a1d2e;
        border-radius: 12px;
        overflow: hidden;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .table-header span {
        font-size: 15px;
        font-weight: 600;
        color: #fff;
    }

    .table-header input {
        background: #0f1117;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 7px 12px;
        color: #fff;
        font-size: 13px;
        width: 220px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .data-table thead th {
        background: rgba(255,255,255,0.03);
        color: rgba(255,255,255,0.45);
        font-weight: 500;
        padding: 11px 16px;
        text-align: right;
    }

    .data-table tbody td {
        padding: 12px 16px;
        color: #e2e8f0;
        border-bottom: 1px solid rgba(255,255,255,0.04);
    }

    .data-table tbody tr:hover {
        background: rgba(255,255,255,0.03);
    }

    .pilot-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #6366f1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
        flex-shrink: 0;
    }

    .progress-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 120px;
    }

    .progress-bar {
        height: 6px;
        background: #6366f1;
        border-radius: 3px;
        transition: width .3s;
    }

    .progress-wrap span {
        font-size: 11px;
        color: rgba(255,255,255,0.4);
        white-space: nowrap;
    }

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

    .badge-info {
        background: rgba(99,102,241,0.15);
        color: #a5b4fc;
    }

    .badge-warning {
        background: rgba(245,158,11,0.15);
        color: #f59e0b;
    }

    .badge-neutral {
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.5);
    }

    .btn-primary {
        background: #6366f1;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-primary:hover {
        background: #4f46e5;
    }

    .btn-reset {
        background: transparent;
        color: rgba(255,255,255,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 13px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-reset:hover {
        color: #fff;
        border-color: rgba(255,255,255,0.3);
    }

    .empty-row {
        text-align: center;
        padding: 40px;
        color: rgba(255,255,255,0.3);
        font-size: 14px;
    }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Bar Chart
    var monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
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
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        ticks: { color: 'rgba(255,255,255,0.4)', font: {size: 11} },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    },
                    y: {
                        ticks: { color: 'rgba(255,255,255,0.4)', font: {size: 11} },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    }
                }
            }
        });
    }

    // Distribution Doughnut Chart
    var distributionCtx = document.getElementById('distributionChart');
    if (distributionCtx) {
        new Chart(distributionCtx, {
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
                            color: 'rgba(255,255,255,0.5)',
                            font: {size: 11},
                            padding: 12
                        }
                    }
                }
            }
        });
    }

    // Live table search
    var searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var q = this.value.toLowerCase();
            var rows = document.querySelectorAll('#pilotsTable tbody tr');
            rows.forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }
});
</script>
@endpush