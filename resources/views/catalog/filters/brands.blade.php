<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $filter->title() }}</h5>

    @foreach($filter->values() as $id => $label)
        <div>
            <input
                type="checkbox"
                class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                name="{{ $filter->name($id) }}"
                value="{{ $id }}"
                @checked($filter->requestValue($id))
                id="{{ $filter->id($id) }}"
            >

            <label for="{{ $filter-> id($id) }}" class="label cursor-pointer ml-2 text-sm">
                {{ $label }}
            </label>
        </div>
    @endforeach
</div>
