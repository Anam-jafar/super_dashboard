@extends('layouts.base')

@section('content')

<div class="max-w-full mx-auto p-4 sm:p-6 bg-gray-100">
    <div class="flex flex-wrap -mx-4">
        <h1 class="text-xl font-bold mb-4">Branches</h1>

        <!-- Filter and Search Card -->
        <div class="w-full mb-4 bg-white shadow-md rounded-lg p-4">
            <form method="GET" action="{{ route('showBranchList') }}" class="flex flex-wrap items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <!-- Name Search -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700">Search by Name</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Enter branch name" 
                           class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500">
                </div>
                <!-- Submit Button -->
                <div class="flex-none">
                    <label class="block text-sm font-medium text-transparent">Submit</label>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300">
                        Apply
                    </button>
                </div>
            </form>
        </div>

        <!-- Table to display data -->
        <div class="w-full overflow-x-auto bg-white shadow-md rounded-lg p-4">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Short Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Telephone</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">URL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $branch)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $branch->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $branch->sname }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $branch->tel }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $branch->mel }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="{{ $branch->url }}" target="_blank" class="text-blue-500 hover:underline">
                                    {{ $branch->url }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="mt-4">
                {{ $branches->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
