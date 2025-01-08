<?php

namespace App\Services\Google;

/**
 * "aspectRatio": "1:1, 9:16, 16:9, 3:4, or 4:3. default 1:1",
 */
enum ImageAspectRatios: string
{
    case _1_1 = '1:1';
    case _9_16 = '9:16';
    case _16_9 = '16:9';
    case _3_4 = '3:4';
    case _4_3 = '4:3';
}
