<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\DTOs\CustomerDTO;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;

class AssignCustomer implements OrderProcessContract
{
    public function __construct(protected CustomerDTO $customer) {
    }

    public function handle(Order $order, $next)
    {
        $order->orderCustomer()
            ->create($this->customer->toArray());
        return $next($order);
    }
}
