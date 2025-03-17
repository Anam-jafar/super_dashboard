@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Penghantaran Baru'" :breadcrumbs="[
                ['label' => 'Laporan Kewangan', 'url' => 'javascript:void(0);'],
                ['label' => 'Penghantaran Baru'],
            ]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

            <x-filter-card :filters="[
                ['name' => 'fin_year', 'label' => 'Tahun Penyata', 'type' => 'select', 'options' => $years],
                ['name' => 'fin_category', 'label' => 'Kategori Penyata', 'type' => 'select', 'options' => $parameters['statements']],
                ['name' => 'rem8', 'label' => 'Semau Daerah', 'type' => 'select', 'options' => $parameters['districts']],
                ['name' => 'search', 'label' => '', 'type' => 'text', 'placeholder' => 'Carian...']
            ]" :route="route('statementList')" />


                <x-table :headers="[
                    'Tarikh Hantar',
                    'Tahun Penyata',
                    'Kategori Penyata',
                    'Daerah',
                    'Nama Institusi',
                    'Wakil Institusi',
                    'Status',
                ]" :columns="['submission_date', 'fin_year', 'CATEGORY', 'DISTRICT', 'INSTITUTE', 'OFFICER', 'FINSUBMISSIONSTATUS']" :rows="$financialStatements" :id="'id'" route="reviewStatement"
                    docIcon="true" />
                <x-pagination :items="$financialStatements" label="mosques" />

            </div>
        </div>
    </div>
@endsection
