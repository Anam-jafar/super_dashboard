@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Pengguna'" :breadcrumbs="[
                ['label' => 'Pengurusan Pengguna', 'url' => 'javascript:void(0);'],
                ['label' => 'Senarai Pengguna'],
            ]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    [
                        'name' => 'syslevel',
                        'label' => 'Semau Pengguna',
                        'type' => 'select',
                        'options' => $parameters['admin_groups'],
                    ],
                    [
                        'name' => 'joblvl',
                        'label' => 'Semau Daerah',
                        'type' => 'select',
                        'options' => $parameters['districts'],
                    ],
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('userList')" button-label="Tambah Pentadbir" :button-route="route('userCreate')" />

                <x-table :headers="['Nama', 'Emel', 'No KP', 'HP', 'Peringkat Pengguna', 'Akses Daerah', 'Status']" :columns="['name', 'ic', 'hp', 'mel', 'USER_GROUP', 'DISTRICT_ACCESS', 'status']" :id="'id'" :rows="$users" route="userEdit" />

                <x-pagination :items="$users" label="Admin" />

            </div>
        </div>
    </div>
@endsection
