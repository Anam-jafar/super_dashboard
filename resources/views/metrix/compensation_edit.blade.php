@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Edit Kaffarah Setting'" :breadcrumbs="[['label' => 'Kaffarah', 'url' => 'javascript:void(0);'], ['label' => 'Edit Setting']]" />

            <form action="{{ route('metrix.compensation.update', ['category' => 'kaffarah', 'id' => $setting['_id']]) }}"
                method="POST" class="space-y-8">
                @csrf

                <!-- Title -->
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-gray-900">Title</label>
                    <input type="text" name="title" id="title" value="{{ $setting['title'] }}" required
                        class="block w-96 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                        placeholder="Enter the title">
                </div>


                <!-- Offense Types -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-900">Offense Types</label>
                    <div class="flex gap-4 w-full">
                        <div id="offense_types" class="space-y-3 w-1/2">
                            @foreach ($setting['offense_type'] as $index => $offense)
                                <div class="flex gap-4">
                                    <input type="text" name="offense_type[{{ $index }}][parameter]"
                                        value="{{ $offense['parameter'] }}" placeholder="Offense Description" required
                                        class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <input type="number" name="offense_type[{{ $index }}][value]"
                                        value="{{ $offense['value'] }}" placeholder="Value" required readonly
                                        class="w-32 px-3 py-2 rounded-md border-black-900 bg-gray-200 text-gray-500 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Kaffarah Items -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-900">Kaffarah Items</label>
                    <div class="flex gap-4 w-full">
                        <div id="kaffarah_items" class="space-y-3 w-1/2">
                            @foreach ($setting['kaffarah_item'] as $index => $item)
                                <div class="flex gap-4">
                                    <input type="text" name="kaffarah_item[{{ $index }}][name]"
                                        value="{{ $item['name'] }}" placeholder="Item Name" required
                                        class="flex-1 px-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <input type="number" name="kaffarah_item[{{ $index }}][price]"
                                        value="{{ $item['price'] }}" placeholder="Price" required readonly
                                        class="w-32 px-3 py-2 rounded-md border-gray-300 bg-gray-200 text-gray-500 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Rate -->
                <div class="space-y-2">
                    <label for="rate" class="block text-sm font-medium text-gray-900">Rate</label>
                    <input type="number" name="rate" id="rate" value="{{ $setting['rate'] }}" step="0.01"
                        required readonly
                        class="block w-96 px-3 py-2 rounded-md border-gray-300 bg-gray-200 text-gray-500 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                        placeholder="Enter the rate">

                </div>

                <!-- Submit Button to Update Kaffarah Setting -->
                <div class="text-right">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Update Kaffarah Setting
                    </button>

                    <!-- Update & Mark as Active Button -->
                    <button type="submit"
                        formaction="{{ route('metrix.compensation.update-and-activate', ['category' => 'kaffarah', 'id' => $setting['_id']]) }}"
                        class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                        Update & Mark as Active
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
