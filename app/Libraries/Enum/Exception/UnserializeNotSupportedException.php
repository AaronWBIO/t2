<?php
declare(strict_types = 1);

namespace App\Libraries\Enum\Exception;

use Exception;

final class UnserializeNotSupportedException extends Exception implements ExceptionInterface
{
}
