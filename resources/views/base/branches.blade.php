@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Cawangan'" :breadcrumbs="[['label' => 'Cawangan', 'url' => 'javascript:void(0);'], ['label' => 'Senarai Cawangan']]" />

            <x-filter-card :filters="[
                ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
            ]" :route="route('showBranchList')" button-label="Cawangan Baru" :button-route="route('createBranch')" />

            <x-table :headers="['Nama', 'Singkatan', 'Telefon', 'Emel', 'Web']" :columns="['name', 'sname', 'tel', 'mel', 'url']" :rows="$branches" route="editBranch" />

            <x-pagination :items="$branches" label="branches" />

        </div>
    </div>
@endsection
