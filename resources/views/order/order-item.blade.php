@extends('layouts.app')

@section('title', 'Заказ')

@section('content')

<main class="py-16 lg:py-20">
    <div class="container">
        <!-- Breadcrumbs -->
        <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
            <li><a href="{{ route('home') }}" class="text-gray hover:text-teal-700 text-xs">Главная</a></li>
            <li><a href="{{ route('orders.list') }}" class="text-gray hover:text-teal-700 text-xs">Мои заказы</a></li>
            <li><span class="text-teal-700 text-xs">Заказ №{{ $order->id }}</span></li>
        </ul>

        <section>
            <!-- Section heading -->
            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-6 mb-8">
                <h1 class="mt-5 text-md lg:text-[36px] font-medium text-dark">Заказ №{{ $order->id }}</h1>

                @if($order->status->value == "new")
                    <div class="px-6 py-3 rounded-lg bg-teal-400 text-xs text-dark">{{ $order->status }}</div>

                @elseif($order->status->value == "pending")
                    <div class="px-6 py-3 rounded-lg bg-yellow-300 text-xs text-dark text-bold">{{ $order->status }}</div>

                @elseif($order->status->value == "cancelled")
                    <div class="px-6 py-3 rounded-lg bg-pink/50 text-xs text-dark text-bold">{{ $order->status }}</div>

                @else
                    <div class="px-6 py-3 rounded-lg bg-gray/40 text-xs text-dark">{{ $order->status }}</div>
                @endif

                <div class="px-6 py-3 rounded-lg bg-gray/70 text-neutral-50">{{ $order->created_at }}</div>
            </div>

            <!-- Message -->
            <div class="md:hidden py-3 px-6 rounded-lg bg-yellow-100 text-gray">Таблицу можно пролистать вправо →</div>

            <!-- Adaptive table -->
            <div class="overflow-auto">
                <table class="min-w-full border-spacing-y-4 text-gray text-sm text-left" style="border-collapse: separate">
                    <thead class="text-xs uppercase">
                    <th scope="col" class="py-3 px-6">Товар</th>
                    <th scope="col" class="py-3 px-6">Цена</th>
                    <th scope="col" class="py-3 px-6">Кол-во</th>
                    <th scope="col" class="py-3 px-6">Сумма</th>
                    </thead>
                    <tbody>

                    @foreach($items as $item)
                    <tr>
                        <td scope="row" class="py-4 px-6 rounded-l-2xl bg-neutral-200">
                            <div class="flex flex-col lg:flex-row min-w-[200px] gap-2 lg:gap-6">
                                <div class="shrink-0 overflow-hidden w-[64px] lg:w-[84px] h-[64px] lg:h-[84px] rounded-2xl">
                                    <img src="{{ $item->product->thumbnail }}" class="object-cover w-full h-full" alt="SteelSeries Aerox 3 Snow">
                                </div>
                                <div class="py-3">
                                    <h4 class="text-xs sm:text-sm xl:text-md font-bold"><a href="{{ route('product', $item->product) }}" class="inline-block text-dark hover:text-pink">{{ $item->product->title }}</a></h4>
                                    <a href="{{ route('product', $item->product) }}" class="text-teal-700">Подробнее →</a>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 bg-neutral-200">
                            <div class="font-medium whitespace-nowrap">{{ $item->product->price }}</div>
                        </td>
                        <td class="py-4 px-6 bg-neutral-200">{{ $item->quantity }}</td>
                        <td class="py-4 px-6 bg-neutral-200 rounded-r-2xl">
                            <div class="font-medium whitespace-nowrap">{{ $item->product->price }}</div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col-reverse md:flex-row md:items-center md:justify-between mt-8 gap-6">
                <div class="flex md:justify-end">
                    <a href="{{ route('orders.list') }}" class="btn btn-pink">←&nbsp; Вернуться назад</a>
                </div>
                <div class="text-[32px] font-black md:text-right">Итого: {{ $item->order->amount }}</div>
            </div>

        </section>

    </div>
</main>
@endsection
