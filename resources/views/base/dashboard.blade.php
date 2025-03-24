@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Start::page-header -->
            <div class="flex items-center justify-between page-header-breadcrumb flex-wrap gap-2">
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">
                                Utama </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"> Laman Utama
                        </li>
                    </ol>
                    <h1 class="page-title font-medium text-lg mb-0"> Laman Utama
                    </h1>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::Row-1 -->
            <div class="grid grid-cols-12 gap-x-6">
                <div class="xl:col-span-8 col-span-12">
                    <div class="grid grid-cols-12 gap-x-6">
                        <div class="xxl:col-span-3 xl:col-span-6 col-span-12">
                            <div class="box overflow-hidden main-content-card">
                                <div class="box-body">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <span class="text-textmuted dark:text-textmuted/50 block mb-1">Jumlah Institusi
                                                Berdaftar</span>
                                            <h4 class="font-medium mb-0">{{ $total_institute ?? 0 }}</h4>
                                        </div>
                                        <div class="leading-none">

                                            <img src="{{ asset('assets/icons/dashboard_icons_1.svg') }}" alt="logo"
                                                class="toggle-dark h-10 w-10">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="xxl:col-span-3 xl:col-span-6 col-span-12">
                            <div class="box overflow-hidden main-content-card">
                                <div class="box-body">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <span class="block text-textmuted dark:text-textmuted/50 mb-1">Pendaftaran
                                                Masjid Baru
                                            </span>
                                            <h4 class="font-medium mb-0">{{ $total_institute_registration ?? 0 }}</h4>
                                        </div>
                                        <div class="leading-none">
                                            <img src="{{ asset('assets/icons/dashboard_icons_2.svg') }}" alt="logo"
                                                class="toggle-dark h-10 w-10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="xxl:col-span-3 xl:col-span-6 col-span-12">
                            <div class="box overflow-hidden main-content-card">
                                <div class="box-body">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <span class="text-textmuted dark:text-textmuted/50 block mb-1">Status Laporan
                                                Disemak
                                            </span>
                                            <h4 class="font-medium mb-0">{{ $total_statement_to_review ?? 0 }}</h4>
                                        </div>
                                        <div class="leading-none">
                                            <img src="{{ asset('assets/icons/dashboard_icons_3.svg') }}" alt="logo"
                                                class="toggle-dark h-10 w-10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="xxl:col-span-3 xl:col-span-6 col-span-12">
                            <div class="box overflow-hidden main-content-card">
                                <div class="box-body">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <span class="text-textmuted dark:text-textmuted/50 block mb-1">Status Laporan
                                                Dibatalkan
                                            </span>
                                            <h4 class="font-medium mb-0">{{ $total_statement_cancelled ?? 0 }}</h4>
                                        </div>
                                        <div class="leading-none">
                                            <img src="{{ asset('assets/icons/dashboard_icons_4.svg') }}" alt="logo"
                                                class="toggle-dark h-10 w-10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="xxl:col-span-4 xl:col-span-4 col-span-12 ">
                            <div class="box">
                                <div class="box-header justify-between">
                                    <div class="box-title">
                                        Permohonan Pendaftaran
                                    </div>
                                    <a href="{{ route('registrationRequests') }}"
                                        class="ti-ti-btn ti-btn-light btn-wave   text-textmuted dark:text-textmuted/50 waves-effect waves-light px-2 py-[0.26rem]">Lihat
                                        Semua</a>
                                </div>
                                <div class="box-body mt-6 mb-6 flex flex-col justify-start" style="min-height: 350px;">
                                    @if (!isset($institute_registration_list[0]))
                                        <div class="text-center text-gray-500">Tiada rekod ditemui</div>
                                    @endif
                                    <ul class="list-none recent-activity-list">
                                        @if (isset($institute_registration_list[0]))
                                            <li>
                                                <div>
                                                    <div>
                                                        <div class="font-medium text-[14px]">
                                                            {{ $institute_registration_list[0]->name }}</div>
                                                        <span class="text-xs activity-time">
                                                            {{ \Carbon\Carbon::parse($institute_registration_list[0]->registration_request_date)->format('d-m-y') }}
                                                        </span>
                                                    </div>
                                                    <span class="block text-textmuted dark:text-textmuted/50">
                                                        {{ $institute_registration_list[0]->Category->prm }}<br>
                                                        <span
                                                            class="text-primary font-medium">{{ $institute_registration_list[0]->con1 }}</span>.
                                                    </span>
                                                </div>
                                            </li>
                                        @endif

                                        @if (isset($institute_registration_list[1]))
                                            <li>
                                                <div>
                                                    <div>
                                                        <div class="font-medium text-[14px]">
                                                            {{ $institute_registration_list[1]->name }}</div>
                                                        <span class="text-xs activity-time">
                                                            {{ \Carbon\Carbon::parse($institute_registration_list[1]->registration_request_date)->format('d-m-y') }}
                                                        </span>
                                                    </div>
                                                    <span class="block text-textmuted dark:text-textmuted/50">
                                                        {{ $institute_registration_list[1]->Category->prm }}<br>
                                                        <span
                                                            class="text-primary font-medium">{{ $institute_registration_list[1]->con1 }}</span>.
                                                    </span>
                                                </div>
                                            </li>
                                        @endif

                                        @if (isset($institute_registration_list[2]))
                                            <li>
                                                <div>
                                                    <div>
                                                        <div class="font-medium text-[14px]">
                                                            {{ $institute_registration_list[2]->name }}</div>
                                                        <span class="text-xs activity-time">
                                                            {{ \Carbon\Carbon::parse($institute_registration_list[2]->registration_request_date)->format('d-m-y') }}
                                                        </span>
                                                    </div>
                                                    <span class="block text-textmuted dark:text-textmuted/50">
                                                        {{ $institute_registration_list[2]->Category->prm }}<br>
                                                        <span
                                                            class="text-primary font-medium">{{ $institute_registration_list[2]->con1 }}</span>.
                                                    </span>
                                                </div>
                                            </li>
                                        @endif

                                        @if (isset($institute_registration_list[3]))
                                            <li>
                                                <div>
                                                    <div>
                                                        <div class="font-medium text-[14px]">
                                                            {{ $institute_registration_list[3]->name }}</div>
                                                        <span class="text-xs activity-time">
                                                            {{ \Carbon\Carbon::parse($institute_registration_list[3]->registration_request_date)->format('d-m-y') }}
                                                        </span>
                                                    </div>
                                                    <span class="block text-textmuted dark:text-textmuted/50">
                                                        {{ $institute_registration_list[3]->Category->prm }}<br>
                                                        <span
                                                            class="text-primary font-medium">{{ $institute_registration_list[3]->con1 }}</span>.
                                                    </span>
                                                </div>
                                            </li>
                                        @endif

                                        @if (isset($institute_registration_list[4]))
                                            <li>
                                                <div>
                                                    <div>
                                                        <div class="font-medium text-[14px]">
                                                            {{ $institute_registration_list[4]->name }}</div>
                                                        <span class="text-xs activity-time">
                                                            {{ \Carbon\Carbon::parse($institute_registration_list[4]->registration_request_date)->format('d-m-y') }}
                                                        </span>
                                                    </div>
                                                    <span class="block text-textmuted dark:text-textmuted/50">
                                                        {{ $institute_registration_list[4]->Category->prm }}<br>
                                                        <span
                                                            class="text-primary font-medium">{{ $institute_registration_list[4]->con1 }}</span>.
                                                    </span>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="xxl:col-span-8 xl:col-span-8 col-span-12">
                            <div class="box overflow-hidden">
                                <div class="box-header justify-between">
                                    <div class="box-title">
                                        Senarai Laporan Kewangan Disemak
                                    </div>
                                    <a href="{{ route('statementList') }}"
                                        class="ti-btn ti-btn-light btn-wave text-textmuted dark:text-textmuted/50 ti-btn-sm">Lihat
                                        Semua
                                        <i class="ti ti-arrow-narrow-right"></i></a>
                                </div>
                                <div class="box-body mt-6 mb-6 flex flex-col justify-start" style="min-height: 350px;">
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
                                                                <span
                                                                    class="badge {{ $badgeClass }}">{{ $statement->CATEGORY ?? '-' }}</span>
                                                            </td>

                                                            <td>
                                                                <span
                                                                    class="font-medium">{{ $statement->INSTITUTE ?? '-' }}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="font-medium">{{ $statement->DISTRICT ?? '-' }}</span>
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
                    </div>
                </div>
                <div class="xl:col-span-4 col-span-12">
                    <div class="grid grid-cols-12 gap-x-6">
                        <div class="xl:col-span12 col-span-12">
                            <div class="box overflow-hidden"
                                style="background-image: url('{{ asset('assets/icons/banner.png') }}'); background-size: cover; background-position: center; min-height:180px">
                                <div class="box-body p-6 relative">
                                    <div class="grid grid-cols-12 justify-between">
                                    </div>

                                    <!-- Dark Transparent Footer for Date & Time -->
                                    <div
                                        class="absolute bottom-0 left-0 w-full bg-black bg-opacity-50 text-white p-4 text-center">
                                        <span class="text-lg font-semibold">
                                            {{ now('Asia/Kuala_Lumpur')->format('l, d F Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="xl:col-span12 col-span-12">
                            <div class="xxl:col-span-4 xl:col-span-6 col-span-12">
                                <div class="box overflow-hidden">
                                    <div class="box-header pb-0 justify-between">
                                        <div class="box-title">
                                            Jumlah Penghantaran Tahunan Laporan Kewangan
                                        </div>
                                        <!-- Year Dropdown -->
                                        <select id="yearSelect" class="px-3 py-2 border rounded-md w-20">
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}"
                                                    {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="box-body py-4 px-3">
                                        <div id="orders" class="my-2"></div>
                                    </div>

                                    <div class="box-footer border-t border-dashed py-3 px-4">
                                        <div class="flex justify-between items-center">
                                            <!-- Left Section -->
                                            <div class="text-gray-700 dark:text-gray-300">
                                                <h5 class="text-sm font-semibold mb-2">Jumlah Penghantaran</h5>
                                                <h5 class="text-sm font-semibold">Jumlah Institusi Berdaftar</h5>
                                            </div>

                                            <!-- Right Section -->
                                            <div class="text-gray-700 dark:text-gray-300 text-right">
                                                <h5 id="totalEntries" class="text-lg font-bold mb-2">{{ $totalEntries }}
                                                </h5>
                                                <h5 id="totalClients" class="text-lg font-bold">{{ $totalClients }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End::Row-1 -->
            @if (!in_array(Auth::user()->syslevel, ['ACL02', 'ACL03']))
                <!-- Start::Row-3 -->
                <div class="grid grid-cols-12 gap-x-6">
                    <div class="xl:col-span-9 col-span-12">
                        <div class="box overflow-hidden">
                            <div class="box-header justify-between">
                                <div class="box-title">
                                    Senarai Pembayaran Langganan Tertunggak
                                </div>
                                <a href="{{ route('outstandingSubscriptions') }}"
                                    class="ti-btn ti-btn-light btn-wave px-2 py-[0.26rem] text-textmuted dark:text-textmuted/50 waves-effect waves-light">
                                    Lihat Semua
                                </a>
                            </div>
                            <div class="box-body mt-6 mb-6 flex flex-col justify-start" style="min-height: 460px;">
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
                                                                <span
                                                                    class="block font-medium">{{ $subscription->NAME }}</span>
                                                                <span
                                                                    class="block text-[11px] text-textmuted dark:text-textmuted/50">
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
                                                        <span
                                                            class="badge bg-primarytint1color ">{{ $subscription->STATUS ?? '-' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        // Define an array of theme colors
                        $colors = [
                            'bg-primarytint3color',
                            'bg-primarytint2color',
                            'bg-primarytint1color',
                            'bg-primary',
                        ];
                    @endphp

                    <div class="xl:col-span-3 col-span-12">
                        <div class="box">
                            <div class="box-header justify-between">
                                <div class="box-title">
                                    Jumlah Institusi Mengikut Daerah
                                </div>
                            </div>
                            <div class="box-body mt-6 mb-6 flex flex-col justify-start" style="min-height: 460px;">
                                <ul class="list-none sales-country-list">
                                    @foreach ($institute_by_district as $district)
                                        @if (!empty($district->DISTRICT))
                                            @php
                                                // Pick a random color from the predefined theme colors
                                                $randomColor = $colors[array_rand($colors)];
                                            @endphp
                                            <li>
                                                <div class="flex items-start gap-4">
                                                    <div class="flex-auto w-full">
                                                        <div class="flex items-center justify-between">
                                                            <span class="block font-medium mb-2 leading-none">
                                                                {{ $district->DISTRICT }}
                                                            </span>
                                                            <span class="text-[14px] font-medium block leading-none">
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

                </div>
                <!-- End::Row-3 -->
            @endif
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
            const totalEntriesEl = document.getElementById("totalEntries");
            const totalClientsEl = document.getElementById("totalClients");

            let chart;

            function fetchFinancialReport(year) {
                fetch(`{{ route('getFinancialReport') }}?year=${year}`)
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
            fetchFinancialReport(yearSelect.value);

            // Event Listener for Year Change
            yearSelect.addEventListener("change", function() {
                fetchFinancialReport(this.value);
            });
        });
    </script>
@endsection
