<?php

namespace App\Services;

use App\Models\Media;
use App\Models\PageSection;
use App\Models\SiteSetting;

/**
 * Finds where a Media record is referenced so MediaController::destroy()
 * can safely refuse to delete media that is still in use.
 *
 * Scans site_settings (type=media) and page_sections.content JSON for
 * `media_id` / `*_media_id` keys — never treats an arbitrary matching
 * number as a reference.
 */
class MediaUsageService
{
    /**
     * @return array<int, array{type: string, label: string, location: string}>
     */
    public function findUsages(Media $media): array
    {
        $usages = [];

        foreach (SiteSetting::where('type', 'media')->get() as $setting) {
            if ($setting->value !== null && (string) $setting->value === (string) $media->id) {
                $usages[] = [
                    'type' => 'site_setting',
                    'label' => $this->settingLabel($setting),
                    'location' => $setting->group.'.'.$setting->key,
                ];
            }
        }

        foreach (PageSection::with('page')->get() as $section) {
            $paths = $this->scanContentForMediaId(is_array($section->content) ? $section->content : [], $media->id);

            foreach ($paths as $path) {
                $usages[] = [
                    'type' => 'page_section',
                    'label' => ($section->page?->name ?? 'Halaman').' — '.$section->section_name,
                    'location' => ($section->page?->slug ?? '?').'.'.$section->section_key.'.'.$path,
                ];
            }
        }

        return $usages;
    }

    public function isUsed(Media $media): bool
    {
        return $this->findUsages($media) !== [];
    }

    private function settingLabel(SiteSetting $setting): string
    {
        $fieldLabel = config("site-settings.groups.{$setting->group}.fields.{$setting->key}.label");
        $groupLabel = config("site-settings.groups.{$setting->group}.label");

        if (! $fieldLabel) {
            return $setting->group.'.'.$setting->key;
        }

        return $groupLabel ? $groupLabel.' — '.$fieldLabel : $fieldLabel;
    }

    /**
     * Recursively scan a content array for `media_id` / `*_media_id` keys
     * whose value matches the given media ID. Returns dot-notation paths.
     *
     * @param array<array-key, mixed> $content
     * @return array<int, string>
     */
    private function scanContentForMediaId(array $content, int $mediaId, string $prefix = ''): array
    {
        $matches = [];

        foreach ($content as $key => $value) {
            $path = $prefix === '' ? (string) $key : $prefix.'.'.$key;

            if (is_array($value)) {
                array_push($matches, ...$this->scanContentForMediaId($value, $mediaId, $path));

                continue;
            }

            $isMediaReferenceKey = is_string($key) && ($key === 'media_id' || str_ends_with($key, '_media_id'));

            if ($isMediaReferenceKey && $value !== null && (string) $value === (string) $mediaId) {
                $matches[] = $path;
            }
        }

        return $matches;
    }
}
