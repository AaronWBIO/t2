<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Logo;

final class Logo implements LogoInterface
{
    private $path;
    private $resizeToWidth;
    private $resizeToHeight;
    private  $punchoutBackground;

    public function __construct($path, $resizeToWidth = null, $resizeToHeight = null,  $punchoutBackground = false)
    {
        $this->path = $path;
        $this->resizeToWidth = $resizeToWidth;
        $this->resizeToHeight = $resizeToHeight;
        $this->punchoutBackground = $punchoutBackground;
    }

    public static function create($path): self
    {
        return new self($path);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getResizeToWidth(): ?int
    {
        return $this->resizeToWidth;
    }

    public function setResizeToWidth($resizeToWidth): self
    {
        $this->resizeToWidth = $resizeToWidth;

        return $this;
    }

    public function getResizeToHeight(): ?int
    {
        return $this->resizeToHeight;
    }

    public function setResizeToHeight($resizeToHeight): self
    {
        $this->resizeToHeight = $resizeToHeight;

        return $this;
    }

    public function getPunchoutBackground(): bool
    {
        return $this->punchoutBackground;
    }

    public function setPunchoutBackground( $punchoutBackground): self
    {
        $this->punchoutBackground = $punchoutBackground;

        return $this;
    }
}
