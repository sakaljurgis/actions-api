<?php

namespace App\Http\Controllers;

use App\Services\Google\DTO\ImageGenerationRequest;
use App\Services\Google\DTO\ImageGenerationResponse;
use App\Services\Google\Error\APIError;
use App\Services\Google\ImageAspectRatios;
use App\Services\Google\ImageGenerationService;
use App\Services\Image\ImageService;
use Exception;
use Google\Exception as GoogleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GoogleImageGenerationController
{
    public function __construct(
        private readonly ImageService $imageService,
        private readonly ImageGenerationService $imageGenerationService,
    ) {
    }

    public function generateImage(Request $request): JsonResponse|string
    {
        try {
            $imageGenerationRequest = $this->buildImageGenerationRequest($request);
            $imageGenerationResponse = $this->imageGenerationService->generateImage($imageGenerationRequest);

            return new JsonResponse(
                ['generations' => $this->handleGenerationResponse($imageGenerationResponse)]
            );
        } catch (GoogleException|Exception|APIError $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function buildImageGenerationRequest(Request $request): ImageGenerationRequest
    {
        // add nulls for optional fields
        $request->merge([
            'aspect_ratio' => $request->input('aspect_ratio'),
            'negative_prompt' => $request->input('negative_prompt'),
            'sample_count' => $request->input('sample_count'),
        ]);

        $values = $request->validate([
            'prompt' => 'required|string',
            'aspect_ratio' => [Rule::enum(ImageAspectRatios::class), 'nullable'],
            'negative_prompt' => 'string|nullable',
            'sample_count' => 'integer|nullable',
        ]);


        return new ImageGenerationRequest(
            $values['prompt'],
            $values['negative_prompt'],
            $values['sample_count'],
            $values['aspect_ratio'],
        );
    }

    /**
     * @throws Exception
     */
    private function handleGenerationResponse(ImageGenerationResponse $generationResponseData): array
    {
        if (isset($generationResponseData->error)) {
            throw $generationResponseData->error;
        }

        $generations = [];

        foreach ($generationResponseData->predictions as $prediction) {
            $savedImage = $this->imageService->saveImage($prediction->bytesBase64Encoded, $prediction->mimeType);
            $generations[] = $savedImage;
        }
        return $generations;
    }
}
