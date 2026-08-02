{{--
    Pratinjau Hasil Pencarian — an approximation only, never a claim of
    exact search-engine rendering. Server-rendered from Draft-or-Published
    SEO (whichever the caller passes as $seo); admin-seo.js re-renders the
    title/description live from the form fields as the admin types,
    falling back to this same server-rendered value when a field is empty.
--}}
@props(['seo'])

<div class="ca-admin-seo-preview" data-seo-preview>
    <p class="ca-admin-seo-preview__title" data-seo-preview="title">{{ $seo['title'] }}</p>
    <p class="ca-admin-seo-preview__url" data-seo-preview="canonical">{{ $seo['canonical'] }}</p>
    <p class="ca-admin-seo-preview__description" data-seo-preview="description">
        {{ $seo['description'] ?? 'Tidak ada meta description — mesin pencari dapat menampilkan cuplikan otomatis dari halaman.' }}
    </p>

    <div class="ca-admin-seo-preview__meta">
        <span class="ca-admin-seo-preview__robots" data-seo-preview="robots">
            Robots: {{ $seo['robots'] === 'index,follow' ? 'Izinkan Pengindeksan' : 'Jangan Indeks Halaman' }}
        </span>
    </div>

    <p class="ca-admin-seo-preview__disclaimer">
        Pratinjau ini hanya memperkirakan tampilan metadata. Mesin pencari dapat menampilkan hasil yang berbeda.
    </p>
</div>
