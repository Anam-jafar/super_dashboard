<div class="bg-white mt-4">
    <div class="overflow-auto sm:p-2">
        <table class="min-w-full divide-y divide-gray-200" style="table-layout: fixed;">
            <thead>
                <tr class="border-b border-defaultborder">
                    @foreach ($headers as $header)
                        <th scope="col" class="{{ $header['class'] ?? '' }}" style="{{ $header['style'] ?? '' }}">
                            {{ $header['label'] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($rows as $index => $row)
                    <tr class="hover:bg-gray-50 cursor-pointer">
                        @foreach ($row as $cell)
                            <td class="{{ $cell['class'] ?? '' }}" style="{{ $cell['style'] ?? '' }}">
                                {!! $cell['content'] !!}
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) }}"
                            class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 text-center">
                            No records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
