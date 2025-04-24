@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Carian Laporan'" :breadcrumbs="[['label' => 'Pelaporan', 'url' => 'javascript:void(0);'], ['label' => 'Carian Laporan']]" />
      <x-alert />

      <div class="rounded-lg bg-white px-4 py-8 shadow">
        <div class="2xl:justify-start flex w-full flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <!-- Filters Form -->
          <form method="GET" action="" class="order-2 flex flex-col gap-4 md:flex-row lg:order-1 lg:flex-1">
          </form>
          <div class="order-1 flex w-full flex-row gap-2 lg:order-2 lg:w-auto">
            <a href="{{ route('exportStatementReport', $filters) }}"
              class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-lg flex w-full items-center justify-center rounded-sm border border-gray-300 bg-white p-2 hover:bg-gray-50 lg:w-auto">
              <span class="fe fe-download mr-1 text-center text-gray-700"></span>
              <span class="text-sm font-normal text-gray-700 sm:inline md:inline lg:hidden">Download</span>
            </a>
            {{-- <a href="{{ request()->fullUrlWithQuery(['excel' => true]) }}"
        class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-lg flex w-1/2 items-center justify-center rounded-sm border border-gray-300 bg-white p-2 hover:bg-gray-50 lg:w-auto">
        <span class="fe fe-printer mr-1 text-center text-gray-700"></span>
        <span class="text-sm font-normal text-gray-700 sm:inline md:inline lg:hidden">Print</span>
      </a> --}}
          </div>
        </div>
        <x-table :headers="[
            'Jenis Institusi',
            'Nama Institusi',
            'Tarikh Hantar',
            'Tahun Laporan',
            'Kategori Laporan',
            'Daerah',
            'Status',
        ]" :columns="[
            'Jenis_Institusi',
            'Nama_institusi',
            'Tarikh_Hantar',
            'Tahun_Laporan',
            'Kategori_laporan',
            'Daerah',
            'FIN_STATUS',
        ]" :rows="$entries" :id="'id'" route="viewStatement"
          docIcon="true" />
        <x-pagination :items="$entries" label="jumlah rekod" />

      </div>
    </div>
  </div>
@endsection
