<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Create the empty site_settings shell from config/site-settings.php.
     *
     * Defaults come from the config file (brand name, tagline, SEO
     * fallback text, etc.). The two brand logo settings additionally fall
     * back to the legacy static asset paths if those files exist on disk —
     * see SettingsService::mediaUrl() for how that legacy string format is
     * resolved until an admin picks a real Media Library file instead.
     *
     * Safe to run repeatedly: existing rows are NEVER overwritten, so any
     * value an admin has already set via /admin/settings is preserved.
     */
    public function run(): void
    {
        $legacyMediaDefaults = [
            'brand.logo_horizontal' => file_exists(public_path('assets/images/brand/logo-horizontal.png'))
                ? 'assets/images/brand/logo-horizontal.png'
                : null,
            'brand.logo_on_dark' => file_exists(public_path('assets/images/brand/logo-on-dark.png'))
                ? 'assets/images/brand/logo-on-dark.png'
                : null,
            'brand.favicon' => file_exists(public_path('assets/images/brand/favicon.png'))
                ? 'assets/images/brand/favicon.png'
                : null,
        ];

        foreach (config('site-settings.groups') as $groupKey => $groupData) {
            foreach ($groupData['fields'] as $fieldKey => $fieldData) {
                $exists = SiteSetting::where('group', $groupKey)->where('key', $fieldKey)->exists();

                if ($exists) {
                    continue;
                }

                $flatKey = "{$groupKey}.{$fieldKey}";
                $defaultValue = array_key_exists($flatKey, $legacyMediaDefaults)
                    ? $legacyMediaDefaults[$flatKey]
                    : ($fieldData['default'] ?? null);

                // group/key diisi lewat properti langsung, bukan mass
                // assignment — keduanya guarded karena daftar key yang sah
                // ditentukan config/site-settings.php, bukan input bebas.
                $setting = new SiteSetting();
                $setting->group = $groupKey;
                $setting->key = $fieldKey;
                $setting->type = $fieldData['type'];
                $setting->value = $defaultValue;
                $setting->save();
            }
        }
    }
}
