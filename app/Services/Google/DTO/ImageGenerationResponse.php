<?php

namespace App\Services\Google\DTO;

use App\Services\Google\Error\APIError;

class ImageGenerationResponse
{
    /**
     * @var \App\Services\Google\DTO\ImageGenerationPrediction[]
     */
    public readonly array $predictions;
    public readonly ?APIError $error;

    public function __construct(array $rawResponse)
    {
        if (isset($rawResponse['predictions']) && count($rawResponse['predictions']) > 0) {
            $predictions = [];
            foreach ($rawResponse['predictions'] as $prediction) {
                $predictions[] = new ImageGenerationPrediction($prediction['bytesBase64Encoded'], $prediction['mimeType']);
            }
            $this->predictions = $predictions;
            $this->error = null;
        }

        if (isset($rawResponse['error'])) {
            $error = $rawResponse['error'];
            $this->error = new APIError($error['message'], $error['code']);
        }

        if (!isset($this->predictions) && !isset($this->error)) {
            $this->error = new APIError('An unknown error occurred.', 0,);
        }
    }
}
