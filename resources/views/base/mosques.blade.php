@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Mosques</h1>

                <button type="button" onclick="openModal()"
                    class="mb-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Add New
                </button>

                <x-filter-card :filters="[
                    ['name' => 'sch', 'label' => 'Filter by Sch', 'type' => 'select', 'options' => $schs],
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Enter name'],
                    [
                        'name' => 'status',
                        'label' => 'Filter by Status',
                        'type' => 'select',
                        'options' => ['0' => 'Active', '1' => 'Inactive', '2' => 'Terminated', '3' => 'Reserved'],
                    ],
                    ['name' => 'city', 'label' => 'Filter by City', 'type' => 'select', 'options' => $cities],
                ]" :route="route('showEntityList')" button-label="Apply Filters" />

                <!-- Table to display data -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <x-table :headers="['Name', 'Status', 'Category', 'Link', 'Code', 'SID', 'District']" :columns="['name', 'sta', 'cate', 'rem1', 'rem2', 'rem3', 'city']" :rows="$clients" :statuses="$statuses" />

                    <x-pagination :items="$clients" label="mosques" />
                </div>
            </div>

            <!-- Modal -->
            <div id="mosqueModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden"
                aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center pb-3">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Mosque Details</h3>
                            <div class="flex space-x-2">
                                <button onclick="refreshModal()"
                                    class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                    Refresh
                                </button>
                                <button onclick="updateMosque()"
                                    class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                                    Update
                                </button>
                                <button onclick="closeModal()"
                                    class="px-3 py-1 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Close
                                </button>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="mb-4 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px" role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 border-indigo-500 text-indigo-600 rounded-t-lg"
                                        id="profile-tab" onclick="changeTab(event, 'profile')" type="button" role="tab"
                                        aria-controls="profile" aria-selected="true">
                                        Profile
                                    </button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="address-tab" onclick="changeTab(event, 'address')" type="button" role="tab"
                                        aria-controls="address" aria-selected="false">
                                        Address
                                    </button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="additional-tab" onclick="changeTab(event, 'additional')" type="button"
                                        role="tab" aria-controls="additional" aria-selected="false">
                                        Additional Info
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div id="tabContent">
                            <!-- Profile Tab -->
                            <div id="profile" class="tab-content">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label for="modalName" class="block text-sm font-medium text-gray-700">Mosque
                                            Name</label>
                                        <input type="text" id="modalName"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="modalContact" class="block text-sm font-medium text-gray-700">Primary
                                            Contact</label>
                                        <input type="text" id="modalContact"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="modalCategory"
                                            class="block text-sm font-medium text-gray-700">Category</label>
                                        <select id="modalCategory"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->prm }}">{{ $category->prm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="modalStatus"
                                            class="block text-sm font-medium text-gray-700">Status</label>
                                        <select id="modalStatus"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->val }}">{{ $status->prm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="modalGroup"
                                            class="block text-sm font-medium text-gray-700">Group</label>
                                        <select id="modalGroup"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->prm }}">{{ $area->prm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="modalEmail"
                                            class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" id="modalEmail"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="modalPhone" class="block text-sm font-medium text-gray-700">Mobile
                                            Phone</label>
                                        <input type="tel" id="modalPhone"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>

                            <!-- Address Tab -->
                            <div id="address" class="tab-content hidden">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="modalAddress1" class="block text-sm font-medium text-gray-700">Address
                                            Line 1</label>
                                        <input type="text" id="modalAddress1"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="modalAddress2" class="block text-sm font-medium text-gray-700">Address
                                            Line 2</label>
                                        <input type="text" id="modalAddress2"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="modalAddress3" class="block text-sm font-medium text-gray-700">Address
                                            Line 3</label>
                                        <input type="text" id="modalAddress3"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="modalCity"
                                            class="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" id="modalCity"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="modalPcode" class="block text-sm font-medium text-gray-700">Postal
                                            Code</label>
                                        <input type="text" id="modalPcode"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="modalState"
                                            class="block text-sm font-medium text-gray-700">State</label>
                                        <select id="modalState"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            @foreach ($states as $state)
                                                <option value="{{ $state->prm }}">{{ $state->prm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="modalCountry"
                                            class="block text-sm font-medium text-gray-700">Country</label>
                                        <input type="text" id="modalCountry"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info Tab -->
                            <div id="additional" class="tab-content hidden">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label for="modalCustomerLink"
                                            class="block text-sm font-medium text-gray-700">Customer Link</label>
                                        <input type="text" id="modalCustomerLink"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="modalAppCode"
                                            class="block text-sm font-medium text-gray-700">Directory / App Code</label>
                                        <input type="text" id="modalAppCode"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="modalCenterId" class="block text-sm font-medium text-gray-700">Center
                                            ID</label>
                                        <input type="text" id="modalCenterId"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/modalHandler.js') }}"></script>
    <script src="{{ asset('js/mosqueHandler.js') }}"></script>
@endsection
