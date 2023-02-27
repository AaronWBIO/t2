<?php
declare(strict_types = 1);

namespace App\Libraries\BaconQrCode\Renderer\Color;

interface ColorInterface
{
    /**
     * Converts the color to RGB.
     */
    public function toRgb() : Rgb;

    /**
     * Converts the color to CMYK.
     */
    public function toCmyk() : Cmyk;

    /**
     * Converts the color to gray.
     */
    public function toGray() : Gray;
}
