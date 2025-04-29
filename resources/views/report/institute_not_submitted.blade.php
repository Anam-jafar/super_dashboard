@extends('layouts.app')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Jumlah Penghantaran yang Ditapis'" :breadcrumbs="[
          ['label' => 'Pelaporan', 'url' => 'javascript:void(0);'],
          ['label' => 'Jumlah Penghantaran', 'url' => 'javascript:void(0);'],
          ['label' => 'Jumlah Penghantaran yang Ditapis'],
      ]" />
      <x-alert />
      <div class="rounded-lg bg-white px-4 py-8 shadow">

        <div class="2xl:justify-start flex w-full flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <!-- Filters Form -->
          <form method="GET" action="{{ route('filteredSubmission', $queries) }}"
            class="order-2 flex flex-col gap-4 md:flex-row lg:order-1 lg:flex-1">

            {{-- Preserve all other query parameters except 'status' --}}
            @foreach (request()->except('status') as $key => $value)
              <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            {{-- Status filter dropdown --}}
            <div class="w-full lg:max-w-[14rem]">
              <select id="status" name="status" class="ti-form-select w-full text-ellipsis rounded-sm py-2 pr-1"
                onchange="this.form.submit()">

                <option value="not_submitted" {{ request()->has('status') ? '' : 'selected' }}>
                  Belum Hantar
                </option>

                @foreach ($statuses as $key => $value)
                  <option value="{{ $key }}"
                    {{ request('status') !== null && request('status') == $key ? 'selected' : '' }}>
                    {{ is_object($value) ? $value->name ?? 'Unknown' : $value }}
                  </option>
                @endforeach
              </select>
            </div>

          </form>

          <!-- Download Button -->
          <div class="order-1 flex w-full flex-row gap-2 lg:order-2 lg:w-auto">
            <a href="{{ request()->fullUrlWithQuery(['excel' => true]) }}"
              class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-lg flex w-full items-center justify-center rounded-sm border border-gray-300 bg-white p-2 hover:bg-gray-50 lg:w-auto">
              <span class="fe fe-download mr-1 text-center text-gray-700"></span>
              <span class="text-sm font-normal text-gray-700 sm:inline md:inline lg:hidden">Download</span>
            </a>
          </div>
        </div>

        <x-table :headers="['Institusi', 'Nama Institusi', 'Wakil Institusi', 'Nombor Telefon', 'Emel', 'Daerah', 'Mukim']" :columns="['CATEGORY', 'INSTITUTE', 'OFFICER', 'HP', 'EMAIL', 'DISTRICT', 'SUBDISTRICT']" :rows="$entries" />
        <x-pagination :items="$entries" label="jumlah rekod" />

      </div>
    </div>
  </div>
@endsection
