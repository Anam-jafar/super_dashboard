@props(['column', 'value'])

@php
    $statusStyles = [
        // Status mappings for 'sta' column
        'sta' => [
            0 => ['text' => 'Aktif', 'class' => 'bg-green-100 text-green-700 border-green-500 rounded-sm'],
            1 => ['text' => 'Tidak Aktif', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500 rounded-sm'],
            2 => ['text' => 'Ditamatkan', 'class' => 'bg-red-100 text-red-700 border-red-500 rounded-sm'],
            3 => ['text' => 'Terpelihara', 'class' => 'bg-gray-100 text-gray-700 border-gray-500 rounded-sm'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500 rounded-sm'],
        ],

        // Status mappings for 'status' column
        'status' => [
            0 => ['text' => 'Aktif', 'class' => 'bg-green-100 text-green-700 border-green-500 rounded-sm'],
            1 => ['text' => 'Tidak Aktif', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],
        'subscription_status' => [
            0 => ['text' => 'Tidak Melanggan', 'class' => 'bg-red-100 text-red-700 border-red-500 rounded-sm'],
            1 => ['text' => 'Baru', 'class' => 'bg-blue-100 text-blue-700 border-blue-500 rounded-sm'],
            2 => ['text' => 'Tertunggak', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500 rounded-sm'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],

        'is_activated' => [
            0 => ['text' => 'Tidak Melanggan', 'class' => 'bg-red-100 text-red-700 border-red-500 rounded-sm'],
            1 => ['text' => 'Baru', 'class' => 'bg-blue-100 text-blue-700 border-blue-500 rounded-sm'],
            2 => ['text' => 'Aktif', 'class' => 'bg-green-100 text-green-700 border-green-500 rounded-sm'],
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
