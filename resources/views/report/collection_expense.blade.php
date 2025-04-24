@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Laporan Kutipan & Perbelanjaan Kewangan Institusi'" :breadcrumbs="[['label' => 'Pelaporan', 'url' => 'javascript:void(0);'], ['label' => 'Kutipan & Perbelanjaan']]" />
      <x-alert />
      <div class="rounded-lg bg-white px-4 py-8 shadow">
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
        
            ['name' => 'fin_year', 'label' => 'Tahun Penyata', 'type' => 'select', 'options' => $years],
            ['name' => 'search', 'label' => '', 'type' => 'text', 'placeholder' => 'Carian nama...'],
        ]" :route="route('collectionAndExpenseReport')" :download='true' />

        <x-table :headers="[
            'Jenis Institusi',
            'Nama Institusi',
            'Tahun Laporan',
            'Kategori Laporan',
            'Daerah',
            'Jumlah Kutipan',
            'Jumlah Perbelanjaan',
            'Jumlah Pendapatan',
            'Maklumat Baki Bank Dan Tunai',
        ]" :columns="[
            'Jenis_Institusi',
            'Nama_institusi',
            'Tahun_Laporan',
            'Kategori_laporan',
            'Daerah',
            'Jumlah_kutipan',
            'Jumlah_Belanja',
            'Jumlah_Pendapatan',
            'Jumlah_Baki_Diisytihar',
        ]" :rows="$entries" :id="'id'" />
        <x-pagination :items="$entries" label="jumlah rekod" />

      </div>
    </div>
  </div>
@endsection
