@extends('layouts.employee.main')

@section('content')
<div class="dashboard-content">

    {{-- Header --}}
    <div class="dashboard-header">
        <div>
            <p class="dash-greeting">مرحباً، {{ auth()->user()->name }}</p>
            <h1>لوحة تحكم المدير</h1>
            <p class="dash-date">{{ now()->translatedFormat('l، d F Y') }}</p>
        </div>
        <a href="{{ route('admin.accounts.index') }}" class="btn-primary">
            <i class="fas fa-user-plus"></i> إنشاء حساب جديد
        </a>
    </div>

    {{-- Account Stats --}}
    <p class="section-label">إحصائيات الحسابات</p>
    <div class="stats-grid">
        <div class="stat-card stat-card-indigo">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-label">حساب مسجل</span>
                <span class="stat-value">{{ $accountStats['total'] }}</span>
            </div>
        </div>
        <div class="stat-card stat-card-cyan">
            <div class="stat-icon"><i class="fas fa-id-badge"></i></div>
            <div class="stat-info">
                <span class="stat-label">موظف</span>
                <span class="stat-value">{{ $accountStats['employees'] }}</span>
            </div>
        </div>
        <div class="stat-card stat-card-green">
            <div class="stat-icon"><i class="fas fa-plane"></i></div>
            <div class="stat-info">
                <span class="stat-label">كابتن</span>
                <span class="stat-value">{{ $accountStats['captains'] }}</span>
            </div>
        </div>
        <div class="stat-card stat-card-purple">
            <div class="stat-icon"><i class="fas fa-shield-halved"></i></div>
            <div class="stat-info">
                <span class="stat-label">مدير</span>
                <span class="stat-value">{{ $accountStats['admins'] }}</span>
            </div>
        </div>
        <div class="stat-card stat-card-amber">
            <div class="stat-icon"><i class="fas fa-circle-check"></i></div>
            <div class="stat-info">
                <span class="stat-label">حساب نشط</span>
                <span class="stat-value">{{ $accountStats['active'] }}</span>
            </div>
        </div>
        <div class="stat-card stat-card-red">
            <div class="stat-icon"><i class="fas fa-ban"></i></div>
            <div class="stat-info">
                <span class="stat-label">حساب معطل</span>
                <span class="stat-value">{{ $accountStats['inactive'] }}</span>
            </div>
        </div>
    </div>

    {{-- Flight Stats --}}
    <p class="section-label">إحصائيات الرحلات</p>
    <div class="stats-grid stats-grid-4">
        <div class="stat-card stat-card-indigo">
            <div class="stat-icon"><i class="fas fa-plane-departure"></i></div>
            <div class="stat-info">
                <span class="stat-label">إجمالي الرحلات</span>
                <span class="stat-value">{{ $flightStats['total'] }}</span>
            </div>
        </div>
        <div class="stat-card stat-card-cyan">
            <div class="stat-icon"><i class="fas fa-calendar-days"></i></div>
            <div class="stat-info">
                <span class="stat-label">رحلات هذا الشهر</span>
                <span class="stat-value">{{ $flightStats['this_month'] }}</span>
            </div>
        </div>
        <div class="stat-card stat-card-green">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <span class="stat-label">إجمالي ساعات الطيران</span>
                <span class="stat-value">{{ $flightStats['total_hours'] }}</span>
            </div>
        </div>
        <div class="stat-card stat-card-amber">
            <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
            <div class="stat-info">
                <span class="stat-label">ساعات هذا الشهر</span>
                <span class="stat-value">{{ $flightStats['month_hours'] }}</span>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="charts-grid">
        <div class="chart-card">
            <h3 class="chart-title">نمو الحسابات الجديدة</h3>
            <div class="chart-container">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <h3 class="chart-title">توزيع الأدوار</h3>
            <div class="chart-container chart-pie">
                <canvas id="roleChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <h3 class="chart-title">نسبة النشاط</h3>
            <div class="chart-container chart-pie">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Lower Grid --}}
    <div class="two-columns">
        {{-- Recent Accounts --}}
        <div class="section-card">
            <div class="section-title-row">
                <h3 class="section-title">أحدث الحسابات المضافة</h3>
                <a href="{{ route('admin.accounts.index') }}" class="view-all">
                    عرض الكل <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>المستخدم</th>
                            <th>نوع الحساب</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAccounts as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar"
                                        style="background:{{ $user->role === 'captain' ? 'rgba(16,185,129,0.2)' : 'rgba(99,102,241,0.2)' }};
                                               color:{{ $user->role === 'captain' ? '#10b981' : '#a5b4fc' }}">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->role === 'captain')
                                    <span class="badge badge-teal">كابتن</span>
                                @elseif($user->role === 'admin')
                                    <span class="badge badge-purple">مدير</span>
                                @else
                                    <span class="badge badge-indigo">موظف</span>
                                @endif
                            </td>
                            <td class="muted-text">{{ $user->created_at->diffForHumans() }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success">نشط</span>
                                @else
                                    <span class="badge badge-danger">معطل</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="empty-table">لا توجد حسابات حديثة</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Captains --}}
        <div class="section-card">
            <div class="section-title-row">
                <h3 class="section-title">أفضل الكابتنات</h3>
            </div>
            <div class="captain-list">
                @forelse($topCaptains as $index => $captain)
                <div class="captain-row">
                    <div class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</div>
                    <div class="avatar" style="background:rgba(16,185,129,0.15);color:#10b981">
                        {{ mb_substr($captain->user->name ?? 'غ', 0, 1) }}
                    </div>
                    <div style="flex:1">
                        <div class="user-name">{{ $captain->user->name ?? '—' }}</div>
                        <div class="user-email">{{ $captain->total_flights }} رحلة</div>
                    </div>
                    <div class="captain-hours">
                        <div class="hours-value">{{ number_format($captain->total_hours, 1) }}</div>
                        <div class="hours-label">ساعة</div>
                    </div>
                </div>
                @empty
                <div class="empty-table">لا توجد بيانات</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <p class="section-label">إجراءات سريعة</p>
    <div class="quick-actions">
        <a href="{{ route('admin.accounts.index') }}" class="quick-card">
            <i class="fas fa-users" style="color:#6366f1"></i>
            <span>إدارة الحسابات</span>
        </a>
        <a href="{{ route('admin.accounts.index') }}?role=captain" class="quick-card">
            <i class="fas fa-plane" style="color:#10b981"></i>
            <span>حسابات الكابتنات</span>
        </a>
        <a href="{{ route('admin.accounts.index') }}?role=employee" class="quick-card">
            <i class="fas fa-id-badge" style="color:#06b6d4"></i>
            <span>حسابات الموظفين</span>
        </a>
        <a href="{{ route('admin.accounts.index') }}?is_active=0" class="quick-card">
            <i class="fas fa-ban" style="color:#ef4444"></i>
            <span>الحسابات المعطلة</span>
        </a>
        <a href="{{ route('admin.accounts.index') }}" class="quick-card">
            <i class="fas fa-user-plus" style="color:#8b5cf6"></i>
            <span>إضافة حساب جديد</span>
        </a>
    </div>

</div>
@endsection

@push('style')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800&display=swap');

    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-content {
        background: var(--theme-bg);
        min-height: 100vh;
        padding: 24px;
        font-family: 'Tajawal', sans-serif;
        direction: rtl;
        text-align: right;
    }

    /* ── Header ── */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 28px;
    }
    .dash-greeting { font-size: 13px; color: var(--theme-text-muted); margin: 0 0 4px; }
    .dashboard-header h1 { font-size: 24px; font-weight: 700; color: var(--theme-text); margin: 0 0 4px; }
    .dash-date { font-size: 12px; color: var(--theme-text-muted); margin: 0; }

    .btn-primary {
        background: #6366f1;
        color: var(--theme-text);
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background .15s;
        font-family: 'Tajawal', sans-serif;
    }
    .btn-primary:hover { background: #4f46e5; }

    /* ── Section label ── */
    .section-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--theme-section-label);
        text-transform: uppercase;
        letter-spacing: .08em;
        margin: 24px 0 12px;
    }

    /* ── Stats Grid ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        margin-bottom: 8px;
    }
    .stats-grid-4 { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }

    .stat-card {
        background: var(--theme-bg-card);
        border: 1px solid var(--theme-border);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        right: 0; top: 0; bottom: 0;
        width: 3px;
    }
    .stat-card-indigo::before { background: #6366f1; }
    .stat-card-cyan::before   { background: #06b6d4; }
    .stat-card-green::before  { background: #10b981; }
    .stat-card-amber::before  { background: #f59e0b; }
    .stat-card-purple::before { background: #8b5cf6; }
    .stat-card-red::before    { background: #ef4444; }

    .stat-icon { font-size: 28px; line-height: 1; }
    .stat-card-indigo .stat-icon { color: #6366f1; }
    .stat-card-cyan   .stat-icon { color: #06b6d4; }
    .stat-card-green  .stat-icon { color: #10b981; }
    .stat-card-amber  .stat-icon { color: #f59e0b; }
    .stat-card-purple .stat-icon { color: #8b5cf6; }
    .stat-card-red    .stat-icon { color: #ef4444; }

    .stat-info { display: flex; flex-direction: column; }
    .stat-label { font-size: 12px; color: var(--theme-text-muted); margin-bottom: 4px; }
    .stat-value { font-size: 28px; font-weight: 700; color: var(--theme-text); line-height: 1.1; }

    /* ── Charts ── */
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 14px;
        margin: 20px 0 24px;
    }
    .chart-card {
        background: var(--theme-bg-card);
        border-radius: 12px;
        padding: 20px;
    }
    .chart-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--theme-text);
        margin-bottom: 16px;
    }
    .chart-container { position: relative; min-height: 200px; }
    .chart-container.chart-pie { min-height: 170px; max-height: 200px; }

    /* ── Two columns ── */
    .two-columns {
        display: grid;
        grid-template-columns: 3fr 2fr;
        gap: 14px;
        margin-bottom: 24px;
    }

    /* ── Section card ── */
    .section-card {
        background: var(--theme-bg-card);
        border-radius: 12px;
        overflow: hidden;
    }
    .section-title-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid var(--theme-border);
    }
    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--theme-text);
        margin: 0;
    }
    .view-all {
        font-size: 12px;
        color: #a5b4fc;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .view-all:hover { color: var(--theme-text); }

    /* ── Table ── */
    .table-responsive { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .data-table thead th {
        background: var(--theme-table-head);
        color: var(--theme-text-muted);
        font-weight: 500;
        padding: 10px 16px;
        text-align: right;
        border-bottom: 1px solid var(--theme-border);
    }
    .data-table tbody td {
        padding: 11px 16px;
        color: var(--theme-text-secondary);
        border-bottom: 1px solid var(--theme-border-subtle);
        vertical-align: middle;
    }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover { background: var(--theme-table-hover); }

    .user-cell { display: flex; align-items: center; gap: 10px; }
    .avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 600; flex-shrink: 0;
    }
    .user-name { font-weight: 500; color: var(--theme-text); font-size: 13px; }
    .user-email { font-size: 11px; color: var(--theme-text-muted); }
    .muted-text { font-size: 12px; color: var(--theme-text-muted); }
    .empty-table { text-align: center; padding: 32px; color: var(--theme-text-muted); font-size: 13px; }

    /* ── Captains list ── */
    .captain-list { padding: 8px 0; }
    .captain-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 20px;
        border-bottom: 1px solid var(--theme-border-subtle);
    }
    .captain-row:last-child { border-bottom: none; }

    .rank-badge {
        width: 22px; height: 22px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; flex-shrink: 0;
    }
    .rank-1 { background: rgba(251,191,36,0.2);  color: #fbbf24; }
    .rank-2 { background: rgba(148,163,184,0.2); color: #94a3b8; }
    .rank-3 { background: rgba(180,83,9,0.2);    color: #b45309; }
    .rank-4, .rank-5 { background: var(--theme-table-head); color: var(--theme-text-muted); }

    .captain-hours { text-align: left; }
    .hours-value { font-size: 14px; font-weight: 700; color: #10b981; }
    .hours-label { font-size: 10px; color: var(--theme-text-muted); }

    /* ── Badges ── */
    .badge { padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 500; }
    .badge-success { background: rgba(16,185,129,0.15); color: #10b981; }
    .badge-danger  { background: rgba(239,68,68,0.15);  color: #ef4444; }
    .badge-indigo  { background: rgba(99,102,241,0.15); color: #a5b4fc; }
    .badge-teal    { background: rgba(6,182,212,0.15);  color: #06b6d4; }
    .badge-purple  { background: rgba(139,92,246,0.15); color: #c4b5fd; }

    /* ── Quick Actions ── */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }
    .quick-card {
        background: var(--theme-bg-card);
        border: 1px solid var(--theme-border);
        border-radius: 12px;
        padding: 20px 16px;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        transition: background .15s, border-color .15s;
    }
    .quick-card:hover { background: rgba(99,102,241,0.08); border-color: rgba(99,102,241,0.3); }
    .quick-card i { font-size: 26px; }
    .quick-card span { font-size: 13px; color: var(--theme-text-secondary); text-align: center; }

    /* ── Responsive ── */
    @media (max-width: 1100px) {
        .charts-grid { grid-template-columns: 1fr 1fr; }
        .charts-grid .chart-card:first-child { grid-column: 1 / -1; }
        .two-columns { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .stats-grid { grid-template-columns: 1fr 1fr; }
        .quick-actions { grid-template-columns: 1fr 1fr; }
        .dashboard-header { flex-direction: column; gap: 12px; }
    }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: { color: 'rgba(255,255,255,0.5)', font: { size: 11 } }
            }
        }
    };

    // Trend line chart
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($trendLabels) !!},
            datasets: [{
                label: 'حسابات جديدة',
                data: {!! json_encode($trendCounts) !!},
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#6366f1',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                x: {
                    ticks: { color: 'rgba(255,255,255,0.4)', font: { size: 11 } },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: 'rgba(255,255,255,0.4)', font: { size: 11 } },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                }
            }
        }
    });

    // Role doughnut
    new Chart(document.getElementById('roleChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($roleLabels) !!},
            datasets: [{
                data: {!! json_encode($roleCounts) !!},
                backgroundColor: ['#6366f1', '#10b981', '#8b5cf6'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            ...chartDefaults,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: 'rgba(255,255,255,0.5)', font: { size: 11 }, padding: 10 }
                }
            }
        }
    });

    // Activity doughnut
    new Chart(document.getElementById('activityChart'), {
        type: 'doughnut',
        data: {
            labels: ['نشط', 'معطل'],
            datasets: [{
                data: [{{ $accountStats['active'] }}, {{ $accountStats['inactive'] }}],
                backgroundColor: ['#10b981', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            ...chartDefaults,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: 'rgba(255,255,255,0.5)', font: { size: 11 }, padding: 10 }
                }
            }
        }
    });

});
</script>
@endpush