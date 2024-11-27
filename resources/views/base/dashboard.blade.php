@extends('layouts.base')

@section('content')

<form method="GET" action="#" class="bg-white p-4 shadow-md rounded-md mt-5">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label for="start_date" class="block text-gray-700 font-semibold">Start Date:</label>
            <input type="date" id="start_date" name="start_date" class="w-full border-gray-300 rounded focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div>
            <label for="end_date" class="block text-gray-700 font-semibold">End Date:</label>
            <input type="date" id="end_date" name="end_date" class="w-full border-gray-300 rounded focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">Filter</button>
        </div>
    </div>
</form>
<div class="mt-6 bg-white p-4 shadow-md rounded-md">
    <!-- Rendered Report Placeholder -->
    <?php $report->render(); ?>

</div>

@endsection
