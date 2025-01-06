@extends('layouts.app')

@section('styles')
  

@endsection

@section('content')

<div class="main-content app-content">
<div class="container-fluid">
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Branches</h1>

    <!-- Filter and Search Card -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <form method="GET" action="{{ route('showBranchList') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:space-x-4">
            <div class="flex-grow">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Name</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Enter branch name" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Table to display data -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Short Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telephone</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($branches as $key => $branch)
                    <tr class="hover:bg-gray-50 cursor-pointer" onclick="openModal('{{ $branch->id }}')">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ($branches->currentPage() - 1) * $branches->perPage() + $key + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $branch->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $branch->sname }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $branch->tel }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $branch->mel }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="{{ $branch->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                {{ $branch->url }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

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

<script>
function updatePagination(recordsPerPage) {
    const url = new URL(window.location.href);
    url.searchParams.set('recordsPerPage', recordsPerPage);
    url.searchParams.set('page', 1); // Reset to the first page when the number of records changes
    window.location.href = url.toString();
}

let currentBranchData = null;

function openModal(branchId) {
    fetch(`/mais/get_branche_detail/${branchId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(branch => {
            currentBranchData = branch;
            setModalData(branch);
            document.getElementById('branchModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching branch data:', error);
            alert('Failed to fetch branch details. Please try again.');
        });
}

function setModalData(branch) {
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
}

function closeModal() {
    document.getElementById('branchModal').classList.add('hidden');
    currentBranchData = null;
}

function changeTab(event, tabName) {
    event.preventDefault();
    const tabContents = document.getElementsByClassName('tab-content');
    Array.from(tabContents).forEach(content => content.classList.add('hidden'));
    document.getElementById(tabName).classList.remove('hidden');

    const tabs = document.querySelectorAll('[role="tab"]');
    tabs.forEach(tab => {
        tab.setAttribute('aria-selected', 'false');
        tab.classList.remove('text-indigo-600', 'border-indigo-600');
        tab.classList.add('text-gray-500', 'border-transparent');
    });
    event.currentTarget.setAttribute('aria-selected', 'true');
    event.currentTarget.classList.remove('text-gray-500', 'border-transparent');
    event.currentTarget.classList.add('text-indigo-600', 'border-indigo-600');
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
        addr2: document.getElementById('modalAddr2').value,
        addr3: document.getElementById('modalAddr3').value,
        daerah: document.getElementById('modalDaerah').value,
        poskod: document.getElementById('modalPoskod').value,
        state: document.getElementById('modalState').value,
        country: document.getElementById('modalCountry').value
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/mais/update/branches/${currentBranchData.id}`, {
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

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('general-tab').click();
});
</script>

@endsection