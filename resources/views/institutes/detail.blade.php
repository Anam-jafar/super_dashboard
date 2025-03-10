@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Profile Institusi'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Profil Institusi'],
            ]" />

            <form method="POST" action="{{ route('approve', ['type' => 'mosques', 'id' => $entity->id]) }}" class="">
                @csrf
                @method('POST')

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs">
                    <h3 class="font-semibold text-lg mb-2">Maklumat Institusi</h3>
                    <hr class="mb-4">

                    <div class="grid grid-col-2 md:grid-cols-4 gap-6">

                        <div class="col-span-2">

                            <x-input-field level="Tarikh Mohon" id="tarikh_mohon" name="" type="text"
                                placeholder="Tarik Mohon" value="{{ $entity->registration_request_date ?? '' }}"
                                disabled="true" />
                        </div>
                        <div class="col-span-2">
                            <x-input-field level="Nama Institusi" id="inst_name" name="name" type="text"
                                placeholder="Enter Institute Name" value="{{ $entity->name }}" disabled='true' />
                        </div>
                    </div>

                    <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Institusi" id="inst_category" name="cate1" type="text"
                                placeholder="Pilih" value="{{ $entity->cate1 }}" disabled='true' />
                            <x-input-field level="Jenis Institusi" id="inst_type" name="cate" type="text"
                                placeholder="Pilih" value="{{ $entity->cate }}" disabled='true' />
                        </div>
                        <x-input-field level="Emel (Rasmi)" id="emel" name="mel" type="email" placeholder=""
                            value="{{ $entity->mel ?? '' }}" />

                    </div>
                    <div class="grid grid-col-1 md:grid-cols-2 gap-6 ">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Nombor Telefon (Rasmi)" id="tel" name="hp" type="text"
                                placeholder="" value="{{ $entity->hp ?? '' }}" disabled='true' />
                            <x-input-field level="Nombor Fax" id="fax" name="fax" type="text" placeholder=""
                                value="{{ $entity->fax ?? '' }}" disabled='true' />
                        </div>
                        <div class="grid grid-cols-2 gap-6">

                            <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name="rem15"
                                type="text" placeholder="" value="{{ $entity->rem15 ?? '' }} " disabled='true' />
                            <x-input-field level="Website" id="web" name="web" type="text" placeholder=""
                                value="{{ $entity->web ?? '' }}" disabled='true' />
                        </div>
                    </div>

                </div>

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs mt-4">
                    <h3 class="font-semibold text-lg mb-2">Maklumat Tambahan</h3>
                    <hr class="mb-4">
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Dun" id="dun" name="rem11" type="text" placeholder=""
                            value="{{ $entity->rem11 ?? '' }}" disabled='true' />

                        <x-input-field level="Parlimen" id="parliament" name="rem12" type="text" placeholder=""
                            value="{{ $entity->rem12 ?? '' }}" disabled='true' />
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Keluasan Institusi" id="area" name="rem13" type="text"
                                placeholder="" value="{{ $entity->rem13 ?? '' }}" disabled='true' />
                            <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name="rem14"
                                type="text" placeholder="" value="{{ $entity->rem14 ?? '' }}" disabled='true' />
                        </div>

                        <x-input-field level="Media Sosial" id="social" name="rem10" type="text" placeholder=""
                            value="{{ $entity->rem10 ?? '' }}" disabled='true' />


                    </div>
                </div>

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs mt-4">
                    <h3 class="font-semibold text-lg mb-2">Alamat Institusi</h3>
                    <hr class="mb-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input-field level="Alamat (Baris 1)" id="address1" name="addr" type="text"
                            placeholder="" value="{{ $entity->addr ?? '' }}" disabled='true' />
                        <x-input-field level="Alamat (Baris 2)" id="address2" name="addr1" type="text"
                            placeholder="" value="{{ $entity->addr1 ?? '' }}" disabled='true' />
                    </div>
                    <div class="grid grid-col-1 md:grid-cols-2 gap-6 !mb-4">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Bandar" id="city" name="city" type="text" placeholder=""
                                value="{{ $entity->city ?? '' }}" disabled='true' />
                            <x-input-field level="Mukim" id="inst_sub_district" name="rem9" type="text"
                                placeholder="Pilih" value="{{ $entity->rem9 }}" disabled='true' />
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Daerah" id="inst_district" name="rem8" type="text"
                                placeholder="Pilih" value="{{ $entity->rem8 }}" disabled='true' />
                            <x-input-field level="Negeri" id="negeri" name="state" type="text" placeholder=""
                                value="{{ $entity->state ?? '' }}" disabled='true' />
                        </div>

                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input-field level="Poskod" id="poskod" name="pcode" type="text" placeholder=""
                            value="{{ $entity->pcode ?? '' }}" disabled='true' />

                        <x-input-field level="Koordinat Institusi" id="coordinates" name="location" type="text"
                            placeholder="" value="{{ $entity->location ?? '' }}" disabled='true' />
                    </div>
                </div>

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs mt-4">
                    <h3 class="font-semibold text-lg mb-2">Pegawai/Wakil Institusi</h3>
                    <hr class="mb-4">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name="con1"
                                type="text" placeholder="" value="{{ $entity->con1 ?? '' }}" disabled='true' />
                            <x-input-field level="No. Kad Pengenalan" id="nric" name="ic" type="text"
                                placeholder="" value="{{ $entity->ic ?? '' }}" disabled='true' />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Jawatan" id="pos" name="pos1" type="text" placeholder=""
                                value="{{ $entity->pos1 ?? '' }}" disabled='true' />
                            <x-input-field level="Nombor Telefon" id="hp" name="tel1" type="text"
                                placeholder="" value="{{ $entity->tel1 ?? '' }}" disabled='true' />
                        </div>
                    </div>
                    <div class="flex justify-between !mt-8">
                        <button
                            class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg">
                            Kembali
                        </button>

                        <button
                            class="bg-green-600 ti-btn ti-btn-success btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                            type="submit">
                            Kemaskini & Luluskan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
