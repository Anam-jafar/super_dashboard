<!-- components/modal.blade.php -->
@props([
    'modalId',
    'title',
    'tabs',
    'formFields'
])

<div id="{{ $modalId }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $title }}</h3>
                <div>
                    <button onclick="refreshData()" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        Refresh
                    </button>
                    <button onclick="saveChanges()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Save
                    </button>
                </div>
            </div>
            
            <!-- Tabs with Form Content -->
            <x-tabs :tabs="$tabs">
                <!-- This form will appear in the maklumat tab -->
                <form id="editForm" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($formFields as $field)
                            <div>
                                <label for="{{ $field['id'] }}" class="block text-sm font-medium text-gray-700">
                                    {{ $field['label'] }}
                                </label>
                                <input type="{{ $field['type'] ?? 'text' }}" 
                                       id="{{ $field['id'] }}" 
                                       name="{{ $field['id'] }}"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            </div>
                        @endforeach
                    </div>
                </form>
            </x-tabs>

            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeModal('{{ $modalId }}')" 
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>