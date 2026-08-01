<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\ReplaceMediaRequest;
use App\Http\Requests\Admin\Media\StoreMediaRequest;
use App\Http\Requests\Admin\Media\UpdateMediaRequest;
use App\Models\Media;
use App\Services\MediaService;
use App\Services\MediaUsageService;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(
        private readonly MediaService $mediaService,
        private readonly MediaUsageService $mediaUsageService,
    ) {
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $media = Media::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('original_name', 'like', "%{$search}%")
                        ->orWhere('file_name', 'like', "%{$search}%")
                        ->orWhere('alt_text', 'like', "%{$search}%")
                        ->orWhere('caption', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(24)
            ->withQueryString();

        $usedMediaIds = $this->usedMediaIds($media->getCollection());

        return view('admin.media.index', [
            'media' => $media,
            'search' => $search,
            'usedMediaIds' => $usedMediaIds,
        ]);
    }

    public function create(): View
    {
        return view('admin.media.create');
    }

    public function store(StoreMediaRequest $request): RedirectResponse
    {
        $this->mediaService->store(
            $request->file('file'),
            $request->only(['alt_text', 'caption']),
            $request->user(),
        );

        return redirect()->route('admin.media.index')
            ->with('success', 'Media berhasil diunggah.');
    }

    public function edit(Media $media): View
    {
        return view('admin.media.edit', [
            'media' => $media,
            'usages' => $this->mediaUsageService->findUsages($media),
            'fileExists' => $this->mediaService->exists($media),
        ]);
    }

    public function update(UpdateMediaRequest $request, Media $media): RedirectResponse
    {
        $this->mediaService->updateMetadata($media, $request->only(['alt_text', 'caption']));

        return redirect()->route('admin.media.edit', $media)
            ->with('success', 'Metadata media berhasil diperbarui.');
    }

    public function replace(ReplaceMediaRequest $request, Media $media, SettingsService $settingsService): RedirectResponse
    {
        $this->mediaService->replace($media, $request->file('file'));

        // File media ini mungkin dipakai sebagai logo/favicon — bersihkan
        // cache settings agar tampilan publik langsung memakai file baru.
        $settingsService->forgetCache();

        return redirect()->route('admin.media.edit', $media)
            ->with('success', 'File media berhasil diganti.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        if ($this->mediaUsageService->isUsed($media)) {
            return redirect()->route('admin.media.edit', $media)
                ->with('error', 'Media tidak dapat dihapus karena masih digunakan pada bagian website.');
        }

        $this->mediaService->delete($media);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media berhasil dihapus.');
    }

    /**
     * @param iterable<int, Media> $mediaItems
     * @return array<int, int>
     */
    private function usedMediaIds(iterable $mediaItems): array
    {
        $ids = [];

        foreach ($mediaItems as $item) {
            if ($this->mediaUsageService->isUsed($item)) {
                $ids[] = $item->id;
            }
        }

        return $ids;
    }
}
