@props([
    'paginator',
    'perPageId' => 'emp-per-page',
])

<div {{ $attributes->merge(['class' => 'emp-data-table w-full']) }}>
    <div class="emp-data-table__panel">
        <div class="emp-data-table__toolbar">
            <div class="emp-data-table__search-wrap">
                <span class="emp-data-table__search-icon">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" class="emp-data-table__search"
                    placeholder="بحث..." />
            </div>
            @isset($toolbar)
                <div class="emp-data-table__toolbar-extra">
                    {{ $toolbar }}
                </div>
            @endisset
        </div>

        <div class="emp-data-table__scroll">
            <table class="emp-data-table__table">
                @isset($head)
                    <thead class="emp-data-table__thead">
                        {{ $head }}
                    </thead>
                @endisset
                <tbody class="emp-data-table__tbody">
                    {{ $slot }}
                </tbody>
            </table>
        </div>

        <div class="emp-data-table__footer">
            <div class="emp-data-table__per-page">
                <label for="{{ $perPageId }}" class="emp-data-table__per-page-label">لكل صفحة</label>
                <select id="{{ $perPageId }}" wire:model.live="perPage" class="emp-data-table__per-page-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="emp-data-table__pagination">
                {{ $paginator->links() }}
            </div>
        </div>
    </div>
</div>
