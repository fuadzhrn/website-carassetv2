@extends('admin.layouts.app')

@section('title', 'Riwayat Revisi — Panel Admin CarAsset')
@section('page-title', 'Riwayat Revisi')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Konten Website', 'route' => route('admin.pages.index')],
        ['label' => $page->name, 'route' => route('admin.pages.'.$page->slug)],
        ['label' => 'Riwayat Revisi'],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-content-workflow.css') }}">
@endpush

@php
    $actionLabels = [
        'baseline' => 'Baseline Sebelum Workflow',
        'published' => 'Published',
    ];

    /**
     * Safe, bounded snapshot summary — top-level keys only, short text
     * values, array item/field counts. Never raw HTML, never unescaped
     * JSON, never a media file.
     */
    $summarize = function (array $content): array {
        $rows = [];

        foreach ($content as $key => $value) {
            if (is_array($value)) {
                $rows[$key] = array_is_list($value)
                    ? count($value).' item'
                    : count($value).' field';
            } elseif (is_bool($value)) {
                $rows[$key] = $value ? 'true' : 'false';
            } elseif ($value === null) {
                $rows[$key] = '—';
            } else {
                $rows[$key] = \Illuminate\Support\Str::limit((string) $value, 80);
            }
        }

        return $rows;
    };
@endphp

@section('content')
    <p class="ca-admin-section__description">
        Lihat versi konten yang pernah dipublikasikan pada section ini.
    </p>

    <div class="ca-admin-workflow-status">
        <div>
            <p class="ca-admin-home-panel__title">{{ $page->name }} — {{ $section->section_name }}</p>
        </div>
        <x-admin::cms.workflow-status :section="$section" />
    </div>

    <x-admin::data-table
        caption="Riwayat revisi section {{ $section->section_name }}"
        :empty="$revisions->total() === 0"
        empty-icon="history"
        empty-title="Belum Ada Riwayat Revisi"
        empty-description="Revisi akan muncul di sini setelah section ini pernah dipublikasikan."
    >
        <x-slot:header>
            <tr>
                <th scope="col">Versi</th>
                <th scope="col">Jenis</th>
                <th scope="col">Status Section</th>
                <th scope="col">Admin</th>
                <th scope="col">Waktu</th>
                <th scope="col">Catatan</th>
                <th scope="col">Ringkasan</th>
                <th scope="col" class="ca-admin-table__action-col">Aksi</th>
            </tr>
        </x-slot:header>

        @foreach ($revisions as $revision)
            <tr>
                <td>#{{ $revision->revision_number }}</td>
                <td>{{ $actionLabels[$revision->action] ?? ucfirst($revision->action) }}</td>
                <td>
                    @if ($revision->is_active)
                        <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
                    @else
                        <x-admin::status-badge variant="inactive">Nonaktif</x-admin::status-badge>
                    @endif
                </td>
                <td>{{ $revision->createdBy->name ?? '—' }}</td>
                <td>{{ $revision->created_at->translatedFormat('d F Y, H:i') }}</td>
                <td>{{ $revision->note ?? '—' }}</td>
                <td>
                    <details>
                        <summary>Lihat ringkasan</summary>
                        <dl class="ca-admin-revision-summary">
                            @foreach ($summarize($revision->content) as $fieldKey => $fieldValue)
                                <div class="ca-admin-revision-summary__row">
                                    <dt>{{ $fieldKey }}</dt>
                                    <dd>{{ $fieldValue }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </details>
                </td>
                <td class="ca-admin-table__action-col">
                    <x-admin::confirm-dialog
                        id="restore-revision-{{ $revision->id }}"
                        title="Pulihkan sebagai Draft"
                        message="Versi ini akan disalin menjadi Draft. Versi Published saat ini tidak akan berubah sampai Draft dipublikasikan."
                        :form-action="route('admin.content.revisions.restore', ['page' => $page->slug, 'sectionKey' => $sectionKey, 'contentRevision' => $revision->id])"
                        form-method="POST"
                        confirm-label="Pulihkan sebagai Draft"
                        trigger-label="Pulihkan sebagai Draft"
                        trigger-icon="rotate-ccw"
                        variant="primary"
                    />
                </td>
            </tr>
        @endforeach

        <x-slot:pagination>
            {{ $revisions->links() }}
        </x-slot:pagination>
    </x-admin::data-table>

    <div class="ca-admin-home-form__actions">
        <x-admin::button :href="route('admin.pages.'.$page->slug).'#section-'.$sectionKey" variant="ghost" icon="arrow-left">
            Kembali ke Editor
        </x-admin::button>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/admin-content-workflow.js') }}" defer></script>
@endpush
