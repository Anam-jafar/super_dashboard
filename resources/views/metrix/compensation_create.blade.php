@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Tambah Tetapan Kaffarah Baharu'" :breadcrumbs="[['label' => 'Kaffarah', 'url' => 'javascript:void(0);'], ['label' => 'Tambah Tetapan']]" />

            <form action="{{ route('metrix.compensation.store', ['type' => 'kaffarah']) }}" method="POST" class="space-y-8">
                @csrf

                <!-- Title -->
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-gray-900">Title</label>
                    <!-- Changed text-gray-700 to text-gray-900 -->
                    <input type="text" name="title" id="title" required
                        class="block w-96 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                        placeholder="Enter the title">
                </div>

                <!-- Offense Types -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-900">Offense Types</label>
                    <!-- Changed text-gray-700 to text-gray-900 -->
                    <div class="flex gap-4 w-full">
                        <div id="offense_types" class="space-y-3 w-1/2">
                            <div class="flex gap-4">
                                <input type="text" name="offense_type[0][parameter]" placeholder="Offense Description"
                                    required
                                    class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                <input type="number" name="offense_type[0][value]" placeholder="Value" required
                                    class="w-32 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="addOffenseType()"
                        class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Another Offense
                    </button>
                </div>

                <!-- Kaffarah Items -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-900">Kaffarah Items</label>
                    <!-- Changed text-gray-700 to text-gray-900 -->
                    <div class="flex gap-4 w-full">
                        <div id="kaffarah_items" class="space-y-3 w-1/2">
                            <div class="flex gap-4">
                                <input type="text" name="kaffarah_item[0][name]" placeholder="Item Name" required
                                    class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                <input type="number" name="kaffarah_item[0][price]" placeholder="Price" required
                                    class="w-32 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="addKaffarahItem()"
                        class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Another Item
                    </button>
                </div>

                <!-- Rate -->
                <div class="space-y-2">
                    <label for="rate" class="block text-sm font-medium text-gray-900">Rate</label>
                    <!-- Changed text-gray-700 to text-gray-900 -->
                    <input type="number" name="rate" id="rate" step="0.01" required
                        class="block w-96 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                        placeholder="Enter the rate">
                </div>

                <!-- Submit Button -->
                <div class="text-right">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Submit Kaffarah Setting
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let offenseTypeIndex = 1;
        let kaffarahItemIndex = 1;

        function addOffenseType() {
            const container = document.getElementById('offense_types');
            const newElement = document.createElement('div');
            newElement.className = 'flex gap-4 opacity-0 transform -translate-y-4 transition duration-300 ease-out';
            newElement.innerHTML = `
            <input 
                type="text" 
                name="offense_type[${offenseTypeIndex}][parameter]" 
                placeholder="Offense Description" 
                required 
                class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
            >
            <input 
                type="number" 
                name="offense_type[${offenseTypeIndex}][value]" 
                placeholder="Value" 
                required 
                class="w-32 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
            >
            <button type="button" onclick="removeOffenseType(this)" class="text-red-500 ml-2">X</button>
        `;
            container.appendChild(newElement);
            setTimeout(() => {
                newElement.classList.remove('opacity-0', '-translate-y-4');
            }, 10);
            offenseTypeIndex++;
        }

        function addKaffarahItem() {
            const container = document.getElementById('kaffarah_items');
            const newElement = document.createElement('div');
            newElement.className = 'flex gap-4 opacity-0 transform -translate-y-4 transition duration-300 ease-out';
            newElement.innerHTML = `
            <input 
                type="text" 
                name="kaffarah_item[${kaffarahItemIndex}][name]" 
                placeholder="Item Name" 
                required 
                class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
            >
            <input 
                type="number" 
                name="kaffarah_item[${kaffarahItemIndex}][price]" 
                placeholder="Price" 
                required 
                class="w-32 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
            >
            <button type="button" onclick="removeKaffarahItem(this)" class="text-red-500 ml-2">X</button>
        `;
            container.appendChild(newElement);
            setTimeout(() => {
                newElement.classList.remove('opacity-0', '-translate-y-4');
            }, 10);
            kaffarahItemIndex++;
        }

        function removeOffenseType(button) {
            const item = button.closest('div');
            item.remove();
        }

        function removeKaffarahItem(button) {
            const item = button.closest('div');
            item.remove();
        }
    </script>
@endsection
