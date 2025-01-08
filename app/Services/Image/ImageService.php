<?php

namespace App\Services\Image;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * @param string $base64ImageData
     * @param string $mimeType
     * @return array ['url', 'id']
     */
    public function saveImage(string $base64ImageData, string $mimeType): array
    {
        $imageId = uniqid();
        $imageData = base64_decode($base64ImageData);
        $ext = explode('/', $mimeType)[1];

        Storage::put('public/images/' . $imageId . '.' . $ext , $imageData);
        $relativePath = Storage::url('public/images/' . $imageId . '.png');

        return [
            'url' => asset($relativePath),
            'id' => $imageId,
            // todo - size, width, height, thumb, etc
        ];
    }
}
