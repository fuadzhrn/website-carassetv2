<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingsRequest;
use App\Models\Media;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function __construct(private readonly SettingsService $settingsService)
    {
    }

    public function index(): View
    {
        $groups = config('site-settings.groups');
        $values = $this->settingsService->all();

        $mediaFieldValues = [];
        foreach ($groups as $groupKey => $groupData) {
            foreach ($groupData['fields'] as $fieldKey => $fieldData) {
                if ($fieldData['type'] !== 'media') {
                    continue;
                }

                $mediaFieldValues["{$groupKey}.{$fieldKey}"] = $this->settingsService->getMedia("{$groupKey}.{$fieldKey}");
            }
        }

        return view('admin.settings.index', [
            'groups' => $groups,
            'values' => $values,
            'mediaFieldValues' => $mediaFieldValues,
            'recentMedia' => Media::latest()->limit(24)->get(),
        ]);
    }

    public function update(UpdateSiteSettingsRequest $request): RedirectResponse
    {
        $flat = [];

        foreach ($request->validated('settings', []) as $groupKey => $fields) {
            foreach ($fields as $fieldKey => $value) {
                $flat["{$groupKey}.{$fieldKey}"] = $value;
            }
        }

        $this->settingsService->setMany($flat, $request->user());

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
