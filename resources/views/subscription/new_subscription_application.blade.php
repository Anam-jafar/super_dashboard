@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Senarai Permohonan Langganan Baru'" :breadcrumbs="[['label' => 'Langganan', 'url' => 'javascript:void(0);'], ['label' => 'Permohonan Baru']]" />
      @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-3 text-green-800">
          {{ session('success') }}
        </div>
      @endif
      <div class="rounded-lg bg-white px-4 py-8 shadow">

        <x-filter-card :filters="[
            [
                'name' => 'cate1',
                'label' => 'Semua Institusi',
                'type' => 'select',
                'options' => $parameters['types'],
            ],
            [
                'name' => 'cate',
                'label' => 'Semua Jenis Institusi',
                'type' => 'select',
                'options' => $parameters['categories'],
            ],
        
            [
                'name' => 'rem8',
                'label' => 'Semua Daerah',
                'type' => 'select',
                'options' => $parameters['districts'],
            ],
        
            [
                'name' => 'rem9',
                'label' => 'Semua Mukim',
                'type' => 'select',
                'options' => $parameters['subdistricts'],
            ],
        
            [
                'name' => 'search',
                'label' => 'Search by Name',
                'type' => 'text',
                'placeholder' => 'Carian nama...',
            ],
        ]" :route="route('requestSubscriptions')" />

        <x-table :headers="['Tarikh Mohon', 'Institusi', 'Jenis Institusi', 'Nama Institusi', 'Daerah', 'Mukim', 'Status']" :columns="['SUBSCRIPTION_DATE', 'TYPE', 'CATEGORY', 'NAME', 'DISTRICT', 'SUBDISTRICT', 'SUBSCRIPTION_STATUS']" :id="'id'" :rows="$subscriptions" popupTriggerButton="'true'" />

        <!-- For each subscription, you'll need just two modals instead of three -->
        @foreach ($subscriptions as $index => $subscription)
          <!-- First Modal - with dropdown directly integrated -->
          <div id="modal-{{ $index }}"
            class="modal pointer-events-none fixed inset-0 z-[9999] flex items-center justify-center opacity-0">
            <div class="modal-overlay fixed inset-0 h-screen w-screen bg-gray-900 opacity-50"></div>
            <div
              class="modal-container z-[100] mx-auto w-11/12 overflow-y-auto !rounded-lg bg-white shadow-lg md:max-w-xl">
              <div class="modal-content px-6 py-4 text-left">
                <!-- Header -->
                <div class="-mx-6 -mt-4 mb-4 bg-[#202947] px-6 py-3">
                  <h3 class="text-xxl mb-3 mt-3 text-center !font-semibold text-white">Permohonan Baru
                  </h3>
                </div>

                <!-- Content -->
                <div class="mb-6 mt-4 text-center">
                  <h4 class="text-xl font-bold">{{ $subscription->name }}</h4>
                  <p class="text-normal font-bold">{{ $subscription->Category->prm }}</p>

                  <div class="mt-4">
                    <p class="text-lg">
                      Penyata Pendapatan
                      {{ $subscription->COLLECTION['FIN_YEAR'] ?? '' }}
                    </p>

                    <p class="text-xl font-bold text-blue-600">
                      @if (!empty($subscription->COLLECTION['TOTAL_COLLECTION']))
                        RM{{ number_format($subscription->COLLECTION['TOTAL_COLLECTION'], 2) }}
                      @else
                        Tiada rekod
                      @endif
                    </p>
                  </div>

                  <div class="mt-4 text-left">
                    <p>Kos Langganan:</p>
                    <div class="mt-2">
                      @php
                        // Get the first package (ID and Amount)
                        $firstPackage = reset($packages);
                        $firstPackageId = key($packages);
                        $firstPackageAmount = number_format((float) $firstPackage, 2);
                      @endphp

                      <!-- Dropdown display -->
                      <div id="dropdown-display-{{ $subscription->id }}"
                        class="mb-2 flex h-[3rem] cursor-pointer items-center rounded-md border p-2">
                        <span id="selected-price-{{ $subscription->id }}" data-package-id="{{ $firstPackageId }}">
                          RM {{ $firstPackageAmount }}
                        </span>
                        <svg class="ml-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                          xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                      </div>

                      <!-- Dropdown options (initially hidden) -->
                      <div id="dropdown-options-{{ $subscription->id }}" class="hidden rounded-md border p-4">
                        @foreach ($packages as $id => $amount)
                          <div class="price-option cursor-pointer py-2 hover:bg-gray-100"
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
                <div class="mb-4 mt-8">
                  <button id="generate-invoice-btn-{{ $subscription->id }}"
                    class="focus:shadow-outline h-[3rem] w-full !rounded-lg bg-[#202947] px-4 py-3 font-bold text-white hover:bg-indigo-900 focus:outline-none">
                    JANA INVOIS
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Second Modal - Success (renamed from modal-second to just modal-second) -->
          <div id="modal-second-{{ $index }}"
            class="modal pointer-events-none fixed inset-0 z-[9999] flex items-center justify-center opacity-0">
            <div class="modal-overlay fixed inset-0 h-screen w-screen bg-gray-900 opacity-50"></div>
            <div
              class="modal-container z-[100] mx-auto w-11/12 overflow-y-auto !rounded-lg bg-white shadow-lg md:max-w-xl">
              <div class="modal-content px-6 py-4 text-left">
                <!-- Header -->
                <div class="-mx-6 -mt-4 mb-4 bg-green-500 px-6 py-3">
                  <h3 class="text-xxl mb-3 mt-3 text-center !font-semibold text-white">Invois Berjaya
                    Dijana</h3>
                </div>

                <!-- Content -->
                <div class="mb-6 mt-4 text-center">
                  <p class="mb-4">Invois telah berjaya dijana<br>dan notifikasi email @ whatsapp telah
                    dihantar<br>ke institusi masjid</p>

                  <h4 class="mt-6 text-lg font-bold">{{ $subscription->name }}</h4>

                  <div class="mt-4">
                    <p>Kos Langganan:</p>
                    <p class="text-xl font-bold text-blue-600" id="final-price-{{ $subscription->id }}"
                      data-package-id="7">RM 1,200.00</p>
                  </div>
                </div>

                <!-- Footer -->
                <div class="mb-4 mt-8">
                  <button id="complete-btn-{{ $index }}" data-subscription-id="{{ $subscription->id }}"
                    class="focus:shadow-outline h-[3rem] w-full !rounded-lg bg-green-500 px-4 py-3 font-bold text-white hover:bg-green-600 focus:outline-none">
                    SELESAI
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Failure Modal -->
          <div id="modal-failure-{{ $index }}"
            class="modal pointer-events-none fixed inset-0 z-[9999] flex items-center justify-center opacity-0">
            <div class="modal-overlay fixed inset-0 h-screen w-screen bg-gray-900 opacity-50"></div>
            <div
              class="modal-container z-[100] mx-auto w-11/12 overflow-y-auto !rounded-lg bg-white shadow-lg md:max-w-xl">
              <div class="modal-content px-6 py-4 text-left">
                <!-- Header -->
                <div
                  style="margin-left: -1.5rem; margin-right: -1.5rem; margin-top: -1rem; margin-bottom: 1rem; background-color: #ef4444; padding: 0.75rem 1.5rem;">
                  <h3
                    style="font-size: 1.25rem; margin-top: 0.75rem; margin-bottom: 0.75rem; text-align: center; font-weight: 600; color: white;">
                    Invois Berjaya Dijana
                  </h3>
                </div>

                <!-- Content -->
                <div class="mb-6 mt-4 text-center">
                  <p class="mb-4">Invois tidak dapat dijana.<br>Sila cuba sebentar lagi atau hubungi sokongan.</p>

                  <h4 class="mt-6 text-lg font-bold">{{ $subscription->name }}</h4>

                  <div class="mt-4">
                    <p>Kos Langganan:</p>
                    <p class="text-xl font-bold text-blue-600" id="final-price-{{ $subscription->id }}"
                      data-package-id="7">RM 1,200.00</p>
                  </div>
                </div>

                <!-- Footer -->
                <div class="mb-4 mt-8">
                  <button id="complete-btn-{{ $index }}" data-subscription-id="{{ $subscription->id }}"
                    style="height: 3rem; width: 100%; border-radius: 0.5rem; background-color: #ef4444; padding: 0.75rem 1rem; font-weight: bold; color: white; outline: none;"
                    onclick="location.reload();">
                    TUTUP
                  </button>

                </div>
              </div>
            </div>
          </div>
        @endforeach

        <x-pagination :items="$subscriptions" label="jumlah rekod" />

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

            generateInvoiceBtn.disabled = true;
            generateInvoiceBtn.innerHTML =
              '<span class="spinner-border spinner-border-sm"></span> Processing...';

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
                if (data.success) {
                  // Update the final price in the success modal
                  const finalPriceElement = document.getElementById(`final-price-${subscriptionId}`);
                  if (finalPriceElement) {
                    finalPriceElement.textContent = selectedPriceElement.textContent;
                    finalPriceElement.setAttribute('data-package-id', packageId);
                  }

                  closeModal(`modal-${index}`);
                  openModal(`modal-second-${index}`);
                } else {
                  // Inject error message into the failure modal
                  const errorEl = document.getElementById(`error-message-${subscriptionId}`);
                  if (errorEl) {
                    errorEl.textContent = data.error || "Unknown error occurred";
                  }

                  closeModal(`modal-${index}`);
                  openModal(`modal-failure-${index}`);
                }
              })
              .catch((error) => {
                console.error('Error:', error);
                const errorEl = document.getElementById(`error-message-${subscriptionId}`);
                if (errorEl) {
                  errorEl.textContent = "Network error. Please try again.";
                }

                closeModal(`modal-${index}`);
                openModal(`modal-failure-${index}`);
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
