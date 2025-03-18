<div style="display: flex; margin-bottom: 12px; align-items: baseline;">
    <div style="font-weight: 500; width: 250px; text-align: left; color: black;">{{ $key }}</div>
    <div style="font-weight: 500; margin: 0 25px; color: black;">:</div>
    <div style="font-weight: 500; color: black;">
        @if (in_array(strtolower($key), ['mel', 'email', 'emel', 'emel (rasmi)']))
            {{ $value }}
        @else
            {{ strtoupper($value) }}
        @endif
    </div>
</div>
