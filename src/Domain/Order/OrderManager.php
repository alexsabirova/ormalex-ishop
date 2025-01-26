<?php

declare(strict_types=1);

namespace Domain\Order;


use Domain\Order\Models\Order;
use Domain\Order\Models\OrderItem;
use Illuminate\Support\Collection;
use Support\ValueObjects\Price;

class OrderManager
{
    public function get(): \Illuminate\Database\Eloquent\Collection
    {
        return Order::query()
            ->select(['id', 'user_id', 'delivery_type_id', 'status', 'payment_method_id', 'amount', 'created_at'])
            ->where('user_id', auth()->id())
            ->with('orderItems')
            ->get();

    }

    public function lists(): Collection
    {
        if (!$this->get()) {
            return collect([]);
        }

        return Order::query()
            ->when('user_id', auth()->id())
            ->get();
    }

    public function items(): Collection
    {
        if (!$this->get()) {
            return collect([]);
        }

        return OrderItem::query()
            ->with(['product', 'optionValues.option'])
            ->whereBelongsTo($this->get())
            ->get();
    }

    public function amount()
    {
        return Price::make(
            $this->orderItems()->sum(function ($item) {
                return $item->amount->raw();
            })
        );
    }

    public function orderItems(): Collection
    {
        if (!$this->get()) {
            return collect([]);
        }
        return $this->get()->orderItems;
    }
}
