@extends('layouts.base')

@section('content')

<div class="max-w-full mx-auto p-4 sm:p-6 bg-gray-100">
    <div class="flex flex-wrap -mx-4">
        <h1 class="text-xl font-bold mb-4">Admins</h1>

        <!-- Filter and Search Card -->
        <div class="w-full mb-4 bg-white shadow-md rounded-lg p-4">
        <form method="GET" action="{{ route('showAdminList') }}" class="flex flex-wrap items-center space-y-4 sm:space-y-0 sm:space-x-4">
            <!-- Name Search -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700">Search by Name</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Enter admin name" 
                    class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500">
            </div>

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
                        <th class="border border-gray-300 px-4 py-2 text-left">IC</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">HP</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">JobDiv</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr class="cursor-pointer hover:bg-gray-100" data-id="{{ $admin->id }}" onclick="openModal('{{ $admin->id }}')">
                            <td class="border border-gray-300 px-4 py-2">{{ $admin->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $admin->ic }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $admin->hp }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $admin->mel }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $admin->jobdiv }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $admin->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>











<!-- Pagination Section -->
<div class="mt-4 flex justify-between items-center">
    <!-- Showing Records Info (Left Side) -->
    <div class="text-sm font-medium text-gray-700">
        Showing 
        {{ $admins->firstItem() }} - {{ $admins->lastItem() }} 
        from total {{ $admins->total() }}
    </div>

    <!-- Pagination Links and Records Per Page (Right Side) -->
    <div class="flex items-center space-x-4">
        <!-- Pagination Links (Prev and Next Buttons) -->
        <div class="flex items-center space-x-2">
            <!-- Prev Button -->
            @if ($admins->currentPage() > 1)
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
            @if ($admins->hasMorePages())
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
<div id="adminModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Admin Details</h3>
                <div>
                    <button onclick="refreshData()" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 mr-2">
                        Refresh
                    </button>
                    <button onclick="saveChanges()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Save
                    </button>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="mb-4">
                <ul class="flex border-b">
                    <li class="-mb-px mr-1">
                        <a class="bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700 font-semibold" onclick="changeTab(event, 'maklumat')" href="#">Maklumat System</a>
                    </li>
                    <li class="mr-1">
                        <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" onclick="changeTab(event, 'tab2')" href="#">Tab 2</a>
                    </li>
                    <li class="mr-1">
                        <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" onclick="changeTab(event, 'tab3')" href="#">Tab 3</a>
                    </li>
                    <li class="mr-1">
                        <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" onclick="changeTab(event, 'tab4')" href="#">Tab 4</a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div id="tabContent">
                <!-- Maklumat System Tab -->
                <div id="maklumat" class="tab-content">
                    <form id="editForm" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="syslevel" class="block text-sm font-medium text-gray-700">Level Sistem</label>
                                <input type="text" id="syslevel" name="syslevel" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="ic" class="block text-sm font-medium text-gray-700">Nombor KP</label>
                                <input type="text" id="ic" name="ic" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="sysaccess" class="block text-sm font-medium text-gray-700">Capaian Sistem</label>
                                <input type="text" id="sysaccess" name="sysaccess" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="hp" class="block text-sm font-medium text-gray-700">Tel. Bimbit</label>
                                <input type="text" id="hp" name="hp" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="jobstart" class="block text-sm font-medium text-gray-700">Tarikh Mula</label>
                                <input type="text" id="jobstart" name="jobstart" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="mel" class="block text-sm font-medium text-gray-700">Emel</label>
                                <input type="text" id="mel" name="mel" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <input type="text" id="status" name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Tab 2 -->
                <div id="tab2" class="tab-content hidden">
                    <h4 class="text-lg font-semibold mb-2">Tab 2 Content</h4>
                    <p>This is some dummy content for Tab 2. You can replace this with actual data or forms as needed.</p>
                </div>
                
                <!-- Tab 3 -->
                <div id="tab3" class="tab-content hidden">
                    <h4 class="text-lg font-semibold mb-2">Tab 3 Content</h4>
                    <p>Here's some placeholder text for Tab 3. Feel free to add any relevant information or functionality here.</p>
                </div>
                
                <!-- Tab 4 -->
                <div id="tab4" class="tab-content hidden">
                    <h4 class="text-lg font-semibold mb-2">Tab 4 Content</h4>
                    <p>This is the content area for Tab 4. You can customize this section with specific details or components as required.</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Close
                </button>
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
let currentAdminId = null;

function openModal(adminId) {
    currentAdminId = adminId;
    const modal = document.getElementById('adminModal');
    const form = document.getElementById('editForm');
    
    // Fetch admin data from the server
    fetch(`/getAdminDetails/${adminId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            // Set form values
            form.name.value = data.name || '';
            form.syslevel.value = data.syslevel || '';
            form.ic.value = data.ic || '';
            form.sysaccess.value = data.sysaccess || '';
            form.hp.value = data.hp || '';
            form.jobstart.value = data.jobstart || '';
            form.mel.value = data.mel || '';
            form.status.value = data.status || '';
            
            modal.classList.remove('hidden');
        })
        .catch(error => console.error('Error fetching admin details:', error));
}

function closeModal() {
    document.getElementById('adminModal').classList.add('hidden');
    currentAdminId = null;
}

function changeTab(event, tabName) {
    event.preventDefault();
    const tabContents = document.getElementsByClassName('tab-content');
    for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.add('hidden');
    }
    document.getElementById(tabName).classList.remove('hidden');
    
    const tabs = document.querySelectorAll('.flex.border-b a');
    tabs.forEach(tab => {
        tab.classList.remove('text-blue-700', 'border-l', 'border-t', 'border-r', 'rounded-t');
        tab.classList.add('text-blue-500', 'hover:text-blue-800');
    });
    event.target.classList.remove('text-blue-500', 'hover:text-blue-800');
    event.target.classList.add('text-blue-700', 'border-l', 'border-t', 'border-r', 'rounded-t');
}
function saveChanges() {
    const form = document.getElementById('editForm');
    const updatedData = {
        name: form.name.value,
        syslevel: form.syslevel.value,
        ic: form.ic.value,
        sysaccess: form.sysaccess.value,
        hp: form.hp.value,
        jobstart: form.jobstart.value,
        mel: form.mel.value,
        status: form.status.value
    };

    fetch(`/updateAdmin/${currentAdminId}`, {
        method: 'POST', // Use POST for updates or PATCH
        body: JSON.stringify(updatedData),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log(data); // Log data to ensure it's being returned properly
        alert('Changes saved successfully!');
        updateTableRow(data); // Update the row in the table with the new data
    })
    .catch(error => {
        console.error('Error saving changes:', error);
        alert('Failed to save changes!');
    });
}

function updateTableRow(data) {
    const row = document.querySelector(`tr[data-id="${data.id}"]`);
    if (row) {
        const cells = row.getElementsByTagName('td');
        cells[0].textContent = data.name;
        cells[1].textContent = data.ic;
        cells[2].textContent = data.hp;
        cells[3].textContent = data.mel;
        cells[4].textContent = data.jobdiv;
        cells[5].textContent = data.status;
    }
}




function refreshData() {
    if (currentAdminId) {
        openModal(currentAdminId);
    }
}


// Initialize the first tab as active
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.flex.border-b a').click();
});
</script>

@endsection