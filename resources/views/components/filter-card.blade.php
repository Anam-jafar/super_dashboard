<div class="bg-white shadow-lg rounded-lg p-6 mb-8">
    <form method="GET" action="{{ $route }}" class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:items-end md:-mx-2">
        @foreach ($filters as $filter)
            <div class="md:w-1/5 md:px-2 mb-4 md:mb-0">
                <label for="{{ $filter['name'] }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $filter['label'] }}</label>
                @if ($filter['type'] === 'select')
                    <select id="{{ $filter['name'] }}" name="{{ $filter['name'] }}" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="" {{ request($filter['name']) == '' ? 'selected' : '' }}>All {{ $filter['label'] }}</option>
                        @foreach ($filter['options'] as $key => $value)
                            <option value="{{ $key }}" {{ request($filter['name']) == $key ? 'selected' : '' }}>
                                {{ is_object($value) ? $value->name ?? 'Unknown' : $value }}
                            </option>
                        @endforeach

                    </select>
                @elseif ($filter['type'] === 'text')
                    <input type="text" id="{{ $filter['name'] }}" name="{{ $filter['name'] }}" value="{{ request($filter['name']) }}" 
                           placeholder="{{ $filter['placeholder'] ?? '' }}" 
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @endif
            </div>
        @endforeach
        <div class="md:w-1/5 md:px-2 flex items-end justify-between">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ $buttonLabel }}
            </button>
        </div>
    </form>
</div>
