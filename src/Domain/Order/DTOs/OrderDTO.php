<?php

declare(strict_types=1);

namespace Domain\Order\DTOs;

use Support\Traits\Makeable;

final class OrderDTO
{
    use Makeable;

    public function __construct(
        public readonly string $payment_method_id,
        public readonly string $delivery_type_id,
        //public readonly ?string $password,
        public readonly string $amount,
        //public readonly int $user_id,
    )
    {
    }

}
