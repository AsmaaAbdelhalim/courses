<?php

namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
class FileService
{
    public function uploadFile(UploadedFile $file, string $path): string
    {
        $fileName = $this->generateFileName($file);
        $file->storeAs($path, $fileName, 'public');
        return $fileName;
    }

    public function deleteFile(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    private function generateFileName(UploadedFile $file): string
    {
        return time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    }

    public function validateFile(UploadedFile $file, array $allowedTypes, int $maxSize): bool
    {
        return $file->getSize() <= $maxSize && 
               in_array($file->getClientOriginalExtension(), $allowedTypes);
    }
}