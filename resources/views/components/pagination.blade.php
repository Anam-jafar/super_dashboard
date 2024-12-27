<!-- components/pagination.blade.php -->
@props(['items'])

<div class="mt-4 flex justify-between items-center">
    <div class="text-sm font-medium text-gray-700">
        Showing {{ $items->firstItem() }} - {{ $items->lastItem() }} 
        from total {{ $items->total() }}
    </div>

    <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-2">
            @if ($items->currentPage() > 1)
                <a href="{{ $items->previousPageUrl() }}" 
                   class="p-2 border border-gray-300 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Prev
                </a>
            @endif

            @if ($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" 
                   class="p-2 border border-gray-300 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Next
                </a>
            @endif
        </div>

        <x-records-per-page :options="[25, 50, 100, 200]" />
    </div>
</div>