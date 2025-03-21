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
                        <li class="breadcrumb-item active" aria-current="page"> Papan Pemuka
                        </li>
                    </ol>
                    <h1 class="page-title font-medium text-lg mb-0"> Papan Pemuka
                    </h1>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text bg-white dark:bg-bodybg border"> <i class="ri-calendar-line"></i>
                            </div>
                            <input type="text" class="form-control breadcrumb-input" id="daterange"
                                placeholder="Search By Date Range">
                        </div>
                    </div>
                    <div class="ti-btn-list">
                        <button
                            class="ti-btn bg-white dark:bg-bodybg border border-defaultborder dark:border-defaultborder/10 btn-wave !my-0 !m-0 !me-[0.35rem]">
                            <i class="ri-filter-3-line align-middle leading-none"></i> Filter
                        </button>
                        <button class="ti-btn ti-btn-primary btn-wave !border-0 me-0 !m-0">
                            <i class="ri-share-forward-line"></i> Share
                        </button>
                    </div>
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
                                            <h4 class="font-medium mb-0">{{ $total_institute }}</h4>
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
                                            <h4 class="font-medium mb-0">{{ $total_institute_registration }}</h4>
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
                                            <span class="text-textmuted dark:text-textmuted/50 block mb-1">Laporan Disemak
                                            </span>
                                            <h4 class="font-medium mb-0">{{ $total_statement_to_review }}</h4>
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
                                            <h4 class="font-medium mb-0">{{ $total_statement_cancelled }}</h4>
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
                                        Institusi Pendaftaran
                                    </div>
                                    <a href="{{ route('registrationRequests') }}"
                                        class="ti-ti-btn ti-btn-light btn-wave   text-textmuted dark:text-textmuted/50 waves-effect waves-light px-2 py-[0.26rem]">View
                                        All</a>
                                </div>
                                <div class="box-body mt-6 mb-6 flex flex-col justify-start" style="min-height: 350px;">
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
                                        Laporan Kewangan Belum Diproses
                                    </div>
                                    <a href="{{ route('statementList') }}"
                                        class="ti-btn ti-btn-light btn-wave text-textmuted dark:text-textmuted/50 ti-btn-sm">View
                                        All<i class="ti ti-arrow-narrow-right"></i></a>
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
                                                        <td colspan="4" class="text-center text-gray-500">Tiada data
                                                            tersedia</td>
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

            {{-- <!-- Start::Row-2 -->
            <div class="grid grid-cols-12 gap-x-6">
                <div class="xxl:col-span-3 xl:col-span-6 col-span-12">
                    <div class="box overflow-hidden">
                        <div class="box-header justify-between">
                            <div class="box-title">
                                Latest Transactions
                            </div>
                            <a href="javascript:void(0);"
                                class="ti-btn ti-btn-light btn-wave text-textmuted dark:text-textmuted/50 ti-btn-sm">View
                                All<i class="ti ti-arrow-narrow-right"></i></a>
                        </div>
                        <div class="box-body p-0">
                            <div class="table-responsive">
                                <table class="ti-custom-table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <div class="leading-none">
                                                        <span class="avatar avatar-sm">
                                                            <img src="{{ asset('build/assets/images/ecommerce/jpg/4.jpg') }}"
                                                                alt="">
                                                        </span>
                                                    </div>
                                                    <div class="font-medium">SwiftBuds</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="font-medium">$39.99</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">Success</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <div class="leading-none">
                                                        <span class="avatar avatar-sm">
                                                            <img src="{{ asset('build/assets/images/ecommerce/jpg/6.jpg') }}"
                                                                alt="">
                                                        </span>
                                                    </div>
                                                    <div class="font-medium">CozyCloud Pillow</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="font-medium">$19.95</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primarytint1color">Pending</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <div class="leading-none">
                                                        <span class="avatar avatar-sm">
                                                            <img src="{{ asset('build/assets/images/ecommerce/jpg/3.jpg') }}"
                                                                alt="">
                                                        </span>
                                                    </div>
                                                    <div class="font-medium">AquaGrip Bottle</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="font-medium">$9.99</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primarytint2color">Failed</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <div class="leading-none">
                                                        <span class="avatar avatar-sm">
                                                            <img src="{{ asset('build/assets/images/ecommerce/jpg/1.jpg') }}"
                                                                alt="">
                                                        </span>
                                                    </div>
                                                    <div class="font-medium">GlowLite Lamp</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="font-medium">$24.99</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primarytint3color">Success</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <div class="leading-none">
                                                        <span class="avatar avatar-sm">
                                                            <img src="{{ asset('build/assets/images/ecommerce/jpg/2.jpg') }}"
                                                                alt="">
                                                        </span>
                                                    </div>
                                                    <div class="font-medium">Bitvitamin</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="font-medium">$26.45</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">Success</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border-b-0">
                                                <div class="flex items-center gap-2">
                                                    <div class="leading-none">
                                                        <span class="avatar avatar-sm">
                                                            <img src="{{ asset('build/assets/images/ecommerce/jpg/5.jpg') }}"
                                                                alt="">
                                                        </span>
                                                    </div>
                                                    <div class="font-medium">FitTrack</div>
                                                </div>
                                            </td>
                                            <td class="border-b-0">
                                                <span class="font-medium">$49.95</span>
                                            </td>
                                            <td class="border-b-0">
                                                <span class="badge bg-warning ">Success</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xxl:col-span-3 xl:col-span-6 col-span-12">
                    <div class="box">
                        <div class="box-header justify-between">
                            <div class="box-title">
                                Recent Activity
                            </div>
                            <a href="javascript:void(0);"
                                class="ti-ti-btn ti-btn-light btn-wave   text-textmuted dark:text-textmuted/50 waves-effect waves-light px-2 py-[0.26rem]">View
                                All</a>
                        </div>
                        <div class="box-body">
                            <ul class="list-none recent-activity-list">
                                <li>
                                    <div>
                                        <div>
                                            <div class="font-medium text-[14px]">John Doe</div>
                                            <span class="text-xs activity-time">
                                                12 Hrs
                                            </span>
                                        </div>
                                        <span class="block text-textmuted dark:text-textmuted/50">
                                            Updated the product description for <span
                                                class="text-primary font-medium">Widget X</span>.
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div>
                                            <div class="font-medium text-[14px]">Jane Smith</div>
                                            <span class="text-xs activity-time">
                                                4:32pm
                                            </span>
                                        </div>
                                        <span class="block text-textmuted dark:text-textmuted/50">
                                            added a <span class="font-medium text-dark">new user</span> with username <span
                                                class="font-medium text-primarytint1color">janesmith89.</span>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div>
                                            <div class="font-medium text-[14px]">Michael Brown</div>
                                            <span class="text-xs activity-time">
                                                11:45am
                                            </span>
                                        </div>
                                        <span class="block text-textmuted dark:text-textmuted/50">
                                            Changed the status of order <a href="javascript:void(0);"
                                                class="font-medium text-dark decoration-solid">#12345</a> to <span
                                                class="font-medium text-primarytint2color">Shipped.</span>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div>
                                            <div class="font-medium text-[14px]">David Wilson</div>
                                            <span class="text-xs activity-time">
                                                9:27am
                                            </span>
                                        </div>
                                        <span class="block text-textmuted dark:text-textmuted/50">
                                            added <span class="font-medium text-primarytint3color">John Smith</span> to
                                            academy group this day.
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <div>
                                            <div class="font-medium text-[14px]">Robert Jackson</div>
                                            <span class="text-xs activity-time">
                                                8:56pm
                                            </span>
                                        </div>
                                        <span class="block text-textmuted dark:text-textmuted/50">
                                            added a comment to the task <span class="font-medium text-secondary">Update
                                                website layout.</span>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="xxl:col-span-3 xl:col-span-6 col-span-12">
                    <div class="box">
                        <div class="box-header justify-between">
                            <div class="box-title">
                                Sales Statistics
                            </div>
                            <div class="ti-dropdown hs-dropdown">
                                <a href="javascript:void(0);"
                                    class="ti-ti-btn ti-btn-light text-textmuted dark:text-textmuted/50 ti-dropdown-toggle gap-0 hs-dropdown-toggle px-2 py-[0.26rem]"
                                    data-bs-toggle="dropdown" aria-expanded="true"> Sort By <i
                                        class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i></a>
                                <ul class="ti-dropdown-menu hs-dropdown-menu hidden" role="menu"
                                    data-popper-placement="bottom-end">
                                    <li><a class="ti-dropdown-item" href="javascript:void(0);">This Week</a></li>
                                    <li><a class="ti-dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                    <li><a class="ti-dropdown-item" href="javascript:void(0);">This Month</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="flex flex-wrap gap-2 justify-between flex-auto pb-3">
                                <div
                                    class="py-4 px-6 rounded-sm border border-defaultborder dark:border-defaultborder/10 border-dashed bg-light">
                                    <span>Total Sales</span>
                                    <p class="font-medium text-[14px] mb-0">$3.478B</p>
                                </div>
                                <div
                                    class="py-4 px-6 rounded-sm border border-defaultborder dark:border-defaultborder/10 border-dashed bg-light">
                                    <span>This Year</span>
                                    <p class="text-success font-medium text-[14px] mb-0">4,25,349</p>
                                </div>
                                <div
                                    class="py-4 px-6 rounded-sm border border-defaultborder dark:border-defaultborder/10 border-dashed bg-light">
                                    <span>Last Year</span>
                                    <p class="text-danger font-medium text-[14px] mb-0">3,41,622</p>
                                </div>
                            </div>
                            <div id="sales-statistics"></div>
                        </div>
                    </div>
                </div>
                <div class="xxl:col-span-3 xl:col-span-6 col-span-12">
                    <div class="box overflow-hidden">
                        <div class="box-header pb-0 justify-between">
                            <div class="box-title">
                                Overall Statistics
                            </div>
                            <a href="javascript:void(0);"
                                class="ti-ti-btn ti-btn-light btn-wave text-textmuted dark:text-textmuted/50 waves-effect waves-light gap-0 px-2 py-[0.26rem]">View
                                All</a>
                        </div>
                        <div class="box-body">
                            <ul class="ti-list-group activity-feed">
                                <li class="ti-list-group-item !m-0">
                                    <div class="flex items-center justify-between">
                                        <div class="leading-none">
                                            <p class="mb-2 text-[13px] text-textmuted dark:text-textmuted/50">Total
                                                Expenses</p>
                                            <h6 class="font-medium mb-0">$134,032<span
                                                    class="text-xs text-success ms-2 font-normal inline-block">0.45%<i
                                                        class="ti ti-trending-up mx-1"></i></span></h6>
                                        </div>
                                        <div class="text-end">
                                            <div id="line-graph1"></div>
                                            <a href="javascript:void(0);" class="text-xs">
                                                <span>See more</span>
                                                <span class="table-icon"><i
                                                        class="ms-1 inline-block ri-arrow-right-line"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="ti-list-group-item !m-0">
                                    <div class="flex items-center justify-between">
                                        <div class="leading-none">
                                            <p class="mb-2 text-[13px] text-textmuted dark:text-textmuted/50">General Leads
                                            </p>
                                            <h6 class="font-medium mb-0">74,354<span
                                                    class="text-xs text-danger ms-2 font-normal inline-block">3.84%<i
                                                        class="ti ti-trending-down mx-1"></i></span></h6>
                                        </div>
                                        <div class="text-end">
                                            <div id="line-graph2"></div>
                                            <a href="javascript:void(0);" class="text-xs">
                                                <span>See more</span>
                                                <span class="table-icon"><i
                                                        class="ms-1 inline-block ri-arrow-right-line"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="ti-list-group-item !m-0">
                                    <div class="flex items-center justify-between">
                                        <div class="leading-none">
                                            <p class="mb-2 text-[13px] text-textmuted dark:text-textmuted/50">Churn Rate
                                            </p>
                                            <h6 class="font-medium mb-0">6.02%<span
                                                    class="text-xs text-success ms-2 font-normal inline-block">0.72%<i
                                                        class="ti ti-trending-up mx-1"></i></span></h6>
                                        </div>
                                        <div class="text-end">
                                            <div id="line-graph3"></div>
                                            <a href="javascript:void(0);" class="text-xs">
                                                <span>See more</span>
                                                <span class="table-icon"><i
                                                        class="ms-1 inline-block ri-arrow-right-line"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="ti-list-group-item !m-0">
                                    <div class="flex items-center justify-between">
                                        <div class="leading-none">
                                            <p class="mb-2 text-[13px] text-textmuted dark:text-textmuted/50">New Users</p>
                                            <h6 class="font-medium mb-0">7,893<span
                                                    class="text-xs text-success ms-2 font-normal inline-block">11.05%<i
                                                        class="ti ti-trending-up mx-1"></i></span></h6>
                                        </div>
                                        <div class="text-end">
                                            <div id="line-graph4"></div>
                                            <a href="javascript:void(0);" class="text-xs">
                                                <span>See more</span>
                                                <span class="table-icon"><i
                                                        class="ms-1 inline-block ri-arrow-right-line"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="ti-list-group-item !m-0">
                                    <div class="flex items-center justify-between">
                                        <div class="leading-none">
                                            <p class="mb-2 text-[13px] text-textmuted dark:text-textmuted/50">Returning
                                                Users</p>
                                            <h6 class="font-medium mb-0">3,258<span
                                                    class="text-xs text-success ms-2 font-normal inline-block">1.69%<i
                                                        class="ti ti-trending-up mx-1"></i></span></h6>
                                        </div>
                                        <div class="text-end">
                                            <div id="line-graph5"></div>
                                            <a href="javascript:void(0);" class="text-xs">
                                                <span>See more</span>
                                                <span class="table-icon"><i
                                                        class="ms-1 inline-block ri-arrow-right-line"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::Row-2 --> --}}

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
                                View All
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
                    $colors = ['bg-primarytint3color', 'bg-primarytint2color', 'bg-primarytint1color', 'bg-primary'];
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

        </div>
    </div>
    <!-- End::app-content -->
@endsection

@section('scripts')
    <!-- Apex Charts JS -->
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script>
        /* Order Statistics */
        var options = {
            series: [{{ $totalEntries }}, {{ $totalClients - $totalEntries }}], // Dynamic Data
            labels: ["Diserahkan", "Dibatalkan"],
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
                                fontSize: '15px',
                                offsetY: -20,
                                formatter: function(val) {
                                    return val + "%";
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                fontSize: '22px',
                                fontWeight: 600,
                                color: '#495057',
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

        var chart = new ApexCharts(document.querySelector("#orders"), options);
        chart.render();
    </script>
@endsection
