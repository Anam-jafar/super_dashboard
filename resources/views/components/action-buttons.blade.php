@props([
    'route' => null,
    'extraRoute' => null,
    'routeType' => null,
    'id' => null,
    'key' => null,
    'popupTriggerButton' => null,
    'popupTriggerButtonIcon' => null,
])

<td class="px-2 py-2 whitespace-nowrap text-xs text-black text-center">
    @if ($extraRoute)
        <a onclick="openModal('modal-{{ $key }}')" class="text-green-600 hover:text-green-800 ml-2"
            title="View">
            <i class="fe fe-eye text-lg"></i>
        </a>
    @endif

    @if ($popupTriggerButton)
        <a onclick="openModal('modal-{{ $key }}')" class="text-blue-500 hover:text-blue-800 ml-2" title="View">
            <i class="fe fe-{{ $popupTriggerButtonIcon }} text-lg"></i>
        </a>
    @endif

    @if ($route)
        <a href="{{ route($route, ['type' => $routeType, 'id' => $id]) }}" class="text-blue-500 hover:underline">
            <i class="fe fe-edit"></i>
        </a>
    @endif
</td>
