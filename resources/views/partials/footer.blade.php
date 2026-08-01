@php
    $brandName = $siteSettings['brand.name'] ?? 'CarAsset';
    $brandTagline = $siteSettings['brand.tagline'] ?? 'Mobil Bekerja. Aset Bertumbuh.';
    $logoOnDarkSrc = $siteLogoOnDarkUrl ?? (file_exists(public_path('assets/images/brand/logo-on-dark.png'))
        ? asset('assets/images/brand/logo-on-dark.png')
        : null);

    $footerDescription = $siteSettings['footer.description']
        ?? 'CarAsset adalah platform pengelolaan kendaraan produktif yang membantu mitra memiliki aset dan mengelola operasionalnya secara profesional.';

    $footerCopyright = $siteSettings['footer.copyright'] ?? ('© '.date('Y').' '.$brandName.'. Seluruh hak dilindungi.');

    // Nomor WhatsApp lama di front-end (+123-456-7890) adalah placeholder,
    // bukan data resmi — hanya tampilkan baris WhatsApp bila admin sudah
    // mengisi nomor asli lewat Pengaturan Website.
    $whatsapp = $siteSettings['contact.whatsapp'] ?? null;
    $whatsappUrl = $siteWhatsappUrl ?? null;

    $email = $siteSettings['contact.email'] ?? 'hello@carasset.id';
    $address = $siteSettings['contact.address'] ?? "Gajah Mada Tower, Lt. 19-01, Jl. Gajah Mada No.19-26, Jakarta Pusat 10130";
@endphp

<footer class="ca-footer">
    <div class="ca-container ca-footer__grid">
        <div class="ca-footer__brand">
            @if ($logoOnDarkSrc)
                <img
                    src="{{ $logoOnDarkSrc }}"
                    alt="{{ $siteLogoOnDarkAlt ?? $brandName }}"
                    class="ca-footer__logo"
                >
            @else
                {{-- Ganti dengan logo resmi CarAsset (public/assets/images/brand/logo-on-dark.png) --}}
                <span class="ca-footer__logo-fallback ca-card-title">{{ $brandName }}</span>
            @endif

            <p class="ca-footer__tagline">{{ $brandTagline }}</p>
            <p class="ca-footer__summary">{{ $footerDescription }}</p>
        </div>

        <div class="ca-footer__column">
            <h3 class="ca-footer__heading">Navigasi</h3>
            <ul class="ca-footer__links ca-list-reset">
                <li><a href="{{ route('home') }}" class="ca-footer__link">Home</a></li>
                <li><a href="{{ route('business') }}" class="ca-footer__link">Bisnis CarAsset</a></li>
                <li><a href="{{ route('partnership') }}" class="ca-footer__link">Program Kemitraan</a></li>
                <li><a href="{{ route('simulation') }}" class="ca-footer__link">Simulasi & Perlindungan</a></li>
                <li><a href="{{ route('about-contact') }}" class="ca-footer__link">Tentang & Kontak</a></li>
            </ul>
        </div>

        <div class="ca-footer__column">
            <h3 class="ca-footer__heading">Program</h3>
            <ul class="ca-footer__links ca-list-reset">
                <li><a href="{{ route('partnership') }}#mitra-owner" class="ca-footer__link">Mitra Owner</a></li>
                <li><a href="{{ route('partnership') }}#mitra-driver" class="ca-footer__link">Mitra Driver</a></li>
                <li><a href="{{ route('business') }}#own-operate-grow" class="ca-footer__link">Own – Operate – Grow</a></li>
                <li><a href="{{ route('about-contact') }}#contact" class="ca-footer__link">Konsultasi</a></li>
            </ul>
        </div>

        <div class="ca-footer__column ca-footer__contact">
            <h3 class="ca-footer__heading">Kontak</h3>
            <ul class="ca-footer__links ca-list-reset">
                @if ($whatsappUrl)
                    <li class="ca-footer__contact-item">
                        <span class="ca-footer__contact-icon" data-lucide="phone" aria-hidden="true"></span>
                        <span>WhatsApp: <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="ca-footer__link">{{ $whatsapp }}</a></span>
                    </li>
                @endif
                @if ($email)
                    <li class="ca-footer__contact-item">
                        <span class="ca-footer__contact-icon" data-lucide="mail" aria-hidden="true"></span>
                        <span>Email: <a href="mailto:{{ $email }}" class="ca-footer__link">{{ $email }}</a></span>
                    </li>
                @endif
                @if ($address)
                    <li class="ca-footer__contact-item">
                        <span class="ca-footer__contact-icon" data-lucide="map-pin" aria-hidden="true"></span>
                        <span>{{ $address }}</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="ca-footer__bottom">
        <div class="ca-container ca-footer__bottom-inner">
            <p class="ca-footer__copyright">{{ $footerCopyright }}</p>
            <p class="ca-footer__notice">Informasi legalitas dan kontak mengikuti ketentuan resmi perusahaan.</p>
        </div>
    </div>
</footer>
