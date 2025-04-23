<div class="2xl:justify-start flex w-full flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
  <!-- Filters Form -->
  <form method="GET" action="{{ $route }}" class="order-2 flex flex-col gap-4 md:flex-row lg:order-1 lg:flex-1">
    @foreach ($filters as $filter)
      @if ($filter['name'] === 'search')
        <!-- Search Input with Button -->
        <div class="flex w-full lg:max-w-[25rem]">
          <input type="text" id="search-input" name="search" value="{{ request('search') }}"
            class="ti-form-input w-full flex-1 rounded-none rounded-s-sm focus:z-10"
            placeholder="{{ $filter['placeholder'] }}">
          <button aria-label="button" type="submit"
            class="inline-flex h-11 w-11 items-center justify-center rounded-e-sm rounded-r-md border border-transparent bg-primary text-sm font-semibold text-white transition-all hover:bg-blue-300 focus:z-10 focus:outline-none focus:ring-0 focus:ring-primary">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              viewBox="0 0 16 16">
              <path
                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
          </button>
        </div>
      @elseif ($filter['type'] === 'select')
        <!-- Select Input -->
        <div class="w-full lg:max-w-[14rem]">
          <select id="{{ $filter['name'] }}" name="{{ $filter['name'] }}"
            class="ti-form-select w-full text-ellipsis rounded-sm py-2 pr-1" onchange="this.form.submit()">

            <option value="" {{ request()->has($filter['name']) ? '' : 'selected' }}>
              {{ $filter['label'] }}
            </option>

            @foreach ($filter['options'] as $key => $value)
              <option value="{{ $key }}"
                {{ request($filter['name']) !== null && request($filter['name']) == $key ? 'selected' : '' }}>
                {{ is_object($value) ? $value->name ?? 'Unknown' : $value }}
              </option>
            @endforeach
          </select>

        </div>
      @elseif ($filter['type'] === 'checkbox')
        <!-- Checkbox Input -->
        <div class="flex items-center space-x-2">
          <input type="checkbox" id="{{ $filter['name'] }}" name="{{ $filter['name'] }}" value="1"
            class="ti-form-checkbox h-5 w-5 border-gray-300 text-primary focus:ring-primary"
            {{ request($filter['name']) == '1' ? 'checked' : '' }} onchange="this.form.submit()">
          <label for="{{ $filter['name'] }}" class="w-[12rem] text-sm font-medium text-gray-700">
            {{ $filter['label'] }}
          </label>
        </div>
      @endif
    @endforeach
  </form>

  <!-- New Page Link -->
  @if ($buttonRoute)
    <a href="{{ $buttonRoute ?? '#' }}"
      class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-lg order-1 flex w-full items-center justify-center lg:order-2 lg:w-auto">
      {{ $buttonLabel }}
      <i class="fe fe-plus ml-2"></i>
    </a>
  @endif
  @if ($download)
    <div class="order-1 flex w-full flex-row gap-2 lg:order-2 lg:w-auto">
      <a href="{{ request()->fullUrlWithQuery(['excel' => true]) }}"
        class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-lg flex w-full items-center justify-center rounded-sm border border-gray-300 bg-white p-2 hover:bg-gray-50 lg:w-auto">
        <span class="fe fe-download mr-1 text-center text-gray-700"></span>
        <span class="text-sm font-normal text-gray-700 sm:inline md:inline lg:hidden">Download</span>
      </a>
      {{-- <a href="{{ request()->fullUrlWithQuery(['excel' => true]) }}"
        class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-lg flex w-1/2 items-center justify-center rounded-sm border border-gray-300 bg-white p-2 hover:bg-gray-50 lg:w-auto">
        <span class="fe fe-printer mr-1 text-center text-gray-700"></span>
        <span class="text-sm font-normal text-gray-700 sm:inline md:inline lg:hidden">Print</span>
      </a> --}}
    </div>
  @endif
</div>
