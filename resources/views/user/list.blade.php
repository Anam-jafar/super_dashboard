@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Senarai Rekod Pengguna'" :breadcrumbs="[['label' => 'Pengurusan Pengguna', 'url' => 'javascript:void(0);'], ['label' => 'Senarai Pengguna']]" />
      <x-alert />
      <div class="rounded-lg bg-white px-4 py-8 shadow">

        <x-filter-card :filters="[
            [
                'name' => 'syslevel',
                'label' => 'Semua Pengguna',
                'type' => 'select',
                'options' => $parameters['admin_groups'],
            ],
            [
                'name' => 'joblvl',
                'label' => 'Semua Akses',
                'type' => 'select',
                'options' => $parameters['districts'],
            ],
            ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
        ]" :route="route('userList')" button-label="Daftar Baru" :button-route="route('userCreate')" />

        <x-table :headers="['Nama', 'Emel', 'No Kad Pengenalan', 'No Telefon', 'Peringkat Pengguna', 'Akses Daerah', 'Status']" :columns="['name', 'mel', 'ic', 'hp', 'USER_GROUP', 'DISTRICT_ACCESS', 'STATUS']" :id="'id'" :rows="$users" route="userEdit" />

        <x-pagination :items="$users" label="jumlah rekod" />

      </div>
    </div>
  </div>
@endsection
