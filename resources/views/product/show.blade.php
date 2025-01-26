@extends('layouts.app')

@section('title', $product->title)

@section('content')
    <main class="py-16 lg:py-20">
        <div class="container">

            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a href="{{ route('home') }}" class="text-gray hover:text-pink text-xs">Главная</a></li>
                <li><a href="{{ route('catalog') }}" class="text-gray hover:text-pink text-xs">Каталог</a></li>
                <li><span class="text-teal-700 hover:text-pink text-xs">{{ $product->title }}</span></li>
            </ul>

            <!-- Main product -->
            <section class="flex flex-col lg:flex-row gap-10 xl:gap-14 2xl:gap-20 mt-12">

                <div class="basis-full lg:basis-2/5 xl:basis-2/4">
                    <div class="overflow-hidden h-auto max-h-[450px] lg:h-[450px] xl:h-[450px] rounded-3xl shadow-lg">
                        <img src="{{ $product->makeThumbnail('345x320') }}" class="object-cover w-full h-full"
                             alt="alt="{{ $product->title }}">

                    </div>

                    <div class="max-lg:hidden">
                        <div class="flex mt-10 py-10 px-6 rounded-lg bg-gradient-to-r from-amber-50 to-yellow-200">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                            </svg>
                            <span class="text-gray font-bold text-[18px] px-3">Гарантия на товар: 2 года</span>
                        </div>
                        <div class="flex mt-5 py-10 px-6 rounded-lg bg-gradient-to-r from-cyan-50 to-cyan-300">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                            <span class="text-gray font-bold text-[18px] px-3">{{ $product->preview }}</span>
                        </div>
                    </div>
                </div>

                <div class="basis-full lg:basis-3/5 xl:basis-2/4">
                    <div class="grow flex flex-col lg:py-4">
                        <span class="text-xs font-semibold text-teal-600">&#8226; В наличии</span>
                        <h1 class="text-lg md:text-xl xl:text-[42px] font-black">
                            {{ $product->title }}
                        </h1>
                        <div class="flex items-start gap-4 mt-4">
                            <div class="text-pink text-lg md:text-xl font-black">{{ $product->price }}</div>
                            <div class="text-gray text-md md:text-lg line-through">{{ $product->price->old() }}</div>
                            <div class="border rounded-xl bg-pink text-neutral-50 px-2">-{{ $product->price->discount() }} %</div>
                        </div>
                        <ul class="sm:max-w-[360px] space-y-1 mt-8">
                            <h2 class="text-gray/50 font-semibold text-md pb-6">Характеристики</h2>
                            @foreach($product->json_properties as $property => $value)
                                <li class="flex justify-between text-[#454545]">
                                    <strong>{{ $property }}</strong> {{ $value }}
                                </li>
                                <hr class="text-neutral-300">
                            @endforeach
                        </ul>

                        <!-- Add to cart -->
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-8 mt-8">
                            @csrf
                            <div class="grid grid-cols-2 md:grid-cols-3 2xl:grid-cols-4 gap-6">
                                @foreach($options as $option => $values)
                                    <div class="flex gap-2">
                                        <div class="grid grid-cols">
                                            <label for="filter-item-1"
                                                   class="cursor-pointer text-dark text-xs font-medium">
                                                {{ $option }}
                                            </label>
                                            <select
                                                name="options[]"
                                                id="filter-item-1"
                                                class="form-select w-max h-12 px-4 rounded-lg border border-gray/30 focus:border-teal-600 focus:shadow-[0_0_0_3px_#00babe] bg-white/5 text-gray text-xs shadow-transparent outline-0 transition">
                                                @foreach($values as $value)
                                                    <option
                                                        value="{{ $value->id }}"
                                                        class="text-gray"
                                                    >
                                                        {{ $value->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="grid grid-cols">
                                            <span class="ml-5 text-dark text-xs font-medium">Количество</span>
                                            <div class="ml-5 flex items-stretch h-[48px] lg:h-[48px] gap-2">
                                                <button type="button"
                                                        class="w-10 h-full rounded-lg border border-gray/30 hover:bg-gray/30 active:bg-card/50 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-gray text-xs text-center font-bold shadow-transparent outline-0 transition">
                                                    -
                                                </button>
                                                <input name="quantity"
                                                       type="number"
                                                       class="h-full px-1 md:px-2 rounded-lg border border-gray/30 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-gray text-xs text-center font-bold shadow-transparent outline-0 transition"
                                                       min="1" max="999" value="1" placeholder="К-во">
                                                <button type="submit"
                                                        class="w-10 h-full rounded-lg border border-gray/30 hover:bg-gray/30 active:bg-card/50 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-gray text-xs text-center font-bold shadow-transparent outline-0 transition">
                                                    +
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <div class="flex items-stretch h-[54px] lg:h-[54px] gap-6">
                                <button
                                    type="submit"
                                    formaction="{{ route('cart.add', $product) }}"
                                    class="px-18 btn btn-teal"
                                    value="cart_submit"
                                >Добавить в корзину
                                </button>
                                <form action="" method="POST">
                                    <button
                                        type="submit"
                                        formaction="{{ route('wishlist.add', $product) }}"
                                        class="btn-like w-[72px] !px-0 btn btn-teal"
                                        value="wishlist_submit"
                                        title="В избранное"
                                    >
                                        <div>
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                 viewBox="0 0 52 52">
                                                <path
                                                    class="svg-inactive_like"
                                                    d="M26 48.486c-.263 0-.526-.067-.762-.203-.255-.148-6.336-3.679-12.504-8.998-3.656-3.153-6.574-6.28-8.673-9.295C1.344 26.09-.022 22.338 0 18.84c.025-4.072 1.483-7.901 4.106-10.782 2.667-2.93 6.226-4.544 10.021-4.544 4.865 0 9.312 2.725 11.872 7.042 2.56-4.317 7.007-7.042 11.872-7.042 3.586 0 7.007 1.456 9.634 4.1 2.883 2.9 4.52 7 4.494 11.245-.022 3.493-1.414 7.24-4.137 11.134-2.105 3.013-5.02 6.14-8.66 9.291-6.146 5.32-12.183 8.85-12.437 8.997a1.524 1.524 0 0 1-.766.206ZM14.128 6.56c-2.927 0-5.686 1.26-7.768 3.548-2.115 2.324-3.292 5.431-3.313 8.75-.042 6.606 6.308 13.483 11.642 18.09 4.712 4.068 9.49 7.123 11.308 8.236 1.808-1.115 6.554-4.168 11.246-8.235 5.319-4.61 11.668-11.493 11.71-18.11.022-3.44-1.294-6.749-3.608-9.079-2.05-2.063-4.705-3.2-7.473-3.2-4.658 0-8.847 3.276-10.422 8.152a1.523 1.523 0 0 1-2.9 0C22.976 9.836 18.787 6.56 14.129 6.56Z"/>
                                                <path
                                                    class="svg-active_like"
                                                    d="M26 48.486c-.263 0-.526-.067-.762-.203-.255-.148-6.336-3.679-12.504-8.998-3.656-3.153-6.574-6.28-8.673-9.295C1.344 26.09-.022 22.338 0 18.84c.025-4.072 1.483-7.901 4.106-10.782 2.667-2.93 6.226-4.544 10.021-4.544 4.865 0 9.312 2.725 11.872 7.042 2.56-4.317 7.007-7.042 11.872-7.042 3.586 0 7.007 1.456 9.634 4.1 2.883 2.9 4.52 7 4.494 11.245-.022 3.493-1.414 7.24-4.137 11.135-2.105 3.012-5.02 6.138-8.66 9.29-6.146 5.32-12.183 8.85-12.437 8.997a1.524 1.524 0 0 1-.766.206Z"/>
                                            </svg>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>

            </section>

            <!-- Description -->
            <section class="mt-12 xl:mt-16 pt-8 lg:pt-12 border-t border-white/10">
                <h2 class="mb-12 text-lg lg:text-[42px] font-black">О товаре</h2>
                <div>

                </div>
                <article class="text-xs md:text-sm">
                    {!! $product->text !!}
                </article>
            </section>

            <!-- Watched products  -->
            <section class="mt-16 xl:mt-24">
                <h2 class="mb-12 text-lg lg:text-[42px] font-black">Просмотренные товары</h2>
                <!-- Products list -->
                <div
                    class="products grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-x-8 gap-y-8 lg:gap-y-10 2xl:gap-y-12">
                    @each('product.shared.product', $viewed, 'product')
                </div>
            </section>

        </div>
    </main>
@endsection
