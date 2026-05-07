@extends('layouts.employee.main')

@section('content')
<div class="dashboard-content">
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
    <div class="stats-grid">
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
    <div class="charts-row">
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
                        <div style="font-size:11px;color:rgba(255,255,255,0.35)">
                            {{ $ac['manufacturer'] ?? 'غير محدد' }}
                        </div>
                    </td>
                    <td><strong>{{ $ac['total_hours'] }}</strong> ساعة</td>
                    <td>{{ $ac['total_flights'] }}</td>
                    <td>{{ $ac['avg_hours'] }}</td>
                    <td style="font-size:12px;color:rgba(255,255,255,0.5)">
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

    .filter-bar input,
    .filter-bar select {
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
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
        font-size: 26px;
        font-weight: 700;
        color: #fff;
        line-height: 1;
    }

    .stat-card .stat-label {
        font-size: 12px;
        color: rgba(255,255,255,0.4);
        margin-top: 6px;
    }

    .charts-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    @media (max-width: 1024px) {
        .charts-row {
            grid-template-columns: 1fr 1fr;
        }
        .charts-row .chart-card:first-child {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 640px) {
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
        width: 260px;
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

    .aircraft-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .plane-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: rgba(99,102,241,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
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
        min-width: 2px;
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

    .badge-warning {
        background: rgba(245,158,11,0.15);
        color: #f59e0b;
    }

    .badge-danger {
        background: rgba(239,68,68,0.15);
        color: #ef4444;
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
        padding: 48px;
        color: rgba(255,255,255,0.3);
        font-size: 14px;
    }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly dual-axis bar chart
    var monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
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
                        labels: { color: 'rgba(255,255,255,0.5)', font: {size: 11} }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: 'rgba(255,255,255,0.4)', font: {size: 11} },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    },
                    y: {
                        ticks: { color: 'rgba(255,255,255,0.4)', font: {size: 11} },
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        title: { display: true, text: 'الساعات', color: 'rgba(255,255,255,0.3)' }
                    }
                }
            }
        });
    }

    // Type doughnut chart
    var typeCtx = document.getElementById('typeChart');
    if (typeCtx) {
        new Chart(typeCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_column($typeBreakdown, 'type')),
                datasets: [{
                    data: @json(array_column($typeBreakdown, 'hours')),
                    backgroundColor: ['#6366f1','#06b6d4','#10b981','#f59e0b','#ec4899'],
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
                        labels: { color: 'rgba(255,255,255,0.5)', font: {size: 11}, padding: 10 }
                    }
                }
            }
        });
    }

    // Utilization bucket doughnut
    var utilizationCtx = document.getElementById('utilizationChart');
    if (utilizationCtx) {
        new Chart(utilizationCtx, {
            type: 'doughnut',
            data: {
                labels: ['أقل من 100', '100–300', '300–600', 'أكثر من 600'],
                datasets: [{
                    data: @json($utilization),
                    backgroundColor: ['#6366f1','#06b6d4','#10b981','#f59e0b'],
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
                        labels: { color: 'rgba(255,255,255,0.5)', font: {size: 11}, padding: 10 }
                    }
                }
            }
        });
    }

    // Live search
    var searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var q = this.value.toLowerCase();
            var rows = document.querySelectorAll('#aircraftTable tbody tr');
            rows.forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }
});
</script>
@endpush