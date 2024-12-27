<!-- components/data-table.blade.php -->
@props([
    'title',
    'columns',
    'items',
    'searchRoute',
    'filterOptions' => null,
    'filterIdField' => 'id',  // Add this prop to specify the ID field
    'filterNameField' => 'name', // Add this prop to specify the name field
    'modalId',
    'formFields'
])

<div class="max-w-full mx-auto p-4 sm:p-6 bg-gray-100">
    <div class="flex flex-wrap -mx-4">
        <h1 class="text-xl font-bold mb-4">{{ $title }}</h1>

        <!-- Filter and Search Card -->
        <div class="w-full mb-4 bg-white shadow-md rounded-lg p-4">
            <form method="GET" action="{{ $searchRoute }}" class="flex flex-wrap items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <!-- Name Search -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700">Search by Name</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                        class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500">
                </div>

                @if($filterOptions)
                <div class="flex-1">
                    <label for="filter" class="block text-sm font-medium text-gray-700">Filter</label>
                    <select id="filter" name="filter" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                        <option value="">All</option>
                        @foreach($filterOptions as $option)
                            <option value="{{ $option->$filterIdField }}" 
                                    {{ request('filter') == $option->$filterIdField ? 'selected' : '' }}>
                                {{ $option->$filterNameField }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="flex-none">
                    <label class="block text-sm font-medium text-transparent">Submit</label>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Apply
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="w-full overflow-x-auto bg-white shadow-md rounded-lg p-4">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        @foreach($columns as $column)
                            <th class="border border-gray-300 px-4 py-2 text-left">{{ $column }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="cursor-pointer hover:bg-gray-100" data-id="{{ $item->id }}" 
                            onclick="openModal('{{ $item->id }}', '{{ $modalId }}')">
                            @foreach($columns as $key => $column)
                                <td class="border border-gray-300 px-4 py-2">{{ $item->$key }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) }}" class="border border-gray-300 px-4 py-2 text-center">
                                No records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <x-pagination :items="$items" />
        </div>
    </div>
</div>