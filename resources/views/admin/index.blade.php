@extends('layouts.employee.main')

@section('content')
<div class="dashboard-content">
    <!-- Page Header -->
    <div class="report-header">
        <div>
            <h1>إدارة الحسابات</h1>
            <p class="subtitle">إنشاء وإدارة حسابات الموظفين والكابتنات</p>
        </div>
        <button onclick="openModal('createModal')" class="btn-primary">
            <i class="fas fa-user-plus"></i> إنشاء حساب جديد
        </button>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
        <button onclick="this.parentElement.remove()" class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
        <button onclick="this.parentElement.remove()" class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Summary Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="color: #6366f1;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">حساب مسجل</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="color: #06b6d4;">
                <i class="fas fa-id-badge"></i>
            </div>
            <div class="stat-value">{{ $stats['employees'] }}</div>
            <div class="stat-label">حساب موظف</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="color: #10b981;">
                <i class="fas fa-plane"></i>
            </div>
            <div class="stat-value">{{ $stats['captains'] }}</div>
            <div class="stat-label">حساب كابتن</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color: #3b82f6;">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-value">{{ $stats['admins'] }}</div>
            <div class="stat-label">حساب مدير</div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <form method="GET" class="filter-bar">
        <div class="filter-group" style="flex:1; min-width:220px">
            <label>البحث</label>
            <div class="search-wrap">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالاسم أو البريد الإلكتروني...">
            </div>
        </div>

        <div class="filter-group">
            <label>نوع الحساب</label>
            <select name="role">
                <option value="">الكل</option>
                <option value="employee" {{ request('role')=='employee'?'selected':'' }}>موظف</option>
                <option value="captain" {{ request('role')=='captain'?'selected':'' }}>كابتن</option>
                <option value="admin" {{ request('role')=='admin'?'selected':'' }}>مدير</option>
            </select>
        </div>

        <div class="filter-group">
            <label>الحالة</label>
            <select name="is_active">
                <option value="">الكل</option>
                <option value="1" {{ request('is_active')=='1'?'selected':'' }}>نشط</option>
                <option value="0" {{ request('is_active')=='0'?'selected':'' }}>معطل</option>
            </select>
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-filter"></i> بحث
        </button>
        <a href="{{ route('admin.accounts.index') }}" class="btn-reset">
            <i class="fas fa-refresh"></i> إعادة تعيين
        </a>
    </form>

    <!-- Accounts Table -->
    <div class="table-card">
        <div class="table-header">
            <span>قائمة الحسابات ({{ $users->total() }})</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>المستخدم</th>
                    <th>نوع الحساب</th>
                    <th>رقم الهاتف</th>
                    <th>الحالة</th>
                    <th>تاريخ الإنشاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:rgba(255,255,255,0.35)">{{ $loop->iteration }}</td>

                    <td>
                        <div class="user-cell">
                            <div class="avatar" style="background: {{ $user->role === 'captain' ? 'rgba(16,185,129,0.2)' : ($user->role === 'admin' ? 'rgba(139,92,246,0.2)' : 'rgba(99,102,241,0.2)') }}; color: {{ $user->role === 'captain' ? '#10b981' : ($user->role === 'admin' ? '#c4b5fd' : '#a5b4fc') }}">
                                {{ mb_substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight:500; color:#fff">{{ $user->name }}</div>
                                <div style="font-size:11px; color:rgba(255,255,255,0.4)">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        @if($user->role === 'captain')
                            <span class="badge badge-teal">
                                <i class="fas fa-plane" style="font-size:10px"></i> كابتن
                            </span>
                        @elseif($user->role === 'admin')
                            <span class="badge badge-blue">
                                <i class="fas fa-user-shield" style="font-size:10px"></i> مدير
                            </span>
                        @else
                            <span class="badge badge-purple">
                                <i class="fas fa-id-badge" style="font-size:10px"></i> موظف
                            </span>
                        @endif
                    </td>

                    <td style="font-size:13px; color:rgba(255,255,255,0.7)">
                        {{ $user->phone ?? '—' }}
                    </td>

                    <td>
                        @if($user->is_active)
                            <span class="badge badge-success">نشط</span>
                        @else
                            <span class="badge badge-danger">معطل</span>
                        @endif
                    </td>

                    <td style="font-size:12px; color:rgba(255,255,255,0.4)">
                        {{ $user->created_at->format('Y/m/d') }}
                    </td>

                    <td>
                        <div class="actions-wrap">
                            <!-- Edit -->
                            <button onclick="openEditModal({{ Illuminate\Support\Js::from($user) }})" class="action-btn" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Toggle active/inactive -->
                            <button onclick="openToggleModal({{ $user->id }}, {{ Illuminate\Support\Js::from($user->name) }}, {{ $user->is_active ? 'true' : 'false' }})" class="action-btn" title="{{ $user->is_active ? 'تعطيل' : 'تفعيل' }}">
                                <i class="fas fa-toggle-{{ $user->is_active ? 'on' : 'off' }}" style="color:{{ $user->is_active ? '#10b981' : 'rgba(255,255,255,0.3)' }}"></i>
                            </button>

                            <!-- Reset password -->
                            <button onclick="openResetModal({{ $user->id }}, {{ Illuminate\Support\Js::from($user->name) }})" class="action-btn" title="إعادة تعيين كلمة المرور">
                                <i class="fas fa-key" style="color:#f59e0b"></i>
                            </button>

                            <!-- Delete -->
                            <button onclick="openDeleteModal({{ $user->id }}, {{ Illuminate\Support\Js::from($user->name) }})" class="action-btn" title="حذف">
                                <i class="fas fa-trash" style="color:#ef4444"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-row">
                        <i class="fas fa-users-slash" style="font-size:32px; display:block; margin-bottom:8px; opacity:0.3"></i>
                        لا توجد حسابات مطابقة للبحث
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-wrap">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Create Account Modal -->
<div id="createModal" class="modal-overlay" style="display:none">
    <div class="modal-box">
        <div class="modal-header">
            <h2><i class="fas fa-user-plus"></i> إنشاء حساب جديد</h2>
            <button onclick="closeModal('createModal')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.accounts.store') }}">
            @csrf
            <input type="hidden" name="_form" value="create">

            <div class="form-grid">
                <div class="form-group">
                    <label>الاسم الكامل <span class="required">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="أدخل الاسم الكامل" required>
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="example@domain.com" required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>نوع الحساب <span class="required">*</span></label>
                    <select name="role" id="createRole" onchange="toggleLicenseField('create')" required>
                        <option value="">اختر نوع الحساب</option>
                        <option value="employee" {{ old('role')=='employee'?'selected':'' }}>موظف</option>
                        <option value="captain" {{ old('role')=='captain'?'selected':'' }}>كابتن</option>
                        <option value="admin" {{ old('role')=='admin'?'selected':'' }}>مدير</option>
                    </select>
                    @error('role')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+966 5X XXX XXXX">
                    @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>كلمة المرور <span class="required">*</span></label>
                    <div class="password-wrap">
                        <input type="password" name="password" id="createPassword" placeholder="8 أحرف على الأقل" required>
                        <button type="button" onclick="togglePassword('createPassword')" class="password-eye">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal('createModal')" class="btn-reset">
                    إلغاء
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-user-plus"></i> إنشاء الحساب
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Account Modal -->
<div id="editModal" class="modal-overlay" style="display:none">
    <div class="modal-box">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> تعديل بيانات الحساب</h2>
            <button onclick="closeModal('editModal')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" id="editForm" action="">
            @csrf @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label>الاسم الكامل <span class="required">*</span></label>
                    <input type="text" name="name" id="editName" required>
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني <span class="required">*</span></label>
                    <input type="email" name="email" id="editEmail" required>
                </div>

                <div class="form-group">
                    <label>نوع الحساب <span class="required">*</span></label>
                    <select name="role" id="editRole" required>
                        <option value="employee">موظف</option>
                        <option value="captain">كابتن</option>
                        <option value="admin">مدير</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="text" name="phone" id="editPhone">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal('editModal')" class="btn-reset">
                    إلغاء
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal-overlay" style="display:none">
    <div class="confirm-box">
        <div class="confirm-icon" id="confirmIcon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 id="confirmTitle">تأكيد الإجراء</h3>
        <p id="confirmMessage">هل أنت متأكد؟</p>
        <div class="confirm-actions">
            <button onclick="closeModal('confirmModal')" class="btn-reset">إلغاء</button>
            <button id="confirmBtn" class="btn-confirm">تأكيد</button>
        </div>
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

    /* Alerts */
    .alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 16px;
        position: relative;
    }

    .alert-success {
        background: rgba(16,185,129,0.12);
        color: #10b981;
        border: 1px solid rgba(16,185,129,0.2);
    }

    .alert-error {
        background: rgba(239,68,68,0.12);
        color: #ef4444;
        border: 1px solid rgba(239,68,68,0.2);
    }

    .alert-close {
        background: none;
        border: none;
        cursor: pointer;
        color: inherit;
        margin-right: auto;
        font-size: 16px;
        opacity: 0.6;
        padding: 0;
    }

    /* Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
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
        font-size: 26px;
        margin-bottom: 10px;
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

    /* Filter */
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
        background: var(--theme-bg);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 8px 12px;
        color: #fff;
        font-size: 13px;
    }

    .search-wrap {
        position: relative;
    }

    .search-wrap input {
        padding-right: 36px;
        width: 100%;
    }

    .search-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.3);
        font-size: 16px;
        pointer-events: none;
    }

    /* Table */
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

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    thead th {
        background: rgba(255,255,255,0.03);
        color: rgba(255,255,255,0.45);
        font-weight: 500;
        padding: 11px 16px;
        text-align: right;
        white-space: nowrap;
    }

    tbody td {
        padding: 12px 16px;
        color: #e2e8f0;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        vertical-align: middle;
    }

    tbody tr:hover {
        background: rgba(255,255,255,0.03);
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
        flex-shrink: 0;
    }

    /* Badges */
    .badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-success {
        background: rgba(16,185,129,0.15);
        color: #10b981;
    }

    .badge-danger {
        background: rgba(239,68,68,0.15);
        color: #ef4444;
    }

    .badge-purple {
        background: rgba(99,102,241,0.15);
        color: #a5b4fc;
    }

    .badge-teal {
        background: rgba(6,182,212,0.15);
        color: #06b6d4;
    }
    .badge-blue {  
         background: rgba(59,130,246,0.15);
        color: #3b82f6;
    }

    /* Action buttons */
    .actions-wrap {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .action-btn {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 8px;
        padding: 6px 9px;
        cursor: pointer;
        color: rgba(255,255,255,0.6);
        font-size: 15px;
        transition: background .15s;
    }

    .action-btn:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
    }

    /* Pagination */
    .pagination-wrap {
        padding: 16px 20px;
        border-top: 1px solid rgba(255,255,255,0.06);
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 20px;
    }

    .modal-box {
        background: #1a1d2e;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        width: 100%;
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 24px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .modal-header h2 {
        font-size: 17px;
        font-weight: 600;
        color: #fff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-close {
        background: rgba(255,255,255,0.06);
        border: none;
        border-radius: 8px;
        padding: 6px 9px;
        cursor: pointer;
        color: rgba(255,255,255,0.6);
        font-size: 16px;
    }

    .modal-close:hover {
        background: rgba(255,255,255,0.12);
        color: #fff;
    }

    /* Form */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group label {
        font-size: 12px;
        color: rgba(255,255,255,0.5);
        font-weight: 500;
    }

    .form-group input,
    .form-group select {
        background: var(--theme-bg);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 9px 12px;
        color: #fff;
        font-size: 13px;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #6366f1;
        outline: none;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }

    .form-group input::placeholder {
        color: rgba(255,255,255,0.2);
    }

    .required {
        color: #ef4444;
    }

    .field-error {
        font-size: 11px;
        color: #ef4444;
        margin-top: 2px;
    }

    .password-wrap {
        position: relative;
    }

    .password-wrap input {
        width: 100%;
        padding-left: 36px;
    }

    .password-eye {
        position: absolute;
        left: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: rgba(255,255,255,0.3);
        font-size: 16px;
    }

    .password-eye:hover {
        color: rgba(255,255,255,0.7);
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.06);
    }

    /* Buttons */
    .btn-primary {
        background: #6366f1;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
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
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .btn-reset:hover {
        color: #fff;
        border-color: rgba(255,255,255,0.3);
    }

    /* Empty state */
    .empty-row {
        text-align: center;
        padding: 48px;
        color: rgba(255,255,255,0.3);
        font-size: 14px;
    }

    /* Confirmation Modal */
    .confirm-box {
        background: #1a1d2e;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        width: 100%;
        max-width: 400px;
        padding: 32px 24px 24px;
        text-align: center;
    }

    .confirm-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
    }

    .confirm-icon.danger {
        background: rgba(239,68,68,0.15);
        color: #ef4444;
    }

    .confirm-icon.warning {
        background: rgba(245,158,11,0.15);
        color: #f59e0b;
    }

    .confirm-icon.info {
        background: rgba(99,102,241,0.15);
        color: #6366f1;
    }

    .confirm-box h3 {
        font-size: 18px;
        font-weight: 600;
        color: #fff;
        margin: 0 0 8px;
    }

    .confirm-box p {
        font-size: 14px;
        color: rgba(255,255,255,0.5);
        margin: 0 0 24px;
        line-height: 1.6;
    }

    .confirm-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .btn-confirm {
        background: #ef4444;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-confirm:hover {
        background: #dc2626;
    }

    .btn-confirm.warning {
        background: #f59e0b;
    }

    .btn-confirm.warning:hover {
        background: #d97706;
    }

    .btn-confirm.info {
        background: #6366f1;
    }

    .btn-confirm.info:hover {
        background: #4f46e5;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('script')
<script>
let confirmAction = null;

function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = '';
}

document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', e => {
        if (e.target === overlay) closeModal(overlay.id);
    });
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay').forEach(m => {
            m.style.display = 'none';
            document.body.style.overflow = '';
        });
    }
});

function openEditModal(user) {
    document.getElementById('editForm').action = '/admin/accounts/' + user.id;
    document.getElementById('editName').value = user.name || '';
    document.getElementById('editEmail').value = user.email || '';
    document.getElementById('editRole').value = user.role || 'employee';
    document.getElementById('editPhone').value = user.phone || '';
    openModal('editModal');
}

function openToggleModal(userId, userName, isActive) {
    const action = isActive ? 'تعطيل' : 'تفعيل';
    const icon = isActive ? 'warning' : 'info';
    const iconClass = isActive ? 'fa-toggle-off' : 'fa-toggle-on';
    const btnClass = isActive ? 'warning' : 'info';
    
    document.getElementById('confirmIcon').className = 'confirm-icon ' + icon;
    document.getElementById('confirmIcon').innerHTML = '<i class="fas ' + iconClass + '"></i>';
    document.getElementById('confirmTitle').textContent = 'تأكيد ' + action + ' الحساب';
    document.getElementById('confirmMessage').textContent = 'هل تريد ' + action + ' حساب ' + userName + '؟';
    
    const btn = document.getElementById('confirmBtn');
    btn.className = 'btn-confirm ' + btnClass;
    btn.textContent = action;
    
    confirmAction = function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/accounts/' + userId + '/toggle';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfInput);
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PATCH';
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    };
    
    openModal('confirmModal');
}

function openResetModal(userId, userName) {
    document.getElementById('confirmIcon').className = 'confirm-icon warning';
    document.getElementById('confirmIcon').innerHTML = '<i class="fas fa-key"></i>';
    document.getElementById('confirmTitle').textContent = 'إعادة تعيين كلمة المرور';
    document.getElementById('confirmMessage').textContent = 'هل تريد إعادة تعيين كلمة المرور لـ ' + userName + '؟ سيتم إرسال كلمة المرور الجديدة إلى بريده الإلكتروني.';
    
    const btn = document.getElementById('confirmBtn');
    btn.className = 'btn-confirm warning';
    btn.textContent = 'إعادة تعيين';
    
    confirmAction = function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/accounts/' + userId + '/reset-password';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfInput);
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PATCH';
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    };
    
    openModal('confirmModal');
}

function openDeleteModal(userId, userName) {
    document.getElementById('confirmIcon').className = 'confirm-icon danger';
    document.getElementById('confirmIcon').innerHTML = '<i class="fas fa-trash"></i>';
    document.getElementById('confirmTitle').textContent = 'حذف الحساب';
    document.getElementById('confirmMessage').textContent = 'هل أنت متأكد من حذف حساب ' + userName + '؟ هذا الإجراء لا يمكن التراجع عنه.';
    
    const btn = document.getElementById('confirmBtn');
    btn.className = 'btn-confirm';
    btn.textContent = 'حذف';
    
    confirmAction = function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/accounts/' + userId;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfInput);
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    };
    
    openModal('confirmModal');
}

document.getElementById('confirmBtn').addEventListener('click', function() {
    if (confirmAction) {
        confirmAction();
        confirmAction = null;
    }
});

function toggleLicenseField(prefix) {
}

function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}

@if($errors->any() && old('_form') === 'create')
openModal('createModal');
@endif

setTimeout(() => {
    document.querySelectorAll('.alert').forEach(a => a.remove());
}, 5000);
</script>
@endpush