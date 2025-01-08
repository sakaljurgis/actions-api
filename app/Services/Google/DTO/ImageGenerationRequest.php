<?php

namespace App\Services\Google\DTO;

class ImageGenerationRequest
{
    public function __construct(
        public readonly string $prompt,
        public readonly ?string $negativePrompt = null,
        public readonly ?int $sampleCount = null,
        public readonly ?string $aspectRatio = null,
        public readonly ?string $safetySetting = null,
    )
    {
    }
}
