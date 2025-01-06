<div class="grid justify-center sm:flex sm:justify-between sm:items-center gap-4 flex-wrap mt-6">
    <div>
        <p class="text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ $items->firstItem() }}</span>
            to
            <span class="font-medium">{{ $items->lastItem() }}</span>
            of
            <span class="font-medium">{{ $items->total() }}</span>
            {{ Str::plural($label, $items->total()) }}
        </p>
    </div>
    <div class="flex items-center space-x-4">
        <nav class="flex items-center gap-x-1">
            <!-- Previous Button -->
            <a href="{{ $items->previousPageUrl() }}&per_page={{ request('per_page', 10) }}"
            class="min-h-[32px] min-w-8 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-md text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 {{ !$items->previousPageUrl() ? 'disabled opacity-50 pointer-events-none' : '' }}">
                <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Previous
            </a>

            <!-- Next Button -->
            <a href="{{ $items->nextPageUrl() }}&per_page={{ request('per_page', 10) }}"
            class="min-h-[32px] min-w-8 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-md text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 {{ !$items->nextPageUrl() ? 'disabled opacity-50 pointer-events-none' : '' }}">
                Next
                <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
        </nav>

        <!-- Go To Page Section -->
        <div class="flex items-center gap-x-4">
            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-x-2">
                <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10/MS</option>
                    <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20/MS</option>
                    <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50/MS</option>
                    <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100/MS</option>
                </select>
            </form>
        </div>
    </div>
</div>
