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

            <form method="POST" action="{{ route('update', ['type' => 'mosques', 'id' => $entity->id]) }}" class="">
                @csrf
                @method('PUT')

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs">
                    <h3 class="font-semibold text-lg mb-2">Maklumat Institusi</h3>
                    <hr class="mb-4">
                    <div class="grid grid-col-2 md:grid-cols-4 gap-6">
                        <div class="col-span-2">

                            <div class="grid grid-cols-2 gap-6">
                                <x-input-field level="ID Masjid" id="inst_refno" name="uid" type="text"
                                    placeholder="Enter Institute Ref No" value="{{ $entity->uid }}" readonly="true" />
                                <x-input-field level="Status" id="inst_type" name="sta" type="select"
                                    placeholder="-- Type --" value="{{ $entity->sta }}" :valueList="$statuses" />
                            </div>
                        </div>
                        <div class="col-span-2">
                            <x-input-field level="Institute Name" id="inst_name" name="name" type="text"
                                placeholder="Enter Institute Name" value="{{ $entity->name }}" />
                        </div>
                    </div>


                    <div class="grid grid-col-1 md:grid-cols-2 gap-6 !mb-4">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Institute Category" id="inst_category" name="cate1" type="select"
                                placeholder="-- Category --" value="{{ $entity->cate1 }}" :valueList="$institute_types" />
                            <x-input-field level="Institute Type" id="inst_type" name="cate" type="select"
                                placeholder="-- Type --" value="{{ $entity->cate }}" :valueList="$institute_categories" />
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="District" id="inst_district" name="rem8" type="select"
                                placeholder="-- District --" value="{{ $entity->rem8 }}" :valueList="$districts" />
                            <x-input-field level="Sub District" id="inst_sub_district" name="rem9" type="select"
                                placeholder="-- Sub District --" value="{{ $entity->rem9 }}" :valueList="$sub_districts" />
                        </div>
                    </div>
                </div>

                <div class="space-y-2 py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs mt-4">
                    <h3 class="font-semibold text-lg mb-2">Maklumat Terperinci</h3>
                    <hr class="mb-4">

                    {{-- <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 space-y-6">
                    <x-input-field level="Tarikh Mohon" id="tarikh_mohon" name="" type="text"
                        placeholder="Tarik Mohon" value="{{ $entity->regdt ?? '' }}" disabled="true" />
                </div> --}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input-field level="Alamat (Baris 1)" id="address1" name="addr" type="text" placeholder=""
                            value="{{ $entity->addr ?? '' }}" />
                        <x-input-field level="Alamat (Baris 2)" id="address2" name="addr1" type="text" placeholder=""
                            value="{{ $entity->addr1 ?? '' }}" />


                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-3 gap-4">
                            <x-input-field level="Poskod" id="poskod" name="pcode" type="text" placeholder=""
                                value="{{ $entity->pcode ?? '' }}" />

                            <x-input-field level="Bandar" id="city" name="city" type="text" placeholder=""
                                value="{{ $entity->city ?? '' }}" />

                            <x-input-field level="Negeri" id="negeri" name="state" type="text" placeholder=""
                                value="{{ $entity->state ?? '' }}" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="grid grid-cols-2 gap-6">
                                <x-input-field level="No. Telefon" id="tel" name="hp" type="text"
                                    placeholder="" value="{{ $entity->hp ?? '' }}" />
                                <x-input-field level="No. Fax" id="fax" name="fax" type="text"
                                    placeholder="" value="{{ $entity->fax ?? '' }}" />
                            </div>
                            <x-input-field level="Emel" id="emel" name="mel" type="email" placeholder=""
                                value="{{ $entity->mel ?? '' }}" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Website" id="web" name="web" type="text" placeholder=""
                                value="{{ $entity->web ?? '' }}" />
                            <x-input-field level="Media Social" id="social" name="rem10" type="text"
                                placeholder="" value="{{ $entity->rem10 ?? '' }}" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Keluasan Institusi" id="area" name="rem13" type="text"
                                placeholder="" value="{{ $entity->rem13 ?? '' }}" />
                            <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name="rem14"
                                type="text" placeholder="" value="{{ $entity->rem14 ?? '' }}" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Dun" id="dun" name="rem11" type="text" placeholder=""
                                value="{{ $entity->rem11 ?? '' }}" />

                            <x-input-field level="Parliament" id="parliament" name="rem12" type="text"
                                placeholder="" value="{{ $entity->rem12 ?? '' }}" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name="rem15"
                            type="text" placeholder="" value="{{ $entity->rem15 ?? '' }}" />

                        <x-input-field level="Koordinat Institusi" id="coordinates" name="location" type="text"
                            placeholder="" value="{{ $entity->location ?? '' }}" />
                    </div>


                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name="con1"
                                type="text" placeholder="" value="{{ $entity->con1 ?? '' }}" />
                            <x-input-field level="No. Kod Pengenalam" id="nric" name="ic" type="text"
                                placeholder="" value="{{ $entity->ic ?? '' }}" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Jawatan" id="pos" name="pos1" type="text" placeholder=""
                                value="{{ $entity->pos1 ?? '' }}" />
                            <x-input-field level="No. H/P" id="hp" name="tel1" type="text" placeholder=""
                                value="{{ $entity->tel1 ?? '' }}" />
                        </div>
                    </div>



                    <div class="flex justify-between mt-8">
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
