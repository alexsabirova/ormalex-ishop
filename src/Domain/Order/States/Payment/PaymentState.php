<?php

declare(strict_types=1);

namespace Domain\Order\States\Payment;

use Domain\Order\Enums\OrderStatuses;
use Domain\Order\Events\OrderStatusChanged;
use Domain\Order\Models\Order;
use InvalidArgumentException;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PaymentState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(PendingPaymentState::class)
            ->allowTransition(PendingPaymentState::class, PaidPaymentState::class)
            ->allowTransition(PendingPaymentState::class, CancelledPaymentState::class);
    }
}
