@extends('layouts.app')

@section('styles')
  

@endsection

@section('content')

<div class="main-content app-content">
<div class="container-fluid">
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Branches</h1>

    <x-filter-card 
        :filters="[
            ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Enter name'],
        ]"
        :route="route('showBranchList')"
        button-label="Apply Filters"
    />

    <!-- Table to display data -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <x-table 
        :headers="['Name', 'Short Name', 'Telephone', 'Email', 'URL']" 
        :columns="['name', 'sname', 'tel', 'mel', 'url']"
        :rows="$branches" 
    />

        <x-pagination :items="$branches" label="branches" />

    </div>
</div>

<!-- Modal -->
<div id="branchModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Branch Details</h3>
                <div class="flex space-x-2">
                    <button onclick="refreshModal()" class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        Refresh
                    </button>
                    <button onclick="updateBranch()" class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                        Update
                    </button>
                    <button onclick="closeModal()" class="px-3 py-1 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Close
                    </button>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="general-tab" onclick="changeTab(event, 'general')" type="button" role="tab" aria-controls="general" aria-selected="true">General</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="address-tab" onclick="changeTab(event, 'address')" type="button" role="tab" aria-controls="address" aria-selected="false">Address</button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div id="tabContent">
                <!-- General Tab -->
                <div id="general" class="tab-content">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="modalName" class="block text-sm font-medium text-gray-700">Centre/Program</label>
                            <input type="text" id="modalName" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalSname" class="block text-sm font-medium text-gray-700">Singkatan</label>
                            <input type="text" id="modalSname" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalSchcat" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <input type="text" id="modalSchcat" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalTel" class="block text-sm font-medium text-gray-700">Telefon</label>
                            <input type="tel" id="modalTel" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalMel" class="block text-sm font-medium text-gray-700">Emel</label>
                            <input type="email" id="modalMel" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalUrl" class="block text-sm font-medium text-gray-700">Web</label>
                            <input type="url" id="modalUrl" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>
                
                <!-- Address Tab -->
                <div id="address" class="tab-content hidden">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="modalAddr" class="block text-sm font-medium text-gray-700">Alamat Baris 1</label>
                            <input type="text" id="modalAddr" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="modalAddr2" class="block text-sm font-medium text-gray-700">Alamat Baris 2</label>
                            <input type="text" id="modalAddr2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="modalAddr3" class="block text-sm font-medium text-gray-700">Alamat Baris 3</label>
                            <input type="text" id="modalAddr3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalDaerah" class="block text-sm font-medium text-gray-700">Daerah</label>
                            <input type="text" id="modalDaerah" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalPoskod" class="block text-sm font-medium text-gray-700">Poskod</label>
                            <input type="text" id="modalPoskod" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalState" class="block text-sm font-medium text-gray-700">Negeri</label>
                            <input type="text" id="modalState" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalCountry" class="block text-sm font-medium text-gray-700">Negara</label>
                            <input type="text" id="modalCountry" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
<script src="{{ asset('js/branchHandler.js') }}"></script>

@endsection