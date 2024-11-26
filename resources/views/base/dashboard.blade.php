@extends('layouts.base')

@section('content')

<div class="w-full mx-auto bg-white p-6 rounded-lg shadow-lg mt-6 space-y-8">
    <!-- Filters Section -->
    <form method="GET" action="{{ route('showReport') }}" class="bg-gray-50 p-6 rounded-lg shadow-md">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="start_date" class="block text-gray-700 font-semibold mb-2">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="end_date" class="block text-gray-700 font-semibold mb-2">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-center items-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Filter</button>
            </div>
        </div>
    </form>

    <!-- Reports and Graphs Section -->
    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
        <!-- Render the Report -->
        <?php $report->render(); ?>
    </div>
</div>

@endsection
