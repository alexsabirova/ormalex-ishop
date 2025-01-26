<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $filter->title() }}</h5>
    <div class="flex items-center justify-between gap-3 mb-2">
        <span class="text-gray text-xxs font-medium">От, ₽</span>
        <span class="text-gray text-xxs font-medium">До, ₽</span>
    </div>

    <div class="flex items-center gap-3">
        <input id="{{ $filter->id('from') }}"
               name="{{ $filter->name('from') }}"
               value="{{ $filter->requestValue('from', 0) }}"
               type="number"
               class="w-full h-12 px-4 rounded-lg border border-body/50 focus:border-teal-400 focus:shadow-[0_0_0_3px_#00babe] bg-white text-gray text-xs shadow-transparent outline-0 transition"
               placeholder="От"
        >
        <span class="text-gray text-sm font-medium">–</span>

        <input id="{{ $filter->id('to') }}"
               name="{{ $filter->name('to') }}"
               value="{{ $filter->requestValue('to', 100000) }}"
               type="number"
               class="w-full h-12 px-4 rounded-lg border border-body/50 focus:border-teal-400 focus:shadow-[0_0_0_3px_#00babe] bg-white text-gray text-xs shadow-transparent outline-0 transition"
               placeholder="До"
        >
    </div>
</div>
