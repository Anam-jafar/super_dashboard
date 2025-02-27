@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Rekod Langganan'" :breadcrumbs="[['label' => 'Langganan SPM', 'url' => 'javascript:void(0);'], ['label' => 'Rekod Langganan']]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    ['name' => 'area', 'label' => 'Daerah', 'type' => 'select', 'options' => $daerah],
                    [
                        'name' => 'institute_type',
                        'label' => 'Jenis Institusi',
                        'type' => 'select',
                        'options' => $instituteType,
                    ],
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('requestSubscriptions')" />

                <x-table :headers="['Nama', 'Jenis Institusi', 'Daerah', 'Tarikh Mohon', 'Status']" :columns="['name', 'cate', 'cate1', 'rem6', 'subscription_status']" :id="'id'" :rows="$subscriptions" :statuses="$statuses"
                    route="edit" routeType="subscriptions" />

                <x-pagination :items="$subscriptions" label="Admin" />

            </div>
        </div>
    </div>
@endsection
