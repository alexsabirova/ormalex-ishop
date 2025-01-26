<?php

declare(strict_types=1);

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;
use Domain\Order\Events\OrderStatusChanged;
use Domain\Order\Models\Order;
use InvalidArgumentException;

class PendingOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'pending';
    }

    public function humanValue(): string
    {
        return 'В обработке';
    }
}
