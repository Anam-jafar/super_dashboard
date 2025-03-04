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

            <form method="POST" action="{{ route('update', ['type' => 'mosques', 'id' => $entity->id]) }}"
                class="py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 space-y-6">
                    <x-input-field level="Tarikh Mohon" id="tarikh_mohon" name="" type="text"
                        placeholder="Tarik Mohon" value="{{ $entity->regdt ?? '' }}" disabled="true" />
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-4">
                        <x-input-field level="Institusi" id="institusi" name="" type="text"
                            placeholder="Institusi" value="{{ $entity->cate ?? '' }}" disabled="true" />
                        <x-input-field level="Jenis Institusi" id="jenis_institusi" name="" type="text"
                            placeholder="" value="{{ $entity->cate ?? '' }}" disabled="true" />
                    </div>

                    <x-input-field level="Nama Institusi" id="nama_institusi" name="" type="text" placeholder=""
                        value="{{ $entity->name ?? '' }}" disabled="true" />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-input-field level="Alamat (Baris 1)" id="address1" name="" type="text" placeholder=""
                        value="{{ $entity->addr ?? '' }}" disabled="true" />
                    <x-input-field level="" id="address2" name="" type="text" placeholder=""
                        value="{{ $entity->addr1 ?? '' }}" disabled="true" />


                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="grid grid-cols-3 gap-4">
                        <x-input-field level="Poskod" id="poskod" name="" type="text" placeholder=""
                            value="{{ $entity->pcode ?? '' }}" disabled="true" />

                        <x-input-field level="Bandar" id="city" name="" type="text" placeholder=""
                            value="{{ $entity->city ?? '' }}" disabled="true" />

                        <x-input-field level="Negeri" id="negeri" name="" type="text" placeholder=""
                            value="{{ $entity->state ?? '' }}" disabled="true" />
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="No. Telefon" id="tel" name="" type="text" placeholder=""
                                value="{{ $entity->hp ?? '' }}" disabled="true" />
                            <x-input-field level="No. Fax" id="fax" name="" type="text" placeholder=""
                                value="{{ $entity->fax ?? '' }}" disabled="true" />
                        </div>
                        <x-input-field level="Emel" id="emel" name="email" type="email" placeholder=""
                            value="{{ $entity->mel ?? '' }}" />
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Website" id="web" name="" type="text" placeholder=""
                            value="{{ $entity->web ?? '' }}" disabled="true" />
                        <x-input-field level="Media Social" id="social" name="" type="text" placeholder=""
                            value="{{ $entity->media_social ?? '' }}" disabled="true" />
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Mukim" id="mukim" name="" type="text" placeholder=""
                            value="{{ $entity->dun ?? '' }}" disabled="true" />

                        <x-input-field level="Daerah" id="daerah" name="" type="text" placeholder=""
                            value="{{ $entity->parliament ?? '' }}" disabled="true" />
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Dun" id="dun" name="" type="text" placeholder=""
                            value="{{ $entity->dun ?? '' }}" disabled="true" />

                        <x-input-field level="Parliament" id="parliament" name="" type="text" placeholder=""
                            value="{{ $entity->parliament ?? '' }}" disabled="true" />
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Keluasan Institusi" id="area" name="" type="text"
                            placeholder="" value="{{ $entity->institutional_area ?? '' }}" disabled="true" />
                        <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name="" type="text"
                            placeholder="" value="{{ $entity->total_capacity ?? '' }}" disabled="true" />
                    </div>

                    <x-input-field level="Koordinat Institusi" id="coordinates" name="" type="text"
                        placeholder="" value="{{ $entity->inst_coordinate ?? '' }}" disabled="true" />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name=""
                            type="text" placeholder="" value="{{ $entity->jatums_date ?? '' }}" disabled="true" />
                    </div>
                    <div></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name="" type="text"
                            placeholder="" value="{{ $entity->con1 ?? '' }}" disabled="true" />
                        <x-input-field level="No. Kod Pengenalam" id="nric" name="" type="text"
                            placeholder="" value="{{ $entity->personIncharge->nric_number ?? '' }}" disabled="true" />
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Jawatan" id="pos" name="" type="text" placeholder=""
                            value="{{ $entity->pos1 ?? '' }}" disabled="true" />
                        <x-input-field level="No. H/P" id="hp" name="" type="text" placeholder=""
                            value="{{ $entity->tel1 ?? '' }}" disabled="true" />
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

            </form>
        </div>
    </div>
@endsection
