<!-- Create this file at: resources/views/components/records-per-page.blade.php -->
@props(['options' => [25, 50, 100, 200]])

<div class="flex items-center space-x-2">
    <select id="recordsPerPage" name="recordsPerPage" 
            onchange="updatePagination(this.value)" 
            class="p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        @foreach($options as $option)
            <option value="{{ $option }}" {{ request('recordsPerPage') == $option ? 'selected' : '' }}>
                {{ $option }}/Ms
            </option>
        @endforeach
    </select>
</div>