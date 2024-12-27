<!-- Create this file at: resources/views/components/tabs.blade.php -->
@props(['tabs'])

<div class="mb-4">
    <ul class="flex border-b">
        @foreach($tabs as $id => $label)
            <li class="mr-1">
                <a href="#" 
                   class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold tab"
                   data-target="{{ $id }}"
                   onclick="changeTab(event, '{{ $id }}')">
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div id="tabContent">
    @foreach($tabs as $id => $label)
        <div id="{{ $id }}" class="tab-content hidden">
            @if($id === 'maklumat')
                {{ $slot }}
            @else
                <h4 class="text-lg font-semibold mb-2">{{ $label }} Content</h4>
                <p>Content for {{ $label }} tab.</p>
            @endif
        </div>
    @endforeach
</div>