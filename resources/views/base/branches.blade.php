@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Cawangan'" :breadcrumbs="[['label' => 'Cawangan', 'url' => 'javascript:void(0);'], ['label' => 'Senarai Cawangan']]" />

            <x-filter-card :filters="[
                ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Enter name'],
            ]" :route="route('showBranchList')" button-label="Cawangan Baru" :button-route="route('createBranch')" />

            <x-table :headers="['Name', 'Short Name', 'Telephone', 'Email', 'URL']" :columns="['name', 'sname', 'tel', 'mel', 'url']" :rows="$branches" />

            <x-pagination :items="$branches" label="branches" />

        </div>
    </div>
@endsection
