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
            <x-page-header :title="'Senarai Tetapan Kaffarah'" :breadcrumbs="[
                ['label' => 'Kaffarah', 'url' => 'javascript:void(0);'],
                ['label' => 'Senari Tetapan Kaffarah'],
            ]" />

            <x-alert />

            <div class="flex justify-end w-full sm:w-auto">
                <a href="{{ route('metrix.compensation.create', ['type' => 'kaffarah']) }}"
                    class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                    style="padding: 9px 12px;">
                    Tambah Tetapan
                    <i class="fe fe-plus"></i>
                </a>
            </div>



            <x-table :headers="['Title', 'Code', 'Status']" :columns="['title', 'code', 'is_active']" :id="'_id'" :rows="$payment_metrix" route="metrix.compensation.edit"
                routeType="kaffarah" extraRoute="'true'" />


            <!-- Modals (Outside the table) -->
            @foreach ($payment_metrix as $index => $setting)
                <div id="modal-{{ $index }}"
                    class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
                    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50 z-[90]"></div>

                    <div
                        class="modal-container bg-white w-8/12 md:max-w-3xl mx-auto rounded shadow-lg z-[100] overflow-y-auto">
                        <div class="modal-content py-4 text-left px-6">
                            <div class="flex justify-between items-center pb-3">
                                <p class="text-2xl font-bold text-gray-900">{{ $setting['title'] }}</p>
                                <div class="modal-close cursor-pointer z-50"
                                    onclick="closeModal('modal-{{ $index }}')">
                                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                                        height="18" viewBox="0 0 18 18">
                                        <path
                                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold text-base text-gray-800 mb-2">Offense Types:</h4>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Offense</th>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Person to Feed</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($setting['offense_type'] as $offense)
                                                    <tr>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                                            {{ $offense['parameter'] }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                                            {{ $offense['value'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-base text-gray-800 mb-2">Kaffarah Items:</h4>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Kaffarah</th>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Price</th>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                        Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($setting['kaffarah_item'] as $item)
                                                    <tr>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                                            {{ $item['name'] }}
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                                            RM {{ number_format($item['price'], 2) }}
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
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
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800"
                                            title="Mark as Active">
                                            Mark as Active
                                        </button>
                                    </form>
                                @endif
                                <button class="px-4 py-2 bg-gray-500 text-white rounded-lg ml-2"
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
