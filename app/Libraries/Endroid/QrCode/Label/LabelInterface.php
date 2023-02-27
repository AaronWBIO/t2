<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Label;

use App\Libraries\Endroid\QrCode\Color\ColorInterface;
use App\Libraries\Endroid\QrCode\Label\Alignment\LabelAlignmentInterface;
use App\Libraries\Endroid\QrCode\Label\Font\FontInterface;
use App\Libraries\Endroid\QrCode\Label\Margin\MarginInterface;

interface LabelInterface
{
    public function getText(): string;

    public function getFont(): FontInterface;

    public function getAlignment(): LabelAlignmentInterface;

    public function getMargin(): MarginInterface;

    public function getTextColor(): ColorInterface;
}
