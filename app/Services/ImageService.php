<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ImageService
{
    /**
     * Upload an image and return the path
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string
     */
    public function uploadImage(UploadedFile $file, string $directory = 'uploads'): string
    {
        try {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($directory), $filename);
            return $directory . '/' . $filename;
        } catch (\Exception $e) {
            Log::error('Failed to upload image: ' . $e->getMessage());
            return 'product-placeholder.jpg';
        }
    }
}