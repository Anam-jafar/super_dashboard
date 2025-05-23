@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Senarai'" :breadcrumbs="[['label' => 'Settings', 'url' => 'javascript:void(0);'], ['label' => 'Country']]" />
      <x-alert />
      <div class="rounded-lg bg-white px-4 py-8 shadow">
        <x-filter-card :filters="[]" :route="route('settingsCountry')" button-label="Daftar Baru" :button-route="route('settingsCountryCreate')" />
        <x-table :headers="['Parameter', 'Nilai', 'Kod', 'Pusat', 'Tahap', 'Index', 'DII', 'Keterangan']" :columns="['prm', 'val', 'code', 'sid', 'lvl', 'idx', 'etc', 'des']" :id="'id'" :rows="$countries" route="settingsCountryEdit" />

        <x-pagination :items="$countries" label="jumlah rekod" />

      </div>
    </div>
  </div>
@endsection
