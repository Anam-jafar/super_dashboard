@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Senarai Rekod Penghantaran Laporan Kewangan'" :breadcrumbs="[['label' => 'Laporan Kewangan', 'url' => 'javascript:void(0);'], ['label' => 'Penghantaran Baru']]" />
      <x-alert />
      <div class="rounded-lg bg-white px-4 py-8 shadow">

        <x-filter-card :filters="[
            ['name' => 'fin_year', 'label' => 'Tahun Penyata', 'type' => 'select', 'options' => $years],
            [
                'name' => 'fin_category',
                'label' => 'Kategori Penyata',
                'type' => 'select',
                'options' => $parameters['statements'],
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
                'name' => 'status',
                'label' => 'Semua Status',
                'type' => 'select',
                'options' => $parameters['financial_statement_statuses_report'],
            ],
            ['name' => 'search', 'label' => '', 'type' => 'text', 'placeholder' => 'Carian nama...'],
        ]" :route="route('reviwedStatementList')" />

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
        ]" :rows="$financialStatements" :id="'id'" route="viewStatement"
          docIcon="true" />
        <x-pagination :items="$financialStatements" label="jumlah rekod" />

      </div>
    </div>
  </div>
@endsection
