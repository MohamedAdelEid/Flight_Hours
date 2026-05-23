@props([
    'title',
    'wide' => false,
    'full' => false,
    'card' => true,
])

<main {{ $attributes->merge(['class' => 'emp-main scrollbar-hide']) }}>
    <div @class([
        'emp-container',
        'emp-container--wide' => $wide,
        'emp-container--full' => $full,
    ])>
        <h2 class="emp-page-title">{{ $title }}</h2>
        @if ($card)
            <div class="emp-card">
                {{ $slot }}
            </div>
        @else
            {{ $slot }}
        @endif
    </div>
</main>
