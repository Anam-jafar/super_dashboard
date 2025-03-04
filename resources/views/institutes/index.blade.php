@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Institusi'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Senari Institusi'],
            ]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    ['name' => 'sch', 'label' => '', 'type' => 'select', 'options' => $schs],
                    [
                        'name' => 'status',
                        'label' => 'Filter by Status',
                        'type' => 'select',
                        'options' => ['0' => 'Active', '1' => 'Inactive', '2' => 'Terminated', '3' => 'Reserved'],
                    ],
                    ['name' => 'city', 'label' => '', 'type' => 'select', 'options' => $cities],
                    ['name' => 'search', 'label' => '', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('showList', ['type' => 'mosques'])" button-label="Tambah Masjid" :button-route="route('create', ['type' => 'mosques'])" />

                <x-table :headers="['ID Masjid', 'Institusi', 'Nama Institusi', 'Daerah', 'Status']" :columns="['uid', 'cate', 'name', 'city', 'sta']" :rows="$entities" :statuses="$statuses" :id="'id'"
                    route="edit" routeType="mosques" />
                <x-pagination :items="$entities" label="mosques" />

            </div>
        </div>
    </div>
@endsection
