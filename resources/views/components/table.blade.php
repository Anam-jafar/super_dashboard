<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                @foreach ($headers as $header)
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($rows as $key => $row)
                <tr class="hover:bg-gray-50 cursor-pointer" onclick="openModal('{{ $row->id }}')">
                    <!-- Index Column -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $rows->firstItem() + $key }}
                    </td>
                    <!-- Dynamic Data Columns -->
                    @foreach ($columns as $column)
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 break-words">
                            @if ($column === 'sta')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $row->$column == 0 ? 'bg-green-100 text-green-800' : 
                                       ($row->$column == 1 ? 'bg-yellow-100 text-yellow-800' : 
                                       ($row->$column == 2 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ $statuses->firstWhere('val', $row->$column) ?->prm ?? 'Unknown' }}
                                </span>
                            @elseif ($column === 'status')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $row->$column == 0 ? 'bg-green-100 text-green-800' : 
                                       ($row->$column == 1 ? 'bg-yellow-100 text-yellow-800' : 
                                       ($row->$column == 2 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ $statuses->firstWhere('val', $row->$column) ?->prm ?? 'Unknown' }}
                                </span>
                            @else
                                {{ $row->$column ?? 'N/A' }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + 1 }}" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
