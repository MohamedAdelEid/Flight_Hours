@props([
    'name' => 'text',
    'value' => '',
    'label' => '',
])

<div>
    <label class="block text-xl">
        <span class="text-gray-700 dark:text-white flex mb-2 text-sm"> {{ $label }} </span>
        <input name="{{ $name }}" value="{{ old($name, $value) }}"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
    </label>
    @error($name)
        <span class="text-xs text-red-600 dark:text-red-400">
            {{ $message }}
        </span>
    @enderror
</div>
