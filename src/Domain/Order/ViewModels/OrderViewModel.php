<?php

declare(strict_types=1);

namespace Domain\Order\ViewModels;

use Domain\Order\Models\Order;
use Domain\Product\Models\Product;
use Illuminate\Support\Collection;
use Support\ViewModels\ViewModel;

final class OrderViewModel extends ViewModel
{
    public function __construct(public Order $order)
    {
    }

    public function items()
    {
        return Order::query()->get();
    }
}
