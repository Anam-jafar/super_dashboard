@extends('layouts.base')

@section('content')

<div class="max-w-full mx-auto p-4 sm:p-6 bg-gray-100">
    <div class="flex flex-wrap -mx-4">
        <h1 class="text-xl font-bold mb-4">Branches</h1>

        <!-- Filter and Search Card -->
        <div class="w-full mb-4 bg-white shadow-md rounded-lg p-4">
            <form method="GET" action="{{ route('showBranchList') }}" class="flex flex-wrap items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <!-- Name Search -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700">Search by Name</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Enter branch name" 
                           class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500">
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
                        <th class="border border-gray-300 px-4 py-2 text-left">Short Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Telephone</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">URL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $branch)
                        <tr class="cursor-pointer hover:bg-gray-100" onclick="openModal('{{ $branch->id }}')">
                            <td class="border border-gray-300 px-4 py-2">{{ $branch->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $branch->sname }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $branch->tel }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $branch->mel }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="{{ $branch->url }}" target="_blank" class="text-blue-500 hover:underline">
                                    {{ $branch->url }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="mt-4">
                {{ $branches->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="branchModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Branch Details</h3>
                <div>
                    <button onclick="refreshModal()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 mr-2">
                        Refresh
                    </button>
                    <button onclick="updateBranch()" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 mr-2">
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
                        <a class="bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700 font-semibold" onclick="changeTab(event, 'general')" href="#">General</a>
                    </li>
                    <li class="mr-1">
                        <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" onclick="changeTab(event, 'address')" href="#">Address</a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div id="tabContent">
                <!-- General Tab -->
                <div id="general" class="tab-content">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalName">Centre/Program:</label>
                        <input type="text" id="modalName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalSname">Singkatan:</label>
                        <input type="text" id="modalSname" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalSchcat">Kategori:</label>
                        <input type="text" id="modalSchcat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalTel">Telefon:</label>
                        <input type="tel" id="modalTel" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalMel">Emel:</label>
                        <input type="email" id="modalMel" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalUrl">Web:</label>
                        <input type="url" id="modalUrl" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
                
                <!-- Address Tab -->
                <div id="address" class="tab-content hidden">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalAddr">Alamat Baris 1:</label>
                        <input type="text" id="modalAddr" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalAddr2">Alamat Baris 2:</label>
                        <input type="text" id="modalAddr2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalAddr3">Alamat Baris 3:</label>
                        <input type="text" id="modalAddr3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalDaerah">Daerah:</label>
                        <input type="text" id="modalDaerah" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="modalPoskod">Poskod:</label>
                        <input type="text" id="modalPoskod" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
            </div>
        </div>
    </div>
</div>

<script>
let currentBranchData = null;

function openModal(branchId) {
    // Fetch branch data using AJAX
    fetch(`/api/branches/${branchId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(branch => {
            currentBranchData = branch;

            // Set the data in the modal
            document.getElementById('modalName').value = branch.name || '';
            document.getElementById('modalSname').value = branch.sname || '';
            document.getElementById('modalSchcat').value = branch.schcat || '';
            document.getElementById('modalTel').value = branch.tel || '';
            document.getElementById('modalMel').value = branch.mel || '';
            document.getElementById('modalUrl').value = branch.url || '';
            document.getElementById('modalAddr').value = branch.addr || '';
            document.getElementById('modalAddr2').value = branch.addr2 || '';
            document.getElementById('modalAddr3').value = branch.addr3 || '';
            document.getElementById('modalDaerah').value = branch.daerah || '';
            document.getElementById('modalPoskod').value = branch.poskod || '';
            document.getElementById('modalState').value = branch.state || '';
            document.getElementById('modalCountry').value = branch.country || '';

            // Show the modal
            document.getElementById('branchModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching branch data:', error);
            alert('Failed to fetch branch details. Please try again.');
        });
}

function closeModal() {
    document.getElementById('branchModal').classList.add('hidden');
    currentBranchData = null;
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
    if (currentBranchData && currentBranchData.id) {
        openModal(currentBranchData.id);
    }
}

function updateBranch() {
    if (!currentBranchData || !currentBranchData.id) {
        alert('No branch data to update.');
        return;
    }

    const updatedData = {
        name: document.getElementById('modalName').value,
        sname: document.getElementById('modalSname').value,
        schcat: document.getElementById('modalSchcat').value,
        tel: document.getElementById('modalTel').value,
        mel: document.getElementById('modalMel').value,
        url: document.getElementById('modalUrl').value,
        addr: document.getElementById('modalAddr').value,
        addr1: document.getElementById('modalAddr2').value,
        addr2: document.getElementById('modalAddr3').value,
        daerah: document.getElementById('modalDaerah').value,
        poskod: document.getElementById('modalPoskod').value,
        state: document.getElementById('modalState').value,
        country: document.getElementById('modalCountry').value
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/update/branches/${currentBranchData.id}`, {
    method: 'POST',
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
    alert('Branch data updated successfully!');
    currentBranchData = data;
    refreshModal();
})
.catch(error => {
    console.error('Error updating branch data:', error);
    alert(`Failed to update branch details. Error: ${error.message}`);
});

}

// Initialize the first tab as active
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.flex.border-b a').click();
});
</script>

@endsection