@props(['column', 'value', 'text' => null])

@php
  $statusStyles = [
      'STATUS' => [
          0 => ['text' => 'Aktif', 'bg' => '#d1fae5', 'textColor' => '#047857', 'border' => '#a7f3d0'],
          1 => ['text' => 'Tidak Aktif', 'bg' => '#fef3c7', 'textColor' => '#b45309', 'border' => '#fde68a'],
          'default' => ['text' => 'Unknown', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#d1d5db'],
      ],
      'SUBSCRIPTION_STATUS' => [
          0 => ['text' => 'Tidak Melanggan', 'bg' => '#fee2e2', 'textColor' => '#b91c1c', 'border' => '#fecaca'],
          1 => ['text' => 'Baru', 'bg' => '#dbeafe', 'textColor' => '#1e40af', 'border' => '#bfdbfe'],
          2 => ['text' => 'Tertunggak', 'bg' => '#fef3c7', 'textColor' => '#b45309', 'border' => '#fde68a'],
          3 => ['text' => '', 'bg' => '#d1fae5', 'textColor' => '#047857', 'border' => '#a7f3d0'],
          'default' => ['text' => 'Unknown', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#d1d5db'],
      ],
      'FIN_STATUS' => [
          0 => ['text' => 'Draft', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#d1d5db'],
          1 => ['text' => 'Disemak', 'bg' => '#fef3c7', 'textColor' => '#b45309', 'border' => '#fde68a'],
          2 => ['text' => 'Diterima', 'bg' => '#d1fae5', 'textColor' => '#047857', 'border' => '#a7f3d0'],
          3 => ['text' => 'Dibatalkan', 'bg' => '#fee2e2', 'textColor' => '#b91c1c', 'border' => '#fecaca'],
          4 => ['text' => 'Mohon Kemaskini', 'bg' => '#fce7f3', 'textColor' => '#be185d', 'border' => '#fbcfe8'],
          'default' => ['text' => 'Unknown', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#d1d5db'],
      ],
      'default' => [
          'default' => ['text' => 'Unknown', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#d1d5db'],
      ],
  ];

  // Determine the appropriate status mapping
  $columnStatus = $statusStyles[$column] ?? $statusStyles['default'];
  $statusData = $columnStatus[$value] ?? $columnStatus['default'];

  // Use the provided text or fall back to the default status text
  $displayText = $text ?? $statusData['text'];
@endphp

<span
  style="
        display: inline-block;
        width: 10rem;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: center;
        border-radius: 4px;
        border: 1px solid {{ $statusData['border'] }};
        background-color: {{ $statusData['bg'] }};
        color: {{ $statusData['textColor'] }};
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    "
  title="{{ $displayText }}">
  {{ $displayText }}
</span>
