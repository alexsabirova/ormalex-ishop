<!-- Product card -->
<div class="product-card flex flex-col md:flex-row rounded-2xl bg-neutral-100 shadow-md">
    <a href="{{ route('product', $product) }}" class="product-card-photo overflow-hidden shrink-0 md:w-[260px] xl:w-[320px] h-[320px] md:h-full rounded-2xl">
        <img src="{{ $product->makeThumbnail('345x320') }}" class="object-cover w-full h-full" alt="{{ $product->title }}">
    </a>
    <div class="grow flex flex-col py-8 px-6 md:px-8">
        <span class="text-xs font-semibold text text-right text-teal-600">&#8226; В наличии</span>
        <span class="text-xxs text text-gray">{{ $product->brand->title }}</span>
        <h3 class="text-sm lg:text-md font-black"><a href="{{ route('product', $product) }}" class="inline-block text-gray hover:text-pink">{{ $product->title }}</a></h3>
        <span class="text-xxs font-bold text text-cyan-800">{{ $product->preview }}</span>
        @if($product->json_properties)
            <ul class="space-y-1 mt-4 text-xxs">
                @foreach($product->json_properties as $property => $value)
                    <li class="flex justify-between text-gray"><strong>{{ $property }}</strong> {{ $value }}</li>
                @endforeach
            </ul>
        @endif
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6 mt-6">
            <div class="flex">
                <div class="flex items-baseline gap-2">
                    <div class="text-gray text-md xl:text-lg font-black">{{ $product->price }}</div>
                </div>
                <div class="mx-3 text-pink text-md line-through">
                    {{ $product->price->old()}}
                </div>
                <div class="border rounded-xl bg-pink/90 text-neutral-50 mb-3 px-2 text-xxs">
                    -{{ $product->price->discount() }} %
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-4">
                <a href="#" class="w-[42px] !h-[42px] !px-0 btn btn-teal" title="Удалить из избранного">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 52 52">
                        <path d="M26 48.486c-.263 0-.526-.067-.762-.203-.255-.148-6.336-3.679-12.504-8.998-3.656-3.153-6.574-6.28-8.673-9.295C1.344 26.09-.022 22.338 0 18.84c.025-4.072 1.483-7.901 4.106-10.782 2.667-2.93 6.226-4.544 10.021-4.544 4.865 0 9.312 2.725 11.872 7.042 2.56-4.317 7.007-7.042 11.872-7.042 3.586 0 7.007 1.456 9.634 4.1 2.883 2.9 4.52 7 4.494 11.245-.022 3.493-1.414 7.24-4.137 11.134-2.105 3.013-5.02 6.14-8.66 9.291-6.146 5.32-12.183 8.85-12.437 8.997a1.524 1.524 0 0 1-.766.206ZM14.128 6.56c-2.927 0-5.686 1.26-7.768 3.548-2.115 2.324-3.292 5.431-3.313 8.75-.042 6.606 6.308 13.483 11.642 18.09 4.712 4.068 9.49 7.123 11.308 8.236 1.808-1.115 6.554-4.168 11.246-8.235 5.319-4.61 11.668-11.493 11.71-18.11.022-3.44-1.294-6.749-3.608-9.079-2.05-2.063-4.705-3.2-7.473-3.2-4.658 0-8.847 3.276-10.422 8.152a1.523 1.523 0 0 1-2.9 0C22.976 9.836 18.787 6.56 14.129 6.56Z"/>
                    </svg>
                    <!--<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 52 52">
                        <path d="M26 48.486c-.263 0-.526-.067-.762-.203-.255-.148-6.336-3.679-12.504-8.998-3.656-3.153-6.574-6.28-8.673-9.295C1.344 26.09-.022 22.338 0 18.84c.025-4.072 1.483-7.901 4.106-10.782 2.667-2.93 6.226-4.544 10.021-4.544 4.865 0 9.312 2.725 11.872 7.042 2.56-4.317 7.007-7.042 11.872-7.042 3.586 0 7.007 1.456 9.634 4.1 2.883 2.9 4.52 7 4.494 11.245-.022 3.493-1.414 7.24-4.137 11.135-2.105 3.012-5.02 6.138-8.66 9.29-6.146 5.32-12.183 8.85-12.437 8.997a1.524 1.524 0 0 1-.766.206Z"/>
                    </svg>-->
                </a>
                <a href="{{ route('product', $product) }}" class="w-[142px] !h-[42px] !px-0 btn btn-teal" title="Перейти к товару">
                    <span> Подробнее</span>
                </a>
            </div>
        </div>
    </div>
</div><!-- /.product-card -->
