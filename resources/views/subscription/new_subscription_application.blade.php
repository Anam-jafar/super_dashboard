@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Rekod Langganan'" :breadcrumbs="[['label' => 'Langganan SPM', 'url' => 'javascript:void(0);'], ['label' => 'Rekod Langganan']]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    ['name' => 'area', 'label' => 'Daerah', 'type' => 'select', 'options' => $daerah],
                    [
                        'name' => 'institute_type',
                        'label' => 'Jenis Institusi',
                        'type' => 'select',
                        'options' => $instituteType,
                    ],
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('requestSubscriptions')" />

                <x-table :headers="['Nama', 'Jenis Institusi', 'Daerah', 'Tarikh Mohon', 'Status']" :columns="['name', 'cate', 'cate1', 'rem6', 'subscription_status']" :id="'id'" :rows="$subscriptions" :statuses="$statuses"
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
                                <div class="bg-blue-600 -mx-6 -mt-4 py-3 px-6 mb-4">
                                    <h3 class="text-white text-xl font-medium text-center">Permohonan Baru</h3>
                                </div>

                                <!-- Content -->
                                <div class="text-center mt-4 mb-6">
                                    <h4 class="font-bold text-lg">{{ $subscription->name }}</h4>
                                    <p class="font-bold">{{ $subscription->cate1 }}</p>

                                    <div class="mt-4">
                                        <p>Penyata Pendapatan {{ $subscription->rem6 }}:</p>
                                        <p class="text-blue-600 font-bold text-xl">
                                            RM{{ number_format($subscription->rem3, 2) }}</p>
                                    </div>

                                    <div class="mt-4 text-left">
                                        <p>Kos Langganan:</p>
                                        <div class="mt-2">
                                            <!-- Dropdown display -->
                                            <div id="dropdown-display-{{ $subscription->id }}"
                                                class="flex items-center border rounded-md p-2 cursor-pointer mb-2">
                                                <span id="selected-price-{{ $subscription->id }}">RM 1,200.00</span>
                                                <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>

                                            <!-- Dropdown options (initially hidden) -->
                                            <div id="dropdown-options-{{ $subscription->id }}"
                                                class="border rounded-md p-4 hidden">
                                                <div class="price-option py-2 cursor-pointer hover:bg-gray-100"
                                                    data-price="RM 1,200.00">
                                                    RM 1,200.00
                                                </div>
                                                <div class="price-option py-2 cursor-pointer hover:bg-gray-100"
                                                    data-price="RM 900.00">
                                                    RM 900.00
                                                </div>
                                                <div class="price-option py-2 cursor-pointer hover:bg-gray-100"
                                                    data-price="RM 0.00">
                                                    RM 0.00
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="mt-8 mb-4">
                                    <button id="generate-invoice-btn-{{ $subscription->id }}"
                                        class="w-full h-[3rem] bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 !rounded-lg focus:outline-none focus:shadow-outline">
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
                                    <h3 class="text-white text-xl font-medium text-center">Invois Berjaya Dijana</h3>
                                </div>

                                <!-- Content -->
                                <div class="text-center mb-6 mt-4">
                                    <p class="mb-4">Invois telah berjaya dijana<br>dan notifikasi email @ whatsapp telah
                                        dihantar<br>ke institusi masjid</p>

                                    <h4 class="font-bold text-lg mt-6">{{ $subscription->name }}</h4>

                                    <div class="mt-4">
                                        <p>Kos Langganan:</p>
                                        <p class="text-blue-600 font-bold text-xl"
                                            id="final-price-{{ $subscription->id }}">RM 1,200.00</p>
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
                console.log('Modal opened successfully:', modalId);
            } else {
                console.error(`Modal with id ${modalId} not found`);
            }
        }

        function closeModal(modalId) {
            console.log('Attempting to close modal:', modalId);
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('modal-active');
                console.log('Modal closed successfully:', modalId);
            } else {
                console.error(`Modal with id ${modalId} not found`);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded and parsed');

            // Get all the "View" buttons
            const viewButtons = document.querySelectorAll('a[onclick^="openModal"]');
            console.log('Found view buttons:', viewButtons.length);

            viewButtons.forEach((button) => {
                // Extract the modal ID from the onclick attribute
                const onclickAttr = button.getAttribute('onclick');
                const match = onclickAttr.match(/openModal\('(.+?)'\)/);
                if (!match) return;

                const modalId = match[1];
                console.log('Extracted modal ID:', modalId);

                // Extract the index from the modal ID
                const index = modalId.split('-')[1];
                console.log('Extracted index:', index);

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
                        if (selectedPriceElement) selectedPriceElement.textContent = selectedPrice;
                    });
                } else {
                    console.error(`Dropdown trigger not found for subscription ID ${subscriptionId}`);
                }

                // First modal price options setup
                const dropdownDisplay = document.getElementById(`dropdown-display-${subscriptionId}`);
                const dropdownOptions = document.getElementById(`dropdown-options-${subscriptionId}`);

                if (dropdownDisplay && dropdownOptions) {
                    dropdownDisplay.addEventListener('click', function() {
                        console.log('Toggling dropdown options');
                        dropdownOptions.classList.toggle('hidden');
                    });
                } else {
                    console.error(`Dropdown display or options not found for subscription ID ${subscriptionId}`);
                }

                // First modal price options selection
                const priceOptions = document.querySelectorAll(`#dropdown-options-${subscriptionId} .price-option`);
                priceOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        selectedPrice = this.getAttribute('data-price');
                        console.log('Price selected:', selectedPrice);

                        // Update price in all modals
                        const selectedPriceElement = document.getElementById(
                            `selected-price-${subscriptionId}`);
                        const finalPriceElement = document.getElementById(
                            `final-price-${subscriptionId}`);

                        if (selectedPriceElement) selectedPriceElement.textContent = selectedPrice;
                        if (finalPriceElement) finalPriceElement.textContent = selectedPrice;

                        // Hide dropdown options after selection
                        if (dropdownOptions) dropdownOptions.classList.add('hidden');
                    });
                });

                // First modal generate invoice button
                const generateInvoiceBtn = document.getElementById(`generate-invoice-btn-${subscriptionId}`);
                if (generateInvoiceBtn) {
                    generateInvoiceBtn.addEventListener('click', function() {
                        console.log('Generate invoice button clicked');
                        closeModal(`modal-${index}`);
                        const finalPriceElement = document.getElementById(`final-price-${subscriptionId}`);
                        if (finalPriceElement) finalPriceElement.textContent = selectedPrice;
                        openModal(`modal-second-${index}`);
                    });
                } else {
                    console.error(`Generate invoice button not found for subscription ID ${subscriptionId}`);
                }

                // Third modal complete button
                const completeBtn = document.getElementById(`complete-btn-${index}`);
                if (completeBtn) {
                    completeBtn.addEventListener('click', function() {
                        console.log('Complete button clicked');

                        // Get the subscription ID from the data attribute
                        const subscriptionId = document.querySelector(`#complete-btn-${index}`)
                            .getAttribute(
                                'data-subscription-id');
                        {{-- console.log('Subscription ID:', subscriptionId);
                        console.log('Selected price:', selectedPrice); --}}
                        // Send the amount to the backend function
                        fetch('subscription-fee-add', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                                },
                                body: JSON.stringify({
                                    subscriptionId: "502",
                                    amount: selectedPrice.replace('RM ', '')
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Success:', data);
                                closeModal(`modal-second-${index}`);
                                // You might want to update the UI or show a success message here
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                // Handle any errors here
                            });
                    });
                } else {
                    console.error(`Complete button not found for index ${index}`);
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
