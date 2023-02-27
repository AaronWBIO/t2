<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Writer;

use App\Libraries\Endroid\QrCode\Bacon\MatrixFactory;
use App\Libraries\Endroid\QrCode\Label\LabelInterface;
use App\Libraries\Endroid\QrCode\Logo\LogoInterface;
use App\Libraries\Endroid\QrCode\QrCodeInterface;
use App\Libraries\Endroid\QrCode\Writer\Result\BinaryResult;
use App\Libraries\Endroid\QrCode\Writer\Result\ResultInterface;

final class BinaryWriter implements WriterInterface
{
    public function write(QrCodeInterface $qrCode, LogoInterface $logo = null, LabelInterface $label = null, array $options = []): ResultInterface
    {
        $matrixFactory = new MatrixFactory();
        $matrix = $matrixFactory->create($qrCode);

        return new BinaryResult($matrix);
    }
}
