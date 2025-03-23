<div class="grid justify-center sm:flex sm:justify-between sm:items-center gap-4 flex-wrap mt-6">
    <div class="p-2 sm:p-2">
        <p class="text-sm text-gray-700">
            Menunjukkan
            <span class="font-medium">{{ $items->firstItem() }}</span>
            hingga
            <span class="font-medium">{{ $items->lastItem() }}</span>
            daripada
            <span class="font-medium">{{ $items->total() }}</span>
            {{ $label }}
        </p>
    </div>
    <div class="flex items-center space-x-4">
        <nav class="flex items-center gap-x-1">
            <!-- Previous Button -->
            <a href="{{ $items->appends(request()->query())->previousPageUrl() }}"
                class="min-h-[32px] min-w-8 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-md text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 {{ !$items->previousPageUrl() ? 'disabled opacity-50 pointer-events-none' : '' }}">
                <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Sebelum
            </a>

            <!-- Pagination Numbers (Hidden on Small Screens) -->
            <div class="hidden sm:flex items-center gap-x-1">
                @php
                    $startPage = max(1, $items->currentPage() - 2);
                    $endPage = min($items->lastPage(), $items->currentPage() + 2);
                @endphp

                @if ($startPage > 1)
                    <a href="{{ $items->appends(request()->query())->url(1) }}"
                        class="text-gray-800 hover:bg-gray-100 py-1 px-2.5 text-sm rounded-md">1</a>
                    @if ($startPage > 2)
                        <span class="text-gray-800 py-1 px-2.5 text-sm rounded-md">...</span>
                    @endif
                @endif

                @for ($i = $startPage; $i <= $endPage; $i++)
                    <a href="{{ $items->appends(request()->query())->url($i) }}"
                        class="min-h-[32px] min-w-8 flex justify-center items-center {{ $items->currentPage() == $i ? 'bg-primary text-white' : 'text-gray-800 hover:bg-gray-100' }} py-1 px-2.5 text-sm rounded-md focus:outline-none focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-primary dark:text-white dark:focus:bg-gray-500"
                        {{ $items->currentPage() == $i ? 'aria-current="page"' : '' }}>
                        {{ $i }}
                    </a>
                @endfor

                @if ($endPage < $items->lastPage())
                    @if ($endPage < $items->lastPage() - 1)
                        <span class="text-gray-800 py-1 px-2.5 text-sm rounded-md">...</span>
                    @endif
                    <a href="{{ $items->appends(request()->query())->url($items->lastPage()) }}"
                        class="text-gray-800 hover:bg-gray-100 py-1 px-2.5 text-sm rounded-md">{{ $items->lastPage() }}</a>
                @endif
            </div>


            <!-- Next Button -->
            <a href="{{ $items->appends(request()->query())->nextPageUrl() }}"
                class="min-h-[32px] min-w-8 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-md text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 {{ !$items->nextPageUrl() ? 'disabled opacity-50 pointer-events-none' : '' }}">
                Seterusnya
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
                @foreach (request()->except(['per_page', 'page']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10/MS</option>
                    <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25/MS</option>
                    <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50/MS</option>
                    <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100/MS</option>

                </select>
            </form>
        </div>
    </div>
</div>
