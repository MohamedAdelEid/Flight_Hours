@props([
    'type' => 'text',
    'name' => '',
    'value' => '',
    'label' => '',
    'id' => null,
    'placeholder' => '',
])

@php
    $inputId = $id ?? $name;
@endphp

<x-employee.form.field :label="$label" :name="$name" :for="$inputId">
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $inputId }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'emp-input form-input']) }} />
</x-employee.form.field>
