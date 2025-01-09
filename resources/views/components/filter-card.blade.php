<div class="flex items-center justify-between w-full gap-4">
    <!-- Filters Form -->
    <form method="GET" action="{{ $route }}" class="flex items-center gap-4 flex-1">
        @foreach ($filters as $filter)
            @if ($filter['name'] === 'search')
                <!-- Search Input with Button -->
                <div class="flex rounded-sm">
                    <input type="text" id="search-input" name="search" value="{{ request('search') }}"
                        class="ti-form-input rounded-none rounded-s-sm focus:z-10 w-40" placeholder="Search...">
                    <button aria-label="button" type="submit"
                        class="inline-flex flex-shrink-0 justify-center items-center h-[2.875rem] w-[2.875rem] rounded-e-sm rounded-r-md border border-transparent font-semibold bg-primary text-white hover:bg-primary focus:z-10 focus:outline-none focus:ring-0 focus:ring-primary transition-all text-sm">
                        <svg class="h-5 w-5 m-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            @elseif ($filter['type'] === 'select')
                <!-- Select Input -->
                <select id="{{ $filter['name'] }}" name="{{ $filter['name'] }}"
                    class="ti-form-select rounded-sm py-2 px-3 w-40" onchange="this.form.submit()">
                    <option value="" {{ request($filter['name']) == '' ? 'selected' : '' }}>
                        All {{ $filter['label'] }}
                    </option>
                    @foreach ($filter['options'] as $key => $value)
                        <option value="{{ $key }}" {{ request($filter['name']) == $key ? 'selected' : '' }}>
                            {{ is_object($value) ? $value->name ?? 'Unknown' : $value }}
                        </option>
                    @endforeach
                </select>
            @endif
        @endforeach
    </form>

    <!-- New Page Link -->
    <a href="#" class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
        style="padding: 9px 12px;">
        {{ $buttonLabel }}
        <i class="fe fe-plus"></i>
    </a>
</div>
