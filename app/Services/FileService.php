<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    /**
     * Upload a file to storage
     */
    public function uploadFile(UploadedFile $file, string $path): string
    {
        try {
            $fileName = $this->generateFileName($file);
            
            // Store the file in the correct storage path
            Storage::disk('public')->putFileAs($path, $file, $fileName);
            
            return $fileName;
        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());
            throw new \RuntimeException('Failed to upload file');
        }
    }

    /**
     * Delete a file from storage
     */
    public function deleteFile(?string $fileName, string $path): bool
    {
        if ($fileName && Storage::disk('public')->exists($path . '/' . $fileName)) {
            return Storage::disk('public')->delete($path . '/' . $fileName);
        }
        return false;
    }

    /**
     * Generate a unique filename
     */
    private function generateFileName(UploadedFile $file): string
    {
        return time() . '_' . Str::random(10) . '.' . 
               strtolower($file->getClientOriginalExtension());
    }

    /**
     * Validate file type and size
     */
    public function validateFile(
        UploadedFile $file, 
        array $allowedTypes = ['jpeg', 'jpg', 'png', 'gif'],
        int $maxSize = 2048
    ): bool {
        return $file->getSize() <= ($maxSize * 1024) && 
               in_array(
                   strtolower($file->getClientOriginalExtension()), 
                   $allowedTypes
               );
    }

    /**
     * Update an existing file
     */
    public function updateFile(?string $oldFileName, UploadedFile $newFile, string $path): string
    {
        $this->deleteFile($oldFileName, $path);
        return $this->uploadFile($newFile, $path);
    }
}