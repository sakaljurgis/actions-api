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

        $imagePath = 'public/images/' . $imageId . '.' . $ext;
        Storage::put($imagePath , $imageData);
        $relativeUrl = Storage::url($imagePath);
        $filesystemPath = Storage::path($imagePath);

        $resolution = [];
        try {
            $image = new \Imagick($filesystemPath);
            $resolution = $image->getImageGeometry();
        } catch (\ImagickException $e) {
            //do nothing
        }
        // resize to thumbnail
//        $image->thumbnailImage(200, 200);
//        $thumbPath = 'public/images/' . $imageId . '-thumb.' . $ext;
//        Storage::put($thumbPath , $image->getImageBlob());

        return [
            'url' => asset($relativeUrl),
            'id' => $imageId,
            ...$resolution,
            // todo - size, width, height, thumb, etc
        ];
    }
}
