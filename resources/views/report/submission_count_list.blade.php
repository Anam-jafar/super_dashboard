@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Jumlah Penghantaran'" :breadcrumbs="[['label' => 'Pelaporan', 'url' => 'javascript:void(0);'], ['label' => 'Jumlah Penghantaran']]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    ['name' => 'fin_year', 'label' => 'Semua Tahun Penyata', 'type' => 'select', 'options' => $years],
                    [
                        'name' => 'fin_category',
                        'label' => 'Semua Kategori',
                        'type' => 'select',
                        'options' => $parameters['statements'],
                    ],
                ]" :route="route('submissionCountReport')" />


                <x-table :headers="['Institusi', 'Tahun', 'Telah Hantar Penyata', 'Belum Hantar Penyata']" :columns="['CATEGORY', 'fin_year', 'total_submission', 'unsubmitted']" :rows="$entries" :id="'id'" />
                <x-pagination :items="$entries" label="jumlah rekod" />

            </div>
        </div>
    </div>
@endsection
