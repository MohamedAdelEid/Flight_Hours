<!-- Desktop sidebar -->
<aside class="sidebar" class="z-20 sticky top-0 hidden w-65 h-screen overflow-y-auto md:block flex-shrink-0">
    <div class="py-4">
        <a class="logo-text" href="{{ route('employee.index') }}">
            <img src="{{ asset('logo1(2).png') }}" alt="Flight Hours Logo" class="sidebar-logo">
        </a>

        <!-- dashboard -->
        <ul class="mt-6">
            <li class="relative px-2">
                <a href="{{ route('employee.index') }}"
                    class="nav-item nav-item-active">
                    <svg class="w-[18px] h-[18px] ms-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>الصفحة الرئيسية</span>
                </a>
            </li>
        </ul>

        <!-- controls -->
        <ul>
            <li class="relative px-2 mt-2">
                <!-- DROPDOWN LINK -->
                <div class="block" x-data="{ open: false }">
                    <div @click="open = !open"
                        class="nav-item">
                        <svg class="w-[18px] h-[18px] ms-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span>البيانات الاساسية</span>
                        <svg class="w-4 h-4 arrow-icon" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </div>
                    <div x-show="open" class="dropdown-menu">

                        <!-- Jobs -->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open" class="nav-item nav-item-sub">
                                <i class="fa-solid fa-briefcase ms-2.5 w-[18px]"></i>
                                <span>الوظائف</span>
                                <svg class="w-4 h-4 arrow-icon" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </div>
                            <div x-show="open" class="dropdown-submenu">
                                <a href="{{ route('job.create') }}" class="dropdown-item">اضافة وظيفة</a>
                                <a href="{{ route('job.index') }}" class="dropdown-item">عرض الوظائف</a>
                            </div>
                        </div>

                        <!-- Airports -->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open" class="nav-item nav-item-sub">
                                <i class="fa-solid fa-plane-departure ms-2.5 w-[18px]"></i>
                                <span>المطارات</span>
                                <svg class="w-4 h-4 arrow-icon" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </div>
                            <div x-show="open" class="dropdown-submenu">
                                <a href="{{ route('airport.create') }}" class="dropdown-item">اضافة مطار</a>
                                <a href="{{ route('airport.index') }}" class="dropdown-item">عرض المطارات</a>
                            </div>
                        </div>

                        <!-- Aircraft -->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open" class="nav-item nav-item-sub">
                                <i class="fa-solid fa-plane ms-2.5 w-[18px]"></i>
                                <span>الطائرات</span>
                                <svg class="w-4 h-4 arrow-icon" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </div>
                            <div x-show="open" class="dropdown-submenu">
                                <a href="{{ route('aircraft.create') }}" class="dropdown-item">اضافة طائرة</a>
                                <a href="{{ route('aircraft.index') }}" class="dropdown-item">عرض الطائرات</a>
                            </div>
                        </div>

                        <!-- Crew -->
                        <div class="block" x-data="{ open: false }">
                            <div @click="open = !open" class="nav-item nav-item-sub">
                                <i class="fa-solid fa-users ms-2.5 w-[18px]"></i>
                                <span>الطقم</span>
                                <svg class="w-4 h-4 arrow-icon" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </div>
                            <div x-show="open" class="dropdown-submenu">
                                <a href="{{ route('crew.create') }}" class="dropdown-item">اضافة عضو طقم</a>
                                <a href="{{ route('crew.index') }}" class="dropdown-item">عرض طاقم طائرة</a>
                            </div>
                        </div>

                    </div>
                </div>
            </li>

            <!-- Reports -->
            <li class="relative px-2 mt-2">
                <div class="block" x-data="{ open: false }">
                    <div @click="open = !open" class="nav-item">
                        <svg class="w-[18px] h-[18px] ms-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>التقارير</span>
                        <svg class="w-4 h-4 arrow-icon" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </div>
                    <div x-show="open" class="dropdown-menu">
                        <a href="{{ route('employee.pilotHoursReport') }}" class="dropdown-item">ساعات الطيران لكل طيار</a>
                        <a href="{{ route('employee.aircraftHoursReport') }}" class="dropdown-item">ساعات الطيران لكل طائرة</a>
                    </div>
                </div>
            </li>
        </ul>

        <!-- my profile -->
        <ul class="mt-2">
            <li class="relative px-2">
                <a href="{{ route('employee.profile') }}" class="nav-item">
                    <i class="fa-solid fa-user ms-2.5 w-[18px]"></i>
                    <span>الصفحة الشخصية</span>
                </a>
            </li>
        </ul>

        <!-- Logout -->
        <div class="px-2 my-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                <svg class="w-[18px] h-[18px] ms-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>تسجيل الخروج</span>
            </button>
            </form>
        </div>

    </div>
</aside>

<style>
.sidebar {
    background: #0f1117;
}

.logo-text {
    padding: 0 16px;
    display: block;
    margin-bottom: 16px;
}

.sidebar-logo {
    width: 100%;
    height: auto;
    max-height: 48px;
    object-fit: contain;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    color: rgba(255,255,255,0.6);
    border-radius: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
    font-size: 14px;
}

.nav-item:hover {
    color: #fff;
    background: rgba(255,255,255,0.05);
}

.nav-item-active {
    background: #6366f1;
    color: #fff;
}

.nav-item-sub {
    padding: 10px 12px 10px 20px;
}

.dropdown-menu {
    padding: 8px 0 8px 12px;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.dropdown-submenu {
    padding: 4px 0 4px 12px;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.dropdown-item {
    padding: 8px 12px 8px 20px;
    color: rgba(255,255,255,0.6);
    border-radius: 6px;
    font-size: 13px;
    transition: all 0.2s ease;
    display: block;
}

.dropdown-item:hover {
    color: #fff;
    background: rgba(255,255,255,0.05);
}

.logout-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    background: #6366f1;
    color: #fff;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.logout-btn:hover {
    background: #4f46e5;
}

.arrow-icon {
    margin-right: auto;
    transition: transform 0.2s ease;
}

.rotate-180 {
    transform: rotate(180deg);
}
</style>