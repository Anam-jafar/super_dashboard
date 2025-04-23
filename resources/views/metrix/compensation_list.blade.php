@extends('layouts.app')

@section('styles')
  <style>
    .modal {
      transition: opacity 0.25s ease;
      z-index: 100;
    }

    body.modal-active {
      overflow-x: hidden;
      overflow-y: visible !important;
    }
  </style>
@endsection

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">
      <x-page-header :title="'Senarai Tetapan Kaffarah'" :breadcrumbs="[['label' => 'Kaffarah', 'url' => 'javascript:void(0);'], ['label' => 'Senari Tetapan Kaffarah']]" />

      <x-alert />

      <div class="flex w-full justify-end sm:w-auto">
        <a href="{{ route('metrix.compensation.create', ['type' => 'kaffarah']) }}"
          class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg" style="padding: 9px 12px;">
          Tambah Tetapan
          <i class="fe fe-plus"></i>
        </a>
      </div>

      <x-table :headers="['Title', 'Code', 'Status']" :columns="['title', 'code', 'is_active']" :id="'_id'" :rows="$payment_metrix" route="metrix.compensation.edit"
        routeType="kaffarah" extraRoute="'true'" />

      <!-- Modals (Outside the table) -->
      @foreach ($payment_metrix as $index => $setting)
        <div id="modal-{{ $index }}"
          class="modal pointer-events-none fixed left-0 top-0 flex h-full w-full items-center justify-center opacity-0">
          <div class="modal-overlay absolute z-[90] h-full w-full bg-gray-900 opacity-50"></div>

          <div class="modal-container rounded z-[100] mx-auto w-8/12 overflow-y-auto bg-white shadow-lg md:max-w-3xl">
            <div class="modal-content px-6 py-4 text-left">
              <div class="flex items-center justify-between pb-3">
                <p class="text-2xl font-bold text-gray-900">{{ $setting['title'] }}</p>
                <div class="modal-close z-50 cursor-pointer" onclick="closeModal('modal-{{ $index }}')">
                  <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                    viewBox="0 0 18 18">
                    <path
                      d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                    </path>
                  </svg>
                </div>
              </div>

              <div class="space-y-4">
                <div>
                  <h4 class="mb-2 text-base font-semibold text-gray-800">Offense Types:</h4>
                  <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                        <tr>
                          <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                            Offense</th>
                          <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                            Person to Feed</th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($setting['offense_type'] as $offense)
                          <tr>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-800">
                              {{ $offense['parameter'] }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-800">
                              {{ $offense['value'] }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

                <div>
                  <h4 class="mb-2 text-base font-semibold text-gray-800">Kaffarah Items:</h4>
                  <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                        <tr>
                          <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                            Kaffarah</th>
                          <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                            Price</th>
                          <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                            Amount</th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($setting['kaffarah_item'] as $item)
                          <tr>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-800">
                              {{ $item['name'] }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-800">
                              RM {{ number_format($item['price'], 2) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-800">
                              RM {{ number_format($item['rate_value'], 2) }}
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

                <div>
                  <p class="text-base text-gray-900"><span class="font-semibold">Rate:</span>
                    {{ $setting['rate'] }}</p>
                </div>
              </div>

              <div class="mt-4 flex justify-end">
                @if (!$setting['is_active'])
                  <form
                    action="{{ route('metrix.compensation.mark-active', ['type' => 'kaffarah', 'id' => $setting['_id']]) }}"
                    method="POST" class="inline-block" onclick="event.stopPropagation();">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-800"
                      title="Mark as Active">
                      Mark as Active
                    </button>
                  </form>
                @endif
                <button class="ml-2 rounded-lg bg-gray-500 px-4 py-2 text-white"
                  onclick="closeModal('modal-{{ $index }}')">Close</button>
              </div>

            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function openModal(modalId) {
      const modal = document.getElementById(modalId);
      modal.classList.remove('opacity-0', 'pointer-events-none');
      modal.classList.add('opacity-100');
      document.body.classList.add('modal-active');
    }

    function closeModal(modalId) {
      const modal = document.getElementById(modalId);
      modal.classList.remove('opacity-100');
      modal.classList.add('opacity-0', 'pointer-events-none');
      document.body.classList.remove('modal-active');
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
      if (event.target.classList.contains('modal-overlay')) {
        closeModal(event.target.parentElement.id);
      }
    });
  </script>
@endsection
