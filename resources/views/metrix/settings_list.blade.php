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
      <x-page-header :title="'Senarai Tetapan Fidyah'" :breadcrumbs="[['label' => 'Fidyah', 'url' => 'javascript:void(0);'], ['label' => 'Senari Tetapan Fidyah']]" />

      @if (session('success'))
        <div class="mb-4 rounded-r-lg border-l-4 border-green-500 bg-green-100 p-4 text-green-700">
          {{ session('success') }}
        </div>
      @elseif (session('error'))
        <div class="mb-4 rounded-r-lg border-l-4 border-red-500 bg-red-100 p-4 text-red-700">
          {{ session('error') }}
        </div>
      @endif

      <div class="flex w-full justify-end sm:w-auto">
        <a href="{{ route('metrix.settings.create', ['type' => 'fidyah']) }}"
          class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg" style="padding: 9px 12px;">
          Tambah Tetapan
          <i class="fe fe-plus"></i>
        </a>
      </div>

      <div class="space-y-4">

        <x-table :headers="['Title', 'Code', 'Status']" :columns="['title', 'code', 'is_active']" :id="'_id'" :rows="$payment_metrix" route="metrix.settings.edit"
          routeType="fidyah" extraRoute="'true'" />
        @foreach ($payment_metrix as $index => $setting)
          <!-- Modal -->
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
                  <!-- Individual Status -->
                  @foreach ($setting['individual_status'] as $status)
                    <div>
                      <h4 class="mb-2 text-base font-semibold text-gray-800">
                        {{ $status['parameter'] }}</h4>
                      <ul class="ml-5 list-disc">
                        @foreach ($status['categories'] as $category)
                          <li class="text-sm text-gray-800">{{ $category['parameter'] }} (Code:
                            {{ $category['code'] }})</li>
                        @endforeach
                      </ul>
                    </div>
                  @endforeach

                  <!-- Fidyah Items -->
                  <div>
                    <h4 class="mb-2 text-base font-semibold text-gray-800">Fidyah Items:</h4>
                    <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                          <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                              Item</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                              Price</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-700">
                              Rate</th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          @foreach ($setting['fidyah_item'] as $item)
                            <tr>
                              <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-800">
                                {{ $item['name'] }}</td>
                              <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-800">RM
                                {{ $item['price'] }}</td>
                              <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-800">RM
                                {{ $item['rate_value'] }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <!-- Rate -->
                  <div>
                    <p class="text-base text-gray-900"><span class="font-semibold">Rate:</span>
                      {{ $setting['rate'] }}</p>
                  </div>
                </div>

                <div class="mt-4 flex justify-end">
                  @if (!$setting['is_active'])
                    <form
                      action="{{ route('metrix.settings.mark-active', ['type' => 'fidyah', 'id' => $setting['_id']]) }}"
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
