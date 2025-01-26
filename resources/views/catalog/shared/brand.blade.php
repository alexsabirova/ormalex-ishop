<a href="#" class="p-6 rounded-xl bg-neutral-300 hover:bg-teal-500">
    <div class="h-12 md:h-16">
        <img src="{{ $brand->makeThumbnail('70x70') }}" class="object-contain w-full h-full" alt="{{ $brand->title }}">
    </div>
    <div class="mt-8 text-xs sm:text-sm lg:text-md font-semibold text-center">
        {{ $brand->title }}
    </div>
</a>
