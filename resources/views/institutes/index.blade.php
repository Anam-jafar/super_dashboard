@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senari Masjid'" :breadcrumbs="[['label' => 'Masjid', 'url' => 'javascript:void(0);'], ['label' => 'Senari Masjid']]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

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
                ]" :route="route('showList', ['type' => 'mosques'])" button-label="Tambah Masjid" :button-route="route('create', ['type' => 'mosques'])" />

                <x-table :headers="[
                    'Nama',
                    'HP',
                    'Emel',
                    'Kategory',
                    'Link',
                    'App Code',
                    'SID',
                    'Daerah',
                    'Status',
                    'Subscription',
                ]" :columns="['name', 'hp', 'mel', 'cate', 'rem1', 'rem2', 'rem3', 'city', 'sta', 'subscription_status']" :rows="$entities" :statuses="$statuses" :id="'id'"
                    route="edit" routeType="mosques" />
                <x-pagination :items="$entities" label="mosques" />

            </div>
        </div>
    </div>
@endsection
