<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Matrix;

use App\Libraries\Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeEnlarge;
use App\Libraries\Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeInterface;
use App\Libraries\Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use App\Libraries\Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeShrink;

final class Matrix implements MatrixInterface
{
    /** @var array<int, array<int, int>> */
    private $blockValues = [];

    private $blockSize;
    private $innerSize;
    private $outerSize;
    private $marginLeft;
    private $marginRight;

    /** @param array<array<int>> $blockValues */
    public function __construct($blockValues, $size, $margin, RoundBlockSizeModeInterface $roundBlockSizeMode)
    {
        $this->blockValues = $blockValues;

        $this->blockSize = $size / $this->getBlockCount();
        $this->innerSize = $size;
        $this->outerSize = $size + 2 * $margin;

        if ($roundBlockSizeMode instanceof RoundBlockSizeModeEnlarge) {
            $this->blockSize = intval(ceil($this->blockSize));
            $this->innerSize = intval($this->blockSize * $this->getBlockCount());
            $this->outerSize = $this->innerSize + 2 * $margin;
        } elseif ($roundBlockSizeMode instanceof RoundBlockSizeModeShrink) {
            $this->blockSize = intval(floor($this->blockSize));
            $this->innerSize = intval($this->blockSize * $this->getBlockCount());
            $this->outerSize = $this->innerSize + 2 * $margin;
        } elseif ($roundBlockSizeMode instanceof RoundBlockSizeModeMargin) {
            $this->blockSize = intval(floor($this->blockSize));
            $this->innerSize = intval($this->blockSize * $this->getBlockCount());
        }

        if ($this->blockSize < 1) {
            throw new \Exception('Too much data: increase image dimensions or lower error correction level');
        }

        $this->marginLeft = intval(($this->outerSize - $this->innerSize) / 2);
        $this->marginRight = $this->outerSize - $this->innerSize - $this->marginLeft;
    }

    public function getBlockValue($rowIndex, $columnIndex): int
    {
        return $this->blockValues[$rowIndex][$columnIndex];
    }

    public function getBlockCount(): int
    {
        return count($this->blockValues[0]);
    }

    public function getBlockSize(): float
    {
        return $this->blockSize;
    }

    public function getInnerSize(): int
    {
        return $this->innerSize;
    }

    public function getOuterSize(): int
    {
        return $this->outerSize;
    }

    public function getMarginLeft(): int
    {
        return $this->marginLeft;
    }

    public function getMarginRight(): int
    {
        return $this->marginRight;
    }
}
