<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Writer;

use App\Libraries\Endroid\QrCode\Writer\Result\ResultInterface;

interface ValidatingWriterInterface
{
    public function validateResult(ResultInterface $result, string $expectedData): void;
}
