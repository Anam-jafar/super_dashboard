@extends('layouts.app')

@section('styles')
@endsection

@section('content')
  <!-- Start::app-content -->
  <div class="main-content app-content">
    <div class="container-fluid">

      <!-- Start::page-header -->
      <div class="page-header-breadcrumb flex flex-wrap items-center justify-between gap-2">
        <div>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="javascript:void(0);">
                Utama </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"> Laman Utama
            </li>
          </ol>
          <h1 class="page-title mb-0 text-lg font-medium"> Laman Utama
          </h1>
        </div>
      </div>
      <!-- End::page-header -->

      <!-- Start::Row-1 -->
      <div class="grid grid-cols-12 gap-x-6">

        {{-- Left Side --}}
        <div class="col-span-12 xl:col-span-9">
          <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">

            {{-- First Row of Dashboard Cards --}}
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Jumlah Institusi Berdaftar</span>
                      <h4 class="card-value">{{ $total_institute ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_1.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Permohonan Daftar Masjid</span>
                      <h4 class="card-value">{{ $total_institute_registration ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_2.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Status Menunggu Semakan</span>
                      <h4 class="card-value">{{ $total_statement_to_review ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_3.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Jumlah Diterima</span>
                      <h4 class="card-value">{{ $total_statement_accepted ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_5.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Jumlah Ditolak</span>
                      <h4 class="card-value">{{ $total_statement_cancelled ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_4.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- End of First Row --}}

            {{-- Second Row of Dashboard Cards --}}
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Jumlah Mohon Kemaskini</span>
                      <h4 class="card-value">{{ $total_statement_request_edit ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_6.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Status Menunggu Semakan</span>
                      <h4 class="card-value">{{ $total_statement_to_review ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_3.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Jumlah Diterima</span>
                      <h4 class="card-value">{{ $total_statement_accepted ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_5.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Jumlah Ditolak</span>
                      <h4 class="card-value">{{ $total_statement_cancelled ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_4.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div>
                      <span class="card-title">Jumlah Mohon Kemaskini</span>
                      <h4 class="card-value">{{ $total_statement_request_edit ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_6.svg') }}" alt="logo"
                        class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- End::Second Row --}}

          </div>
        </div>
        {{-- End::Left Side --}}

        {{-- Right Side --}}
        <div class="col-span-12 xl:col-span-3">
          <div class="box h-full overflow-hidden"
            style="background-image: url('{{ asset('assets/icons/banner.png') }}'); background-size: cover; background-position: center; min-height:225px">
            <div class="box-body relative p-3">
              <div class="grid grid-cols-12 justify-between">
              </div>

              <!-- Dark Transparent Footer for Date & Time -->
              <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-50 p-3 text-center text-white">
                <span class="text-lg font-semibold">
                  {{ now('Asia/Kuala_Lumpur')->format('l, d F Y') }}
                </span>
              </div>
            </div>
          </div>
        </div>
        {{-- End::Right Side --}}

      </div>
      <!-- End::Row-1 -->

      <!-- Start::Row-2 -->
      {{-- Financial Reports Grid Container --}}
      <div class="grid grid-cols-12 gap-6">
        {{-- Filters Row --}}
        <div class="col-span-12">
          <div class="mb-2 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <!-- Header -->
            <h2 class="text-lg font-semibold text-gray-800 sm:mb-0">Statistic</h2>

            <!-- Filters -->
            <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
              <!-- Year Dropdown -->
              <select id="yearSelect" class="w-full rounded-md border px-3 py-2 sm:w-20">
                @foreach ($years as $year)
                  <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                    {{ $year }}
                  </option>
                @endforeach
              </select>

              <!-- District Dropdown -->
              <select id="districtSelect" class="w-full rounded-md border px-3 py-2 sm:w-40">
                <option value="">Semua Daerah</option>
                @foreach ($districts as $code => $prm)
                  <option value="{{ $code }}">
                    {{ $prm }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        {{-- Financial Report Pie Chart 1 --}}
        <div class="col-span-12 xl:col-span-6 xxl:col-span-3">
          <div class="box overflow-hidden">
            <div class="box-header justify-between pb-0">
              <div class="box-title">
                Penghantaran Laporan Kewangan
              </div>
            </div>

            <div class="box-body px-3 py-4">
              <div id="orders1" class="my-2"></div>
            </div>

            <div class="box-footer border-t border-dashed px-4 py-3">
              <div class="flex items-center justify-between">
                <!-- Left Section -->
                <div class="text-gray-700 dark:text-gray-300">
                  <h5 class="mb-2 text-sm font-semibold">Jumlah Penghantaran</h5>
                  <h5 class="text-sm font-semibold">Jumlah Institusi Berdaftar</h5>
                </div>

                <!-- Right Section -->
                <div class="text-right text-gray-700 dark:text-gray-300">
                  <h5 id="totalEntries1" class="mb-2 text-lg font-bold">{{ $totalEntries }}</h5>
                  <h5 id="totalClients1" class="text-lg font-bold">{{ $totalClients }}</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- End::Financial Report Pie Chart 1 --}}

        {{-- Financial Report Pie Chart 2 --}}
        <div class="col-span-12 xl:col-span-6 xxl:col-span-3">
          <div class="box overflow-hidden">
            <div class="box-header justify-between pb-0">
              <div class="box-title">
                Status Pematuhan Kewangan
              </div>
            </div>

            <div class="box-body px-3 py-4">
              <div id="orders2" class="my-2"></div>
            </div>

            <div class="box-footer border-t border-dashed px-4 py-3">
              <div class="flex items-center justify-between">
                <!-- Left Section -->
                <div class="text-gray-700 dark:text-gray-300">
                  <h5 class="mb-2 text-sm font-semibold">Jumlah Penghantaran</h5>
                  <h5 class="text-sm font-semibold">Jumlah Institusi Berdaftar</h5>
                </div>

                <!-- Right Section -->
                <div class="text-right text-gray-700 dark:text-gray-300">
                  <h5 id="totalEntries2" class="mb-2 text-lg font-bold">{{ $totalEntries }}</h5>
                  <h5 id="totalClients2" class="text-lg font-bold">{{ $totalClients }}</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- End::Financial Report Pie Chart 2 --}}

        {{-- Financial Report Pie Chart 3 --}}
        <div class="col-span-12 xl:col-span-6 xxl:col-span-3">
          <div class="box overflow-hidden">
            <div class="box-header justify-between pb-0">
              <div class="box-title">
                Pengesahan Audit Tahunan
              </div>
            </div>

            <div class="box-body px-3 py-4">
              <div id="orders3" class="my-2"></div>
            </div>

            <div class="box-footer border-t border-dashed px-4 py-3">
              <div class="flex items-center justify-between">
                <!-- Left Section -->
                <div class="text-gray-700 dark:text-gray-300">
                  <h5 class="mb-2 text-sm font-semibold">Jumlah Penghantaran</h5>
                  <h5 class="text-sm font-semibold">Jumlah Institusi Berdaftar</h5>
                </div>

                <!-- Right Section -->
                <div class="text-right text-gray-700 dark:text-gray-300">
                  <h5 id="totalEntries3" class="mb-2 text-lg font-bold">{{ $totalEntries }}</h5>
                  <h5 id="totalClients3" class="text-lg font-bold">{{ $totalClients }}</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- End::Financial Report Pie Chart 3 --}}

        {{-- Financial Report Pie Chart 4 --}}
        <div class="col-span-12 xl:col-span-6 xxl:col-span-3">
          <div class="box overflow-hidden">
            <div class="box-header justify-between pb-0">
              <div class="box-title">
                Status Dokumen Kewangan
              </div>
            </div>

            <div class="box-body px-3 py-4">
              <div id="orders4" class="my-2"></div>
            </div>

            <div class="box-footer border-t border-dashed px-4 py-3">
              <div class="flex items-center justify-between">
                <!-- Left Section -->
                <div class="text-gray-700 dark:text-gray-300">
                  <h5 class="mb-2 text-sm font-semibold">Jumlah Penghantaran</h5>
                  <h5 class="text-sm font-semibold">Jumlah Institusi Berdaftar</h5>
                </div>

                <!-- Right Section -->
                <div class="text-right text-gray-700 dark:text-gray-300">
                  <h5 id="totalEntries4" class="mb-2 text-lg font-bold">{{ $totalEntries }}</h5>
                  <h5 id="totalClients4" class="text-lg font-bold">{{ $totalClients }}</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- End::Financial Report Pie Chart 4 --}}
      </div>
      {{-- End::Financial Reports Grid Container --}}

      <!-- End::Row-2 -->

      <!-- Start::Row-3 -->
      <div class="grid grid-cols-12 gap-x-6">

        {{-- Left Side --}}
        <div class="col-span-12 xl:col-span-8">
          <div class="grid grid-cols-12 gap-x-6">

            {{-- New Registration Requests --}}
            <div class="col-span-12 xl:col-span-4 xxl:col-span-4">
              <div class="box">
                <div class="box-header justify-between">
                  <div class="box-title">
                    Permohonan Pendaftaran
                  </div>
                  <a href="{{ route('registrationRequests') }}"
                    class="ti-ti-btn ti-btn-light btn-wave waves-effect waves-light px-2 py-[0.26rem] text-textmuted dark:text-textmuted/50">Lihat
                    Semua</a>
                </div>
                <div class="box-body mb-6 mt-6 flex flex-col justify-start" style="min-height: 350px;">
                  @if (!isset($institute_registration_list[0]))
                    <div class="text-center text-gray-500">Tiada rekod ditemui</div>
                  @endif
                  <ul class="recent-activity-list list-none">
                    @if (isset($institute_registration_list[0]))
                      <li>
                        <div>
                          <div>
                            <div class="text-[14px] font-medium">
                              {{ $institute_registration_list[0]->name }}</div>
                            <span class="activity-time text-xs">
                              {{ \Carbon\Carbon::parse($institute_registration_list[0]->registration_request_date)->format('d-m-y') }}
                            </span>
                          </div>
                          <span class="block text-textmuted dark:text-textmuted/50">
                            {{ $institute_registration_list[0]->Category->prm }}<br>
                            <span class="font-medium text-primary">{{ $institute_registration_list[0]->con1 }}</span>.
                          </span>
                        </div>
                      </li>
                    @endif

                    @if (isset($institute_registration_list[1]))
                      <li>
                        <div>
                          <div>
                            <div class="text-[14px] font-medium">
                              {{ $institute_registration_list[1]->name }}</div>
                            <span class="activity-time text-xs">
                              {{ \Carbon\Carbon::parse($institute_registration_list[1]->registration_request_date)->format('d-m-y') }}
                            </span>
                          </div>
                          <span class="block text-textmuted dark:text-textmuted/50">
                            {{ $institute_registration_list[1]->Category->prm }}<br>
                            <span class="font-medium text-primary">{{ $institute_registration_list[1]->con1 }}</span>.
                          </span>
                        </div>
                      </li>
                    @endif

                    @if (isset($institute_registration_list[2]))
                      <li>
                        <div>
                          <div>
                            <div class="text-[14px] font-medium">
                              {{ $institute_registration_list[2]->name }}</div>
                            <span class="activity-time text-xs">
                              {{ \Carbon\Carbon::parse($institute_registration_list[2]->registration_request_date)->format('d-m-y') }}
                            </span>
                          </div>
                          <span class="block text-textmuted dark:text-textmuted/50">
                            {{ $institute_registration_list[2]->Category->prm }}<br>
                            <span class="font-medium text-primary">{{ $institute_registration_list[2]->con1 }}</span>.
                          </span>
                        </div>
                      </li>
                    @endif

                    @if (isset($institute_registration_list[3]))
                      <li>
                        <div>
                          <div>
                            <div class="text-[14px] font-medium">
                              {{ $institute_registration_list[3]->name }}</div>
                            <span class="activity-time text-xs">
                              {{ \Carbon\Carbon::parse($institute_registration_list[3]->registration_request_date)->format('d-m-y') }}
                            </span>
                          </div>
                          <span class="block text-textmuted dark:text-textmuted/50">
                            {{ $institute_registration_list[3]->Category->prm }}<br>
                            <span class="font-medium text-primary">{{ $institute_registration_list[3]->con1 }}</span>.
                          </span>
                        </div>
                      </li>
                    @endif

                    @if (isset($institute_registration_list[4]))
                      <li>
                        <div>
                          <div>
                            <div class="text-[14px] font-medium">
                              {{ $institute_registration_list[4]->name }}</div>
                            <span class="activity-time text-xs">
                              {{ \Carbon\Carbon::parse($institute_registration_list[4]->registration_request_date)->format('d-m-y') }}
                            </span>
                          </div>
                          <span class="block text-textmuted dark:text-textmuted/50">
                            {{ $institute_registration_list[4]->Category->prm }}<br>
                            <span class="font-medium text-primary">{{ $institute_registration_list[4]->con1 }}</span>.
                          </span>
                        </div>
                      </li>
                    @endif
                  </ul>
                </div>

              </div>
            </div>
            {{-- End::New Registration Requests --}}

            {{-- Financial Statements List --}}
            <div class="col-span-12 xl:col-span-8 xxl:col-span-8">
              <div class="box overflow-hidden">
                <div class="box-header justify-between">
                  <div class="box-title">
                    Senarai Laporan Kewangan Disemak
                  </div>
                  <a href="{{ route('statementList') }}"
                    class="ti-btn ti-btn-light btn-wave ti-btn-sm text-textmuted dark:text-textmuted/50">Lihat
                    Semua
                    <i class="ti ti-arrow-narrow-right"></i></a>
                </div>
                <div class="box-body mb-6 mt-6 flex flex-col justify-start" style="min-height: 350px;">
                  <div class="table-responsive">
                    <table class="ti-custom-table text-nowrap">
                      <thead>
                        <tr>
                          <th>Tarikh Hantar</th>
                          <th>Kategori Penyata</th>
                          <th>Nama Institusi</th>
                          <th>Daerah</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (isset($financial_statements_list) && $financial_statements_list->isNotEmpty())
                          @foreach ($financial_statements_list as $statement)
                            <tr>
                              <td>
                                <div class="flex items-center gap-2">
                                  <div class="font-medium">
                                    {{ $statement->SUBMISSION_DATE ?? '-' }}</div>
                                </div>
                              </td>
                              <td>
                                @php
                                  $badgeClass = 'bg-secondary'; // Default color
                                  if (isset($statement->CATEGORY)) {
                                      if ($statement->CATEGORY === '01 TAHUN') {
                                          $badgeClass = 'bg-primary';
                                      } elseif ($statement->CATEGORY === '06 BULAN') {
                                          $badgeClass = 'bg-primarytint1color'; // Use the correct Tailwind or Bootstrap class for tint
                                      }
                                  }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $statement->CATEGORY ?? '-' }}</span>
                              </td>

                              <td>
                                <span class="font-medium">{{ $statement->INSTITUTE ?? '-' }}</span>
                              </td>
                              <td>
                                <span class="font-medium">{{ $statement->DISTRICT ?? '-' }}</span>
                              </td>
                            </tr>
                          @endforeach
                        @else
                          <tr>
                            <td colspan="4" class="text-center text-gray-500">Tiada rekod
                              Ditemui</td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>
            {{-- End::Financial Statements List --}}
          </div>
        </div>
        {{-- End::Left Side --}}

        {{-- Right Side --}}
        <div class="col-span-12 xl:col-span-4">
          <div class="grid grid-cols-12 gap-x-6">

            {{-- Institute Count by District --}}
            @php
              // Define an array of theme colors
              $colors = ['bg-primarytint3color', 'bg-primarytint2color', 'bg-primarytint1color', 'bg-primary'];
            @endphp
            <div class="xl:col-span12 col-span-12">
              <div class="box">
                <div class="box-header justify-between">
                  <div class="box-title">
                    Jumlah Institusi Mengikut Daerah
                  </div>
                  <div>
                    (Jumlah {{ $institute_by_district->sum('total') }})
                  </div>
                </div>
                <div class="box-body mb-6 mt-6 flex flex-col justify-start" style="min-height: 460px;">
                  <ul class="sales-country-list list-none">
                    @foreach ($institute_by_district as $district)
                      @if (!empty($district->DISTRICT))
                        @php
                          // Pick a random color from the predefined theme colors
                          $randomColor = $colors[array_rand($colors)];
                        @endphp
                        <li>
                          <div class="flex items-start gap-4">
                            <div class="w-full flex-auto">
                              <div class="flex items-center justify-between">
                                <span class="mb-2 block font-medium leading-none">
                                  {{ $district->DISTRICT }}
                                </span>
                                <span class="block text-[14px] font-medium leading-none">
                                  {{ $district->total }}
                                </span>
                              </div>
                              <div class="progress progress-md p-1" role="progressbar"
                                aria-valuenow="{{ $district->total }}" aria-valuemin="0"
                                aria-valuemax="{{ $maxCount }}">
                                <div class="progress-bar {{ $randomColor }} !rounded-s-full"
                                  style="width: {{ $maxCount > 0 ? ($district->total / $maxCount) * 100 : 0 }}%;">
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      @endif
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            {{-- End::Institute Count by District --}}
          </div>
        </div>
        {{-- End::Right Side --}}

      </div>
      <!-- End::Row-3 -->

      <!-- Start::Row-4 -->
      @if (!in_array(Auth::user()->syslevel, ['ACL02', 'ACL03']))
        <div class="grid grid-cols-12 gap-x-6">
          <div class="col-span-12">
            <div class="box overflow-hidden">
              <div class="box-header justify-between">
                <div class="box-title">
                  Senarai Pembayaran Langganan Tertunggak
                </div>
                <a href="{{ route('outstandingSubscriptions') }}"
                  class="ti-btn ti-btn-light btn-wave waves-effect waves-light px-2 py-[0.26rem] text-textmuted dark:text-textmuted/50">
                  Lihat Semua
                </a>
              </div>
              <div class="box-body mb-6 mt-6 flex flex-col justify-start" style="min-height: 460px;">
                <div class="table-responsive">
                  <table class="ti-custom-table text-nowrap">
                    <thead>
                      <tr class="border !border-defaultborder dark:!border-defaultborder/10">
                        <th>Nama Institusi</th>
                        <th>Nama Wakil</th>
                        <th class="!text-center">No. Telefon</th>
                        <th class="!text-center">Jumlah Tertunggak</th>
                        <th class="!text-center">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($subscriptions as $subscription)
                        <tr class="border !border-defaultborder dark:!border-defaultborder/10">
                          <td>
                            <div class="flex items-center gap-4">
                              <div>
                                <span class="block font-medium">{{ $subscription->NAME }}</span>
                                <span class="block text-[11px] text-textmuted dark:text-textmuted/50">
                                  {{ $subscription->EMAIL }}
                                </span>
                              </div>
                            </div>
                          </td>
                          <td>{{ $subscription->OFFICER }}</td>
                          <td class="text-center">{{ $subscription->PHONE }}</td>
                          <td class="text-center">
                            RM {{ number_format($subscription->TOTAL_OUTSTANDING, 2) }}
                          </td>
                          <td class="text-center">
                            <span class="badge bg-primarytint1color">{{ $subscription->STATUS ?? '-' }}</span>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
      <!-- End::Row-4 -->

    </div>
  </div>
  <!-- End::app-content -->
@endsection

@section('scripts')
  <!-- Apex Charts JS -->
  <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const yearSelect = document.getElementById("yearSelect");
      const districtSelect = document.getElementById("districtSelect");

      // Elements for Chart 1
      const totalEntriesEl1 = document.getElementById("totalEntries1");
      const totalClientsEl1 = document.getElementById("totalClients1");

      // Elements for Chart 2
      const totalEntriesEl2 = document.getElementById("totalEntries2");
      const totalClientsEl2 = document.getElementById("totalClients2");

      // Elements for Chart 3
      const totalEntriesEl3 = document.getElementById("totalEntries3");
      const totalClientsEl3 = document.getElementById("totalClients3");

      // Elements for Chart 4
      const totalEntriesEl4 = document.getElementById("totalEntries4");
      const totalClientsEl4 = document.getElementById("totalClients4");

      // Chart instances
      let chart1, chart2, chart3, chart4;

      function fetchFinancialReport(year, district) {
        fetch(`{{ route('getFinancialReport') }}?year=${year}&district=${district}`)
          .then(response => response.json())
          .then(data => {
            // Update all 4 charts with the same data initially
            // In the future, the backend could return different data sets for each chart

            // Update Chart 1
            totalEntriesEl1.textContent = data.totalEntries;
            totalClientsEl1.textContent = data.totalClients;
            updateChart(1, "orders1", data.totalEntries, data.totalClients, chart1);
            chart1 = chart1 || window.chart1;

            // Update Chart 2
            totalEntriesEl2.textContent = data.totalEntries;
            totalClientsEl2.textContent = data.totalClients;
            updateChart(2, "orders2", data.totalEntries, data.totalClients, chart2);
            chart2 = chart2 || window.chart2;

            // Update Chart 3
            totalEntriesEl3.textContent = data.totalEntries;
            totalClientsEl3.textContent = data.totalClients;
            updateChart(3, "orders3", data.totalEntries, data.totalClients, chart3);
            chart3 = chart3 || window.chart3;

            // Update Chart 4
            totalEntriesEl4.textContent = data.totalEntries;
            totalClientsEl4.textContent = data.totalClients;
            updateChart(4, "orders4", data.totalEntries, data.totalClients, chart4);
            chart4 = chart4 || window.chart4;
          })
          .catch(error => console.error("Error fetching data:", error));
      }

      function updateChart(chartNumber, chartElementId, totalEntries, totalClients) {
        const remainingClients = totalClients - totalEntries;

        // Avoid division by zero and round to the nearest whole number
        const percentageSent = totalClients > 0 ? Math.round((totalEntries / totalClients) * 100) : 0;

        // Define different colors for each chart
        const colorSets = {
          1: ["rgba(var(--primary-rgb))", "rgba(227, 84, 212, 1)"],
          2: ["rgba(255, 93, 159, 1)", "rgba(255, 142, 111, 1)"],
          3: ["rgba(0, 158, 247, 1)", "rgba(41, 204, 151, 1)"],
          4: ["rgba(255, 199, 0, 1)", "rgba(247, 103, 7, 1)"]
        };

        const options = {
          series: [totalEntries, remainingClients],
          labels: ["Dihantar", "Belum Dihantar"],
          chart: {
            height: 175,
            type: 'donut',
          },
          dataLabels: {
            enabled: false,
          },
          legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            height: 52,
            markers: {
              width: 8,
              height: 8,
              radius: 2,
              shape: "circle",
              size: 4,
              strokeWidth: 0
            },
            offsetY: 10,
          },
          stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'round',
            colors: "#fff",
            width: 0,
            dashArray: 0,
          },
          plotOptions: {
            pie: {
              startAngle: -90,
              endAngle: 90,
              offsetY: 10,
              expandOnClick: false,
              donut: {
                size: '80%',
                background: 'transparent',
                labels: {
                  show: true,
                  name: {
                    show: true,
                    fontSize: '20px',
                    color: '#495057',
                    offsetY: -25
                  },
                  value: {
                    show: true,
                    fontSize: '16px',
                    fontWeight: 600,
                    offsetY: -20,
                    formatter: function() {
                      return percentageSent + "%"; // Show percentage without decimal points
                    }
                  },
                  total: {
                    show: true,
                    showAlways: true,
                    label: 'Peratusan',
                    fontSize: '16px',
                    fontWeight: 600,
                    color: '#495057',
                    formatter: function() {
                      return percentageSent + "%"; // Show total percentage at center
                    }
                  }
                }
              }
            }
          },
          grid: {
            padding: {
              bottom: -100
            }
          },
          colors: colorSets[chartNumber]
        };

        // Check if chart instance exists
        const chartInstance = window[`chart${chartNumber}`];

        if (chartInstance) {
          chartInstance.updateOptions(options);
        } else {
          window[`chart${chartNumber}`] = new ApexCharts(document.querySelector(`#${chartElementId}`), options);
          window[`chart${chartNumber}`].render();
        }
      }

      // Initial Load
      fetchFinancialReport(yearSelect.value, districtSelect.value);

      // Event Listener for Year Change
      yearSelect.addEventListener("change", function() {
        fetchFinancialReport(this.value, districtSelect.value);
      });

      // Event Listener for District Change
      districtSelect.addEventListener("change", function() {
        fetchFinancialReport(yearSelect.value, this.value);
      });
    });
  </script>
@endsection
