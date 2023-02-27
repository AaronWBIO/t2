<?php

declare(strict_types=1);

namespace App\Libraries\Endroid\QrCode\Bacon;

use App\Libraries\BaconQrCode\Common\ErrorCorrectionLevel;
use App\Libraries\Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use App\Libraries\Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface;
use App\Libraries\Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use App\Libraries\Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium;
use App\Libraries\Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelQuartile;

final class ErrorCorrectionLevelConverter
{
    public static function convertToBaconErrorCorrectionLevel(ErrorCorrectionLevelInterface $errorCorrectionLevel): ErrorCorrectionLevel
    {
        if ($errorCorrectionLevel instanceof ErrorCorrectionLevelLow) {
            return ErrorCorrectionLevel::valueOf('L');
        } elseif ($errorCorrectionLevel instanceof ErrorCorrectionLevelMedium) {
            return ErrorCorrectionLevel::valueOf('M');
        } elseif ($errorCorrectionLevel instanceof ErrorCorrectionLevelQuartile) {
            return ErrorCorrectionLevel::valueOf('Q');
        } elseif ($errorCorrectionLevel instanceof ErrorCorrectionLevelHigh) {
            return ErrorCorrectionLevel::valueOf('H');
        }

        throw new \Exception('Error correction level could not be converted');
    }
}
