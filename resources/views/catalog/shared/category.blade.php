
    <a href="{{ route('catalog', $category) }}"
       class="flex items-center rounded-xl border border-solid text-gray hover:text-[#048e91] p-3 sm:p-1 2xl:p-2 text-xxs sm:text-xs lg:text-sm font-semibold hover:shadow-md hover:shadow-teal-600/40">
        <div class="h-10 md:h-12">
            <img src="{{ $category->makeThumbnail('70x70') }}" class="object-contain w-full h-full" alt="{{ $category->title }}">
        </div>
        <span class="text-center px-3">{{ $category->title }}</span>

    </a>


