<?php

declare(strict_types=1);

namespace Domain\Order\Exceptions;

use Exception;

class PaymentProviderException extends Exception
{
    public static function providerRequired(): self
    {
        return new self('Provider is required');
    }
}
