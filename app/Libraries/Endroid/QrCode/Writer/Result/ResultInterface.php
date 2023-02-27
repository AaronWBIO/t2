<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Writer\Result;

interface ResultInterface
{
    public function getString(): string;

    public function getDataUri(): string;

    public function saveToFile(string $path): void;

    public function getMimeType(): string;
}
