@props([
    'name' => '',
    'icon' => '',
    'value' => '',
])

<div class="block text-sm">
    <div class="text-right text-gray-700 text-lg dark:text-white">
        {{ $name }}
    </div>
    <div
        class="text-right block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
        <i class="{{ $icon }}"></i> <span> {{ $value }} </span>
    </div>
    </d>
</div>
