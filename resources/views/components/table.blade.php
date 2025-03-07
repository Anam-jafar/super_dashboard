<div class="overflow-auto sm:p-2 min-h-[55vh]">
    <table class="min-w-full  divide-y divide-gray-200 mt-4 border-separate border-spacing-y-4"
        style="table-layout: fixed;">
        <thead>
            <tr class="border-b border-defaultborder">
                <th scope="col" class="px-1 py-1 text-xs font-medium text-center"
                    style="color: #2624D0 !important; font-weight: bold !important; width: 50px;">
                    Bil.
                </th>
                @foreach ($headers as $header)
                    <th scope="col" class="px-2 py-1 text-left text-xs font-medium text-start"
                        style="color: #2624D0 !important; font-weight: bold !important;">
                        {{ $header }}
                    </th>
                @endforeach
                @if ($route || $extraRoute || $popupTriggerButton)
                    <th scope="col" class="px-2 py-1 text-left text-xs font-medium text-center"
                        style="color: #2624D0 !important; font-weight: bold !important;">
                        Tindakan
                    </th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-white space-y-2">
            @forelse($rows as $key => $row)
                <tr class="hover:bg-gray-50 cursor-pointer">
                    <!-- Index Column -->
                    <td class="px-1 py-2 whitespace-nowrap text-xs text-black text-center">
                        {{ $rows->firstItem() + $key }}
                    </td>
                    <!-- Dynamic Data Columns -->
                    @foreach ($columns as $column)
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-black break-words">
                            @if (in_array($column, ['sta', 'status', 'subscription_status', 'is_activated']))
                                <x-status-badge :column="$column" :value="$row->$column" />
                            @elseif($column == 'amount')
                                RM 9000
                            @else
                                {{ $row->$column ?? '-' }}
                            @endif
                        </td>
                    @endforeach

                    <!-- Actions Column -->

                    <x-action-buttons :route="$route" :extraRoute="$extraRoute" :routeType="$routeType" :id="$row->$id"
                        :key="$key" :popupTriggerButton="$popupTriggerButton" :popupTriggerButtonIcon="$popupTriggerButtonIcon" />

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
