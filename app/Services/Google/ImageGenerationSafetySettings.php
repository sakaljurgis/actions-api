<?php

namespace App\Services\Google;

/**
 * "safetySetting": "block_none, block_only_high, block_medium_and_above, block_low_and_above. default block_medium_and_above"
 */
enum ImageGenerationSafetySettings: string
{
    case BLOCK_NONE = 'block_none';
    case BLOCK_ONLY_HIGH = 'block_only_high';
    case BLOCK_MEDIUM_AND_ABOVE = 'block_medium_and_above';
    case BLOCK_LOW_AND_ABOVE = 'block_low_and_above';
}
