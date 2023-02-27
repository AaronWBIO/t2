<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Label\Font;

final class Font implements FontInterface
{
    private $path;
    private $size;

    public function __construct($path, $size = 16)
    {
        $this->validatePath($path);

        $this->path = $path;
        $this->size = $size;
    }

    private function validatePath($path): void
    {
        if (!file_exists($path)) {
            throw new \Exception(sprintf('Invalid font path "%s"', $path));
        }
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
