@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Permohonan Pendaftaran Baru'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Permohonan Baru Institusi'],
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
                    ['name' => 'search', 'label' => '', 'type' => 'text', 'placeholder' => 'Carian nama...'],
                ]" :route="route('registrationRequests')" />

                <x-table :headers="['Institusi', 'Jenis Institusi', 'Nama Institusi', 'Daerah', 'Mukim']" :columns="['TYPE', 'CATEGORY', 'NAME', 'DISTRICT', 'SUBDISTRICT']" :rows="$institutes" :id="'id'"
                    route="registrationRequestDetail" routeType="" />
                <x-pagination :items="$institutes" label="jumlah institusi" />

            </div>
        </div>
    </div>
@endsection
