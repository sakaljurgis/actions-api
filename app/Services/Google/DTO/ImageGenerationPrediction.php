<?php

namespace App\Services\Google\DTO;

class ImageGenerationPrediction
{
    public readonly string $bytesBase64Encoded;
    public readonly string $mimeType;

    public function __construct(string $bytesBase64Encoded, string $mimeType)
    {
        $this->bytesBase64Encoded = $bytesBase64Encoded;
        $this->mimeType = $mimeType;
    }
}
