@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Activity Logs'" :breadcrumbs="[['label' => 'Audit Trail', 'url' => 'javascript:void(0);'], ['label' => 'Activity Logs']]" />
            <x-alert />
            <div class="bg-white sm:p-2">

                <x-table :headers="['Name', 'IC', 'UID', 'App', 'Action', 'Description', 'time', 'Date']" :columns="['name', 'ic', 'uid', 'app', 'act', 'des', 'tm', 'dt']" :rows="$logs" />
                <x-pagination :items="$logs" label="log" />


            </div>
        </div>
    </div>
@endsection
