@extends('layouts.app')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="max-w-full mx-auto p-4 sm:p-6">
            <h1 class="text-2xl font-bold mb-4">Activity Logs</h1>

            <div class="overflow-x-auto">
                <table class="table-auto border-collapse border border-gray-200 w-full text-sm text-left bg-white shadow-sm rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border border-gray-300 px-4 py-2">#</th>
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
                                <!-- Numbering Column -->
                                <td class="border border-gray-300 px-4 py-2">{{ $logs->firstItem() + $loop->iteration - 1 }}</td>
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
                                <td colspan="9" class="border border-gray-300 px-4 py-2 text-center">No logs available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <x-pagination :items="$logs" label="log" />




        </div>
    </div>
</div>
@endsection
