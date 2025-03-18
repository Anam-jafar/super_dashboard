@props(['column', 'value', 'text' => null])

@php
    $statusStyles = [
        'sta' => [
            0 => ['text' => 'Aktif', 'class' => 'bg-green-100 text-green-700 border-green-500 rounded-sm'],
            1 => ['text' => 'Tidak Aktif', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500 rounded-sm'],
            2 => ['text' => 'Ditamatkan', 'class' => 'bg-red-100 text-red-700 border-red-500 rounded-sm'],
            3 => ['text' => 'Terpelihara', 'class' => 'bg-gray-100 text-gray-700 border-gray-500 rounded-sm'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500 rounded-sm'],
        ],
        'STATUS' => [
            0 => ['text' => 'Aktif', 'class' => 'bg-green-100 text-green-700 border-green-500 rounded-sm'],
            1 => ['text' => 'Tidak Aktif', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500 rounded-sm'],
            2 => ['text' => 'Ditamatkan', 'class' => 'bg-red-100 text-red-700 border-red-500 rounded-sm'],
            3 => ['text' => 'Terpelihara', 'class' => 'bg-gray-100 text-gray-700 border-gray-500 rounded-sm'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500 rounded-sm'],
        ],
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
        'FINSUBMISSIONSTATUS' => [
            0 => ['text' => 'Draft', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
            2 => ['text' => 'Diterima', 'class' => 'bg-green-100 text-green-700 border-green-500'],
            1 => ['text' => 'Disemak', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500'],
            3 => ['text' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-700 border-red-500'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],
        'default' => [
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],
    ];

    // Determine the appropriate status mapping
    $columnStatus = $statusStyles[$column] ?? $statusStyles['default'];
    $statusData = $columnStatus[$value] ?? $columnStatus['default'];

    // Use the provided text or fall back to the default status text
    $displayText = $text ?? $statusData['text'];
@endphp

<span class="inline-block w-24 px-2 py-1 text-xs font-semibold text-center border rounded-sm {{ $statusData['class'] }}">
    {{ $displayText }}
</span>
