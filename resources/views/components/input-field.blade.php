<div class="mt-4 flex flex-col">
  <label for="{{ $id }}" class="mb-4 font-normal text-gray-800">
    {{ $level }}
    @if ($required && $required === true)
      <span class="text-red-500">*</span>
    @endif
  </label>
  @if (!empty($spanText))
    <span class="mb-4 font-normal text-gray-500">({{ $spanText }})</span>
  @endif

  @if ($type === 'select')
    <select id="{{ $id }}" name="{{ $name }}"
      class="input-field {{ $disabled || $readonly ? 'bg-gray-200' : '' }} h-[3rem] rounded-lg border !border-[#6E829F] p-2 !text-gray-800"
      autocomplete="off" {{ $disabled ? 'disabled' : '' }} {{ $required && $required === true ? 'required' : '' }}>
      <option value="" disabled {{ $value === null ? 'selected' : '' }}>
        {{ $placeholder }}
      </option>
      @foreach ($valueList as $key => $displayValue)
        <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}>
          {{ $displayValue }}
        </option>
      @endforeach
    </select>
  @elseif ($type === 'money')
    <input type="text" id="{{ $id }}_formatted"
      class="input-field {{ $disabled || $readonly ? 'bg-gray-100 cursor-not-allowed text-gray-500' : 'bg-white' }} {{ $rightAlign && $rightAlign === true ? 'text-right' : 'text-left' }} h-[3rem] rounded-lg border !border-[#6E829F] p-2 text-gray-800"
      autocomplete="off" placeholder="{{ $placeholder }}"
      value="{{ old($name, $value) !== null && old($name, $value) !== '' && old($name, $value) !== '0' ? number_format(old($name, $value), 2, '.', ',') : '' }}"
      {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}>

    <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}">
  @else
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}"
      class="input-field {{ $disabled || $readonly ? 'bg-gray-100 cursor-not-allowed text-gray-500' : 'bg-white' }} {{ $rightAlign && $rightAlign === true ? 'text-right' : 'text-left' }} h-[3rem] rounded-lg border !border-[#6E829F] p-2 text-gray-800"
      autocomplete="off" placeholder="{{ $placeholder }}" value="{{ $value }}"
      {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}
      {{ $required && $required === true ? 'required' : '' }}>
  @endif

  @if ($errors->has($name))
    <span class="mt-1 text-sm text-red-500">{{ $errors->first($name) }}</span>
  @endif
</div>

<style>
  .input-field:focus {
    outline: none;
    border-color: #314866 !important;
    border-width: 2px !important;
    box-shadow: 0 0 0 1px #314866;
  }
</style>
