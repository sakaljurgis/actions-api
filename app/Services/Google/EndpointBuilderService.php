<?php

namespace App\Services\Google;

class EndpointBuilderService
{
    public function buildPredictionEndpoint(string $model): string
    {
        return $this->buildEndpoint($model, 'predict');
    }

    public function buildGenerationEndpoint(string $model): string
    {
        return $this->buildEndpoint($model, 'generateContent');
    }

    private function buildEndpoint(string $model, string $action): string
    {
        $projectId = env('GOOGLE_CLOUD_PROJECT');
        $location = env('GOOGLE_LOCATION');
        $modelPath = 'projects/' . $projectId .
            '/locations/' . $location .
            '/publishers/google/models/' . $model .
            ':' . $action;

        return 'https://' . $location . '-aiplatform.googleapis.com/v1/' . $modelPath;
    }
}
