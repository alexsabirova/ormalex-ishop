<?php

namespace App\Http\Controllers;


use App\Http\Requests\OrderFormRequest;
use Domain\Order\Actions\NewOrderAction;
use Domain\Order\DTOs\CustomerDTO;
use Domain\Order\DTOs\OrderDTO;
use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\Order;
use Domain\Order\Models\OrderItem;
use Domain\Order\Models\PaymentMethod;
use Domain\Order\Processes\AssignCustomer;
use Domain\Order\Processes\AssignProducts;
use Domain\Order\Processes\CheckProductQuantities;
use Domain\Order\Processes\ClearCart;
use Domain\Order\Processes\DecreaseProductQuantities;
use Domain\Order\Processes\OrderProcess;
use DomainException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function index(): View|Factory|Application
    {
        $items = cart()->items();

        if($items->isEmpty()) {
            throw new DomainException('Корзина пуста');
        }

        return view('order.index', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get(),
        ]);
    }

    public function handle(OrderFormRequest $request, NewOrderAction $action): RedirectResponse
    {
        $order = $action(
            OrderDTO::make(...$request->only(['payment_method_id', 'delivery_type_id', 'password', 'amount'])),
            CustomerDTO::fromArray($request->get('customer')),
            $request->boolean('create_account')
        );

        (new OrderProcess($order))->processes([
            new CheckProductQuantities(),
            new AssignCustomer(CustomerDTO::fromArray($request->get('customer'))),
            new AssignProducts(),
            //new ChangeStateToPending(),
            new DecreaseProductQuantities(),
            new ClearCart()
        ])->run();

        return redirect()
            ->route('home');
    }

    public function list(): View|Factory|Application
    {
        return view('order.orders-list', [
                'orders' => order()->get(),
            ]);
    }

    public function show(Order $order): View|Factory|Application
    {
        $items = OrderItem::query()
            ->select(['id','product_id', 'order_id', 'price', 'quantity'])
            ->where('order_id', $order->id)
            ->with(['product', 'order'])
            ->get();

        return view('order.order-item', [
            'order' => $order,
            'items' => $items,
            ]);
    }

    public function get()
    {
            return Order::query()
                ->with('orderItems')
                ->first() ?? false;
    }
}
