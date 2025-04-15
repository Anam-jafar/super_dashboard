@extends('layouts.app')

@section('styles')
@endsection

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Kemaskini'" :breadcrumbs="[['label' => 'Setting', 'url' => route('settingsList')], ['label' => 'Kemaskini']]" />
      <x-alert />

      <form method="POST" action="{{ route('settingsEdit', $item->id) }}" class="rounded-lg bg-white text-xs shadow sm:p-6">
        @csrf
        <x-required-warning-text />
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          @if (count($parentGroup) > 0)
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <x-input-field level="{{ $levelParameter }}" id="prm" name="prm" type="text" placeholder=""
                :required="true" :value="$item->prm" />
              <x-input-field level="{{ $levelParentParameter }}" id="etc" name="etc" type="select"
                placeholder="" :value="$selectedParent" :valueList="$parentGroup" :required="true" :value="$item->etc" />
            </div>
          @else
            <x-input-field level="{{ $levelParameter }}" id="prm" name="prm" type="text" placeholder=""
              :required="true" :value="$item->prm" />
          @endif

          <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <x-input-field level="Kod Negara" id="code" name="code" type="text" placeholder=""
              :readonly="true" :value="$item->code" />
            <x-input-field level="Index" id="idx" name="idx" type="number" placeholder=""
              :value="$item->idx" />
          </div>
        </div>
        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
          <x-input-field level="Keterangan" id="des" name="des" type="text" placeholder=""
            :value="$item->des" />
        </div>

        <div class="mt-8 flex justify-between">
          <a href="{{ route('settingsList') }}"
            class="ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg inline-flex items-center justify-center bg-gray-500 font-medium text-white hover:bg-gray-600">
            Kembali
          </a>

          <button
            class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg bg-indigo-500 font-semibold text-white hover:bg-indigo-600"
            type="submit">
            Kemaskini
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
