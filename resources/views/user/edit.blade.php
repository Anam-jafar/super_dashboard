@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Daftar Baharu'" :breadcrumbs="[
                ['label' => 'Pengurusan Pengguna', 'url' => 'javascript:void(0);'],
                ['label' => 'Daftar Baharu'],
            ]" />
            <x-alert />


            <form method="POST" aaction="{{ route('userEdit', ['id' => $user->id]) }}"
                class="bg-white sm:p-6 text-xs rounded-lg shadow">
                @csrf
                <div class="flex flex-col gap-4">
                    <h2 class="text-base font-medium">Profile Picture</h2>

                    <div class="flex flex-row gap-4">
                        <div
                            class="w-[150px] h-[150px] border border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                        </div>
                        <div class="flex flex-col justify-end gap-2">
                            <button
                                class="w-[12rem] h-[3rem] bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Muat Naik Imej
                            </button>
                            <p class="text-sm text-gray-500 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                use JPEG and PNG, best size 150x150 pixels. Keep it under 3MB
                            </p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input-field level="Nama Penuh" id="fullname" name="name" type="text"
                        placeholder="Enter Full Name" value="{{ $user->name }}" />
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="No. Kod Pengenadan" id="nric_number" name="ic" type="text"
                            placeholder="" value="{{ $user->ic }}" />
                        <x-input-field level="No. H/P" id="mobile_number" name="hp" type="text" placeholder=""
                            value="{{ $user->hp }}" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-6">

                        <x-input-field level="Email" id="email" name="mel" type="email" placeholder=""
                            value="{{ $user->mel }}" />
                        <x-input-field level="Jabatan" id="department" name="jobdiv" type="select" placeholder="Pilih"
                            :valueList="$parameters['admin_departments']" value="{{ $user->jobdiv }}" />
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Jawatan" id="position" name="job" type="select" placeholder="Pilih"
                            :valueList="$parameters['admin_positions']" value="{{ $user->job }}" />
                        <x-input-field level="Akses Daerah" id="district_access" name="joblvl" type="select"
                            placeholder="Semua" :valueList="$parameters['districts']" value="{{ $user->joblvl }}" />
                    </div>
                </div>

                <div class="mt-8 lg:w-1/2 rounded-sm border border-[#2624D0] p-4">
                    <p class="text-sm font-bold text-[#2624D0]">Tindakan</p>
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Peringkat Pengguna" id="user_group" name="syslevel" type="select"
                            placeholder="Pilih" :valueList="$parameters['admin_groups']" value="{{ $user->syslevel }}" />
                        <x-input-field level="Status" id="status" name="status" type="select" placeholder="Pilih"
                            :valueList="$parameters['statuses']" value="{{ $user->status }}" />

                    </div>
                </div>




                <div class="flex justify-between mt-8">
                    {{-- <button onclick="window.location='{{ route('userList') }}'" type="button" --}}
                    <button type="button"
                        class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg">
                        Kembali
                    </button>

                    <button
                        class="bg-[#5C67F7] ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                        type="submit">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
