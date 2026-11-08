<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileService
{
    /**
     * Default disk.
     */
    protected string $disk = 'public';

    /**
     * Upload file.
     */
    public function upload(UploadedFile $file, string $directory = 'uploads'): string 
    {
        $filename = $this->generateFilename($file);

        return $file->storeAs($directory, $filename, $this->disk);
    }

    /**
     * Replace existing file.
     */
    public function replace(?string $oldPath, UploadedFile $file, string $directory = 'uploads'): string 
    {
        $this->delete($oldPath);

        return $this->upload(file: $file, directory: $directory);
    }

    /**
     * Delete file.
     */
    public function delete(?string $path): bool
    {
        if (empty($path) || ! Storage::disk($this->disk)->exists($path)) {
            return false;
        }

        return Storage::disk($this->disk)->delete($path);
    }

    /**
     * Check file exists.
     */
    public function exists(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        return Storage::disk($this->disk)->exists($path);
    }

    /**
     * Get public url.
     */
    public function url(?string $path): ?string
    {
        if (! $this->exists($path)) {
            return null;
        }

        return Storage::disk($this->disk)->url($path);
    }

    /**
     * File name only.
     */
    public function filename(string $path): string
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }

    /**
     * Extension.
     */
    public function extension(string $path): string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * File size.
     */
    public function size(string $path): ?int
    {
        if (! $this->exists($path)) {
            return null;
        }

        return Storage::disk($this->disk)->size($path);
    }

    /**
     * Mime type.
     */
    public function mimeType(string $path): ?string
    {
        if (! $this->exists($path)) {
            return null;
        }

        return Storage::disk($this->disk)->mimeType($path);
    }

    /**
     * Generate unique filename.
     */
    protected function generateFilename(UploadedFile $file): string 
    {
        return now()->format('YmdHis') .'_' .Str::random(12) .'.' .$file->getClientOriginalExtension();
    }
}