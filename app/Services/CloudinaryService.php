<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    /**
     * Upload file ke Cloudinary jika CLOUDINARY_URL dikonfigurasi.
     * Mengembalikan URL publik dari Cloudinary, atau null jika gagal/tidak dikonfigurasi.
     */
    public static function upload(UploadedFile $file, string $folder = 'events'): ?string
    {
        $cloudinaryUrl = env('CLOUDINARY_URL');

        if (! $cloudinaryUrl) {
            return null;
        }

        try {
            $cloudinary = new Cloudinary($cloudinaryUrl);
            $response = $cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                [
                    'folder' => 'amikomeventhub/' . $folder,
                    'resource_type' => 'image',
                ]
            );

            return $response['secure_url'] ?? null;
        } catch (\Exception $e) {
            logger()->error('Cloudinary Upload Failed: ' . $e->getMessage());
            return null;
        }
    }
}
