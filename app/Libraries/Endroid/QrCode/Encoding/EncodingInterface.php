<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Encoding;

interface EncodingInterface
{
    public function __toString(): string;
}
