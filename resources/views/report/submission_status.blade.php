@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Laporan Status Penghantaran Penyata Kewangan Institusi'" :breadcrumbs="[['label' => 'Pelaporan', 'url' => 'javascript:void(0);'], ['label' => 'Status Penghantaran']]" />
      <x-alert />
      <div class="rounded-lg bg-white px-4 py-8 shadow">
        <a href="{{ request()->fullUrlWithQuery(['excel' => true]) }}" class="btn btn-success">
          Download Excel
        </a>
        <x-filter-card :filters="[
            [
                'name' => 'cate',
                'label' => 'Semua Institusi',
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
                'name' => 'status',
                'label' => 'Semua Status',
                'type' => 'select',
                'options' => $parameters['financial_statement_statuses_report'],
            ],
        
            ['name' => 'fin_year', 'label' => 'Tahun Penyata', 'type' => 'select', 'options' => $years],
            ['name' => 'search', 'label' => '', 'type' => 'text', 'placeholder' => 'Carian nama...'],
        ]" :route="route('submissionStatusReport')" :download='true' />

        <x-table :headers="[
            'Jenis Institusi',
            'Nama Institusi',
            'Tahun Laporan',
            'Tarikh Hantar',
            'Kategori Laporan',
            'Daerah',
            'Jumlah Kutipan',
            'Jumlah Perbelanjaan',
            'Maklumat Baki Bank Dan Tunai',
            'Status',
        ]" :columns="[
            'CATEGORY',
            'NAME',
            'YEAR',
            'DATE',
            'STATEMENT',
            'DISTRICT',
            'JUMLAH_KUTIPAN',
            'JUMLAH_BELANJA',
            'JUMLAH_BAKI_BANK',
            'FIN_STATUS',
        ]" :rows="$entries" :id="'id'" />
        <x-pagination :items="$entries" label="jumlah rekod" />

      </div>
    </div>
  </div>
@endsection
