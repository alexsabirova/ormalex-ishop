<nav class="hidden 2xl:flex gap-8">
    @foreach($menu as $item)
        <a href="{{ $item->link() }}"
           class="text-gray-500 hover:text-teal-600 @if($item->isActive()) font-bold @endif"
        >
            {{ $item->label() }}
        </a>
    @endforeach
</nav>

