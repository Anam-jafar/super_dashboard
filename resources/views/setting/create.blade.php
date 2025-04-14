@extends('layouts.app')

@section('styles')
@endsection

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Daftar Negara'" :breadcrumbs="[['label' => 'Pengurusan Negara', 'url' => route('settingsCountry')], ['label' => 'Daftar Negara']]" />
      <x-alert />

      <form method="POST" action="{{ route('settingsCreate', ['group' => $selectedGroup]) }}"
        class="rounded-lg bg-white text-xs shadow sm:p-6">
        @csrf
        <x-required-warning-text />
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

          <x-input-field level="Parameter (prm)" id="prm" name="prm" type="text" placeholder=""
            :required="true" />
          <x-input-field level="Kod Negara (code)" id="code" name="code" type="text" placeholder=""
            :required="true" />

        </div>

        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
          <x-input-field level="Nilai (val)" id="val" name="val" type="text" placeholder="" />
          <x-input-field level="Keterangan (des)" id="des" name="des" type="text" placeholder="" />
        </div>

        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-3">
          <x-input-field level="SID" id="sid" name="sid" type="text" placeholder="" />
          <x-input-field level="Level" id="lvl" name="lvl" type="text" placeholder="" />
          <x-input-field level="ETC" id="etc" name="etc" type="select" placeholder="" :value="$selectedParent"
            :valueList="$parentGroup" />

        </div>

        <div class="mt-4">
          <x-input-field level="Index (idx)" id="idx" name="idx" type="number" placeholder="" />
        </div>

        <div class="mt-8 flex justify-between">
          <a href="{{ route('settingsCountry') }}"
            class="ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg inline-flex items-center justify-center bg-gray-500 font-medium text-white hover:bg-gray-600">
            Kembali
          </a>

          <button
            class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg bg-indigo-500 font-semibold text-white hover:bg-indigo-600"
            type="submit">
            Simpan
          </button>
        </div>

      </form>
    </div>
  </div>
@endsection
