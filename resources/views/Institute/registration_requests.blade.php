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
                    [
                        'name' => 'cate1',
                        'label' => 'Semua Institusi',
                        'type' => 'select',
                        'options' => $parameters['types'],
                    ],
                    [
                        'name' => 'cate',
                        'label' => 'Semua Jenis Institusi',
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
                        'name' => 'rem9',
                        'label' => 'Semua Mukim',
                        'type' => 'select',
                        'options' => $parameters['subdistricts'],
                    ],
                    [
                        'name' => 'sta',
                        'label' => 'Semua Status',
                        'type' => 'select',
                        'options' => $parameters['user_statuses'],
                    ],
                    ['name' => 'search', 'label' => '', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('registrationRequests')" />

                <x-table :headers="['Institusi', 'Jenis Institusi', 'Nama Institusi', 'Daerah', 'Mukim']" :columns="['TYPE', 'CATEGORY', 'name', 'DISTRICT', 'SUBDISTRICT']" :rows="$institutes" :id="'id'"
                    route="registrationRequestDetail" routeType="" />
                <x-pagination :items="$institutes" label="mosques" />

            </div>
        </div>
    </div>
@endsection
