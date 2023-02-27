<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Writer;

use App\Libraries\Endroid\QrCode\Label\LabelInterface;
use App\Libraries\Endroid\QrCode\Logo\LogoInterface;
use App\Libraries\Endroid\QrCode\QrCodeInterface;
use App\Libraries\Endroid\QrCode\Writer\Result\DebugResult;
use App\Libraries\Endroid\QrCode\Writer\Result\ResultInterface;

final class DebugWriter implements WriterInterface, ValidatingWriterInterface
{
    public function write(QrCodeInterface $qrCode, LogoInterface $logo = null, LabelInterface $label = null, array $options = []): ResultInterface
    {
        return new DebugResult($qrCode, $logo, $label, $options);
    }

    public function validateResult(ResultInterface $result, string $expectedData): void
    {
        if (!$result instanceof DebugResult) {
            throw new \Exception('Unable to write logo: instance of DebugResult expected');
        }

        $result->setValidateResult(true);
    }
}
