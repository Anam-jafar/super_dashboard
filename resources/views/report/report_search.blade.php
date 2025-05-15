@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Carian Penghantaran Laporan Kewangan'" :breadcrumbs="[['label' => 'Pelaporan', 'url' => 'javascript:void(0);'], ['label' => 'Carian Laporan']]" />
      <x-alert />

      <form method="POST" action="{{ route('searchStatementReport') }}" class="">
        @csrf
        <div class="mt-4 space-y-2 rounded-lg bg-white px-4 py-8 text-xs shadow lg:px-8">
          <div>
            <span class="text-md fe fe-info text-red-500"> Ruangan bertanda (*) adalah wajib dipilih</span>
          </div>

          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-2 gap-6">
              <x-input-field level="Tahun Laporan" id="incharge" name="fin_year" type="select" placeholder="Pilih"
                :valueList="$years" :required="true" />
              <x-input-field level="Status Penghantaran" id="nric" name="status" type="select" placeholder="Pilih"
                :valueList="$parameters['financial_statement_statuses']" :required="true" />
            </div>

            <div class="grid grid-cols-2 gap-6">
              <x-input-field level="Daerah" id="pos" name="rem8" type="select" placeholder="Pilih"
                :valueList="$parameters['districts']" />
              <x-input-field level="Institusi" id="hp" name="institute" type="select" placeholder="Pilih"
                :valueList="$parameters['types']" />
            </div>
          </div>

          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-2 gap-6">
              <x-input-field level="Kategori Penyata" id="incharge" name="fin_category" type="select"
                placeholder="Pilih" :valueList="$parameters['statements']" />
              <x-input-field level="Jenis Institusi" id="nric" name="institute_type" type="select"
                placeholder="Pilih" :valueList="$parameters['categories']" />
            </div>

            <div class="grid grid-cols-2 gap-6">
              <x-input-field level="Tahun Penghantaran Penyata Kewangan" id="pos" name="year" type="select"
                placeholder="Pilih" :valueList="$years" />
              <x-input-field level="Bulan Penghantaran Penyata Kewangan" id="hp" name="month" type="select"
                placeholder="Pilih" :valueList="$months" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-6" style="margin-top: 1.5rem;">
            <p class="font-normal text-gray-800">Tarikh Penghantaran Penyata Kewangan</p>
          </div>
          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-2 gap-6">
              <x-input-field level="Dari" id="incharge" name="start_date" type="date" placeholder="Pilih"
                :valueList="$years" />
              <x-input-field level="Hingga" id="nric" name="end_date" type="date" placeholder="Pilih"
                :valueList="$parameters['financial_statement_statuses']" />
            </div>
          </div>

          <br><br>
          <div class="!mt-8 flex justify-end">

            <button
              class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg bg-indigo-500 font-semibold text-white hover:bg-indigo-600"
              type="submit">
              Cari
            </button>

          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
