@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Tambah Tetapan Fidyah Baharu'" :breadcrumbs="[['label' => 'Fidyah', 'url' => 'javascript:void(0);'], ['label' => 'Tambah Tetapan']]" />

            <form action="{{ route('metrix.settings.update', ['type' => 'fidyah', 'id' => $setting['_id']]) }}" method="POST"
                class="space-y-8">
                @csrf
                @method('PUT')


                <!-- Title -->
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-gray-900">Title</label>
                    <input type="text" name="title" id="title" required
                        class="block w-96 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                        value="{{ $setting['title'] }}">
                </div>

                <!-- Individual Status -->
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-900">Individual Status</label>
                    <div id="individual_statuses" class="space-y-4">
                        @foreach ($setting['individual_status'] as $statusIndex => $status)
                            <div class="status-group">
                                <div class="flex gap-4">
                                    <input type="text" name="individual_status[{{ $statusIndex }}][parameter]"
                                        value="{{ $status['parameter'] }}" placeholder="Status Parameter" required
                                        class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="categories mt-3 space-y-3">
                                    @foreach ($status['categories'] as $categoryIndex => $category)
                                        <div class="flex gap-4">
                                            <input type="text"
                                                name="individual_status[{{ $statusIndex }}][categories][{{ $categoryIndex }}][parameter]"
                                                value="{{ $category['parameter'] }}" placeholder="Category Parameter"
                                                required
                                                class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <input type="text"
                                                name="individual_status[{{ $statusIndex }}][categories][{{ $categoryIndex }}][code]"
                                                value="{{ $category['code'] }}" placeholder="Category Code" required
                                                class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <!-- Fidyah Items -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-900">Edit Fidyah Items</label>
                    <div id="fidyah_items" class="space-y-3">
                        @foreach ($setting['fidyah_item'] as $itemIndex => $item)
                            <div class="flex gap-4">
                                <input type="text" name="fidyah_item[{{ $itemIndex }}][name]"
                                    value="{{ $item['name'] }}" placeholder="Item Name" required
                                    class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <input type="number" name="fidyah_item[{{ $itemIndex }}][price]"
                                    value="{{ $item['price'] }}" placeholder="Price" readonly
                                    class="w-32 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <input type="number" name="fidyah_item[{{ $itemIndex }}][rate_value]"
                                    value="{{ $item['rate_value'] ?? '' }}" placeholder="Rate" readonly
                                    class="w-32 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        @endforeach
                    </div>
                </div>


                <!-- Rate -->
                <div class="space-y-2">
                    <label for="rate" class="block text-sm font-medium text-gray-900">Rate</label>
                    <input type="number" name="rate" id="rate" step="0.01" required
                        class="block w-96 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $setting['rate'] }}" readonly>
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
