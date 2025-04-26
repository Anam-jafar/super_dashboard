@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Jumlah Penghantaran yang Ditapis'" :breadcrumbs="[
          ['label' => 'Pelaporan', 'url' => 'javascript:void(0);'],
          ['label' => 'Jumlah Penghantaran', 'url' => 'javascript:void(0);'],
          ['label' => 'Jumlah Penghantaran yang Ditapis'],
      ]" />
      <x-alert />
      <div class="rounded-lg bg-white px-4 py-8 shadow">

        <x-filter-card :filters="[]" :route="route('filteredSubmission')" :download='true' />

        <x-table :headers="[
            'Tarikh Hantar',
            'Tahun Penyata',
            'Kategori Penyata',
            'Daerah',
            'Mukim',
            'Nama Institusi',
            'Wakil Institusi',
            'Status',
        ]" :columns="[
            'SUBMISSION_DATE',
            'fin_year',
            'CATEGORY',
            'DISTRICT',
            'SUBDISTRICT',
            'INSTITUTE',
            'OFFICER',
            'FIN_STATUS',
        ]" :rows="$entries" />
        <x-pagination :items="$entries" label="jumlah rekod" />

      </div>
    </div>
  </div>
@endsection
