@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Tambah Pentadbir Baru'" :breadcrumbs="[['label' => 'Pentadbir', 'url' => 'javascript:void(0);'], ['label' => 'Tambah Pentadbir']]" />

            <form method="POST" action="#">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="name" class="ti-form-label">Nama</label>
                        <input type="text" id="name" name="name" placeholder="Nama" class="form-control">
                    </div>

                    <!-- Level Sistem -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="syslevel" class="ti-form-label">Level Sistem</label>
                        <select id="syslevel" name="syslevel" class="form-control">
                            @foreach ($syslevels as $syslevel)
                                <option value="{{ $syslevel->prm }}">{{ $syslevel->prm }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nombor KP -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="ic" class="ti-form-label">Nombor KP</label>
                        <input type="text" id="ic" name="ic" placeholder="Nombor KP" class="form-control">
                    </div>

                    <!-- Capaian Sistem -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="sysaccess" class="ti-form-label">Capaian Sistem</label>
                        <input type="text" id="sysaccess" name="sysaccess" placeholder="Capaian Sistem"
                            class="form-control">
                    </div>

                    <!-- Tel. Bimbit -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="hp" class="ti-form-label">Tel. Bimbit</label>
                        <input type="text" id="hp" name="hp" placeholder="Tel. Bimbit" class="form-control">
                    </div>

                    <!-- Tarikh Mula -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="jobstart" class="ti-form-label">Tarikh Mula</label>
                        <input type="date" id="jobstart" name="jobstart" class="form-control">
                    </div>

                    <!-- Emel -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="mel" class="ti-form-label">Emel</label>
                        <input type="email" id="mel" name="mel" placeholder="Emel" class="form-control">
                    </div>

                    <!-- Status -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="status" class="ti-form-label">Status</label>
                        <select id="status" name="status" class="form-control">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->val }}">{{ $status->prm }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </form>




        </div>
    </div>
@endsection
