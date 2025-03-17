<div class="flex flex-col mt-4">
    <label for="{{ $id }}" class="text-gray-800 font-normal mb-2">
        {{ $level }}
        @if ($required && $required === true)
            <span class="text-red-500">*</span> <!-- Red asterisk for required field -->
        @endif
    </label>

    @if ($type === 'select')
        <!-- Render select field -->
        <select id="{{ $id }}" name="{{ $name }}"
            class="p-2 border !border-[#6E829F] rounded-lg !text-gray-800 h-[3rem]
                {{ $disabled || $readonly ? 'bg-gray-200' : '' }}"
            {{ $disabled ? 'disabled' : '' }} {{ $required && $required === true ? 'required' : '' }}>
            <!-- Conditionally required -->
            <option value="" disabled {{ $value === null ? 'selected' : '' }}>
                {{ $placeholder }}
            </option>
            @foreach ($valueList as $key => $displayValue)
                <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}>
                    {{ $displayValue }}
                </option>
            @endforeach
        </select>
    @else
        <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}"
            class="p-2 border !border-[#6E829F] rounded-lg text-gray-800 h-[3rem]
                {{ $disabled || $readonly ? 'bg-gray-100 cursor-not-allowed text-gray-500' : 'bg-white' }}
                {{ $rightAlign && $rightAlign === true ? 'text-right' : 'text-left' }}
                hover:!bg-gray-300"
            placeholder="{{ $placeholder }}" value="{{ $value }}"
            {{ $readonly ? 'readonly' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $required && $required === true ? 'required' : '' }}>


    @endif
</div>
