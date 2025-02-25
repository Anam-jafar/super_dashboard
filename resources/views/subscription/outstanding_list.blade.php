@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Rekod Tunggakan'" :breadcrumbs="[['label' => 'Langganan SPM', 'url' => 'javascript:void(0);'], ['label' => 'Rekod Tunggakan']]" /> <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('activeSubscriptions')" />

                <x-table :headers="['Nama', 'Status', 'In Charge', 'HP', 'Emel']" :columns="['name', 'sta', 'con1', 'hp', 'mel']" :id="'id'" :rows="$subscriptions" :statuses="$statuses"
                    route="edit" routeType="subscriptions" />

                <x-pagination :items="$subscriptions" label="Admin" />

            </div>
        </div>
    </div>
@endsection
