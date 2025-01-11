@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senari Masjid'" :breadcrumbs="[['label' => 'Masjid', 'url' => 'javascript:void(0);'], ['label' => 'Senari Masjid']]" />

            <x-filter-card :filters="[
                ['name' => 'sch', 'label' => 'Filter by Sch', 'type' => 'select', 'options' => $schs],
                [
                    'name' => 'status',
                    'label' => 'Filter by Status',
                    'type' => 'select',
                    'options' => ['0' => 'Active', '1' => 'Inactive', '2' => 'Terminated', '3' => 'Reserved'],
                ],
                ['name' => 'city', 'label' => 'Filter by City', 'type' => 'select', 'options' => $cities],
                ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
            ]" :route="route('showEntityList')" button-label="Tambah Masjid" :button-route="route('createInstitute')" />

            <x-table :headers="['Nama', 'Status', 'Kategory', 'Link', 'Code', 'SID', 'Daerah']" :columns="['name', 'sta', 'cate', 'rem1', 'rem2', 'rem3', 'city']" :rows="$clients" :statuses="$statuses" route="editEntity" />

            <x-pagination :items="$clients" label="mosques" />

        </div>
    </div>
@endsection
