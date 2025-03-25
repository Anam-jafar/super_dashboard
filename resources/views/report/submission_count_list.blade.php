@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Jumlah Penghantaran'" :breadcrumbs="[['label' => 'Pelaporan', 'url' => 'javascript:void(0);'], ['label' => 'Jumlah Penghantaran']]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    [
                        'name' => 'fin_year',
                        'label' => date('Y'), // Show only the current year
                        'type' => 'select',
                        'options' => $years,
                    ],
                    [
                        'name' => 'fin_category',
                        'label' => $parameters['statements']['STM01'] ?? '', // Show only STM01 value
                        'type' => 'select',
                        'options' => collect($parameters['statements'])->except('STM01')->toArray(), // Remove STM01 from options
                    ],
                ]" :route="route('submissionCountReport')" />




                <x-table :headers="['Institusi', 'Tahun', 'Telah Hantar Penyata', 'Belum Hantar Penyata']" :columns="['CATEGORY', 'fin_year', 'total_submission', 'unsubmitted']" :rows="$entries" :id="'id'" />
                <x-pagination :items="$entries" label="jumlah rekod" />

            </div>
        </div>
    </div>
@endsection
