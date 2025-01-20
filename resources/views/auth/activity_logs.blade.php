@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="max-w-full mx-auto p-4 sm:p-6">
                <h1 class="text-2xl font-bold mb-4">Activity Logs</h1>

                <x-table :headers="['Name', 'IC', 'UID', 'App', 'Action', 'Description', 'time', 'Date']" :columns="['name', 'ic', 'uid', 'app', 'act', 'des', 'tm', 'dt']" :rows="$logs" />
                <x-pagination :items="$logs" label="log" />

            </div>
        </div>
    </div>
@endsection
