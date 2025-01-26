@extends('layouts.app')

@section('title', 'Корзина')

@section('content')

    <!-- Breadcrumbs -->
    <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6 mt-10">
        <li><a href="{{ route('home') }}" class="text-gray hover:text-pink text-xs">Главная</a></li>
        <li><span class="text-teal-700 text-xs">Корзина</span></li>
    </ul>

    <section>
        <!-- Section heading -->
        <h1 class="my-10 text-md lg:text-[36px] font-medium text-dark">Корзина</h1>

        @if($items->isEmpty())
            <div class="mt-20 py-10 px-6 rounded-lg bg-rose-300/50 text-gray font-bold">
                Ваша корзина пуста
            </div>
            <div class="pt-5 flex flex-col sm:flex-row lg:justify-end gap-4">
                <a href="{{ route('catalog') }}" class="btn btn-teal">За покупками</a>
            </div>
        @else
            <div class="lg:hidden py-3 px-6 rounded-lg bg-yellow-100 text-dark">Таблицу можно пролистать вправо →</div>

        <!-- Adaptive table -->
        <div class="overflow-auto">
            <table class="min-w-full border-spacing-y-4 text-gray text-sm text-left" style="border-collapse: separate">
                <thead class="text-xxs text-neutral-600 uppercase">
                <th scope="col" class="py-3 px-6">Товар</th>
                <th scope="col" class="py-3 px-6">Цена</th>
                <th scope="col" class="py-3 px-6">Кол-во</th>
                <th scope="col" class="py-3 px-6">Сумма</th>
                <th scope="col" class="py-3 px-6"></th>
                </thead>
                <tbody>
                @foreach($items as $item)
                <tr>
                    <td class="py-4 px-4 md:px-6 rounded-l-2xl bg-neutral-200">
                        <div class="flex flex-col lg:flex-row min-w-[200px] gap-2 lg:gap-6 pt-6">
                            <div class="shrink-0 overflow-hidden w-[64px] lg:w-[84px] h-[64px] lg:h-[84px] rounded-2xl shadow-md">
                                <img src="{{ $item->product->makeThumbnail('345x320') }}" class="object-cover w-full h-full" alt="{{ $item->product->title }}">
                            </div>

                            <div class="py-3">
                                <h4 class="text-xs sm:text-sm xl:text-md font-bold">
                                    <a href="{{ route('product', $item->product) }}" class="inline-block text-gray hover:text-teal-700">
                                        {{ $item->product->title }}
                                    </a>
                                </h4>
                                @if($item->optionValues->isNotEmpty())
                                <ul class="space-y-1 mt-2 text-xs">
                                    @foreach($item->optionValues as $value)
                                    <li class="text-gray">
                                        {{ $value->option->title }}: {{ $value->title }}
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 md:px-6 bg-neutral-200">
                        <div class="font-medium whitespace-nowrap text-gray">
                            {{ $item->price }}
                        </div>
                    </td>

                    <td class="py-4 px-4 md:px-6 bg-neutral-200">
                        <div class="flex items-stretch h-[56px] gap-2">
                            <form action="{{ route('cart.quantity', $item) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <input name="quantity" type="number" class="h-full px-1 md:px-2 rounded-lg border border-gray/30 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/30 text-gray text-xs text-center font-bold shadow-transparent outline-0 transition" min="1" max="999" value="{{ $item->quantity }}" placeholder="К-во">

                            </form>
                        </div>
                    </td>

                    <td class="py-4 px-4 md:px-6 bg-neutral-200">
                        <div class="font-medium whitespace-nowrap text-dark">{{ $item->amount }}</div>
                    </td>

                    <td class="py-4 px-4 md:px-6 rounded-r-2xl bg-neutral-200">
                        <form action="{{ route('cart.delete', $item) }}" method="POST">
                            @csrf
                            @method('delete')

                            <button type="submit" class="w-12 !h-12 !px-0 btn btn-teal" title="Удалить из корзины">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 52 52">
                                    <path d="M49.327 7.857H2.673a2.592 2.592 0 0 0 0 5.184h5.184v31.102a7.778 7.778 0 0 0 7.776 7.776h20.735a7.778 7.778 0 0 0 7.775-7.776V13.041h5.184a2.592 2.592 0 0 0 0-5.184Zm-25.919 28.51a2.592 2.592 0 0 1-5.184 0V23.409a2.592 2.592 0 1 1 5.184 0v12.96Zm10.368 0a2.592 2.592 0 0 1-5.184 0V23.409a2.592 2.592 0 1 1 5.184 0v12.96ZM20.817 5.265h10.367a2.592 2.592 0 0 0 0-5.184H20.817a2.592 2.592 0 1 0 0 5.184Z"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mt-8">
            <div class="text-[32px] text-dark font-black">Итого: {{ cart()->amount() }}</div>

            <div class="pb-3 lg:pb-0">
                <form action="{{ route('cart.truncate') }}" method="POST">
                    @csrf
                    @method('delete')

                    <button type="submit" class="text-pink hover:text-pink/50 font-bold">
                        Очистить корзину
                    </button>
                </form>
            </div>

            <div class="flex flex-col sm:flex-row lg:justify-end gap-4">
                <a href="{{ route('catalog') }}" class="btn btn-outline">Назад за покупками</a>
                <a href="{{ route('order') }}" class="btn btn-teal">Оформить заказ</a>
            </div>
        </div>
        @endif
    </section>

@endsection

