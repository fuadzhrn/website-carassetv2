{{--
    Draft/Published workflow badge + metadata for one section. This is the
    CMS WORKFLOW status (draft|published) — NOT the same thing as a
    section's own internal data_status/editorial_status (Simulasi/Visi &
    Misi/Legalitas), which stays completely separate and is rendered by
    each section's own form, not here.
--}}
@props(['section'])

@php
    $isDraft = $section->workflow_status === \App\Models\PageSection::WORKFLOW_DRAFT;
@endphp

<div class="ca-admin-workflow-status">
    @if ($isDraft)
        <x-admin::status-badge variant="draft">Draft Belum Dipublikasikan</x-admin::status-badge>
    @else
        <x-admin::status-badge variant="published">Published</x-admin::status-badge>
    @endif

    <div class="ca-admin-workflow-status__meta">
        @if ($isDraft)
            @if ($section->draft_updated_at)
                <span class="ca-admin-workflow-status__meta-item">
                    Draft diperbarui {{ $section->draft_updated_at->translatedFormat('d F Y, H:i') }}
                    @if ($section->updatedBy)
                        oleh {{ $section->updatedBy->name }}
                    @endif
                </span>
            @endif
            <p class="ca-admin-workflow-status__notice">
                Website publik masih menggunakan versi Published.
            </p>
        @else
            @if ($section->published_at)
                <span class="ca-admin-workflow-status__meta-item">
                    Dipublikasikan {{ $section->published_at->translatedFormat('d F Y, H:i') }}
                    @if ($section->publishedBy)
                        oleh {{ $section->publishedBy->name }}
                    @endif
                </span>
            @else
                <span class="ca-admin-workflow-status__meta-item">
                    Versi publik lama — waktu publish belum tercatat.
                </span>
            @endif
        @endif
    </div>
</div>
