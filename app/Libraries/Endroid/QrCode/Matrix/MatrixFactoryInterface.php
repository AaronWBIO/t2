<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Matrix;

use App\Libraries\Endroid\QrCode\QrCodeInterface;

interface MatrixFactoryInterface
{
    public function create(QrCodeInterface $qrCode): MatrixInterface;
}
