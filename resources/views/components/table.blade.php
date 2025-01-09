<table class="min-w-full divide-y divide-gray-200 mt-4">
    <thead>
        <tr class="border-b border-defaultborder">
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-start"
                style="color: #2624D0 !important; font-weight: bold !important;">#</th>
            @foreach ($headers as $header)
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-start"
                    style="color: #2624D0 !important; font-weight: bold !important;">
                    {{ $header }}
                </th>
            @endforeach
        </tr>

    </thead>
    <tbody class="bg-white">
        @forelse($rows as $key => $row)
            <tr class="hover:bg-gray-50 cursor-pointer" onclick="openModal('{{ $row->id }}')">
                <!-- Index Column -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $rows->firstItem() + $key }}
                </td>
                <!-- Dynamic Data Columns -->
                @foreach ($columns as $column)
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black break-words">
                        @if ($column === 'sta')
                            {{ $statuses->firstWhere('val', $row->$column)?->prm ?? 'Unknown' }}
                        @elseif ($column === 'status')
                            {{ $statuses->firstWhere('val', $row->$column)?->prm ?? 'Unknown' }}
                        @else
                            {{ $row->$column ?? 'N/A' }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($headers) + 1 }}"
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
