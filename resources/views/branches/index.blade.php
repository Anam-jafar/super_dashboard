@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Cawangan'" :breadcrumbs="[['label' => 'Cawangan', 'url' => 'javascript:void(0);'], ['label' => 'Senarai Cawangan']]" />
            <x-alert />
            <div class="bg-white sm:p-2">


                <x-filter-card :filters="[
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" :route="route('showList', ['type' => 'branches'])" button-label="Cawangan Baru" :button-route="route('create', ['type' => 'branches'])" />

                <x-table :headers="['Nama', 'Singkatan', 'Telefon', 'Emel', 'Web']" :columns="['name', 'sname', 'tel', 'mel', 'url']" :rows="$entities" route="edit" routeType="branches" />

                <x-pagination :items="$entities" label="branches" />

            </div>
        </div>
    </div>
@endsection
