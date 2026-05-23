@props([
    'label' => '',
    'name' => '',
    'for' => null,
])

@php
    $fieldId = $for ?? $name;
@endphp

<div {{ $attributes->merge(['class' => 'emp-field']) }}>
    @if ($label)
        <label @if ($fieldId) for="{{ $fieldId }}" @endif class="emp-field-label">{{ $label }}</label>
    @endif
    {{ $slot }}
    @if ($name)
        @error($name)
            <p class="emp-field-error">{{ $message }}</p>
        @enderror
    @endif
</div>
