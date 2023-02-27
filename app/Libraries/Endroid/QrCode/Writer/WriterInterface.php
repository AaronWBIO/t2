<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Writer;

use App\Libraries\Endroid\QrCode\Label\LabelInterface;
use App\Libraries\Endroid\QrCode\Logo\LogoInterface;
use App\Libraries\Endroid\QrCode\QrCodeInterface;
use App\Libraries\Endroid\QrCode\Writer\Result\ResultInterface;

interface WriterInterface
{
    /** @param array<mixed> $options */
    public function write(QrCodeInterface $qrCode, LogoInterface $logo = null, LabelInterface $label = null, array $options = []): ResultInterface;
}
