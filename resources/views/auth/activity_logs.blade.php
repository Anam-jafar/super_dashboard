@extends('layouts.app')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="max-w-full mx-auto p-4 sm:p-6 bg-gray-100">
            <h1 class="text-2xl font-bold mb-4">Activity Logs</h1>

            <div class="overflow-x-auto">
                <table class="table-auto border-collapse border border-gray-200 w-full text-sm text-left bg-white shadow-sm rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border border-gray-300 px-4 py-2">Name</th>
                            <th class="border border-gray-300 px-4 py-2">IC</th>
                            <th class="border border-gray-300 px-4 py-2">UID</th>
                            <th class="border border-gray-300 px-4 py-2">App</th>
                            <th class="border border-gray-300 px-4 py-2">Action</th>
                            <th class="border border-gray-300 px-4 py-2">Description</th>
                            <th class="border border-gray-300 px-4 py-2">Time</th>
                            <th class="border border-gray-300 px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 px-4 py-2">{{ $log->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $log->ic }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $log->uid }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $log->app }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $log->act }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $log->des }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $log->tm }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $log->dt }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="border border-gray-300 px-4 py-2 text-center">No logs available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Section -->
            <div class="grid justify-center sm:flex sm:justify-between sm:items-center gap-4 flex-wrap mt-6">
                <nav class="flex items-center gap-x-1">
                    <button type="button"
                        class="min-h-[32px] min-w-8 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-md text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        <span aria-hidden="true" class="sr-only">Previous</span>
                    </button>
                    <div class="flex items-center gap-x-1">
                        @for ($i = 1; $i <= $logs->lastPage(); $i++)
                            <button type="button"
                                class="min-h-[32px] min-w-8 flex justify-center items-center {{ $logs->currentPage() == $i ? 'bg-primary text-white' : 'text-gray-800 hover:bg-gray-100' }} py-1 px-2.5 text-sm rounded-md focus:outline-none focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-primary dark:text-white dark:focus:bg-gray-500"
                                {{ $logs->currentPage() == $i ? 'aria-current="page"' : '' }}>
                                {{ $i }}
                            </button>
                        @endfor
                    </div>
                    <button type="button"
                        class="min-h-[32px] min-w-8 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-md text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <span aria-hidden="true" class="sr-only">Next</span>
                        <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </nav>

                <div class="flex items-center gap-x-4">
                    <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-x-2">
                        <label for="per_page" class="text-sm">Show:</label>
                        <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>
                    <div class="flex items-center gap-x-2">
                        <span class="text-sm text-gray-800">Go to</span>
                        <input type="number" min="1" max="{{ $logs->lastPage() }}" class="min-h-[32px] py-1 px-2.5 block w-12 border-gray-200 rounded-md text-sm text-center focus:border-primary focus:ring-primary" onchange="location.href='{{ $logs->url(1) }}'.replace('page=1','page='+this.value)">
                        <span class="text-sm text-gray-800">page</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
