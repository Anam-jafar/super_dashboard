@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senari Masjid'" :breadcrumbs="[['label' => 'Rekod Masjid', 'url' => 'javascript:void(0);'], ['label' => 'Senari Masjid']]" />

            <x-filter-card :filters="[
                ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Enter name'],
            ]" :route="route('showBranchList')" button-label="Apply Filters" :button-route="route('createBranch')" />

            <x-table :headers="['Name', 'Short Name', 'Telephone', 'Email', 'URL']" :columns="['name', 'sname', 'tel', 'mel', 'url']" :rows="$branches" />

            <x-pagination :items="$branches" label="branches" />

        </div>
    </div>
@endsection
