@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Daftar Baru'" :breadcrumbs="[['label' => 'Pengurusan Pengguna', 'url' => 'javascript:void(0);'], ['label' => 'Daftar Baru']]" />
            <x-alert />


            <form method="POST" aaction="{{ route('userCreate') }}" class="bg-white sm:p-6 text-xs rounded-lg shadow">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input-field level="Nama Penuh" id="fullname" name="name" type="text"
                        placeholder="Enter Full Name" />
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="No. Kod Pengenadan" id="nric_number" name="ic" type="text"
                            placeholder="" />
                        <x-input-field level="No. H/P" id="mobile_number" name="hp" type="text" placeholder="" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-6">

                        <x-input-field level="Email" id="email" name="mel" type="email" placeholder="" />
                        <x-input-field level="Jabatan" id="department" name="jobdiv" type="select" placeholder="Pilih"
                            :valueList="$parameters['admin_departments']" />
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Jawatan" id="position" name="job" type="select" placeholder="Pilih"
                            :valueList="$parameters['admin_positions']" />
                        <x-input-field level="Akses Daerah" id="district_access" name="joblvl" type="select"
                            placeholder="Pilih" :valueList="$parameters['districts']" />
                    </div>
                </div>

                <div class="mt-8 lg:w-1/2 rounded-sm border border-[#2624D0] p-4">
                    <p class="text-sm font-bold text-[#2624D0]">Tindakan</p>
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Peringkat Pengguna" id="user_group" name="syslevel" type="select"
                            placeholder="Pilih" :valueList="$parameters['admin_groups']" />
                        <x-input-field level="Status" id="status" name="status" type="select" placeholder="Pilih"
                            :valueList="$parameters['statuses']" />

                    </div>
                </div>




                <div class="flex justify-between mt-8">
                    {{-- <button onclick="window.location='{{ route('userList') }}'" type="button" --}}
                    <a href="{{ route('userList') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-medium ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg inline-flex items-center justify-center">
                        Kembali
                    </a>

                    <button
                        class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                        type="submit">
                        Simpan
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection
