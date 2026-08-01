@props([
    'title' => null,
    'caption' => null,
    'empty' => false,
    'emptyIcon' => 'inbox',
    'emptyTitle' => 'Belum Ada Data',
    'emptyDescription' => null,
])

<div class="ca-admin-table-card">
    @if ($title)
        <div class="ca-admin-table-card__header">
            <h2 class="ca-admin-table-card__title">{{ $title }}</h2>
        </div>
    @endif

    @if ($empty)
        <x-admin::empty-state :icon="$emptyIcon" :title="$emptyTitle" :description="$emptyDescription" />
    @else
        <div class="ca-admin-table-wrapper">
            <table class="ca-admin-table">
                @if ($caption)
                    <caption class="ca-admin-table__caption">{{ $caption }}</caption>
                @endif
                <thead class="ca-admin-table__head">
                    {{ $header }}
                </thead>
                <tbody class="ca-admin-table__body">
                    {{ $slot }}
                </tbody>
            </table>
        </div>

        @isset($pagination)
            <div class="ca-admin-table-card__pagination">{{ $pagination }}</div>
        @endisset
    @endif
</div>
