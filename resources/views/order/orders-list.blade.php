@extends('layouts.app')

@section('title', 'Заказ')

@section('content')
    <main class="py-16 lg:py-20">
        <div class="container">

            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a href="{{ route('home') }}" class="text-gray hover:text-pink text-xs">Главная</a></li>
                <li><span class="text-teal-700 text-xs">История заказов</span></li>
            </ul>

            <section>
                <!-- Section heading -->
                <h1 class="my-10 text-md lg:text-[36px] font-medium text-dark">История заказов</h1>

                @if($orders->isEmpty())
                    <div class="mt-20 py-10 px-6 rounded-lg bg-rose-300/50 text-gray font-bold">
                        Список заказов пуст
                    </div>
                    <div class="pt-5 flex flex-col sm:flex-row lg:justify-end gap-4">
                        <a href="{{ route('catalog') }}" class="btn btn-teal">За покупками</a>
                    </div>
                @else

                <!-- Orders list -->
                <div class="w-full space-y-4 text-white text-sm text-left">

                    <!-- Order item -->

                    @foreach($orders as $order)
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between px-4 md:px-6 rounded-xl md:rounded-2xl bg-neutral-200">
                            <div class="py-4">
                                <div class="flex gap-6">
                                    <div class="grow py-2">
                                        <div class="flex flex-col md:flex-row md:items-center gap-2">
                                            <h4 class="pr-3 text-md font-bold"><a href="#" class="inline-block text-dark hover:text-pink">Заказ № {{ $order->id }}</a></h4>

                                            @if($order->status->value == "new")
                                                <div class="px-3 py-1 rounded-md bg-teal-400 text-xxs text-dark">{{ $order->status }}</div>

                                            @elseif($order->status->value == "pending")
                                                <div class="px-3 py-1 rounded-md bg-yellow-500 text-xxs text-dark">{{ $order->status }}</div>

                                            @elseif($order->status->value == "cancelled")
                                                <div class="px-3 py-1 rounded-md bg-pink/50 text-xxs text-dark">{{ $order->status }}</div>

                                            @else
                                                <div class="px-3 py-1 rounded-md bg-gray/40 text-xxs text-dark">{{ $order->status }}</div>
                                            @endif

                                            <div class="px-3 py-1 rounded-md bg-gray/70 text-xxs">{{ $order->created_at }}</div>
                                        </div>
                                        <div class="mt-3 text-dark text-xs">На сумму: {{ $order->amount }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('order.item', $order) }}" class="!h-14 btn btn-teal">Подробнее</a>
                                    <a href="#" class="w-14 !h-14 !px-0 btn btn-teal" title="Удалить заказ">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 52 52">
                                            <path d="M49.327 7.857H2.673a2.592 2.592 0 0 0 0 5.184h5.184v31.102a7.778 7.778 0 0 0 7.776 7.776h20.735a7.778 7.778 0 0 0 7.775-7.776V13.041h5.184a2.592 2.592 0 0 0 0-5.184Zm-25.919 28.51a2.592 2.592 0 0 1-5.184 0V23.409a2.592 2.592 0 1 1 5.184 0v12.96Zm10.368 0a2.592 2.592 0 0 1-5.184 0V23.409a2.592 2.592 0 1 1 5.184 0v12.96ZM20.817 5.265h10.367a2.592 2.592 0 0 0 0-5.184H20.817a2.592 2.592 0 1 0 0 5.184Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </section>

        </div>
    </main>

@endsection
