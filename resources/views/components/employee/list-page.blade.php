@props(['title'])

<main {{ $attributes->merge(['class' => 'emp-main scrollbar-hide']) }}>
    <div class="emp-container emp-container--full">
        <h2 class="emp-page-title">{{ $title }}</h2>
        {{ $slot }}
    </div>
</main>
