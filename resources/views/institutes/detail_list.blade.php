@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Permohonan Baru'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Permohonan Baru'],
            ]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    {{-- ['name' => 'type', 'label' => 'Institusi', 'type' => 'select', 'options' => $institute_types],
                    [
                        'name' => 'cate',
                        'label' => 'Jenis Institusi',
                        'type' => 'select',
                        'options' => $institute_categories,
                    ],
                    [
                        'name' => 'status',
                        'label' => 'Filter by Status',
                        'type' => 'select',
                        'options' => ['0' => 'Active', '1' => 'Inactive', '2' => 'Terminated', '3' => 'Reserved'],
                    ],
                
                    ['name' => 'city', 'label' => 'Filter by City', 'type' => 'select', 'options' => $cities], --}}
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('detailList', ['type' => 'mosques'])" />

                <x-table :headers="['Tarikh Permohonan', 'Institusi', 'Jenis Institusi', 'Nama Institusi', 'Nama Permohon', 'Daerah']" :columns="['registration_request_date', 'cate1', 'cate', 'name', 'con1', 'rem8']" :rows="$requests" :statuses="$statuses" :id="'id'"
                    route="detail" routeType="mosques" />
                <x-pagination :items="$requests" label="mosques" />

            </div>
        </div>
    </div>
@endsection
