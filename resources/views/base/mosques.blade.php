@extends('layouts.base')

@section('content')
<div class="max-w-full mx-auto p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Mosques Management</h1>

    <!-- Filter and Search Card -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <form method="GET" action="{{ route('showEntityList') }}" class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:items-end md:-mx-2">
            <div class="md:w-1/5 md:px-2 mb-4 md:mb-0">
                <label for="sch" class="block text-sm font-medium text-gray-700 mb-1">Filter by School</label>
                <select id="sch" name="sch" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="" {{ request('sch') == '' ? 'selected' : '' }}>All Schools</option>
                    @foreach ($schs as $sch)
                        <option value="{{ $sch->sid }}" {{ request('sch') == $sch->sid ? 'selected' : '' }}>
                            {{ $sch->sname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:w-1/5 md:px-2 mb-4 md:mb-0">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Name</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Enter mosque name" 
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="md:w-1/5 md:px-2 mb-4 md:mb-0">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                <select id="status" name="status" 
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">All Statuses</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Active</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Inactive</option>
                    <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Terminated</option>
                    <option value="3" {{ request('status') === '3' ? 'selected' : '' }}>Reserved</option>
                </select>
            </div>
            <div class="md:w-1/5 md:px-2 mb-4 md:mb-0">
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Filter by City</label>
                <select id="city" name="city" 
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">All Cities</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:w-1/5 md:px-2 flex items-end justify-between">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Apply Filters
                </button>
                <button type="button" onclick="openModal()" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Add New
                </button>
            </div>
        </form>
    </div>

    <!-- Table to display data -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">District</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($clients as $key => $mosque)
                    <tr class="hover:bg-gray-50 cursor-pointer" onclick="openModal('{{ $mosque->id }}')">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ($clients->currentPage() - 1) * $clients->perPage() + $key + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $mosque->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mosque->regdt }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $mosque->sta == 0 ? 'bg-green-100 text-green-800' : 
                                   ($mosque->sta == 1 ? 'bg-yellow-100 text-yellow-800' : 
                                   ($mosque->sta == 2 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ $statuses->firstWhere('val', $mosque->sta)?->prm ?? 'Unknown' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mosque->cate }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mosque->mel }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mosque->rem1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mosque->rem2 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mosque->rem3 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mosque->city }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Section -->
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-4">
        <div class="flex-1 flex justify-between sm:hidden">
            @if ($clients->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $clients->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
            @endif
            @if ($clients->hasMorePages())
                <a href="{{ $clients->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ $clients->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $clients->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $clients->total() }}</span>
                    results
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    @if ($clients->onFirstPage())
                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $clients->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                    
                    @if ($clients->hasMorePages())
                        <a href="{{ $clients->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </nav>
                <div class="flex items-center space-x-2">
                    <label for="perPage" class="text-sm font-medium text-gray-700">Per Page:</label>
                    <select id="perPage" name="perPage" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="updatePagination(this.value)">
                        <option value="25" {{ request('perPage', 25) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                        <option value="200" {{ request('perPage') == 200 ? 'selected' : '' }}>200</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="mosqueModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" x-data="{ activeTab: 'profile' }">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-xl font-medium text-gray-900" id="modalTitle">Mosque Details</h3>
                <div class="flex items-center space-x-2">
                    <button @click="refreshModal()" class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Refresh
                    </button>
                    <button @click="updateMosque()" class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Save
                    </button>
                    <button @click="closeModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex" aria-label="Tabs">
                    <button @click="activeTab = 'profile'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'profile'}" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm" :aria-selected="activeTab === 'profile'">
                        Profile
                    </button>
                    <button @click="activeTab = 'address'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'address'}" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm" :aria-selected="activeTab === 'address'">
                        Address
                    </button>
                    <button @click="activeTab = 'additional'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'additional'}" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm" :aria-selected="activeTab === 'additional'">
                        Additional Info
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="mt-4">
                <!-- Profile Tab -->
                <div x-show="activeTab === 'profile'">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="modalName" class="block text-sm font-medium text-gray-700">Mosque Name</label>
                            <input type="text" id="modalName" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalContact" class="block text-sm font-medium text-gray-700">Primary Contact</label>
                            <input type="text" id="modalContact" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalCategory" class="block text-sm font-medium text-gray-700">Category</label>
                            <select id="modalCategory" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach($categories as $category)
                                    <option value="{{ $category->prm }}">{{ $category->prm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="modalGroup" class="block text-sm font-medium text-gray-700">Group</label>
                            <select id="modalGroup" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach($areas as $area)
                                    <option value="{{ $area->prm }}">{{ $area->prm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="modalStatus" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="modalStatus" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->val }}">{{ $status->prm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="modalEmail" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="modalEmail" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalPhone" class="block text-sm font-medium text-gray-700">Mobile Phone</label>
                            <input type="tel" id="modalPhone" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>
                
                <!-- Address Tab -->
                <div x-show="activeTab === 'address'">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="modalAddress1" class="block text-sm font-medium text-gray-700">Address Line 1</label>
                            <input type="text" id="modalAddress1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalAddress2" class="block text-sm font-medium text-gray-700">Address Line 2</label>
                            <input type="text" id="modalAddress2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalAddress3" class="block text-sm font-medium text-gray-700">Address Line 3</label>
                            <input type="text" id="modalAddress3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalPcode" class="block text-sm font-medium text-gray-700">Postal Code</label>
                            <input type="text" id="modalPcode" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalCity" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" id="modalCity" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalState" class="block text-sm font-medium text-gray-700">State</label>
                            <select id="modalState" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach($states as $state)
                                    <option value="{{ $state->prm }}">{{ $state->prm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="modalCountry" class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" id="modalCountry" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>
                
                <!-- Additional Info Tab -->
                <div x-show="activeTab === 'additional'">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="modalCustomerLink" class="block text-sm font-medium text-gray-700">Customer Link</label>
                            <input type="text" id="modalCustomerLink" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalAppCode" class="block text-sm font-medium text-gray-700">Directory / App Code</label>
                            <input type="text" id="modalAppCode" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="modalCenterId" class="block text-sm font-medium text-gray-700">Center ID</label>
                            <input type="text" id="modalCenterId" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentMosqueData = null;

function openModal(mosqueId = null) {
    if (mosqueId === null) {
        currentMosqueData = null;
        clearModalFields();
        document.getElementById('mosqueModal').classList.remove('hidden');
        return;
    }

    fetch(`/api/mosques/${mosqueId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(mosque => {
            currentMosqueData = mosque;
            populateModalFields(mosque);
            document.getElementById('mosqueModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching mosque data:', error);
            alert('Failed to fetch mosque details. Please try again.');
        });
}

function clearModalFields() {
    const fields = ['Name', 'Contact', 'Category', 'Group', 'Status', 'Email', 'Phone', 
                    'Address1', 'Address2', 'Address3', 'Pcode', 'City', 'State', 'Country',
                    'CustomerLink', 'AppCode', 'CenterId'];
    fields.forEach(field => {
        document.getElementById(`modal${field}`).value = '';
    });
}

function populateModalFields(mosque) {
    document.getElementById('modalName').value = mosque.name || '';
    document.getElementById('modalContact').value = mosque.con1 || '';
    document.getElementById('modalCategory').value = mosque.cate || '';
    document.getElementById('modalGroup').value = mosque.cate1 || '';
    document.getElementById('modalStatus').value = mosque.sta || '';
    document.getElementById('modalEmail').value = mosque.mel || '';
    document.getElementById('modalPhone').value = mosque.hp || '';
    document.getElementById('modalAddress1').value = mosque.addr || '';
    document.getElementById('modalAddress2').value = mosque.addr1 || '';
    document.getElementById('modalAddress3').value = mosque.addr2 || '';
    document.getElementById('modalPcode').value = mosque.pcode || '';
    document.getElementById('modalCity').value = mosque.city || '';
    document.getElementById('modalState').value = mosque.state || '';
    document.getElementById('modalCountry').value = mosque.country || '';
    document.getElementById('modalCustomerLink').value = mosque.rem1 || '';
    document.getElementById('modalAppCode').value = mosque.rem2 || '';
    document.getElementById('modalCenterId').value = mosque.rem3 || '';
}

function closeModal() {
    document.getElementById('mosqueModal').classList.add('hidden');
    currentMosqueData = null;
}

function refreshModal() {
    if (currentMosqueData && currentMosqueData.id) {
        openModal(currentMosqueData.id);
    }
}

function updateMosque() {
    const updatedData = {
        name: document.getElementById('modalName').value,
        con1: document.getElementById('modalContact').value,
        cate: document.getElementById('modalCategory').value,
        cate1: document.getElementById('modalGroup').value,
        sta: document.getElementById('modalStatus').value,
        mel: document.getElementById('modalEmail').value,
        hp: document.getElementById('modalPhone').value,
        addr: document.getElementById('modalAddress1').value,
        addr1: document.getElementById('modalAddress2').value,
        addr2: document.getElementById('modalAddress3').value,
        pcode: document.getElementById('modalPcode').value,
        city: document.getElementById('modalCity').value,
        state: document.getElementById('modalState').value,
        country: document.getElementById('modalCountry').value,
        rem1: document.getElementById('modalCustomerLink').value,
        rem2: document.getElementById('modalAppCode').value,
        rem3: document.getElementById('modalCenterId').value
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = currentMosqueData ? `/update/mosques/${currentMosqueData.id}` : '/add/mosques/';
    const method = currentMosqueData ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(updatedData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(JSON.stringify(err));
            });
        }
        return response.json();
    })
    .then(data => {
        alert(currentMosqueData ? 'Mosque data updated successfully!' : 'New mosque created successfully!');
        currentMosqueData = data;
        closeModal();
        location.reload();
    })
    .catch(error => {
        console.error('Error updating/creating mosque data:', error);
        alert(`Failed to update/create mosque details. Error: ${error.message}`);
    });
}

function updatePagination(perPage) {
    const url = new URL(window.location.href);
    url.searchParams.set('perPage', perPage);
    url.searchParams.set('page', 1); // Reset to the first page when changing items per page
    window.location.href = url.toString();
}

document.addEventListener('DOMContentLoaded', function() {
    const perPageSelect = document.getElementById('perPage');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            updatePagination(this.value);
        });
    }
});
</script>

@endsection