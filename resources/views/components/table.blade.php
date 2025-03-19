<div class="overflow-auto sm:p-2 min-h-[55vh]">
    <table class="min-w-full  divide-y divide-gray-200 mt-4 border-separate border-spacing-y-4"
        style="table-layout: fixed;">
        <thead>
            @php
                $alignCenter = ['Status']; // Add columns that should be centered
                $alignRight = ['Jumlah Invois', 'Jumlah Pembayaran', 'Baki Tertunggak']; // Add columns that should be right-aligned
            @endphp

            <tr class="border-b border-defaultborder">
                <th scope="col" class="px-1 py-1 text-xs font-medium text-center"
                    style="color: #2624D0 !important; font-weight: bold !important; width: 50px;">
                    Bil.
                </th>
                @foreach ($headers as $header)
                    @php
                        $alignClass = in_array($header, $alignCenter)
                            ? 'text-center'
                            : (in_array($header, $alignRight)
                                ? 'text-right'
                                : 'text-left');
                    @endphp
                    <th scope="col" class="px-2 py-1 text-xs font-medium {{ $alignClass }}"
                        style="color: #2624D0 !important; font-weight: bold !important;">
                        {{ $header }}
                    </th>
                @endforeach
                @if ($route || $extraRoute || $popupTriggerButton)
                    <th scope="col" class="px-2 py-1 text-xs font-medium text-center"
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
                        @php
                            $alignCenter = [
                                'status',
                                'subscription_status',
                                'is_activated',
                                'FINSUBMISSIONSTATUS',
                                'SUBSCRIPTION_STATUS',
                                'FIN_STATUS',
                                'STATUS',
                            ]; // Add columns that should be centered
                            $alignRight = ['TOTAL_INVOICE', 'TOTAL_RECEIVED', 'TOTAL_OUTSTANDING']; // Add columns that should be right-aligned
                        @endphp
                        <td
                            class="px-2 py-2 whitespace-nowrap text-xs text-black 
                                    {{ in_array($column, $alignCenter) ? 'text-center' : (in_array($column, $alignRight) ? 'text-right' : '') }}">
                            @if (in_array($column, ['sta', 'status', 'subscription_status', 'is_activated', 'FINSUBMISSIONSTATUS']))
                                <x-status-badge :column="$column" :value="$row->$column" />
                            @elseif ($column == 'STATUS' && is_array($row->STATUS))
                                <x-status-badge :column="$column" :value="$row->STATUS['val'] ?? ''" :text="$row->STATUS['prm'] ?? 'Unknown'" />
                            @elseif ($column == 'FIN_STATUS' && is_array($row->FIN_STATUS))
                                <x-status-badge :column="$column" :value="$row->FIN_STATUS['val'] ?? ''" :text="$row->FIN_STATUS['prm'] ?? 'Unknown'" />
                            @elseif ($column == 'SUBSCRIPTION_STATUS' && is_array($row->SUBSCRIPTION_STATUS))
                                <x-status-badge :column="$column" :value="$row->SUBSCRIPTION_STATUS['val'] ?? ''" :text="$row->SUBSCRIPTION_STATUS['prm'] ?? 'Unknown'" />
                            @elseif ($column == 'amount')
                                RM 9000
                            @else
                                {{ $row->$column ?? '-' }}
                            @endif
                        </td>
                    @endforeach
                    <!-- Actions Column -->
                    @if ($route || $extraRoute || $popupTriggerButton)
                        <x-action-buttons :route="$route" :extraRoute="$extraRoute" :routeType="$routeType" :id="$row->$id"
                            :key="$key" :popupTriggerButton="$popupTriggerButton" :popupTriggerButtonIcon="$popupTriggerButtonIcon" />
                    @endif


                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + 2 }}"
                        class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 text-center">
                        Tiada Rekod Ditemui.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
