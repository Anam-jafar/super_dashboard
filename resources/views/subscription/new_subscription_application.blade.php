@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Permohonan Langganan Baru'" :breadcrumbs="[['label' => 'Langganan SPM', 'url' => 'javascript:void(0);'], ['label' => 'Permohonan Baru']]" />
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    [
                        'name' => 'institute_type',
                        'label' => 'Semua Institusi',
                        'type' => 'select',
                        'options' => $instituteType,
                    ],
                    ['name' => 'area', 'label' => 'Semua Daerah', 'type' => 'select', 'options' => $daerah],
                
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('requestSubscriptions')" />

                <x-table :headers="['Tarikh Mohon', 'Institusi', 'Nama Institusi', 'Daerah', 'Status']" :columns="['rem6', 'etc', 'name', 'cate1', 'subscription_status']" :id="'id'" :rows="$subscriptions" :statuses="$statuses"
                    popupTriggerButton="'true'" />

                <!-- For each subscription, you'll need just two modals instead of three -->
                @foreach ($subscriptions as $index => $subscription)
                    <!-- First Modal - with dropdown directly integrated -->
                    <div id="modal-{{ $index }}"
                        class="modal opacity-0 pointer-events-none fixed inset-0 flex items-center justify-center z-[9999]">
                        <div class="modal-overlay fixed inset-0 w-screen h-screen bg-gray-900 opacity-50"></div>
                        <div
                            class="modal-container bg-white w-11/12 md:max-w-xl mx-auto !rounded-lg shadow-lg z-[100] overflow-y-auto">
                            <div class="modal-content py-4 text-left px-6">
                                <!-- Header -->
                                <div class="bg-[#202947] -mx-6 -mt-4 py-3 px-6 mb-4">
                                    <h3 class="text-white text-xxl !font-semibold text-center mt-3 mb-3">Permohonan Baru
                                    </h3>
                                </div>

                                <!-- Content -->
                                <div class="text-center mt-4 mb-6">
                                    <h4 class="font-bold text-lg">{{ $subscription->name }}</h4>
                                    <p class="font-bold">{{ $subscription->cate1 }}</p>

                                    <div class="mt-4">
                                        {{-- <p>Penyata Pendapatan {{ $subscription->rem6 }}:</p> --}}
                                        <p class="text-lg">Penyata Pendapatan 2024 :</p>

                                        <p class="text-blue-600 font-bold text-xl">
                                            {{-- RM{{ number_format($subscription->rem3, 2) }}</p> --}}
                                            RM 80,765.90</p>

                                    </div>

                                    <div class="mt-4 text-left">
                                        <p>Kos Langganan:</p>
                                        <div class="mt-2">
                                            <!-- Dropdown display -->
                                            <div id="dropdown-display-{{ $subscription->id }}"
                                                class="flex items-center border rounded-md p-2 cursor-pointer mb-2 h-[3rem]">
                                                <span id="selected-price-{{ $subscription->id }}" data-package-id="7">RM
                                                    1,200.00</span>
                                                <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>

                                            <!-- Dropdown options (initially hidden) -->
                                            <div id="dropdown-options-{{ $subscription->id }}"
                                                class="border rounded-md p-4 hidden">
                                                @foreach ($packages as $id => $amount)
                                                    <div class="price-option py-2 cursor-pointer hover:bg-gray-100"
                                                        data-price="RM {{ number_format((float) $amount, 2) }}"
                                                        data-package-id="{{ $id }}">
                                                        RM {{ number_format((float) $amount, 2) }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="mt-8 mb-4">
                                    <button id="generate-invoice-btn-{{ $subscription->id }}"
                                        class="w-full h-[3rem] bg-[#202947] hover:bg-indigo-900 text-white font-bold py-3 px-4 !rounded-lg focus:outline-none focus:shadow-outline">
                                        JANA INVOIS
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Modal - Success (renamed from modal-second to just modal-second) -->
                    <div id="modal-second-{{ $index }}"
                        class="modal opacity-0 pointer-events-none fixed inset-0 flex items-center justify-center z-[9999]">
                        <div class="modal-overlay fixed inset-0 w-screen h-screen bg-gray-900 opacity-50"></div>
                        <div
                            class="modal-container bg-white w-11/12 md:max-w-xl mx-auto !rounded-lg shadow-lg z-[100] overflow-y-auto">
                            <div class="modal-content py-4 text-left px-6">
                                <!-- Header -->
                                <div class="bg-green-500 -mx-6 -mt-4 py-3 px-6 mb-4">
                                    <h3 class="text-white text-xxl !font-semibold text-center mt-3 mb-3">Invois Berjaya
                                        Dijana</h3>
                                </div>

                                <!-- Content -->
                                <div class="text-center mb-6 mt-4">
                                    <p class="mb-4">Invois telah berjaya dijana<br>dan notifikasi email @ whatsapp telah
                                        dihantar<br>ke institusi masjid</p>

                                    <h4 class="font-bold text-lg mt-6">{{ $subscription->name }}</h4>

                                    <div class="mt-4">
                                        <p>Kos Langganan:</p>
                                        <p class="text-blue-600 font-bold text-xl" id="final-price-{{ $subscription->id }}"
                                            data-package-id="7">RM 1,200.00</p>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="mt-8 mb-4">
                                    <button id="complete-btn-{{ $index }}"
                                        data-subscription-id="{{ $subscription->id }}"
                                        class="w-full h-[3rem] bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 !rounded-lg focus:outline-none focus:shadow-outline">
                                        SELESAI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <x-pagination :items="$subscriptions" label="Admin" />

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // Define common functions in the global scope
        function openModal(modalId) {
            console.log('Attempting to open modal:', modalId);
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100');
                document.body.classList.add('modal-active');
            } else {}
        }

        function closeModal(modalId) {
            console.log('Attempting to close modal:', modalId);
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('modal-active');
            } else {}
        }

        document.addEventListener('DOMContentLoaded', function() {
            let successMessage = sessionStorage.getItem('successMessage');
            if (successMessage) {
                let messageBox = document.createElement('div');
                messageBox.className = "bg-green-100 text-green-800 p-3 rounded-lg mb-4";
                messageBox.innerText = successMessage;

                document.body.prepend(messageBox);

                // Clear message from sessionStorage
                sessionStorage.removeItem('successMessage');
            }
            // Get all the "View" buttons
            const viewButtons = document.querySelectorAll('a[onclick^="openModal"]');

            viewButtons.forEach((button) => {
                // Extract the modal ID from the onclick attribute
                const onclickAttr = button.getAttribute('onclick');
                const match = onclickAttr.match(/openModal\('(.+?)'\)/);
                if (!match) return;

                const modalId = match[1];

                // Extract the index from the modal ID
                const index = modalId.split('-')[1];

                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    console.log('Button clicked, opening modal:', modalId);
                    openModal(modalId);
                });

                // Set up event listeners for each modal set
                setupModalListeners(index);
            });

            function setupModalListeners(index) {
                console.log('Setting up listeners for index:', index);
                let selectedPrice = "RM 1,200.00";
                let selectedPackageId = "7"; // Default package ID
                const subscriptionId = document.querySelector(`#complete-btn-${index}`).getAttribute(
                    'data-subscription-id');

                // First modal dropdown trigger
                const dropdownTrigger = document.getElementById(`dropdown-trigger-${subscriptionId}`);
                if (dropdownTrigger) {
                    dropdownTrigger.addEventListener('click', function() {
                        console.log('Dropdown trigger clicked');
                        // Now just directly update the price in the dropdown
                        const selectedPriceElement = document.getElementById(
                            `selected-price-${subscriptionId}`);
                        if (selectedPriceElement) {
                            selectedPriceElement.textContent = selectedPrice;
                            selectedPriceElement.setAttribute('data-package-id', selectedPackageId);
                        }
                    });
                } else {}

                // First modal price options setup
                const dropdownDisplay = document.getElementById(`dropdown-display-${subscriptionId}`);
                const dropdownOptions = document.getElementById(`dropdown-options-${subscriptionId}`);

                if (dropdownDisplay && dropdownOptions) {
                    dropdownDisplay.addEventListener('click', function() {
                        dropdownOptions.classList.toggle('hidden');
                    });
                } else {}

                // First modal price options selection
                const priceOptions = document.querySelectorAll(`#dropdown-options-${subscriptionId} .price-option`);
                priceOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        selectedPrice = this.getAttribute('data-price');
                        selectedPackageId = this.getAttribute('data-package-id');


                        // Update price in all modals
                        const selectedPriceElement = document.getElementById(
                            `selected-price-${subscriptionId}`);
                        const finalPriceElement = document.getElementById(
                            `final-price-${subscriptionId}`);

                        if (selectedPriceElement) {
                            selectedPriceElement.textContent = selectedPrice;
                            selectedPriceElement.setAttribute('data-package-id', selectedPackageId);
                        }
                        if (finalPriceElement) {
                            finalPriceElement.textContent = selectedPrice;
                            finalPriceElement.setAttribute('data-package-id', selectedPackageId);
                        }

                        // Hide dropdown options after selection
                        if (dropdownOptions) dropdownOptions.classList.add('hidden');
                    });
                });
                // First modal generate invoice button
                const generateInvoiceBtn = document.getElementById(`generate-invoice-btn-${subscriptionId}`);
                if (generateInvoiceBtn) {
                    generateInvoiceBtn.addEventListener('click', function() {
                        // Get the subscription ID from the data attribute
                        const completeBtn = document.getElementById(`complete-btn-${index}`);
                        const subscriptionId = completeBtn.getAttribute('data-subscription-id');

                        // Get the package ID from the selected price element
                        const selectedPriceElement = document.getElementById(
                            `selected-price-${subscriptionId}`);
                        const packageId = selectedPriceElement.getAttribute('data-package-id');

                        // Send the package ID to the backend function
                        fetch('subscription-fee-add', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    subscriptionId: subscriptionId,
                                    packageId: packageId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Update the final price in the success modal
                                const finalPriceElement = document.getElementById(
                                    `final-price-${subscriptionId}`);
                                if (finalPriceElement) {
                                    finalPriceElement.textContent = selectedPriceElement.textContent;
                                    finalPriceElement.setAttribute('data-package-id', packageId);
                                }

                                // Close the first modal and open the success modal
                                closeModal(`modal-${index}`);
                                openModal(`modal-second-${index}`);
                            })
                            .catch((error) => {
                                // Handle any errors here
                                console.error('Error:', error);
                            });
                    });
                } else {
                    console.log(`Generate invoice button not found for subscription ${subscriptionId}`);
                }

                // Second modal complete button
                const completeBtn = document.getElementById(`complete-btn-${index}`);
                if (completeBtn) {
                    completeBtn.addEventListener('click', function() {
                        closeModal(`modal-second-${index}`);
                        setTimeout(() => {
                            location.reload(); // Reload the page after closing the modal
                        }, 300); // Add a small delay to ensure smooth UI transition
                    });
                } else {
                    console.log(`Complete button not found for index ${index}`);
                }
            }

            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target.classList.contains('modal-overlay')) {
                    closeModal(event.target.parentElement.id);
                }
            });
        });
    </script>
@endsection
