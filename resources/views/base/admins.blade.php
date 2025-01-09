@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senari Masjid'" :breadcrumbs="[['label' => 'Rekod Masjid', 'url' => 'javascript:void(0);'], ['label' => 'Senari Masjid']]" />

            <x-filter-card :filters="[
                ['name' => 'sch', 'label' => 'Filter by Sch', 'type' => 'select', 'options' => $schs],
                ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Enter name'],
            ]" :route="route('showAdminList')" button-label="Apply Filters" :button-route="route('createAdmin')" />

            <x-table :headers="['Name', 'Status', 'IC', 'HP', 'Email', 'JobDiv']" :columns="['name', 'status', 'ic', 'hp', 'mel', 'jobdiv']" :rows="$admins" :statuses="$statuses" />

            <x-pagination :items="$admins" label="Admin" />

        </div>
    </div>
@endsection
