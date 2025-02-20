<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between 2xl:justify-start w-full gap-4">
    <!-- Filters Form -->
    <form method="GET" action="{{ $route }}" class="flex flex-col md:flex-row gap-4 lg:flex-1 order-2 lg:order-1">
        @foreach ($filters as $filter)
            @if ($filter['name'] === 'search')
                <!-- Search Input with Button -->
                <div class="flex w-full lg:max-w-[25rem]">
                    <input type="text" id="search-input" name="search" value="{{ request('search') }}"
                        class="ti-form-input flex-1 rounded-none rounded-s-sm focus:z-10 w-full"
                        placeholder="{{ $filter['placeholder'] }}">
                    <button aria-label="button" type="submit"
                        class="inline-flex justify-center items-center h-11 w-11 rounded-e-sm rounded-r-md border border-transparent font-semibold bg-primary text-white hover:bg-primary focus:z-10 focus:outline-none focus:ring-0 focus:ring-primary transition-all text-sm">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            @elseif ($filter['type'] === 'select')
                <!-- Select Input -->
                <div class="w-full lg:max-w-[14rem]">
                    <select id="{{ $filter['name'] }}" name="{{ $filter['name'] }}"
                        class="ti-form-select rounded-sm py-2 px-3 w-full" onchange="this.form.submit()">
                        <option value="" {{ request($filter['name']) == '' ? 'selected' : '' }}>
                            {{ $filter['label'] }}
                        </option>
                        @foreach ($filter['options'] as $key => $value)
                            <option value="{{ $key }}"
                                {{ request($filter['name']) == $key ? 'selected' : '' }}>
                                {{ is_object($value) ? $value->name ?? 'Unknown' : $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @elseif ($filter['type'] === 'checkbox')
                <!-- Checkbox Input -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="{{ $filter['name'] }}" name="{{ $filter['name'] }}" value="1"
                        class="ti-form-checkbox h-5 w-5 text-primary border-gray-300 focus:ring-primary"
                        {{ request($filter['name']) == '1' ? 'checked' : '' }} onchange="this.form.submit()">
                    <label for="{{ $filter['name'] }}" class="text-gray-700 text-sm font-medium w-[12rem]">
                        {{ $filter['label'] }}
                    </label>
                </div>
            @endif
        @endforeach
    </form>

    <!-- New Page Link -->
    @if ($buttonRoute)
        <a href="{{ $buttonRoute ?? '#' }}"
            class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-lg w-full lg:w-auto flex items-center justify-center order-1 lg:order-2">
            {{ $buttonLabel }}
            <i class="fe fe-plus ml-2"></i>
        </a>
    @endif
</div>
