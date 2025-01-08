<?php

namespace App\Services\Google;

use App\Services\Google\DTO\ImageGenerationRequest;
use App\Services\Google\DTO\ImageGenerationResponse;

/**
 * ref: https://cloud.google.com/vertex-ai/generative-ai/docs/model-reference/imagen-api
 */
class ImageGenerationService
{
    private readonly string $imagenModel;

    public function __construct(
        private readonly ApiAuthService $apiAuthService,
        private readonly EndpointBuilderService $endpointBuilderService,
    )
    {
        $this->imagenModel = env('GOOGLE_IMAGEN_MODEL');
    }

    /**
     * @throws \Exception
     */
    public function generateImage(ImageGenerationRequest $request): ImageGenerationResponse
    {
        $requestBody = $this->buildRequestBody($request);

        return $this->sendGenerationRequest($requestBody);
    }

    private function buildRequestBody(ImageGenerationRequest $request): string {
        $instance = [
            'prompt' => $request->prompt,
        ];
        if ($request->negativePrompt) {
            $instance['negativePrompt'] = $request->negativePrompt;
        }

        $parameters = [
            'sampleCount' => 1,
        ];

        if ($request->sampleCount) {
            $parameters['sampleCount'] = $request->sampleCount;
        }
        if ($request->aspectRatio) {
            $parameters['aspectRatio'] = $request->aspectRatio;
        }
        if ($request->safetySetting) {
            $parameters['safetySetting'] = $request->safetySetting;
        }

        $requestBody = [
            'instances' => [$instance],
            'parameters' => $parameters
        ];

        return json_encode($requestBody);
    }

    /**
     * @throws \Google\Exception
     * @throws \Exception
     */
    private function sendGenerationRequest(string $requestBody): ImageGenerationResponse
    {
        $endpoint = $this->endpointBuilderService->buildPredictionEndpoint($this->imagenModel);
        $accessToken = $this->apiAuthService->getAccessToken();

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch) || $response === false) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);

        $responseArray = json_decode($response, true);

        return new ImageGenerationResponse($responseArray);
    }
}
