@props(['items' => []])

<nav aria-label="Breadcrumb" class="ca-admin-breadcrumb">
    <ol class="ca-admin-breadcrumb__list">
        @foreach ($items as $item)
            <li class="ca-admin-breadcrumb__item">
                @if (! $loop->last && ! empty($item['route']))
                    <a href="{{ $item['route'] }}" class="ca-admin-breadcrumb__link">{{ $item['label'] }}</a>
                @else
                    <span class="ca-admin-breadcrumb__current" @if ($loop->last) aria-current="page" @endif>{{ $item['label'] }}</span>
                @endif

                @unless ($loop->last)
                    <span class="ca-admin-breadcrumb__separator" data-lucide="chevron-right" aria-hidden="true"></span>
                @endunless
            </li>
        @endforeach
    </ol>
</nav>
