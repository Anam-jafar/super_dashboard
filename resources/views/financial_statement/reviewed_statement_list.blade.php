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
                    ['name' => 'fin_year', 'label' => 'Tahun Penyata', 'type' => 'select', 'options' => $years],
                    [
                        'name' => 'fin_category',
                        'label' => 'Kategori Penyata',
                        'type' => 'select',
                        'options' => $parameters['statements'],
                    ],
                    ['name' => 'search', 'label' => '', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('statementList')" />

                <x-table :headers="[
                    'Tarikh Hantar',
                    'Tahun Penyata',
                    'Kategori Penyata',
                    'Nama Institusi',
                    'Wakil Institusi',
                    'Status',
                ]" :columns="['submission_date', 'fin_year', 'CATEGORY', 'INSTITUTE', 'OFFICER', 'FINSUBMISSIONSTATUS']" :rows="$financialStatements" :id="'id'" route="viewStatement"
                    docIcon="true" />
                <x-pagination :items="$financialStatements" label="mosques" />

            </div>
        </div>
    </div>
@endsection
