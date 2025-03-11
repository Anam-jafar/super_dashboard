@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Daftar Institusi Baru'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Daftar Institusi'],
            ]" />
            <x-alert />

            <form method="POST" action="{{ route('instituteCreate') }}" class="">
                @csrf
                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs">

                    <h3 class="font-semibold text-lg mb-2">Maklumat Institusi</h3>
                    <hr class="mb-4">
                    <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                        <x-input-field level="Nama Institusi" id="inst_name" name="name" type="text" placeholder=""
                            :required="true" />
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Institusi" id="inst_category" name="cate1" type="select" placeholder=""
                                :valueList="$parameters['types']" :required="true" />
                            <x-input-field level="Jenis Institusi" id="inst_type" name="cate" type="select"
                                placeholder="" :valueList="$parameters['categories']" :required="true" />
                        </div>
                    </div>

                    <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Daerah" id="inst_district" name="rem8" type="select" placeholder=""
                                :valueList="$parameters['districts']" :required="true" />
                            <x-input-field level="Mukim" id="inst_sub_district" name="rem9" type="select"
                                placeholder="" :valueList="$parameters['subdistricts']" :required="true" />
                        </div>
                    </div>
                </div>
                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs mt-4">
                    <h3 class="font-semibold text-lg mb-2">Maklumat Terperinci</h3>
                    <hr class="mb-4">



                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input-field level="Alamat (Baris 1)" id="address1" name="addr" type="text"
                            placeholder="" />
                        <x-input-field level="Alamat (Baris 2)" id="address2" name="addr1" type="text"
                            placeholder="" />


                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-3 gap-4">
                            <x-input-field level="Poskod" id="poskod" name="pcode" type="text" placeholder="" />

                            <x-input-field level="Bandar" id="city" name="city" type="select" placeholder=""
                                :valueList="$parameters['cities']" />

                            <x-input-field level="Negeri" id="negeri" name="state" type="text" placeholder="" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="grid grid-cols-2 gap-6">
                                <x-input-field level="No. Telefon" id="tel" name="hp" type="text"
                                    placeholder="" />
                                <x-input-field level="No. Fax" id="fax" name="fax" type="text"
                                    placeholder="" />
                            </div>
                            <x-input-field level="Emel" id="emel" name="mel" type="email" placeholder="" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Website" id="web" name="web" type="text" placeholder="" />
                            <x-input-field level="Media Social" id="social" name="rem10" type="text"
                                placeholder="" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Keluasan Institusi" id="area" name="rem13" type="text"
                                placeholder="" />
                            <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name="rem14"
                                type="text" placeholder="" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Dun" id="dun" name="rem11" type="text"
                                placeholder="" />

                            <x-input-field level="Parliament" id="parliament" name="rem12" type="text"
                                placeholder="" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name="rem15"
                            type="text" placeholder="" />

                        <x-input-field level="Koordinat Institusi" id="coordinates" name="location" type="text"
                            placeholder="" />
                    </div>


                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name="con1"
                                type="text" placeholder="" />
                            <x-input-field level="No. Kod Pengenalan" id="nric" name="ic" type="text"
                                placeholder="" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Jawatan" id="pos" name="pos1" type="select" placeholder=""
                                :valueList="$parameters['user_positions']" />
                            <x-input-field level="No. H/P" id="hp" name="tel1" type="text"
                                placeholder="" />
                        </div>
                    </div>

                    <input type="hidden" name="sta" value=1 />
                    <input type="hidden" name="state" value="Selangor" />
                    <input type="hidden" name="country" value="Malaysia" />



                    <div class="flex justify-between !mt-8">
                        <button
                            class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg">
                            Kembali
                        </button>

                        <button
                            class="bg-[#5C67F7] ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                            type="submit">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
