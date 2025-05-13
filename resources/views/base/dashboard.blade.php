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
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Berdaftar (Aktif)</span>
                      </div>
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
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Masjid Pengurusan</span>
                      </div>
                      <h4 class="card-value">{{ $categoryCounts['MAP'] ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/card_icon_1.svg') }}" alt="logo" class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Masjid Institusi</span>
                      </div>
                      <h4 class="card-value">{{ $categoryCounts['MAI'] ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/card_icon_1.svg') }}" alt="logo" class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Masjid Kariah</span>
                      </div>
                      <h4 class="card-value">{{ $categoryCounts['MAK'] ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/card_icon_1.svg') }}" alt="logo" class="toggle-dark card-icon">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-1">
              <div class="box dashboard-card overflow-hidden">
                <div class="box-body">
                  <div class="flex items-start justify-between">
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Masjid Pembinaan</span>
                      </div>
                      <h4 class="card-value">{{ $categoryCounts['MPD'] ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/card_icon_1.svg') }}" alt="logo" class="toggle-dark card-icon">
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
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Surau Biasa</span>
                      </div>
                      <h4 class="card-value">{{ $categoryCounts['SUB'] ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/card_icon_2.svg') }}" alt="logo"
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
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Kebenaran Jumaat</span>
                      </div>
                      <h4 class="card-value">{{ $categoryCounts['SKJ'] ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/card_icon_2.svg') }}" alt="logo"
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
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Surau Pembinaan</span>
                      </div>
                      <h4 class="card-value">{{ $categoryCounts['SUD'] ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/card_icon_2.svg') }}" alt="logo"
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
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Musolla</span>
                      </div>
                      <h4 class="card-value">{{ $categoryCounts['MSL'] ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/card_icon_3.svg') }}" alt="logo"
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
                    <div class="flex flex-col">
                      <div class="card-title-container">
                        <span class="card-title">Bil Musolla Kebenaran Jumaat</span>
                      </div>
                      <h4 class="card-value">{{ $categoryCounts['MKJ'] ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/card_icon_3.svg') }}" alt="logo"
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

      <div class="mt-4 grid grid-cols-12 gap-6">
        {{-- Filters Row --}}
        <div class="col-span-12">
          <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <!-- Header -->
            <div>
              <h2 class="text-lg font-semibold text-gray-800">Statistik</h2>
            </div>
            <!-- Filters -->
            <div class="grid w-full grid-cols-1 gap-2 sm:w-auto sm:grid-cols-2 md:grid-cols-4">
              <!-- Year Dropdown -->
              <select id="yearSelect" class="w-full rounded-md border px-3 py-2">
                @foreach ($years as $year)
                  <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                    {{ $year }}
                  </option>
                @endforeach
              </select>

              <!-- Statement Dropdown -->
              <select id="finCategorySelect" class="w-full rounded-md border px-3 py-2">
                <option value="STM02">01 Tahun</option>
                @foreach (collect($statement)->except('STM02') as $code => $label)
                  <option value="{{ $code }}">{{ $label }}</option>
                @endforeach
              </select>

              <!-- Institute Dropdown -->
              <select id="instituteSelect" class="w-full rounded-md border px-3 py-2">
                <option value="">Semua Institusi</option>
                @foreach ($institute as $code => $prm)
                  <option value="{{ $code }}">{{ $prm }}
                  </option>
                @endforeach
              </select>

              <!-- District Dropdown -->
              <select id="districtSelect" class="w-full rounded-md border px-3 py-2">
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
              </div>
            </div>

            <div class="box-body px-3 py-4">
              <div id="orders1" class="my-2"></div>
            </div>

            <div class="box-footer border-t border-dashed px-4 py-3">
              <div class="flex items-center justify-between">
                <!-- Left Section -->
                <div class="text-gray-700 dark:text-gray-300">
                  <h5 class="mb-2 text-sm font-semibold">Bil Hantar</h5>
                  <h5 class="text-sm font-semibold">Bil Daftar (Aktif)</h5>
                </div>

                <!-- Right Section -->
                <div class="text-right text-gray-700 dark:text-gray-300">
                  <h5 id="totalSubmitted" class="mb-2 text-lg font-bold"></h5>
                  <h5 id="totalNotSubmitted" class="text-lg font-bold"></h5>
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
              </div>
            </div>

            <div class="box-body px-3 py-4">
              <div id="orders2" class="my-2"></div>
            </div>

            <div class="box-footer border-t border-dashed px-4 py-3">
              <div class="flex items-center justify-between">
                <!-- Left Section -->
                <div class="text-gray-700 dark:text-gray-300">
                  <h5 class="mb-2 text-sm font-semibold">
                    Bil Dah Semak
                  </h5>
                  <h5 class="text-sm font-semibold">Bil Belum Semak</h5>
                </div>

                <!-- Right Section -->
                <div class="text-right text-gray-700 dark:text-gray-300">
                  <h5 id="totalChecked" class="mb-2 text-lg font-bold"></h5>
                  <h5 id="totalUnchecked" class="text-lg font-bold"></h5>
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
              </div>
            </div>

            <div class="box-body px-3 py-4">
              <div id="orders3" class="my-2"></div>
            </div>

            <div class="box-footer border-t border-dashed px-4 py-3">
              <div class="flex items-center justify-between">
                <!-- Left Section -->
                <div class="text-gray-700 dark:text-gray-300">
                  <h5 class="mb-2 text-sm font-semibold">Bil Terima</h5>
                  <h5 class="text-sm font-semibold">Bil Ditolak</h5>
                </div>

                <!-- Right Section -->
                <div class="text-right text-gray-700 dark:text-gray-300">
                  <h5 id="totalAccepted" class="mb-2 text-lg font-bold"></h5>
                  <h5 id="totalRejected" class="text-lg font-bold"></h5>
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
              </div>
            </div>

            <div class="box-body px-3 py-4">
              <div id="orders4" class="my-2"></div>
            </div>

            <div class="box-footer border-t border-dashed px-4 py-3">
              <div class="flex items-center justify-between">
                <!-- Left Section -->
                <div class="text-gray-700 dark:text-gray-300">
                  <h5 class="mb-2 text-sm font-semibold">Bil Tolak & Telah Hantar Semula</h5>
                  <h5 class="text-sm font-semibold">Bil Ditolak Belum Hantar Semula</h5>
                </div>

                <!-- Right Section -->
                <div class="text-right text-gray-700 dark:text-gray-300">
                  <h5 id="totalResubmitted" class="mb-2 text-lg font-bold"></h5>
                  <h5 id="totalNotResubmitted" class="text-lg font-bold"></h5>
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
      const finCategorySelect = document.getElementById("finCategorySelect");
      const instituteSelect = document.getElementById("instituteSelect");


      // Elements for Chart 1
      const totalSubmitted = document.getElementById("totalSubmitted");
      const totalNotSubmitted = document.getElementById("totalNotSubmitted");

      // Elements for Chart 2
      const totalChecked = document.getElementById("totalChecked");
      const totalUnchecked = document.getElementById("totalUnchecked");

      // Elements for Chart 3
      const totalAccepted = document.getElementById("totalAccepted");
      const totalRejected = document.getElementById("totalRejected");

      // Elements for Chart 4
      const totalResubmitted = document.getElementById("totalResubmitted");
      const totalNotResubmitted = document.getElementById("totalNotResubmitted");

      // Chart instances
      let chart1, chart2, chart3, chart4;

      function fetchStatementsReport() {
        const year = yearSelect.value;
        const district = districtSelect.value;
        const finCategory = finCategorySelect ? finCategorySelect.value : 'STM02';
        const institute = instituteSelect ? instituteSelect.value : '';

        fetch(
            `{{ route('getStatementsReport') }}?year=${year}&district=${district}&fin_category=${finCategory}&institute=${institute}`
          )
          .then(response => response.json())
          .then(data => {
            // Update Chart 1: Jumlah Hantar vs Jumlah Berdaftar
            updateChartData(1, "orders1",
              data.series[0][0], data.series[0][1],
              data.categories[0][0], data.categories[0][1],
              data.colors[0]);

            if (totalSubmitted) totalSubmitted.textContent = data.series[0][0];
            if (totalNotSubmitted) totalNotSubmitted.textContent = data.series[0][0] + data.series[0][1];

            // Update Chart 2: Jumlah Terima vs Jumlah Ditolak
            updateChartData(2, "orders2",
              data.series[1][0], data.series[1][1],
              data.categories[1][0], data.categories[1][1],
              data.colors[1]);

            if (totalChecked && totalUnchecked) {
              const checked = data.series[1][0];
              const unchecked = data.series[1][1];
              const total = checked + unchecked;

              const checkedPercent = total ? Math.round((checked / total) * 100) : 0;
              const uncheckedPercent = total ? Math.round((unchecked / total) * 100) : 0;

              totalChecked.innerHTML = `${checked} <span class="text-xs text-gray-700">(${checkedPercent}%)</span>`;
              totalUnchecked.innerHTML =
                `${unchecked} <span class="text-xs text-gray-700">(${uncheckedPercent}%)</span>`;
            }



            // Update Chart 3: Ditolak & Telah Hantar Semula vs Ditolak & Belum Hantar Semula
            updateChartData(3, "orders3",
              data.series[2][0], data.series[2][1],
              data.categories[2][0], data.categories[2][1],
              data.colors[2]);

            if (totalAccepted && totalRejected) {
              const accepted = data.series[2][0];
              const rejected = data.series[2][1];

              const checked = data.series[1][0];
              const total = checked;

              const acceptedPercent = total ? Math.round((accepted / total) * 100) : 0;
              const rejectedPercent = total ? Math.round((rejected / total) * 100) : 0;

              totalAccepted.innerHTML =
                `${accepted} <span class="text-xs text-gray-700">(${acceptedPercent}%)</span>`;
              totalRejected.innerHTML =
                `${rejected} <span class="text-xs text-gray-700">(${rejectedPercent}%)</span>`;
            }


            // Update Chart 4: Custom chart (if needed)
            updateChartData(4, "orders4",
              data.series[3][0], data.series[3][1],
              data.categories[3][0], data.categories[3][1],
              data.colors[3]);

            if (totalResubmitted && totalNotResubmitted) {
              const resubmitted = data.series[3][0];
              const notResubmitted = data.series[3][1];
              const total = resubmitted + notResubmitted;

              const resubmittedPercent = total ? Math.round((resubmitted / total) * 100) : 0;
              const notResubmittedPercent = total ? Math.round((notResubmitted / total) * 100) : 0;

              totalResubmitted.innerHTML =
                `${resubmitted} <span class="text-xs text-gray-700">(${resubmittedPercent}%)</span>`;
              totalNotResubmitted.innerHTML =
                `${notResubmitted} <span class="text-xs text-gray-700">(${notResubmittedPercent}%)</span>`;
            }

          })
          .catch(error => console.error("Error fetching data:", error));
      }

      function updateChartData(chartNumber, chartElementId, value1, value2, label1, label2, colors) {
        // Calculate percentage
        const total = value1 + value2;
        const percentage = total > 0 ? Math.round((value1 / total) * 100) : 0;

        const options = {
          series: [value1, value2],
          labels: [label1, label2],
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
                      return percentage + "%";
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
                      return percentage + "%";
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
          colors: colors
        };

        // Check if chart instance exists
        if (window[`chart${chartNumber}`]) {
          window[`chart${chartNumber}`].updateOptions(options);
        } else {
          window[`chart${chartNumber}`] = new ApexCharts(document.querySelector(`#${chartElementId}`), options);
          window[`chart${chartNumber}`].render();
        }
      }

      // Initial Load
      fetchStatementsReport();

      // Event Listener for Year Change
      if (yearSelect) {
        yearSelect.addEventListener("change", fetchStatementsReport);
      }

      // Event Listener for District Change
      if (districtSelect) {
        districtSelect.addEventListener("change", fetchStatementsReport);
      }

      // Event Listener for Financial Category Change
      if (finCategorySelect) {
        finCategorySelect.addEventListener("change", fetchStatementsReport);
      }

      if (instituteSelect) {
        instituteSelect.addEventListener("change", fetchStatementsReport);
      }
    });
  </script>
@endsection
