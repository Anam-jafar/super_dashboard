@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Daftar Institusi'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Daftar Institusi'],
            ]" />
            <x-alert />

            <form method="POST" action="{{ route('store', ['type' => 'mosques']) }}"
                class="py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs">
                @csrf
                <div class="min-h-[50vh] space-y-6">


                    <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                        <x-input-field level="Nama Institusi" id="inst_name" name="name" type="text" placeholder="" />
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Institusi" id="inst_category" name="cate" type="select" placeholder=""
                                :valueList="$categories" />
                            <x-input-field level="Jenis Institusi" id="inst_type" name="" type="select"
                                placeholder="" :valueList="$categories" />
                        </div>
                    </div>

                    <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Daerah" id="inst_district" name="city" type="select" placeholder=""
                                :valueList="$areas" />
                            <x-input-field level="Mukim" id="inst_sub_district" name="" type="select"
                                placeholder="" :valueList="$areas" />
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between mt-8">
                    {{-- <button onclick="window.location='{{ route('instituteList') }}'" type="button" --}}
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
