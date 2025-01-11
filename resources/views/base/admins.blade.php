@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Pentadbir'" :breadcrumbs="[['label' => 'Pentadbir', 'url' => 'javascript:void(0);'], ['label' => 'Senarai Pentadbir']]" />

            <x-filter-card :filters="[
                ['name' => 'sch', 'label' => 'Filter by Sch', 'type' => 'select', 'options' => $schs],
                ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
            ]" :route="route('showAdminList')" button-label="Tambah Pentadbir" :button-route="route('createAdmin')" />

            <x-table :headers="['Nama', 'Status', 'No KP', 'HP', 'Emel', 'Jawatan']" :columns="['name', 'status', 'ic', 'hp', 'mel', 'jobdiv']" :rows="$admins" :statuses="$statuses" route="editAdmin" />

            <x-pagination :items="$admins" label="Admin" />

        </div>
    </div>
@endsection
