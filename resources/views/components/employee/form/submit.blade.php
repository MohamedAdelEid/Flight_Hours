@props([
    'label' => 'حفظ',
])

<div class="emp-form-actions">
    <button type="submit" {{ $attributes->merge(['class' => 'emp-btn-primary']) }}>
        {{ $label }}
    </button>
</div>
