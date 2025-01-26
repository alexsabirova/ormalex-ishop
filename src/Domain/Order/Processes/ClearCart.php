<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;
use Domain\Order\States\PendingOrderState;

class ClearCart implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        cart()->truncate();

        return $next($order);
    }
}
