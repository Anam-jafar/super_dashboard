@extends('layouts.base')

@section('content')

<div class="max-w-full mx-auto p-4 sm:p-6 bg-gray-100">
    <div class="flex flex-wrap -mx-4">
        <h1 class="text-xl font-bold mb-4">Mosques</h1>

        <!-- Filter and Search Card -->
        <div class="w-full mb-4 bg-white shadow-md rounded-lg p-4">
            <form method="GET" action="{{ route('showEntityList') }}" class="flex flex-wrap items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <!-- Filter by School -->
                <div class="flex-1">
                    <label for="sch" class="block text-sm font-medium text-gray-700">Filter by Sch</label>
                    <select id="sch" name="sch" class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500">
                        <!-- Default "All" option -->
                        <option value="" {{ request('sch') == '' ? 'selected' : '' }}>All</option>
                        <!-- School options -->
                        @foreach ($schs as $sch)
                            <option value="{{ $sch->sid }}" {{ request('sch') == $sch->sid ? 'selected' : '' }}>
                                {{ $sch->sname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Name Search -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700">Search by Name</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Enter mosque name" 
                           class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500">
                </div>
                <!-- Status Filter -->
                <div class="flex-1">
                    <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status</label>
                    <select id="status" name="status" 
                            class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Active</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Inactive</option>
                        <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Terminated</option>
                        <option value="3" {{ request('status') === '3' ? 'selected' : '' }}>Reserved</option>
                    </select>
                </div>
                <!-- City Filter -->
                <div class="flex-1">
                    <label for="city" class="block text-sm font-medium text-gray-700">Filter by City</label>
                    <select id="city" name="city" 
                            class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Submit Button -->
                <div class="flex-none">
                    <label class="block text-sm font-medium text-transparent">Submit</label>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300">
                        Apply
                    </button>
                </div>
            </form>
        </div>

        <!-- Table to display data -->
        <div class="w-full overflow-x-auto bg-white shadow-md rounded-lg p-4">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Registration</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Category</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Mel</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Link</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Code</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">SID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Daerah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $mosque)
                        <tr class="cursor-pointer hover:bg-gray-100" onclick="openModal('{{ $mosque->id }}')">
                            <td class="border border-gray-300 px-4 py-2">{{ $mosque->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $mosque->regdt }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $mosque->sta }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $mosque->cate }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $mosque->mel }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $mosque->rem1 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $mosque->rem2 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $mosque->rem3 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $mosque->city }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="border border-gray-300 px-4 py-2 text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>



<!-- Pagination Section -->
<div class="mt-4 flex justify-between items-center">
    <!-- Showing Records Info (Left Side) -->
    <div class="text-sm font-medium text-gray-700">
        Showing 
        {{ $clients->firstItem() }} - {{ $clients->lastItem() }} 
        from total {{ $clients->total() }}
    </div>

    <!-- Pagination Links and Records Per Page (Right Side) -->
    <div class="flex items-center space-x-4">
        <!-- Pagination Links (Prev and Next Buttons) -->
        <div class="flex items-center space-x-2">
            <!-- Prev Button -->
            @if ($clients->currentPage() > 1)
                <a href="{{ $clients->previousPageUrl() }}" 
                   class="p-2 border border-gray-300 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Prev
                </a>
            @else
                <span class="p-2 border border-gray-300 rounded-md bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                    Prev
                </span>
            @endif

            <!-- Next Button -->
            @if ($clients->hasMorePages())
                <a href="{{ $clients->nextPageUrl() }}" 
                   class="p-2 border border-gray-300 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Next
                </a>
            @else
                <span class="p-2 border border-gray-300 rounded-md bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>

        <!-- Records Per Page Dropdown -->
        <div class="flex items-center space-x-2">
            <select id="recordsPerPage" name="recordsPerPage" 
                    onchange="updatePagination(this.value)" 
                    class="p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="25" {{ request('recordsPerPage') == 25 ? 'selected' : '' }}>25/Ms</option>
                <option value="50" {{ request('recordsPerPage') == 50 ? 'selected' : '' }}>50/Ms</option>
                <option value="100" {{ request('recordsPerPage') == 100 ? 'selected' : '' }}>100/Ms</option>
                <option value="200" {{ request('recordsPerPage') == 200 ? 'selected' : '' }}>200/Ms</option>
            </select>
        </div>
    </div>
</div>



        </div>
    </div>
</div>

<!-- Modal -->
<div id="mosqueModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-40 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Mosque Details</h3>
                <div>
                    <button onclick="refreshModal()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 mr-2">
                        Refresh
                    </button>
                    <button onclick="updateMosque()" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 mr-2">
                        Update
                    </button>
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Close
                    </button>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="mb-4">
                <ul class="flex border-b">
                    <li class="-mb-px mr-1">
                        <a class="bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700 font-semibold" onclick="changeTab(event, 'profile')" href="#">Profil</a>
                    </li>
                    <li class="mr-1">
                        <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" onclick="changeTab(event, 'alamat')" href="#">Alamat</a>
                    </li>
                    <li class="mr-1">
                        <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" onclick="changeTab(event, 'additionalInfo')" href="#">Maklumat Tambahan</a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div id="tabContent">
                <!-- Profil Tab -->
                <div id="profile" class="tab-content">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalName">Mosque Name:</label>
                        <input type="text" id="modalName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalContact">Mosque Contact Utama:</label>
                        <input type="text" id="modalContact" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalCategory">Kategori:</label>
                        <input type="text" id="modalCategory" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalGroup">Kumpulan:</label>
                        <input type="text" id="modalGroup" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalStatus">Status:</label>
                        <input type="text" id="modalStatus" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalEmail">Emel:</label>
                        <input type="email" id="modalEmail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalPhone">Tel. Bimbit:</label>
                        <input type="tel" id="modalPhone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
                
                <!-- Alamat Tab -->
                <div id="alamat" class="tab-content hidden">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalAddress1">Alamat Baris 1:</label>
                        <input type="text" id="modalAddress1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalAddress2">Alamat Baris 2:</label>
                        <input type="text" id="modalAddress2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalAddress3">Alamat Baris 3:</label>
                        <input type="text" id="modalAddress3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalPcode">Poskod:</label>
                        <input type="text" id="modalPcode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalCity">Bandar:</label>
                        <input type="text" id="modalCity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalState">Negeri:</label>
                        <input type="text" id="modalState" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalCountry">Negara:</label>
                        <input type="text" id="modalCountry" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
<!-- Maklumat Tambahan Tab -->
<div id="additionalInfo" class="tab-content hidden">
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalCustomerLink">CUSTOMER LINK:</label>
        <input type="text" id="modalCustomerLink" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalAppCode">DIRECTORY / APPCODE:</label>
        <input type="text" id="modalAppCode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalCenterId">CENTER ID:</label>
        <input type="text" id="modalCenterId" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
</div>

            </div>
        </div>
    </div>
</div>

<script>

function updatePagination(recordsPerPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('recordsPerPage', recordsPerPage);
        url.searchParams.set('page', 1); // Reset to the first page when the number of records changes
        window.location.href = url.toString();
    }
let currentMosqueData = null;

function openModal(mosqueId) {
    // Fetch mosque data using AJAX
    fetch(`/api/mosques/${mosqueId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(mosque => {
            currentMosqueData = mosque;

            // Set the data in the modal
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


            // Show the modal
            document.getElementById('mosqueModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching mosque data:', error);
            alert('Failed to fetch mosque details. Please try again.');
        });
}

function closeModal() {
    document.getElementById('mosqueModal').classList.add('hidden');
    currentMosqueData = null;
}

function changeTab(event, tabName) {
    event.preventDefault();

    // Hide all tab contents
    const tabContents = document.getElementsByClassName('tab-content');
    for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.add('hidden');
    }

    // Show the selected tab content
    document.getElementById(tabName).classList.remove('hidden');

    // Update active tab styling
    const tabs = document.querySelectorAll('.flex.border-b a');
    tabs.forEach(tab => {
        tab.classList.remove('text-blue-700', 'border-l', 'border-t', 'border-r', 'rounded-t');
        tab.classList.add('text-blue-500', 'hover:text-blue-800');
    });
    event.target.classList.remove('text-blue-500', 'hover:text-blue-800');
    event.target.classList.add('text-blue-700', 'border-l', 'border-t', 'border-r', 'rounded-t');
}

function refreshModal() {
    if (currentMosqueData && currentMosqueData.id) {
        openModal(currentMosqueData.id);
    }
}

function updateMosque() {
    if (!currentMosqueData || !currentMosqueData.id) {
        alert('No mosque data to update.');
        return;
    }

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

    fetch(`/update/mosques/${currentMosqueData.id}`, {
        method: 'PUT',
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
        alert('Mosque data updated successfully!');
        currentMosqueData = data;
        refreshModal();
    })
    .catch(error => {
        console.error('Error updating mosque data:', error);
        alert(`Failed to update mosque details. Error: ${error.message}`);
    });
}





// Initialize the first tab as active
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.flex.border-b a').click();
});
</script>

@endsection

