<div class="overflow-auto sm:p-2">
    <table class="min-w-full divide-y divide-gray-200 mt-4" style="table-layout: fixed;">
        <thead>
            <tr class="border-b border-defaultborder">
                <th scope="col" class="px-1 py-1 text-left text-xs font-medium text-center"
                    style="color: #2624D0 !important; font-weight: bold !important; width: 50px;">
                    Bil.
                </th>
                @foreach ($headers as $header)
                    <th scope="col" class="px-2 py-1 text-left text-xs font-medium text-start"
                        style="color: #2624D0 !important; font-weight: bold !important;">
                        {{ $header }}
                    </th>
                @endforeach
                @if ($route || $extraRoute)
                    <th scope="col" class="px-2 py-1 text-left text-xs font-medium text-center"
                        style="color: #2624D0 !important; font-weight: bold !important;">
                        Actions
                    </th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-white">
            @forelse($rows as $key => $row)
                <tr class="hover:bg-gray-50 cursor-pointer">
                    <!-- Index Column -->
                    <td class="px-1 py-2 whitespace-nowrap text-xs text-black text-center">
                        {{ $rows->firstItem() + $key }}
                    </td>
                    <!-- Dynamic Data Columns -->
                    @foreach ($columns as $column)
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-black break-words">
                            @if ($column === 'sta')
                                {{ $statuses->firstWhere('val', $row->$column)?->prm ?? 'Unknown' }}
                            @elseif ($column === 'status')
                                {{ $statuses->firstWhere('val', $row->$column)?->prm ?? 'Unknown' }}
                            @elseif($column === 'is_active')
                                @if ($row->$column)
                                    <span class="text-green-600 font-bold">Active</span>
                                @else
                                    <span class="text-gray-600">Inactive</span>
                                @endif
                            @else
                                {{ $row->$column ?? '--' }}
                            @endif
                        </td>
                    @endforeach

                    <!-- Actions Column -->
                    <td class="px-2 py-2 whitespace-nowrap text-xs text-black text-center">

                        @if ($extraRoute)
                            <a onclick="openModal('modal-{{ $key }}')"
                                class="text-green-600 hover:text-green-800 ml-2" title="Edit">
                                <i class="fe fe-eye text-lg"></i>
                            </a>
                        @endif

                        @if ($route)
                            <a href="{{ route($route, ['type' => $routeType, 'id' => $row->$id]) }}"
                                class="text-blue-500 hover:underline">
                                <i class="fe fe-edit"></i>
                            </a>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + 2 }}"
                        class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 text-center">
                        No records found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
