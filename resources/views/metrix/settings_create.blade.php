@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Tambah Tetapan Fidyah Baharu'" :breadcrumbs="[['label' => 'Fidyah', 'url' => 'javascript:void(0);'], ['label' => 'Tambah Tetapan']]" />

            <form action="{{ route('compensation_.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Title -->
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-gray-900">Title</label>
                    <input type="text" name="title" id="title" required
                        class="block w-96 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                        placeholder="Enter the title">
                </div>

                <!-- Individual Status -->
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-900">Individual Status</label>
                    <div id="individual_statuses" class="space-y-4">
                        <div class="status-group">
                            <div class="flex gap-4">
                                <input type="text" name="individual_status[0][parameter]" placeholder="Status Parameter"
                                    required
                                    class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <button type="button" onclick="addCategory(this)"
                                    class="text-blue-500 px-4 py-2 rounded-md bg-blue-100">Add Category</button>
                                <button type="button" onclick="removeStatus(this)"
                                    class="text-red-500 px-4 py-2">X</button>
                            </div>
                            <div class="categories mt-3 space-y-3">
                                <div class="flex gap-4">
                                    <input type="text" name="individual_status[0][categories][0][parameter]"
                                        placeholder="Category Parameter" required
                                        class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <button type="button" onclick="removeCategory(this)"
                                        class="text-red-500 px-4 py-2">X</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="addStatus()"
                        class="mt-2 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md">Add Individual Status</button>
                </div>

                <!-- Fidyah Items -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-900">Fidyah Items</label>
                    <div id="fidyah_items" class="space-y-3">
                        <div class="flex gap-4">
                            <input type="text" name="fidyah_item[0][name]" placeholder="Item Name" required
                                class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <input type="number" name="fidyah_item[0][price]" placeholder="Price" required
                                class="w-32 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="button" onclick="removeItem(this)" class="text-red-500 px-4 py-2">X</button>
                        </div>
                    </div>
                    <button type="button" onclick="addFidyahItem()"
                        class="mt-2 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md">Add Item</button>
                </div>

                <!-- Rate -->
                <div class="space-y-2">
                    <label for="rate" class="block text-sm font-medium text-gray-900">Rate</label>
                    <input type="number" name="rate" id="rate" step="0.01" required
                        class="block w-96 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Enter the rate">
                </div>

                <!-- Submit Button -->
                <div class="text-right">
                    <button type="submit"
                        class="py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let statusIndex = 1;
        let categoryIndex = 0;

        function addStatus() {
            const container = document.getElementById('individual_statuses');
            const newStatus = document.createElement('div');
            newStatus.className = 'status-group space-y-4';
            newStatus.innerHTML = `
                <div class="flex gap-4">
                    <input type="text" name="individual_status[${statusIndex}][parameter]" placeholder="Status Parameter" required
                        class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm">
                    <button type="button" onclick="addCategory(this)" class="text-blue-500 px-4 py-2">Add Category</button>
                    <button type="button" onclick="removeStatus(this)" class="text-red-500 px-4 py-2">X</button>
                </div>
                <div class="categories mt-3 space-y-3">
                    <div class="flex gap-4">
                        <input type="text" name="individual_status[${statusIndex}][categories][0][parameter]" 
                            placeholder="Category Parameter" required
                            class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm">
                        <button type="button" onclick="removeCategory(this)" class="text-red-500 px-4 py-2">X</button>
                    </div>
                </div>`;
            container.appendChild(newStatus);
            statusIndex++;
        }

        function addCategory(button) {
            const categoriesContainer = button.closest('.status-group').querySelector('.categories');
            const newCategory = document.createElement('div');
            newCategory.className = 'flex gap-4';
            newCategory.innerHTML = `
                <input type="text" name="individual_status[${statusIndex - 1}][categories][${++categoryIndex}][parameter]"
                    placeholder="Category Parameter" required
                    class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm">
                <button type="button" onclick="removeCategory(this)" class="text-red-500 px-4 py-2">X</button>`;
            categoriesContainer.appendChild(newCategory);
        }

        function removeStatus(button) {
            button.closest('.status-group').remove();
        }

        function removeCategory(button) {
            button.closest('.flex').remove();
        }

        function addFidyahItem() {
            const container = document.getElementById('fidyah_items');
            const newItem = document.createElement('div');
            newItem.className = 'flex gap-4';
            newItem.innerHTML = `
                <input type="text" name="fidyah_item[${statusIndex}][name]" placeholder="Item Name" required
                    class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm">
                <input type="number" name="fidyah_item[${statusIndex}][price]" placeholder="Price" required
                    class="w-32 px-3 py-2 rounded-md border-gray-300 shadow-sm">
                <button type="button" onclick="removeItem(this)" class="text-red-500 px-4 py-2">X</button>`;
            container.appendChild(newItem);
        }

        function removeItem(button) {
            button.closest('.flex').remove();
        }
    </script>
@endsection
