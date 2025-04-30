@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Jumlah Penghantaran'" :breadcrumbs="[['label' => 'Pelaporan', 'url' => 'javascript:void(0);'], ['label' => 'Jumlah Penghantaran']]" />
      <x-alert />
      <div class="rounded-lg bg-white px-4 py-8 shadow">
        <x-filter-card :filters="[
            [
                'name' => 'fin_year',
                'label' => date('Y'), // Show only the current year
                'type' => 'select',
                'options' => $years,
            ],
            [
                'name' => 'fin_category',
                'label' => $parameters['statements']['STM01'] ?? '', // Show only STM01 value
                'type' => 'select',
                'options' => collect($parameters['statements'])->except('STM01')->toArray(), // Remove STM01 from options
            ],
            [
                'name' => 'rem8',
                'label' => 'Semua Daerah',
                'type' => 'select',
                'options' => $parameters['districts'],
            ],
        ]" :route="route('submissionCountReport')" />
        @php
          $headers = [
              'Institusi',
              'Tahun',
              'Kategori Penyata',
              'Dihantar',
              'Belum Hantar',
              'Jumlah',
              'Diterima',
              'Ditolak',
              'Jumlah',
              'Ditolak & Telah Hantar Semula',
              'Ditolak Dan Belum Hantar Semula',
              'Jumlah',
          ];
          $alignCenter = [
              'Dihantar',
              'Belum Hantar',
              'Diterima',
              'Ditolak',
              'Ditolak & Telah Hantar Semula',
              'Ditolak Dan Belum Hantar Semula',
              'Jumlah',
          ];
          $alignRight = [];
        @endphp
        <div class="min-h-[55vh] overflow-auto sm:p-2">
          <table class="mt-4 min-w-full border-separate border-spacing-y-4 divide-y divide-gray-200"
            style="table-layout: fixed;">
            <thead>
              <tr class="border-b border-defaultborder">
                <th scope="col" class="px-1 py-1 text-center text-xs font-medium"
                  style="color: #2624D0 !important; font-weight: bold !important; width: 50px;">
                  Bil.
                </th>
                @foreach ($headers as $header)
                  @php
                    $alignClass = in_array($header, $alignCenter)
                        ? 'text-center'
                        : (in_array($header, $alignRight)
                            ? 'text-right'
                            : 'text-left');
                  @endphp
                  <th scope="col" class="{{ $alignClass }} px-2 py-1 text-xs font-medium"
                    style="color: #2624D0 !important; font-weight: bold !important;">
                    {{ $header }}
                  </th>
                @endforeach
              </tr>
            </thead>
            <tbody class="space-y-2 bg-white">
              @forelse($entries as $key => $row)
                <tr class="cursor-pointer hover:bg-gray-50">
                  <!-- Index Column -->
                  <td class="whitespace-nowrap px-1 py-2 text-center text-xs text-black">
                    {{ $entries->firstItem() + $key }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-xs text-black">
                    {{ $row->CATEGORY ?? '-' }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-xs text-black">
                    {{ $row->fin_year ?? '-' }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-xs text-black">
                    {{ $row->FIN_CATEGORY ?? '-' }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-center text-xs text-black">
                    {{ $row->total_submission ?? '0' }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-center text-xs text-black">
                    {{ $row->unsubmitted ?? '0' }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-center text-xs text-black">
                    <a href="{{ route('filteredSubmission', ['fin_year' => $row->fin_year, 'fin_category' => $row->fin_category, 'status' => '1,2,3', 'category' => $row->cate_name, 'options' => 1, 'rem8' => $district_query]) }}"
                      target=_blank class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-sm inline-flex w-[4rem] items-center justify-center bg-indigo-500 font-medium text-white hover:bg-indigo-600">
                      {{ $row->JUMLAH_1 ?? '0' }}
                    </a>
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-center text-xs text-black">
                    {{ $row->total_diterima ?? '0' }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-center text-xs text-black">
                    {{ $row->total_telah_hantar ?? '0' }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-center text-xs text-black">
                    <a href="{{ route('filteredSubmission', ['fin_year' => $row->fin_year, 'fin_category' => $row->fin_category, 'status' => '2,3', 'category' => $row->cate_name, 'options' => 2, 'rem8' => $district_query]) }}"
                      target=_blank class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-sm inline-flex w-[4rem] items-center justify-center bg-indigo-500 font-medium text-white hover:bg-indigo-600">
                      {{ $row->JUMLAH_2 ?? '0' }}
                    </a>
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-center text-xs text-black">
                    {{ $row->total_ditolak_dan_hantar ?? '0' }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-center text-xs text-black">
                    {{ $row->total_ditolak_belum_hantar ?? '0' }}
                  </td>
                  <td class="whitespace-nowrap px-2 py-2 text-center text-xs text-black">
                    <a href="{{ route('filteredSubmission', ['fin_year' => $row->fin_year, 'fin_category' => $row->fin_category, 'status' => 'canceled_submitted', 'category' => $row->cate_name, 'options' => 3, 'rem8' => $district_query]) }}"
                      target=_blank class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-sm inline-flex w-[4rem] items-center justify-center bg-indigo-500 font-medium text-white hover:bg-indigo-600">
                      {{ $row->JUMLAH_3 ?? '0' }}
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="13" class="whitespace-nowrap px-6 py-4 text-center text-xs text-gray-500">
                    Tiada Rekod Ditemui.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <x-pagination :items="$entries" label="jumlah rekod" />

      </div>
    </div>
  </div>
@endsection
