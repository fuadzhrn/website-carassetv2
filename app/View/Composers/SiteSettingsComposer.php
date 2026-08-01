<?php

namespace App\View\Composers;

use App\Services\SettingsService;
use Illuminate\View\View;

/**
 * Shares global site settings with the public layout shell.
 *
 * Registered only on `layouts.app` (which @include's header/footer/
 * seo-meta directly, so they inherit this same data) and the contact-form
 * section (rendered from within the child page view, before @extends
 * resolves the parent layout — see AppServiceProvider::boot()).
 */
class SiteSettingsComposer
{
    public function __construct(private readonly SettingsService $settingsService)
    {
    }

    public function compose(View $view): void
    {
        $view->with([
            'siteSettings' => $this->settingsService->all(),
            'siteLogoHorizontalUrl' => $this->settingsService->mediaUrl('brand.logo_horizontal'),
            'siteLogoHorizontalAlt' => $this->settingsService->mediaAlt('brand.logo_horizontal', 'Logo CarAsset'),
            'siteLogoOnDarkUrl' => $this->settingsService->mediaUrl('brand.logo_on_dark'),
            'siteLogoOnDarkAlt' => $this->settingsService->mediaAlt('brand.logo_on_dark', 'Logo CarAsset'),
            'siteFaviconUrl' => $this->settingsService->mediaUrl('brand.favicon'),
            'siteWhatsappUrl' => $this->settingsService->whatsappUrl('contact.whatsapp'),
        ]);
    }
}
