@extends('layouts.app')

@section('title', 'Избранное')

@section('content')

    <!-- Breadcrumbs -->
    <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6 mt-10">
        <li><a href="{{ route('home') }}" class="text-gray hover:text-pink text-xs">Главная</a></li>
        <li><span class="text-teal-700 text-xs">Избранное</span></li>
    </ul>

    <section class="mt-16 lg:mt-24">
        <!-- Section heading -->
        <h2 class="text-lg lg:text-[42px] font-black">Избранное</h2>

        @if($items->isEmpty())
            <div class="mt-20 py-10 px-6 rounded-lg bg-rose-300/50 text-gray font-bold">
                Список избранного пуст
            </div>
            <div class="pt-5 flex flex-col sm:flex-row lg:justify-end gap-4">
                <a href="{{ route('catalog') }}" class="btn btn-teal">За покупками</a>
            </div>
        @else

            <div class="flex flex-col lg:flex-row gap-12 lg:gap-6 2xl:gap-8 mt-8">
                <div class="basis-auto xl:basis-3/4">
                    <div
                        class="products grid @if(is_catalog_view('list')) grid-cols-1 gap-y-8 @else grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-x-6 2xl:gap-x-8 gap-y-8 lg:gap-y-10 2xl:gap-y-12 @endif">

                        <!-- Products list -->
                        @foreach($items as $item)
                            <div class="product-card flex flex-col rounded-3xl shadow-lg bg-neutral-100">
                                <a href="{{ route('product', $item->product) }}"
                                   class="product-card-photo overflow-hidden h-[320px] rounded-3xl">
                                    <img
                                        src="{{ $item->product->makeThumbnail('345x320') }}"
                                        class="object-cover w-full h-full"
                                        alt="{{ $item->product->title }}">
                                </a>
                                <div class="grow flex flex-col py-6 px-6">
                                    <span class="text-xxs font-semibold text text-teal-600">&#8226; В наличии</span>
                                    <h3 class="text-sm lg:text-md font-black">
                                        <a href="#" class="inline-block text-gray hover:text-pink">
                                            {{ $item->product->title }}
                                        </a></h3>
                                        <span class="text-xxs font-bold text text-cyan-800">{{ $item->product->preview }}</span>
                                        <div class="mt-auto pt-6">
                                            <div class="flex items-start">
                                                <div class="mb-2 text-sm font-semibold">
                                                    {{ $item->product->price }}
                                                </div>
                                                <div class="mx-3 font-extralight text-pink/70 text-xs line-through">
                                                    {{ $item->product->price->old()}}
                                                </div>
                                                <div class="text-xs font-thin border rounded-xl bg-pink/90 text-neutral-50 mb-3 px-2">
                                                    -{{ $item->product->price->discount() }} %
                                                </div>
                                            </div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <form action="" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                        value="wishlist_submit"
                                                        formaction="{{ route('wishlist.delete', $item) }}"
                                                        class="w-[42px] !h-[42px] !px-0 btn btn-teal"
                                                        title="Удалить из избранного">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                         fill="currentColor" viewBox="0 0 52 52">
                                                        <path
                                                            d="M26 48.486c-.263 0-.526-.067-.762-.203-.255-.148-6.336-3.679-12.504-8.998-3.656-3.153-6.574-6.28-8.673-9.295C1.344 26.09-.022 22.338 0 18.84c.025-4.072 1.483-7.901 4.106-10.782 2.667-2.93 6.226-4.544 10.021-4.544 4.865 0 9.312 2.725 11.872 7.042 2.56-4.317 7.007-7.042 11.872-7.042 3.586 0 7.007 1.456 9.634 4.1 2.883 2.9 4.52 7 4.494 11.245-.022 3.493-1.414 7.24-4.137 11.135-2.105 3.012-5.02 6.138-8.66 9.29-6.146 5.32-12.183 8.85-12.437 8.997a1.524 1.524 0 0 1-.766.206Z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <a href="{{ route('product', $item->product) }}" class="w-[142px] !h-[42px] !px-0 btn btn-teal" title="Перейти к товару">
                                                <span> Подробнее</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Page pagination -->
                    <div class="mt-12">
                        <!-- $items->product->withQueryString()->links() -->
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection

