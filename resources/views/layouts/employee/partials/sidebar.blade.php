<aside class="sidebar z-20 sticky top-0 hidden w-65 h-screen overflow-y-auto md:block flex-shrink-0">
    <div class="py-4 flex flex-col h-full">

        <a href="{{ route('employee.index') }}" class="logo-link">
            <img src="{{ asset('logo1(2).png') }}" alt="Flight Hours Logo" class="sidebar-logo">
        </a>

        {{-- ===== SHARED: Home ===== --}}
        <div class="section-label">الرئيسية</div>
        <ul class="px-2">
            <li>
                <a href="{{ route('employee.index') }}" class="nav-item">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>الصفحة الرئيسية</span>
                </a>
            </li>
        </ul>

        @if(auth()->user()->role === 'admin')
        {{-- ===== ADMIN ONLY ===== --}}
            <ul class="px-2 mt-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>لوحة تحكم المدير</span>
                    </a>
                </li>
            </ul>

            <div class="divider"></div>
            <div class="section-label">الحسابات</div>
            <ul class="px-2">
                <li>
                    <a href="{{ route('admin.accounts.index') }}" class="nav-item">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>إدارة الحسابات</span>
                    </a>
                </li>
            </ul>

        @else
        {{-- ===== EMPLOYEE ONLY ===== --}}
            <div class="divider"></div>
            <div class="section-label">البيانات الأساسية</div>
            <ul class="px-2">
                {{-- Jobs --}}
                <li>
                    <a href="{{ route('job.create') }}" class="nav-item nav-sub">
                        <i class="fa-solid fa-briefcase icon-fa"></i>
                        <span>إضافة وظيفة</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('job.index') }}" class="nav-item nav-sub">
                        <i class="fa-solid fa-briefcase icon-fa"></i>
                        <span>عرض الوظائف</span>
                    </a>
                </li>
                {{-- Airports --}}
                <li>
                    <a href="{{ route('airport.create') }}" class="nav-item nav-sub">
                        <i class="fa-solid fa-plane-departure icon-fa"></i>
                        <span>إضافة مطار</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('airport.index') }}" class="nav-item nav-sub">
                        <i class="fa-solid fa-plane-departure icon-fa"></i>
                        <span>عرض المطارات</span>
                    </a>
                </li>
                {{-- Aircraft --}}
                <li>
                    <a href="{{ route('aircraft.create') }}" class="nav-item nav-sub">
                        <i class="fa-solid fa-plane icon-fa"></i>
                        <span>إضافة طائرة</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('aircraft.index') }}" class="nav-item nav-sub">
                        <i class="fa-solid fa-plane icon-fa"></i>
                        <span>عرض الطائرات</span>
                    </a>
                </li>
                {{-- Crew --}}
                <li>
                    <a href="{{ route('crew.create') }}" class="nav-item nav-sub">
                        <i class="fa-solid fa-users icon-fa"></i>
                        <span>إضافة عضو طقم</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('crew.index') }}" class="nav-item nav-sub">
                        <i class="fa-solid fa-users icon-fa"></i>
                        <span>عرض طاقم طائرة</span>
                    </a>
                </li>
            </ul>

            <div class="divider"></div>
            <div class="section-label">التقارير</div>
            <ul class="px-2">
                <li>
                    <a href="{{ route('employee.pilotHoursReport') }}" class="nav-item">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>ساعات الطيران لكل طيار</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employee.aircraftHoursReport') }}" class="nav-item">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>ساعات الطيران لكل طائرة</span>
                    </a>
                </li>
            </ul>
        @endif

        {{-- ===== SHARED: Profile + Logout ===== --}}
        <div class="divider"></div>
        <div class="section-label">الحساب</div>
        <ul class="px-2">
            <li>
                <a href="{{ route('employee.profile') }}" class="nav-item">
                    <i class="fa-solid fa-user icon-fa"></i>
                    <span>الصفحة الشخصية</span>
                </a>
            </li>
        </ul>

        <div class="px-2 mt-auto mb-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </div>

    </div>
</aside>

<style>
.sidebar { background: #0f1117; }

.logo-link { padding: 0 16px 16px; display: block; }
.sidebar-logo { width: 100%; max-height: 70px; object-fit: contain; }

.section-label {
    padding: 10px 16px 4px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: rgba(255,255,255,0.3);
    font-weight: 600;
}

.divider {
    height: 1px;
    background: rgba(255,255,255,0.07);
    margin: 8px 0;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    color: rgba(255,255,255,0.6);
    border-radius: 8px;
    font-size: 13.5px;
    transition: all 0.2s ease;
    text-decoration: none;
}
.nav-item:hover { color: #fff; background: rgba(255,255,255,0.05); }

.nav-sub { padding-right: 20px; font-size: 13px; }

.icon { width: 16px; height: 16px; flex-shrink: 0; opacity: 0.7; }
.icon-fa { width: 16px; text-align: center; opacity: 0.7; font-size: 13px; }

.logout-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 10px;
    background: #6366f1;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.2s ease;
    font-family: inherit;
}
.logout-btn:hover { background: #4f46e5; }
</style>