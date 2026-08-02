{{--
    Action bar for one section's workflow: Preview / Publish / Batalkan
    Draft / Riwayat Revisi. "Simpan Draft" itself stays the section's own
    <form> submit button (untouched) — this bar renders AFTER that form,
    never nested inside it (Publish/Discard use their own separate forms
    with different routes/methods, which HTML cannot nest inside another
    <form>).
--}}
@props([
    'page',
    'sectionKey',
    'hasDraft' => false,
])

@php
    $previewUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
        'admin.preview.page',
        now()->addMinutes((int) config('content-workflow.preview_expiration_minutes', 30)),
        ['page' => $page->slug],
    ).'#section-'.$sectionKey;
@endphp

<div class="ca-admin-section-action-bar">
    <a href="{{ $previewUrl }}" target="_blank" rel="noopener noreferrer" class="ca-admin-btn ca-admin-btn--outline ca-admin-btn--sm">
        <span class="ca-admin-btn__icon" data-lucide="eye" aria-hidden="true"></span>
        Preview Halaman
    </a>

    @if ($hasDraft)
        <x-admin::confirm-dialog
            id="publish-{{ $page->slug }}-{{ $sectionKey }}"
            title="Publikasikan Section"
            message="Draft ini akan menggantikan versi Published pada website."
            :form-action="route('admin.content.publish', ['page' => $page->slug, 'sectionKey' => $sectionKey])"
            form-method="PATCH"
            confirm-label="Publish"
            trigger-label="Publish"
            trigger-icon="upload-cloud"
            variant="primary"
        />

        <x-admin::confirm-dialog
            id="discard-{{ $page->slug }}-{{ $sectionKey }}"
            title="Batalkan Draft"
            message="Seluruh perubahan Draft pada section ini akan dibuang. Versi Published tidak akan berubah."
            :form-action="route('admin.content.draft.discard', ['page' => $page->slug, 'sectionKey' => $sectionKey])"
            form-method="DELETE"
            confirm-label="Batalkan Draft"
            trigger-label="Batalkan Draft"
            trigger-icon="undo-2"
        />
    @endif

    <a href="{{ route('admin.content.revisions.index', ['page' => $page->slug, 'sectionKey' => $sectionKey]) }}" class="ca-admin-btn ca-admin-btn--ghost ca-admin-btn--sm">
        <span class="ca-admin-btn__icon" data-lucide="history" aria-hidden="true"></span>
        Riwayat Revisi
    </a>
</div>
