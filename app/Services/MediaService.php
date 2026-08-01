<?php

namespace App\Services;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class MediaService
{
    /**
     * Store an uploaded file and create its Media record.
     *
     * @param array{alt_text?: ?string, caption?: ?string} $metadata
     */
    public function store(UploadedFile $file, array $metadata, User $user): Media
    {
        $path = $this->putFile($file);
        [$width, $height] = $this->extractImageDimensions($file);

        $media = new Media();
        $media->original_name = $file->getClientOriginalName();
        $media->file_name = basename($path);
        $media->file_path = $path;
        $media->mime_type = $file->getMimeType();
        $media->file_size = $file->getSize();
        $media->width = $width;
        $media->height = $height;
        $media->alt_text = $metadata['alt_text'] ?? null;
        $media->caption = $metadata['caption'] ?? null;
        // uploaded_by diisi lewat properti langsung — bukan dari request.
        $media->uploaded_by = $user->id;
        $media->save();

        return $media;
    }

    /**
     * Replace a media's physical file while keeping its ID and references
     * intact. The new file is stored and the record updated FIRST; the old
     * file is only removed once that succeeds.
     */
    public function replace(Media $media, UploadedFile $file): Media
    {
        $newPath = $this->putFile($file);
        [$width, $height] = $this->extractImageDimensions($file);
        $oldPath = $media->file_path;

        try {
            $media->file_name = basename($newPath);
            $media->file_path = $newPath;
            $media->mime_type = $file->getMimeType();
            $media->file_size = $file->getSize();
            $media->width = $width;
            $media->height = $height;
            $media->save();
        } catch (Throwable $exception) {
            Storage::disk($this->disk())->delete($newPath);

            throw $exception;
        }

        if ($oldPath && $oldPath !== $newPath) {
            Storage::disk($this->disk())->delete($oldPath);
        }

        return $media;
    }

    /**
     * @param array{alt_text?: ?string, caption?: ?string} $metadata
     */
    public function updateMetadata(Media $media, array $metadata): Media
    {
        if (array_key_exists('alt_text', $metadata)) {
            $media->alt_text = $metadata['alt_text'];
        }

        if (array_key_exists('caption', $metadata)) {
            $media->caption = $metadata['caption'];
        }

        $media->save();

        return $media;
    }

    /**
     * Delete a media record and its physical file.
     *
     * Caller is responsible for checking MediaUsageService::isUsed() first —
     * this method does not check usage itself.
     */
    public function delete(Media $media): void
    {
        $path = $media->file_path;
        $media->delete();

        if ($path && Storage::disk($this->disk())->exists($path)) {
            Storage::disk($this->disk())->delete($path);
        }
    }

    public function url(Media $media): ?string
    {
        return $media->url();
    }

    public function exists(Media $media): bool
    {
        return Storage::disk($this->disk())->exists($media->file_path);
    }

    /**
     * @return array{0: ?int, 1: ?int}
     */
    public function extractImageDimensions(UploadedFile|string $file): array
    {
        $path = $file instanceof UploadedFile ? $file->getRealPath() : $file;
        $size = $path ? @getimagesize($path) : false;

        if (! $size) {
            return [null, null];
        }

        return [$size[0], $size[1]];
    }

    private function putFile(UploadedFile $file): string
    {
        $directory = config('media.directory').'/'.now()->format('Y/m');
        // Nama file dari UUID + ekstensi hasil deteksi MIME asli (bukan nama
        // asli user, bukan ekstensi input mentah).
        $filename = (string) Str::uuid().'.'.$file->extension();

        $storedPath = $file->storeAs($directory, $filename, $this->disk());

        if (! $storedPath) {
            throw new RuntimeException('Gagal menyimpan file media.');
        }

        return $storedPath;
    }

    private function disk(): string
    {
        return config('media.disk', 'public');
    }
}
