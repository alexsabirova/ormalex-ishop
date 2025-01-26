@props([
    'type' => 'text',
    'value' => '',
    'isError' => false,
])

<input type="{{ $type }}" value="{{ $value }}" {{ $attributes
    ->class([
        '_is-error' => $isError,
        'w-full h-12 px-4 rounded-md border border-[#bbbbbb] bg-gray/5 focus:border-[#00babe] focus:shadow-[0_0_0_2px_#bce0e1] outline-none transition text-gray placeholder:text-neutral text-xxs md:text-xs'])
}}
>
