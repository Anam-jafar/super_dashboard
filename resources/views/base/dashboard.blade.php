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
        <div class="col-span-12 xl:col-span-8">
          <div class="grid grid-cols-12 gap-x-6">

            {{-- Dashboard Cards --}}
            <div class="col-span-12 xl:col-span-6 xxl:col-span-4">
              <div class="box main-content-card overflow-hidden">
                <div class="box-body">
                  <div class="mb-2 flex items-start justify-between">
                    <div>
                      <span class="mb-1 block text-textmuted dark:text-textmuted/50">Jumlah Institusi
                        Berdaftar</span>
                      <h4 class="mb-0 font-medium">{{ $total_institute ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">

                      <img src="{{ asset('assets/icons/dashboard_icons_1.svg') }}" alt="logo"
                        class="toggle-dark h-10 w-10">

                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-span-12 xl:col-span-6 xxl:col-span-4">
              <div class="box main-content-card overflow-hidden">
                <div class="box-body">
                  <div class="mb-2 flex items-start justify-between">
                    <div>
                      <span class="mb-1 block text-textmuted dark:text-textmuted/50">Permohonan Daftar Masjid
                      </span>
                      <h4 class="mb-0 font-medium">{{ $total_institute_registration ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_2.svg') }}" alt="logo"
                        class="toggle-dark h-10 w-10">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-12 xl:col-span-6 xxl:col-span-4">
              <div class="box main-content-card overflow-hidden">
                <div class="box-body">
                  <div class="mb-2 flex items-start justify-between">
                    <div>
                      <span class="mb-1 block text-textmuted dark:text-textmuted/50">Status Menunggu Semakan
                      </span>
                      <h4 class="mb-0 font-medium">{{ $total_statement_to_review ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_3.svg') }}" alt="logo"
                        class="toggle-dark h-10 w-10">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-12 xl:col-span-6 xxl:col-span-4">
              <div class="box main-content-card overflow-hidden">
                <div class="box-body">
                  <div class="mb-2 flex items-start justify-between">
                    <div>
                      <span class="mb-1 block text-textmuted dark:text-textmuted/50">Jumlah Diterima
                      </span>
                      <h4 class="mb-0 font-medium">{{ $total_statement_accepted ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_5.svg') }}" alt="logo"
                        class="toggle-dark h-10 w-10">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-12 xl:col-span-6 xxl:col-span-4">
              <div class="box main-content-card overflow-hidden">
                <div class="box-body">
                  <div class="mb-2 flex items-start justify-between">
                    <div>
                      <span class="mb-1 block text-textmuted dark:text-textmuted/50">Jumlah Ditolak
                      </span>
                      <h4 class="mb-0 font-medium">{{ $total_statement_cancelled ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_4.svg') }}" alt="logo"
                        class="toggle-dark h-10 w-10">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-span-12 xl:col-span-6 xxl:col-span-4">
              <div class="box main-content-card overflow-hidden">
                <div class="box-body">
                  <div class="mb-2 flex items-start justify-between">
                    <div>
                      <span class="mb-1 block text-textmuted dark:text-textmuted/50">Jumlah Mohon
                        Kemaskini
                      </span>
                      <h4 class="mb-0 font-medium">{{ $total_statement_request_edit ?? 0 }}</h4>
                    </div>
                    <div class="leading-none">
                      <img src="{{ asset('assets/icons/dashboard_icons_6.svg') }}" alt="logo"
                        class="toggle-dark h-10 w-10">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- End::Dashboard Cards --}}

            {{-- Bar Graph --}}
            <div class="col-span-12">
              <div class="box">
                <div class="box-header justify-between">
                  <div class="box-title">
                    Perbandingan Jumlah Mengikut Status </div>

                  <div class="flex items-center gap-2">
                    <!-- Year Dropdown -->
                    <select id="bar_yearSelect" class="w-20 rounded-md border px-3 py-2">
                      @foreach ($years as $year)
                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                          {{ $year }}
                        </option>
                      @endforeach
                    </select>

                    <!-- District Dropdown -->
                    <select id="bar_districtSelect" class="w-40 rounded-md border px-3 py-2">
                      <option value="">Semua Daerah</option> <!-- Default option -->
                      @foreach ($districts as $code => $prm)
                        <option value="{{ $code }}">
                          {{ $prm }}
                        </option>
                      @endforeach
                    </select>

                  </div>
                </div>
                <div class="box-body mb-6 mt-6 flex flex-col justify-start" style="min-height: 350px;">
                  <div id="chart"></div>

                </div>
              </div>
            </div>
            {{-- End::Bar Graph --}}

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
            {{-- Banner with Time --}}
            <div class="xl:col-span12 col-span-12">
              <div class="box overflow-hidden"
                style="background-image: url('{{ asset('assets/icons/banner.png') }}'); background-size: cover; background-position: center; min-height:225px">
                <div class="box-body relative p-6">
                  <div class="grid grid-cols-12 justify-between">
                  </div>

                  <!-- Dark Transparent Footer for Date & Time -->
                  <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-50 p-4 text-center text-white">
                    <span class="text-lg font-semibold">
                      {{ now('Asia/Kuala_Lumpur')->format('l, d F Y') }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            {{-- End::Banner with Time --}}

            {{-- Financial Report Pie Chart --}}
            <div class="xl:col-span12 col-span-12">
              <div class="col-span-12 xl:col-span-6 xxl:col-span-4">
                <div class="box overflow-hidden">
                  <div class="box-header justify-between pb-0">
                    <div class="box-title">
                      Jumlah Penghantaran Tahunan Laporan Kewangan
                    </div>
                    <div class="flex items-center gap-2">
                      <!-- Year Dropdown -->
                      <select id="yearSelect" class="w-20 rounded-md border px-3 py-2">
                        @foreach ($years as $year)
                          <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                            {{ $year }}
                          </option>
                        @endforeach
                      </select>

                      <!-- District Dropdown -->
                      <select id="districtSelect" class="w-40 rounded-md border px-3 py-2">
                        <option value="">Semua Daerah</option> <!-- Default option -->
                        @foreach ($districts as $code => $prm)
                          <option value="{{ $code }}">
                            {{ $prm }}
                          </option>
                        @endforeach
                      </select>

                    </div>

                  </div>

                  <div class="box-body px-3 py-4">
                    <div id="orders" class="my-2"></div>
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
                        <h5 id="totalEntries" class="mb-2 text-lg font-bold">{{ $totalEntries }}
                        </h5>
                        <h5 id="totalClients" class="text-lg font-bold">{{ $totalClients }}</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- End::Financial Report Pie Chart --}}

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
      <!-- End::Row-1 -->

      <!-- Start::Row-3 -->
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
                            ${{ number_format($subscription->TOTAL_OUTSTANDING, 2) }}
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
      <!-- End::Row-3 -->

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
      const totalEntriesEl = document.getElementById("totalEntries");
      const totalClientsEl = document.getElementById("totalClients");

      let chart;

      function fetchFinancialReport(year, district) {
        fetch(`{{ route('getFinancialReport') }}?year=${year}&district=${district}`)
          .then(response => response.json())
          .then(data => {
            totalEntriesEl.textContent = data.totalEntries;
            totalClientsEl.textContent = data.totalClients;

            updateChart(data.totalEntries, data.totalClients);
          })
          .catch(error => console.error("Error fetching data:", error));
      }

      function updateChart(totalEntries, totalClients) {
        const remainingClients = totalClients - totalEntries;

        // Avoid division by zero and round to the nearest whole number
        const percentageSent = totalClients > 0 ? Math.round((totalEntries / totalClients) * 100) : 0;

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
                      return percentageSent +
                        "%"; // Show percentage without decimal points
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
          colors: [
            "rgba(var(--primary-rgb))",
            "rgba(227, 84, 212, 1)",
            "rgba(255, 93, 159, 1)",
            "rgba(255, 142, 111, 1)"
          ],
        };

        if (chart) {
          chart.updateOptions(options);
        } else {
          chart = new ApexCharts(document.querySelector("#orders"), options);
          chart.render();
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


      // Get the year and district select elements
      const barYearSelect = document.getElementById("bar_yearSelect");
      const barDistrictSelect = document.getElementById("bar_districtSelect");

      let barChart; // Global variable to store the chart instance

      // Function to fetch statements report data
      function fetchStatementsReport(year, district) {
        fetch(`{{ route('getStatementsReport') }}?year=${year}&district=${district}`)
          .then(response => response.json())
          .then(data => {
            updateBarChart(data);
          })
          .catch(error => console.error("Error fetching bar chart data:", error));
      }

      // Function to update or create the bar chart
      function updateBarChart(chartData) {
        const options = {
          series: [{
              name: chartData.categories[0][0],
              data: [chartData.series[0][0], null, null]
            },
            {
              name: chartData.categories[0][1],
              data: [chartData.series[0][1], null, null]
            },
            {
              name: chartData.categories[1][0],
              data: [null, chartData.series[1][0], null]
            },
            {
              name: chartData.categories[1][1],
              data: [null, chartData.series[1][1], null]
            },
            {
              name: chartData.categories[2][0],
              data: [null, null, chartData.series[2][0]]
            },
            {
              name: chartData.categories[2][1],
              data: [null, null, chartData.series[2][1]]
            }
          ],
          chart: {
            type: 'bar',
            height: 350,
            stacked: false,
            toolbar: {
              show: false
            },
            fontFamily: 'Inter, sans-serif',
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '100%',
              borderRadius: 4,
              dataLabels: {
                position: 'top',
              },
            },
          },
          dataLabels: {
            enabled: true,
            formatter: function(val) {
              return val !== null ? val : '';
            },
            offsetY: -20,
            style: {
              fontSize: '12px',
              colors: ["#000"]
            }
          },
          colors: [
            chartData.colors[0][0], chartData.colors[0][1],
            chartData.colors[1][0], chartData.colors[1][1],
            chartData.colors[2][0], chartData.colors[2][1]
          ],
          xaxis: {
            categories: ['Group 1', 'Group 2', 'Group 3'],
            labels: {
              show: false
            },
            axisBorder: {
              show: false
            },
            axisTicks: {
              show: false
            }
          },
          yaxis: {
            max: Math.max(...chartData.series.flat().filter(val => val !== null)) * 1.2,
            title: {
              text: ''
            },
            labels: {
              formatter: function(val) {
                return Math.floor(val);
              }
            }
          },
          legend: {
            position: 'right',
            offsetY: 40,
            markers: {
              width: 12,
              height: 12,
              radius: 0
            }
          },
          grid: {
            borderColor: '#f1f1f1',
            strokeDashArray: 4
          },
          tooltip: {
            enabled: true,
            custom: function({
              series,
              seriesIndex,
              dataPointIndex
            }) {
              const value = series[seriesIndex][dataPointIndex];
              if (value === null) return '';

              const seriesName = options.series[seriesIndex].name;
              return `<div class="p-2">
          <span class="font-semibold">${seriesName}: </span>
          <span>${value}</span>
        </div>`;
            }
          },
          // ✨ Responsive part added here
          responsive: [{
            breakpoint: 992, // screens smaller than 992px
            options: {
              legend: {
                position: 'bottom',
                offsetY: 0
              }
            }
          }]
        };

        if (barChart) {
          barChart.updateOptions(options);
        } else {
          barChart = new ApexCharts(document.querySelector("#chart"), options);
          barChart.render();
        }
      }


      // Initial load
      fetchStatementsReport(barYearSelect.value, barDistrictSelect.value);

      // Event listener for year change
      barYearSelect.addEventListener("change", function() {
        fetchStatementsReport(this.value, barDistrictSelect.value);
      });

      // Event listener for district change
      barDistrictSelect.addEventListener("change", function() {
        fetchStatementsReport(barYearSelect.value, this.value);
      });
    });
  </script>
@endsection
