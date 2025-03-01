@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Pentadbir'" :breadcrumbs="[['label' => 'Pentadbir', 'url' => 'javascript:void(0);'], ['label' => 'Senarai Pentadbir']]" />
            <x-alert />
            <div class="py-8 px-4 rounded-lg shadow bg-white">

                <x-filter-card :filters="[
                    ['name' => 'sch', 'label' => 'Filter by Sch', 'type' => 'select', 'options' => $schs],
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('showList', ['type' => 'admins'])" button-label="Tambah Pentadbir" :button-route="route('create', ['type' => 'admins'])" />

                <x-table :headers="['Nama', 'No KP', 'HP', 'Emel', 'Jawatan', 'Status']" :columns="['name', 'ic', 'hp', 'mel', 'jobdiv', 'status']" :id="'id'" :rows="$entities" :statuses="$statuses"
                    route="edit" routeType="admins" />

                <x-pagination :items="$entities" label="Admin" />

            </div>
        </div>
    </div>
@endsection
