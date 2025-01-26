<div class="max-w-[540px] mt-10 mx-auto p-6 xs:p-8 md:p-12 2xl:p-12 rounded-[20px] bg-white shadow-2xl">
    <h1 class="mb-2 text-lg">
        {{ $title }}
    </h1>

    <form class="space-y-3" action="{{ $action }}" method="{{ $method }}">
        {{ $slot }}
    </form>

    {{ $socialAuth }}

    {{ $links }}

    {{ $agreements }}

</div>
