@extends('layouts.employee.main')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Dashboard Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">لوحة تحكم ساعات الطيران</h1>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-calendar me-2"></i> تصفية حسب
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">اليوم</a></li>
                <li><a class="dropdown-item" href="#">هذا الأسبوع</a></li>
                <li><a class="dropdown-item" href="#">هذا الشهر</a></li>
                <li><a class="dropdown-item" href="#">هذا العام</a></li>
            </ul>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row">
        <!-- Total Flights Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي الرحلات</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFlights }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-plane fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Flight Hours Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                إجمالي ساعات الطيران</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalHours }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Pilots Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                الطيارين النشطين</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activePilots }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-pilot fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aircraft Utilization Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                معدل إكمال الرحلات</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $completionRate }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $completionRate }}%"
                                            aria-valuenow="{{ $completionRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row of Stats -->
    <div class="row">
        <!-- Active Aircraft Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-right-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                الطائرات النشطة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeAircraft }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-plane fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Flight Time Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-right-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                متوسط مدة الرحلة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $avgFlightTime }} ساعة</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flights This Month Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-right-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                رحلات هذا الشهر</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyFlightsData[date('n')] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Flight Hours by Month Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">ساعات الطيران حسب الشهر</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="flightHoursChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flight Types Distribution Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">توزيع أنواع الرحلات</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="flightTypesChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> رحلات عادية
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> طيران تشبيهي
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> طيران غير محمل
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> اختبار طائرة
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Flights Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">آخر الرحلات</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                            <span class="badge bg-success">مكتملة</span>
                                        @elseif($flight->status == 'pending')
                                            <span class="badge bg-warning">قيد التنفيذ</span>
                                        @elseif($flight->status == 'cancelled')
                                            <span class="badge bg-danger">ملغية</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pilot Performance Row -->
    <div class="row">
        <!-- Top Pilots -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">أفضل الطيارين (ساعات طيران)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
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
                </div>
            </div>
        </div>

        <!-- Top Routes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">أكثر المسارات نشاطاً</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Aircraft Utilization -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">استخدام الطائرات (ساعات)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="aircraftUtilizationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    /* Custom styling for the dashboard */
    .border-right-primary {
        border-right: 0.25rem solid #4e73df !important;
    }
    
    .border-right-success {
        border-right: 0.25rem solid #1cc88a !important;
    }
    
    .border-right-info {
        border-right: 0.25rem solid #36b9cc !important;
    }
    
    .border-right-warning {
        border-right: 0.25rem solid #f6c23e !important;
    }
    
    .chart-area {
        position: relative;
        height: 20rem;
        width: 100%;
    }
    
    .chart-pie {
        position: relative;
        height: 15rem;
        width: 100%;
    }
    
    .chart-bar {
        position: relative;
        height: 20rem;
        width: 100%;
    }
    
    .progress {
        height: 0.5rem;
    }
    
    .card {
        border: none;
        border-radius: 0.35rem;
    }
    
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .text-xs {
        font-size: 0.7rem;
    }
    
    .badge {
        font-size: 0.75rem;
        font-weight: 400;
        padding: 0.25em 0.6em;
        border-radius: 0.35rem;
    }
    
    .bg-success {
        background-color: #1cc88a !important;
    }
    
    .bg-warning {
        background-color: #f6c23e !important;
    }
    
    .bg-danger {
        background-color: #e74a3b !important;
    }
    
    .table-bordered {
        border: 1px solid #e3e6f0;
    }
    
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #e3e6f0;
    }
    
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #e3e6f0;
    }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Flight Hours by Month Chart
        var flightHoursCtx = document.getElementById('flightHoursChart').getContext('2d');
        var flightHoursChart = new Chart(flightHoursCtx, {
            type: 'line',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                datasets: [{
                    label: 'ساعات الطيران',
                    data: [
                        {{ $monthlyHoursData[1] }}, 
                        {{ $monthlyHoursData[2] }}, 
                        {{ $monthlyHoursData[3] }}, 
                        {{ $monthlyHoursData[4] }}, 
                        {{ $monthlyHoursData[5] }}, 
                        {{ $monthlyHoursData[6] }}, 
                        {{ $monthlyHoursData[7] }}, 
                        {{ $monthlyHoursData[8] }}, 
                        {{ $monthlyHoursData[9] }}, 
                        {{ $monthlyHoursData[10] }}, 
                        {{ $monthlyHoursData[11] }}, 
                        {{ $monthlyHoursData[12] }}
                    ],
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Flight Types Distribution Chart
        var flightTypesCtx = document.getElementById('flightTypesChart').getContext('2d');
        var flightTypesChart = new Chart(flightTypesCtx, {
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
                    backgroundColor: ['#4e73  ?? 0 }}
                    ],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a'],
                    hoverBorderColor: 'rgba(234, 236, 244, 1)',
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });

        // Aircraft Utilization Chart
        var aircraftUtilizationCtx = document.getElementById('aircraftUtilizationChart').getContext('2d');
        var aircraftLabels = [
            @foreach($aircraftUtilization as $aircraft)
                '{{ $aircraft->aircraft_name }}',
            @endforeach
        ];
        var aircraftData = [
            @foreach($aircraftUtilization as $aircraft)
                {{ $aircraft->total_hours }},
            @endforeach
        ];
        
        var aircraftUtilizationChart = new Chart(aircraftUtilizationCtx, {
            type: 'bar',
            data: {
                labels: aircraftLabels,
                datasets: [{
                    label: 'ساعات الاستخدام',
                    data: aircraftData,
                    backgroundColor: '#1cc88a',
                    hoverBackgroundColor: '#17a673',
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endpush