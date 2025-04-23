@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Edit Kaffarah Setting'" :breadcrumbs="[['label' => 'Kaffarah', 'url' => 'javascript:void(0);'], ['label' => 'Edit Setting']]" />

      <form action="{{ route('metrix.compensation.update', ['type' => 'kaffarah', 'id' => $setting['_id']]) }}"
        method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="space-y-2">
          <label for="title" class="block text-sm font-medium text-gray-900">Title</label>
          <input type="text" name="title" id="title" value="{{ $setting['title'] }}" required
            class="block w-96 rounded-md border-gray-300 px-3 py-2 shadow-sm transition duration-150 ease-in-out focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Enter the title">
        </div>

        <!-- Offense Types -->
        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-900">Offense Types</label>
          <div class="flex w-full gap-4">
            <div id="offense_types" class="w-1/2 space-y-3">
              @foreach ($setting['offense_type'] as $index => $offense)
                <div class="flex gap-4">
                  <input type="text" name="offense_type[{{ $index }}][parameter]"
                    value="{{ $offense['parameter'] }}" placeholder="Offense Description" required
                    class="flex-1 rounded-md border-gray-300 px-3 py-2 shadow-sm transition duration-150 ease-in-out focus:border-indigo-500 focus:ring-indigo-500">
                  <input type="number" name="offense_type[{{ $index }}][value]" value="{{ $offense['value'] }}"
                    placeholder="Value" required readonly
                    class="border-black-900 w-32 rounded-md bg-gray-200 px-3 py-2 text-gray-500 shadow-sm transition duration-150 ease-in-out focus:border-indigo-500 focus:ring-indigo-500">

                </div>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Kaffarah Items -->
        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-900">Kaffarah Items</label>
          <div class="flex w-full gap-4">
            <div id="kaffarah_items" class="w-1/2 space-y-3">
              @foreach ($setting['kaffarah_item'] as $index => $item)
                <div class="flex gap-4">
                  <input type="text" name="kaffarah_item[{{ $index }}][name]" value="{{ $item['name'] }}"
                    placeholder="Item Name" required
                    class="flex-1 rounded-md border-gray-300 px-3 py-2 shadow-sm transition duration-150 ease-in-out focus:border-indigo-500 focus:ring-indigo-500">
                  <input type="number" name="kaffarah_item[{{ $index }}][price]" value="{{ $item['price'] }}"
                    placeholder="Price" required readonly
                    class="w-32 rounded-md border-gray-300 bg-gray-200 px-3 py-2 text-gray-500 shadow-sm transition duration-150 ease-in-out focus:border-indigo-500 focus:ring-indigo-500">
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Rate -->
        <div class="space-y-2">
          <label for="rate" class="block text-sm font-medium text-gray-900">Rate</label>
          <input type="number" name="rate" id="rate" value="{{ $setting['rate'] }}" step="0.01" required
            readonly
            class="block w-96 rounded-md border-gray-300 bg-gray-200 px-3 py-2 text-gray-500 shadow-sm transition duration-150 ease-in-out focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Enter the rate">

        </div>

        <!-- Submit Button to Update Kaffarah Setting -->
        <div class="text-right">
          <button type="submit"
            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition duration-150 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Update Kaffarah Setting
          </button>

          <!-- Update & Mark as Active Button -->
          <button type="submit"
            formaction="{{ route('metrix.compensation.update-and-activate', ['type' => 'kaffarah', 'id' => $setting['_id']]) }}"
            class="inline-flex justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition duration-150 ease-in-out hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
            Update & Mark as Active
          </button>
        </div>

      </form>
    </div>
  </div>
@endsection
