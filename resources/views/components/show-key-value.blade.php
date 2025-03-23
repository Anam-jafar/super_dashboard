<style>
    .info-row {
        display: flex;
        align-items: baseline;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .info-key {
        font-weight: 500;
        color: black;
        text-align: left;
        width: 100px;
        /* Default for small screens */
    }

    .info-separator {
        font-weight: 500;
        margin: 0 15px;
        color: black;
    }

    .info-value {
        font-weight: 500;
        color: black;
    }

    /* Responsive design for larger screens */
    @media (min-width: 600px) {
        .info-key {
            width: 250px;
            /* Expands width on medium and larger screens */
        }

        .info-separator {
            margin: 0 25px;
        }
    }
</style>

<div class="info-row">
    <div class="info-key">{{ $key }}</div>
    <div class="info-separator">:</div>
    <div class="info-value">
        @if (in_array(strtolower($key), ['mel', 'email', 'emel', 'emel (rasmi)']))
            {{ $value }}
        @else
            {{ strtoupper($value) }}
        @endif
    </div>
</div>
