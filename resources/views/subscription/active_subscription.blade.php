@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Langganan Aktif Institusi'" :breadcrumbs="[['label' => 'Langganan', 'url' => 'javascript:void(0);'], ['label' => 'Rekod Aktif']]" />
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif
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
                        'name' => 'search',
                        'label' => 'Search by Name',
                        'type' => 'text',
                        'placeholder' => 'Carian nama...',
                    ],
                ]" :route="route('activeSubscriptions')" />

                <x-table :headers="['Institusi', 'Jenis Institusi', 'Nama Institusi', 'Emel', 'Daerah', 'Mukim', 'Status']" :columns="['TYPE', 'CATEGORY', 'NAME', 'mel', 'DISTRICT', 'SUBDISTRICT', 'SUBSCRIPTION_STATUS']" :rows="$subscriptions" />

                <x-pagination :items="$subscriptions" label="jumlah rekod" />

            </div>
        </div>
    </div>
@endsection
