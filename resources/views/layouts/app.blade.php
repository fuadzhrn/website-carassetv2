<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.seo-meta')

    {{-- Urutan wajib: reset > variables > typography > utilities > global > layouts > components > page-specific --}}
    <link rel="stylesheet" href="{{ asset('assets/css/base/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/utilities.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/global.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/layouts/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/layouts/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/layouts/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/layouts/page-shell.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/components/buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/section-heading.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/icon-box.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/form-field.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/whatsapp-button.css') }}">

    @if ($previewMode ?? false)
        <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-preview-banner.css') }}">
    @endif

    @stack('styles')
</head>
<body class="@yield('body-class', 'ca-page')">
    <a href="#main-content" class="ca-skip-link">Lewati ke konten utama</a>

    @if ($previewMode ?? false)
        <div class="ca-preview-banner" role="status">
            <div class="ca-preview-banner__inner">
                <span class="ca-preview-banner__label">
                    <span data-lucide="eye" aria-hidden="true"></span>
                    Mode Preview Draft
                </span>
                <p class="ca-preview-banner__description">
                    Halaman ini hanya dapat dilihat oleh administrator dan belum dipublikasikan.
                </p>
                <div class="ca-preview-banner__actions">
                    <a href="{{ $previewEditorUrl }}" class="ca-preview-banner__link">Kembali ke Editor</a>
                    <a href="{{ $previewPublishedUrl }}" class="ca-preview-banner__link" target="_blank" rel="noopener noreferrer">Buka Versi Published</a>
                </div>

                @if ($previewSeoTarget ?? null)
                    <div class="ca-preview-banner__seo">
                        <span class="ca-preview-banner__seo-label">SEO Target Setelah Publish:</span>
                        <span>Judul: {{ $previewSeoTarget['meta_title'] ?? '(memakai fallback)' }}</span>
                        <span>Robots: {{ $previewSeoTarget['meta_robots'] === 'noindex,nofollow' ? 'Jangan Indeks Halaman' : 'Izinkan Pengindeksan' }}</span>
                        <span>Canonical: {{ $previewSeoTarget['canonical_url'] ?? '(otomatis dari route)' }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="ca-site">
        @include('partials.header')

        <main id="main-content" class="ca-main">
            @yield('content')
        </main>

        @include('partials.footer')
        @include('partials.whatsapp-button')
    </div>

    {{-- Lucide Icons — dipanggil terpusat di sini, jangan diulang di partial/component lain --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <script src="{{ asset('assets/js/global/lucide-init.js') }}" defer></script>
    <script src="{{ asset('assets/js/global/header-scroll.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
