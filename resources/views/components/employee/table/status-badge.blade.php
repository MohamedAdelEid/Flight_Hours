@props([
    'status',
    'activeValue' => 'active',
    'maintenanceValue' => 'maintenance',
    'activeLabel' => 'نشط',
    'inactiveLabel' => 'غير نشط',
    'maintenanceLabel' => 'صيانة',
])

@php
    $class = match ($status) {
        $activeValue => 'emp-badge emp-badge--active',
        $maintenanceValue => 'emp-badge emp-badge--maintenance',
        default => 'emp-badge emp-badge--inactive',
    };
    $label = match ($status) {
        $activeValue => $activeLabel,
        'inactive' => $inactiveLabel,
        $maintenanceValue => $maintenanceLabel,
        default => $status,
    };
@endphp

<span {{ $attributes->merge(['class' => $class]) }}>{{ $label }}</span>
