@props([
    'name' => '',
    'label' => '',
    'id' => null,
])

@php
    $selectId = $id ?? $name;
@endphp

<x-employee.form.field :label="$label" :name="$name" :for="$selectId">
    <select name="{{ $name }}" id="{{ $selectId }}"
        {{ $attributes->merge(['class' => 'emp-input form-select']) }}>
        {{ $slot }}
    </select>
</x-employee.form.field>
