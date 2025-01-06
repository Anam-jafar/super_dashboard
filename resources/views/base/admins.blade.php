@extends('layouts.app')

@section('styles')
  

@endsection

@section('content')

<div class="main-content app-content">
<div class="container-fluid">
<div class="max-w-full mx-auto p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Admins</h1>

    <!-- Filter and Search Card -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <form method="GET" action="{{ route('showAdminList') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:space-x-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Name</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Enter admin name" 
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <div class="flex-1">
                <label for="sch" class="block text-sm font-medium text-gray-700 mb-1">Filter by School</label>
                <select id="sch" name="sch" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="" {{ request('sch') == '' ? 'selected' : '' }}>All Schools</option>
                    @foreach ($schs as $sch)
                        <option value="{{ $sch->sid }}" {{ request('sch') == $sch->sid ? 'selected' : '' }}>
                            {{ $sch->sname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Admin Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">

        <x-table 
        :headers="['Name', 'IC', 'HP', 'Email', 'JobDiv', 'Status']" 
        :columns="['name', 'ic', 'hp', 'mel', 'jobdiv', 'status']"
        :rows="$admins" 
        :statuses="$statuses" 
    />

        <x-pagination :items="$admins" label="Admin" />

    </div>
</div>

<!-- Modal -->
<div id="adminModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" x-data="{ activeTab: 'maklumat' }">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-semibold text-gray-900">Admin Details</h3>
                <div>
                    <button onclick="refreshData()" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 mr-2 transition">
                        Refresh
                    </button>
                    <button onclick="saveChanges()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                        Save
                    </button>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px">
                    <li class="mr-2">
                        <a class="inline-block p-4 rounded-t-lg" :class="{ 'text-blue-600 border-b-2 border-blue-600': activeTab === 'maklumat', 'hover:text-gray-600 hover:border-gray-300': activeTab !== 'maklumat' }" @click.prevent="activeTab = 'maklumat'" href="#">Maklumat System</a>
                    </li>
                    <li class="mr-2">
                        <a class="inline-block p-4 rounded-t-lg" :class="{ 'text-blue-600 border-b-2 border-blue-600': activeTab === 'tab2', 'hover:text-gray-600 hover:border-gray-300': activeTab !== 'tab2' }" @click.prevent="activeTab = 'tab2'" href="#">Tab 2</a>
                    </li>
                    <li class="mr-2">
                        <a class="inline-block p-4 rounded-t-lg" :class="{ 'text-blue-600 border-b-2 border-blue-600': activeTab === 'tab3', 'hover:text-gray-600 hover:border-gray-300': activeTab !== 'tab3' }" @click.prevent="activeTab = 'tab3'" href="#">Tab 3</a>
                    </li>
                    <li class="mr-2">
                        <a class="inline-block p-4 rounded-t-lg" :class="{ 'text-blue-600 border-b-2 border-blue-600': activeTab === 'tab4', 'hover:text-gray-600 hover:border-gray-300': activeTab !== 'tab4' }" @click.prevent="activeTab = 'tab4'" href="#">Tab 4</a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div id="tabContent">
                <!-- Maklumat System Tab -->
                <div id="maklumat" x-show="activeTab === 'maklumat'">
                    <form id="editForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="syslevel" class="block text-sm font-medium text-gray-700">Level Sistem</label>
                                <select id="syslevel" name="syslevel" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @foreach($syslevels as $syslevel)
                                        <option value="{{ $syslevel->prm }}">{{ $syslevel->prm }}</option>
                                    @endforeach
                                </select>
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
                                <input type="date" id="jobstart" name="jobstart" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="mel" class="block text-sm font-medium text-gray-700">Emel</label>
                                <input type="email" id="mel" name="mel" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->val }}">{{ $status->prm }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Tab 2 -->
                <div id="tab2" x-show="activeTab === 'tab2'" class="hidden">
                    <h4 class="text-lg font-semibold mb-2">Tab 2 Content</h4>
                    <p>This is some dummy content for Tab 2. You can replace this with actual data or forms as needed.</p>
                </div>
                
                <!-- Tab 3 -->
                <div id="tab3" x-show="activeTab === 'tab3'" class="hidden">
                    <h4 class="text-lg font-semibold mb-2">Tab 3 Content</h4>
                    <p>Here's some placeholder text for Tab 3. Feel free to add any relevant information or functionality here.</p>
                </div>
                
                <!-- Tab 4 -->
                <div id="tab4" x-show="activeTab === 'tab4'" class="hidden">
                    <h4 class="text-lg font-semibold mb-2">Tab 4 Content</h4>
                    <p>This is the content area for Tab 4. You can customize this section with specific details or components as required.</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition">
                    Close
                </button>
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

let currentAdminId = null;

function openModal(adminId) {
    currentAdminId = adminId;
    const modal = document.getElementById('adminModal');
    const form = document.getElementById('editForm');
    
    // Fetch admin data from the server
    fetch(`/mais/getAdminDetails/${adminId}`)
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

    fetch(`/mais/updateAdmin/${currentAdminId}`, {
        method: 'POST',
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
        console.log(data);
        alert('Changes saved successfully!');
        updateTableRow(data);
        closeModal();
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
        cells[1].textContent = data.name;
        cells[2].textContent = data.ic;
        cells[3].textContent = data.hp;
        cells[4].textContent = data.mel;
        cells[5].textContent = data.jobdiv;
        
        const statusCell = cells[6];
        const statusText = document.querySelector(`option[value="${data.status}"]`).textContent;
        const statusColor = getStatusColor(data.status);
        statusCell.innerHTML = `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColor}">${statusText}</span>`;
    }
}


function refreshData() {
    if (currentAdminId) {
        openModal(currentAdminId);
    }
}

document.addEventListener('alpine:init', () => {
    Alpine.data('adminModal', () => ({
        activeTab: 'maklumat',
        changeTab(tabName) {
            this.activeTab = tabName;
        }
    }));
});
</script>

@endsection