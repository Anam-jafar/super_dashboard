@props(['column', 'value'])

@php
    $statusStyles = [
        // Status mappings for 'sta' column
        'sta' => [
            1 => ['text' => 'Active', 'class' => 'bg-green-100 text-green-700 border-green-500'],
            0 => ['text' => 'Inactive', 'class' => 'bg-blue-100 text-blue-700 border-blue-500'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],

        // Status mappings for 'status' column
        'status' => [
            1 => ['text' => 'Approved', 'class' => 'bg-orange-100 text-orange-700 border-orange-500'],
            0 => ['text' => 'Pending', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],
        'subscription_status' => [
            1 => ['text' => 'Baharu', 'class' => 'bg-blue-100 text-blue-700 border-blue-500 rounded-sm'],
            0 => ['text' => 'Pending', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],

        // Default mapping for unknown columns
        'default' => [
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],
    ];

    // Determine the appropriate status mapping
    $columnStatus = $statusStyles[$column] ?? $statusStyles['default'];
    $statusData = $columnStatus[$value] ?? $columnStatus['default'];

@endphp

<span class="px-2 py-1 text-xs font-semibold border rounded {{ $statusData['class'] }}">
    {{ $statusData['text'] }}
</span>
