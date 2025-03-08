@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Rekod Institusi'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Senarai Institusi'],
            ]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    ['name' => 'type', 'label' => 'Semua Institusi', 'type' => 'select', 'options' => $institute_types],
                    [
                        'name' => 'cate',
                        'label' => 'Semua Jenis Institusi',
                        'type' => 'select',
                        'options' => $institute_categories,
                    ],
                
                    ['name' => 'district', 'label' => 'Semua Daerah', 'type' => 'select', 'options' => $districts],
                    [
                        'name' => 'status',
                        'label' => 'Semua Status',
                        'type' => 'select',
                        'options' => $statuses,
                    ],
                    ['name' => 'search', 'label' => '', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('showList', ['type' => 'mosques'])" button-label="Daftar Baru" :button-route="route('create', ['type' => 'mosques'])" />

                <x-table :headers="['Institusi', 'Jenis Institusi', 'Nama Institusi', 'Daerah', 'Mukim', 'Status']" :columns="['cate1', 'cate', 'name', 'rem8', 'rem9', 'sta']" :rows="$entities" :statuses="$statuses" :id="'id'"
                    route="edit" routeType="mosques" />
                <x-pagination :items="$entities" label="mosques" />

            </div>
        </div>
    </div>
@endsection
