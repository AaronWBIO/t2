<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Label;

use App\Libraries\Endroid\QrCode\Color\Color;
use App\Libraries\Endroid\QrCode\Color\ColorInterface;
use App\Libraries\Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use App\Libraries\Endroid\QrCode\Label\Alignment\LabelAlignmentInterface;
use App\Libraries\Endroid\QrCode\Label\Font\Font;
use App\Libraries\Endroid\QrCode\Label\Font\FontInterface;
use App\Libraries\Endroid\QrCode\Label\Margin\Margin;
use App\Libraries\Endroid\QrCode\Label\Margin\MarginInterface;

final class Label implements LabelInterface
{
    private $text;
    private  $font;
    private  $alignment;
    private $margin;
    private $textColor;

    public function __construct(
        $text,
         $font = null,
         $alignment = null,
        $margin = null,
        $textColor = null
    ) {
        $this->text = $text;
        $this->font = isset($font) ? $font : new Font(__DIR__.'/../../assets/noto_sans.otf', 16);
        $this->alignment = isset($alignment) ? $alignment : new LabelAlignmentCenter();
        $this->margin = isset($margin) ? $margin : new Margin(0, 10, 10, 10);
        $this->textColor = isset($textColor) ? $textColor : new Color(0, 0, 0);
    }

    public static function create($text): self
    {
        return new self($text);
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText($text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getFont(): FontInterface
    {
        return $this->font;
    }

    public function setFont( $font): self
    {
        $this->font = $font;

        return $this;
    }

    public function getAlignment(): LabelAlignmentInterface
    {
        return $this->alignment;
    }

    public function setAlignment( $alignment): self
    {
        $this->alignment = $alignment;

        return $this;
    }

    public function getMargin(): MarginInterface
    {
        return $this->margin;
    }

    public function setMargin($margin): self
    {
        $this->margin = $margin;

        return $this;
    }

    public function getTextColor(): ColorInterface
    {
        return $this->textColor;
    }

    public function setTextColor($textColor): self
    {
        $this->textColor = $textColor;

        return $this;
    }
}
