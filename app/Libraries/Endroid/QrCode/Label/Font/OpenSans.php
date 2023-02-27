<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Label\Font;

final class OpenSans implements FontInterface
{
    private $size;

    public function __construct(int $size = 16)
    {
        $this->size = $size;
    }

    public function getPath(): string
    {
        return __DIR__.'/../../../assets/open_sans.ttf';
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
