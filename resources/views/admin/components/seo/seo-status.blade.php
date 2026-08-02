{{--
    Draft/Published SEO workflow badge + metadata for one page. This is
    the SEO workflow status (draft|published), completely separate from
    each page's own internal data/editorial status — those never mix.
--}}
@props(['page'])

@php
    $isDraft = $page->hasSeoDraft();
@endphp

<div class="ca-admin-workflow-status">
    @if ($isDraft)
        <x-admin::status-badge variant="draft">Draft SEO Belum Dipublikasikan</x-admin::status-badge>
    @else
        <x-admin::status-badge variant="published">SEO Published</x-admin::status-badge>
    @endif

    <div class="ca-admin-workflow-status__meta">
        @if ($isDraft)
            @if ($page->seo_draft_updated_at)
                <span class="ca-admin-workflow-status__meta-item">
                    Draft diperbarui {{ $page->seo_draft_updated_at->translatedFormat('d F Y, H:i') }}
                    @if ($page->seoUpdatedBy)
                        oleh {{ $page->seoUpdatedBy->name }}
                    @endif
                </span>
            @endif
            <p class="ca-admin-workflow-status__notice">
                Website publik masih menggunakan SEO Published.
            </p>
        @else
            @if ($page->seo_published_at)
                <span class="ca-admin-workflow-status__meta-item">
                    Dipublikasikan {{ $page->seo_published_at->translatedFormat('d F Y, H:i') }}
                    @if ($page->seoPublishedBy)
                        oleh {{ $page->seoPublishedBy->name }}
                    @endif
                </span>
            @else
                <span class="ca-admin-workflow-status__meta-item">
                    SEO lama — waktu publish belum tercatat.
                </span>
            @endif
        @endif
    </div>
</div>
