<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Color;

final class Color implements ColorInterface
{
    private  $red;
    private  $green;
    private  $blue;
    private  $alpha;

    public function __construct( $red,  $green,  $blue,  $alpha = 0)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        $this->alpha = $alpha;
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function getBlue(): int
    {
        return $this->blue;
    }

    public function getAlpha(): int
    {
        return $this->alpha;
    }

    public function getOpacity(): float
    {
        return 1 - $this->alpha / 127;
    }

    public function toArray(): array
    {
        return [
            'red' => $this->red,
            'green' => $this->green,
            'blue' => $this->blue,
            'alpha' => $this->alpha,
        ];
    }
}
