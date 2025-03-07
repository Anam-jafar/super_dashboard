@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="py-8 px-4 bg-white">
                <div class="text-center">
                    <img src="{{ asset('assets/icons/under_maintainance.jpeg') }}" alt="Under Maintainance"
                        class="w-1/2 mx-auto">
                    <h1 class="text-2xl font-semibold mt-4">Sistem Dalam Penyelenggaraan</h1>
                    <p class="text-sm text-gray-500">Kami sedang melakukan penyelenggaraan sistem. Sila kembali lagi
                        kemudian.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
