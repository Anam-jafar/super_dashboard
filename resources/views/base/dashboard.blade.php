@extends('layouts.base')

@section('content')

<form method="GET" action="{{ route('showReport') }}" class="bg-white p-4 shadow-md rounded-md mt-5">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label for="dashboard_name" class="block text-gray-700 font-semibold">Select Dashboard:</label>
            <select id="dashboard_name" name="dashboard_name" class="w-full px-4 py-2 border rounded" required>
                <option value="">Select a dashboard</option>
                @foreach($dashboardNames as $dashboard)
                    <option value="{{ $dashboard['dashboard_name'] }}" {{ request('dashboard_name') == $dashboard['dashboard_name'] ? 'selected' : '' }}>
                        {{ $dashboard['dashboard_name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">Show Dashboard</button>
        </div>
    </div>
</form>

<div class="mt-6 bg-white p-4 shadow-md rounded-md">
    <!-- Rendered Report Placeholder -->
    @if(isset($report))
        <?php $report->render(); ?>
    @endif
</div>

@endsection
