@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Laporan Terperinci Penghantaran Penyata Kewangan Institusi'" :breadcrumbs="[['label' => 'Pelaporan', 'url' => 'javascript:void(0);'], ['label' => 'Perincian Penghantaran']]" />
      <x-alert />
      <div class="rounded-lg bg-white px-4 py-8 shadow">
        <x-filter-card :filters="[
            ['name' => 'fin_year', 'label' => 'Semua Tahun Penyata', 'type' => 'select', 'options' => $years],
            [
                'name' => 'fin_category',
                'label' => 'Semua Kategori',
                'type' => 'select',
                'options' => $parameters['statements'],
            ],
        ]" :route="route('submissionDetailedReport')" :download='true' />

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
