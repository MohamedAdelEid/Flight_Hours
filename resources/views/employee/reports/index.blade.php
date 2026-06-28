@extends('layouts.employee.main')

@section('content')
<div class="dashboard-content report-page reports-hub">
    <div class="report-header">
        <div>
            <h1>مركز التقارير</h1>
            <p class="subtitle">نظرة شاملة على بيانات النظام مع تصدير كامل للبيانات</p>
        </div>
    </div>

    <form method="GET" class="filter-bar">
        <div class="filter-group">
            <label>من تاريخ</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}">
        </div>
        <div class="filter-group">
            <label>إلى تاريخ</label>
            <input type="date" name="date_to" value="{{ $dateTo }}">
        </div>
        <button type="submit" class="btn-primary">
            <i class="fas fa-filter"></i> تطبيق
        </button>
        <a href="{{ route('employee.reports.index') }}" class="btn-reset">
            <i class="fas fa-refresh"></i> إعادة تعيين
        </a>
    </form>

    <div class="stats-grid reports-stats">
        <div class="stat-card"><div class="stat-icon" style="color:#6366f1"><i class="fas fa-plane-departure"></i></div><div class="stat-value">{{ $stats['flights'] }}</div><div class="stat-label">رحلة</div></div>
        <div class="stat-card"><div class="stat-icon" style="color:#06b6d4"><i class="fas fa-clock"></i></div><div class="stat-value">{{ $stats['hours'] }}</div><div class="stat-label">ساعة طيران</div></div>
        <div class="stat-card"><div class="stat-icon" style="color:#10b981"><i class="fas fa-plane"></i></div><div class="stat-value">{{ $stats['aircraft'] }}</div><div class="stat-label">طائرة</div></div>
        <div class="stat-card"><div class="stat-icon" style="color:#f59e0b"><i class="fas fa-map-marker-alt"></i></div><div class="stat-value">{{ $stats['airports'] }}</div><div class="stat-label">مطار</div></div>
        <div class="stat-card"><div class="stat-icon" style="color:#ec4899"><i class="fas fa-users"></i></div><div class="stat-value">{{ $stats['crew'] }}</div><div class="stat-label">عضو طاقم</div></div>
        <div class="stat-card"><div class="stat-icon" style="color:#8b5cf6"><i class="fas fa-briefcase"></i></div><div class="stat-value">{{ $stats['jobs'] }}</div><div class="stat-label">وظيفة</div></div>
        <div class="stat-card"><div class="stat-icon" style="color:#14b8a6"><i class="fas fa-user-shield"></i></div><div class="stat-value">{{ $stats['users'] }}</div><div class="stat-label">مستخدم</div></div>
    </div>

    <div class="reports-grid">
        <div class="table-card">
            <div class="table-header"><span>تصدير البيانات</span></div>
            <div class="export-grid">
                @foreach($exports as $type => $label)
                    <a class="export-card" href="{{ route('employee.reports.export', ['type' => $type, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}">
                        <i class="fas fa-file-export"></i>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="table-card">
            <div class="table-header"><span>حالة الرحلات</span></div>
            <table class="data-table compact-table">
                <thead><tr><th>الحالة</th><th>العدد</th></tr></thead>
                <tbody>
                    @forelse($flightStatus as $row)
                        <tr><td>{{ $row->status }}</td><td>{{ $row->total }}</td></tr>
                    @empty
                        <tr><td colspan="2" class="empty-row">لا توجد بيانات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="reports-grid">
        <div class="table-card">
            <div class="table-header"><span>أكثر الطائرات تشغيلًا</span></div>
            <table class="data-table compact-table">
                <thead><tr><th>الطائرة</th><th>رقم التسجيل</th><th>الساعات</th></tr></thead>
                <tbody>
                    @forelse($topAircraft as $aircraft)
                        <tr>
                            <td>{{ $aircraft->aircraft_name }} <span class="cell-subtitle">{{ $aircraft->aircraft_code }}</span></td>
                            <td>{{ $aircraft->registration_number ?? '—' }}</td>
                            <td>{{ round($aircraft->total_hours, 1) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="empty-row">لا توجد بيانات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-card">
            <div class="table-header"><span>أعلى أفراد الطاقم ساعات</span></div>
            <table class="data-table compact-table">
                <thead><tr><th>الطاقم</th><th>الوظيفة</th><th>الرحلات</th><th>الساعات</th></tr></thead>
                <tbody>
                    @forelse($topCrew as $crew)
                        <tr>
                            <td>{{ $crew->crew_name }} <span class="cell-subtitle">{{ $crew->financial_number }}</span></td>
                            <td>{{ $crew->job_name ?? '—' }}</td>
                            <td>{{ $crew->flights_count }}</td>
                            <td>{{ round($crew->total_hours, 1) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="empty-row">لا توجد بيانات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header"><span>آخر الرحلات</span></div>
        <table class="data-table compact-table">
            <thead>
                <tr>
                    <th>رقم الرحلة</th>
                    <th>التاريخ</th>
                    <th>الطائرة</th>
                    <th>المسار</th>
                    <th>النوع</th>
                    <th>الساعات</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentFlights as $flight)
                    <tr>
                        <td>{{ $flight->flight_number }}</td>
                        <td>{{ $flight->flight_date }}</td>
                        <td>{{ $flight->aircraft_name ?? '—' }}</td>
                        <td>{{ $flight->origin_name ?? '—' }} / {{ $flight->destination_name ?? '—' }}</td>
                        <td>{{ $flight->flight_type }}</td>
                        <td>{{ $flight->hours ?? 0 }}</td>
                        <td>{{ $flight->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty-row">لا توجد بيانات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('style')
<style>
    .reports-stats { grid-template-columns: repeat(auto-fit, minmax(145px, 1fr)); }
    .reports-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin-bottom: 18px; }
    .export-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; padding: 16px; }
    .export-card { display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; color: #fff; background: rgba(255,255,255,0.04); text-decoration: none; font-size: 13px; }
    .export-card:hover { background: rgba(99,102,241,0.18); border-color: rgba(99,102,241,0.35); }
    .compact-table th, .compact-table td { padding: 10px 14px; }
    .cell-subtitle { display: block; font-size: 11px; color: rgba(255,255,255,0.45); margin-top: 2px; }
    @media (max-width: 900px) { .reports-grid { grid-template-columns: 1fr; } }
</style>
@endpush