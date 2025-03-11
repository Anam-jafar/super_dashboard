@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Kemaskini Maklumat Institusi'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Kemaskini Maklumat Institusi'],
            ]" />

            <form method="POST" action="{{ route('update', ['type' => 'mosques', 'id' => $institute->id]) }}" class="">
                @csrf
                @method('PUT')

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs">
                    <h3 class="font-semibold text-lg mb-2">Maklumat Institusi</h3>
                    <hr class="mb-4">
                    <div class="grid grid-col-2 md:grid-cols-4 gap-6">
                        <div class="col-span-2">

                            <x-input-field level="ID Masjid" id="inst_refno" name="uid" type="text"
                                placeholder="Enter Institute Ref No" value="{{ $institute->uid }}" readonly="true" />

                        </div>
                        <div class="col-span-2">
                            <x-input-field level="Nama Institusi" id="inst_name" name="name" type="text"
                                placeholder="Enter Institute Name" value="{{ $institute->name }}" />
                        </div>
                    </div>

                    <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Institusi" id="inst_category" name="cate1" type="select"
                                placeholder="Pilih" value="{{ $institute->cate1 }}" :valueList="$parameters['types']" />
                            <x-input-field level="Jenis Institusi" id="inst_type" name="cate" type="select"
                                placeholder="Pilih" value="{{ $institute->cate }}" :valueList="$parameters['categories']" />
                        </div>
                        <x-input-field level="Emel (Rasmi)" id="emel" name="mel" type="email" placeholder=""
                            value="{{ $institute->mel ?? '' }}" />

                    </div>
                    <div class="grid grid-col-1 md:grid-cols-2 gap-6 ">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Nombor Telefon (Rasmi)" id="tel" name="hp" type="text"
                                placeholder="" value="{{ $institute->hp ?? '' }}" />
                            <x-input-field level="Nombor Fax" id="fax" name="fax" type="text" placeholder=""
                                value="{{ $institute->fax ?? '' }}" />
                        </div>
                        <div class="grid grid-cols-2 gap-6">

                            <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name="rem15"
                                type="text" placeholder="" value="{{ $institute->rem15 ?? '' }}" />
                            <x-input-field level="Website" id="web" name="web" type="text" placeholder=""
                                value="{{ $institute->web ?? '' }}" />
                        </div>
                    </div>
                    <div class="grid grid-col-1 md:grid-cols-4 gap-6 ">

                        <x-input-field level="Status" id="inst_type" name="sta" type="select" placeholder="-- Type --"
                            value="{{ $institute->sta }}" :valueList="$parameters['user_statuses']" />
                    </div>
                </div>

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs mt-4">
                    <h3 class="font-semibold text-lg mb-2">Maklumat Tambahan</h3>
                    <hr class="mb-4">
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Dun" id="dun" name="rem11" type="text" placeholder=""
                            value="{{ $institute->rem11 ?? '' }}" />

                        <x-input-field level="Parlimen" id="parliament" name="rem12" type="text" placeholder=""
                            value="{{ $institute->rem12 ?? '' }}" />
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Keluasan Institusi" id="area" name="rem13" type="text"
                                placeholder="" value="{{ $institute->rem13 ?? '' }}" />
                            <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name="rem14"
                                type="text" placeholder="" value="{{ $institute->rem14 ?? '' }}" />
                        </div>

                        <x-input-field level="Media Sosial" id="social" name="rem10" type="text" placeholder=""
                            value="{{ $institute->rem10 ?? '' }}" />


                    </div>
                </div>

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs mt-4">
                    <h3 class="font-semibold text-lg mb-2">Alamat Institusi</h3>
                    <hr class="mb-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input-field level="Alamat (Baris 1)" id="address1" name="addr" type="text"
                            placeholder="" value="{{ $institute->addr ?? '' }}" />
                        <x-input-field level="Alamat (Baris 2)" id="address2" name="addr1" type="text"
                            placeholder="" value="{{ $institute->addr1 ?? '' }}" />
                    </div>
                    <div class="grid grid-col-1 md:grid-cols-2 gap-6 !mb-4">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Bandar" id="city" name="city" type="select" placeholder=""
                                value="{{ $institute->city ?? '' }}" :valueList="$parameters['cities']" />
                            <x-input-field level="Sub District" id="inst_sub_district" name="rem9" type="select"
                                placeholder="Pilih" value="{{ $institute->rem9 }}" :valueList="$parameters['subdistricts']" />
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="District" id="inst_district" name="rem8" type="select"
                                placeholder="Pilih" value="{{ $institute->rem8 }}" :valueList="$parameters['districts']" />
                            <x-input-field level="Negeri" id="negeri" name="state" type="text" placeholder=""
                                value="{{ $institute->state ?? '' }}" />
                        </div>

                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input-field level="Poskod" id="poskod" name="pcode" type="text" placeholder=""
                            value="{{ $institute->pcode ?? '' }}" />

                        <x-input-field level="Koordinat Institusi" id="coordinates" name="location" type="text"
                            placeholder="" value="{{ $institute->location ?? '' }}" />
                    </div>
                </div>

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs mt-4">
                    <h3 class="font-semibold text-lg mb-2">Pegawai/Wakil Institusi</h3>
                    <hr class="mb-4">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name="con1"
                                type="text" placeholder="" value="{{ $institute->con1 ?? '' }}" />
                            <x-input-field level="No. Kad Pengenalan" id="nric" name="ic" type="text"
                                placeholder="" value="{{ $institute->ic ?? '' }}" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Jawatan" id="pos" name="pos1" type="select" placeholder=""
                                value="{{ $institute->pos1 ?? '' }}" :valueList="$parameters['user_positions']" />
                            <x-input-field level="Nombor Telefon" id="hp" name="tel1" type="text"
                                placeholder="" value="{{ $institute->tel1 ?? '' }}" />
                        </div>
                    </div>
                    <div class="flex justify-between !mt-8">
                        <button
                            class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg">
                            Kembali
                        </button>

                        <button
                            class="bg-[#5C67F7] ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                            type="submit">
                            Kemaskini
                        </button>
                    </div>
                </div>



            </form>
        </div>
    </div>
@endsection
