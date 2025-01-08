<aside class="app-sidebar" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ url('index') }}" class="header-logo">
            <img src="{{ asset('assets/icons/sd_logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/icons/sd_logo_half.svg') }}" alt="logo" class="toggle-dark">

            <img src="{{ asset('assets/icons/sd_logo_full.svg') }}" alt="logo" class="desktop-dark"
                style="height: auto; width: auto;">

            <img src="{{ asset('assets/icons/sd_logo_half.svg') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('assets/icons/sd_logo_half.svg') }}" alt="logo" class="toggle-white">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-white.png') }}" alt="logo"
                class="desktop-white">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-col sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <li class="slide">
                    <a href="{{ route('index') }}" class="side-menu__item">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>

                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" fill="none"
                            viewBox="0 0 24 24" stroke-width="0.8" stroke="currentColor">
                            <path
                                d="M15.2905 1.62179C14.9256 1.2561 14.4403 1.05469 13.9239 1.05469H13.0518V0.878906C13.0518 0.394277 12.6575 0 12.1729 0H5.84473C5.3601 0 4.96582 0.394277 4.96582 0.878906V1.05469H4.09054C3.02667 1.05469 2.16018 1.92115 2.15898 2.98614L2.14453 16.0643C2.14397 16.5811 2.34461 17.0672 2.70949 17.4329C3.07442 17.7986 3.55975 18 4.07609 18H13.9094C14.9733 18 15.8398 17.1335 15.841 16.0686L15.8555 2.99043C15.8561 2.47352 15.6554 1.98745 15.2905 1.62179ZM6.02051 1.05469H11.9971V2.10938H6.02051V1.05469ZM14.7874 16.0674C14.7869 16.5515 14.393 16.9453 13.9094 16.9453H4.07609C3.84138 16.9453 3.62078 16.8538 3.45491 16.6875C3.28904 16.5213 3.19785 16.3004 3.1981 16.0655L3.21254 2.98733C3.21307 2.5032 3.60693 2.10938 4.09054 2.10938H4.96582V2.28516C4.96582 2.76979 5.3601 3.16406 5.84473 3.16406H12.1729C12.6575 3.16406 13.0518 2.76979 13.0518 2.28516V2.10938H13.9239C14.1586 2.10938 14.3792 2.20092 14.5451 2.36714C14.711 2.53336 14.8022 2.75432 14.8019 2.98923L14.7874 16.0674Z"
                                fill="white" />
                            <path
                                d="M9.17882 7.03126H12.9255C13.2167 7.03126 13.4528 6.79515 13.4528 6.50392C13.4528 6.21268 13.2167 5.97657 12.9255 5.97657H9.17882C8.88758 5.97657 8.65147 6.21268 8.65147 6.50392C8.65147 6.79515 8.88758 7.03126 9.17882 7.03126ZM9.17882 10.5469H12.9255C13.2167 10.5469 13.4528 10.3108 13.4528 10.0195C13.4528 9.72831 13.2167 9.4922 12.9255 9.4922H9.17882C8.88758 9.4922 8.65147 9.72831 8.65147 10.0195C8.65147 10.3108 8.88758 10.5469 9.17882 10.5469ZM12.9405 13.0078H9.17882C8.88758 13.0078 8.65147 13.2439 8.65147 13.5352C8.65147 13.8264 8.88758 14.0625 9.17882 14.0625H12.9405C13.2318 14.0625 13.4679 13.8264 13.4679 13.5352C13.4679 13.2439 13.2318 13.0078 12.9405 13.0078ZM6.93434 5.06803L5.71821 6.28415L5.43148 5.99738C5.22553 5.79144 4.89165 5.79144 4.68571 5.99738C4.47976 6.20329 4.47976 6.53721 4.68571 6.74315L5.34535 7.40283C5.44424 7.50172 5.57837 7.55728 5.71823 7.55728C5.85809 7.55728 5.99222 7.50172 6.09112 7.40283L7.68014 5.81383C7.88609 5.60792 7.88609 5.27401 7.68014 5.06806C7.4742 4.86208 7.14032 4.86208 6.93434 5.06803ZM6.93434 8.85214L5.71821 10.0683L5.43148 9.78153C5.22553 9.57559 4.89165 9.57559 4.68571 9.78153C4.47976 9.98744 4.47976 10.3213 4.68571 10.5273L5.34535 11.187C5.44424 11.2859 5.57837 11.3414 5.71823 11.3414C5.85809 11.3414 5.99222 11.2859 6.09112 11.187L7.68014 9.59795C7.88609 9.39204 7.88609 9.05812 7.68014 8.85218C7.4742 8.64623 7.14028 8.64623 6.93434 8.85214ZM6.93434 12.3678L5.71821 13.5839L5.43148 13.2972C5.22553 13.0912 4.89165 13.0912 4.68571 13.2972C4.47976 13.5031 4.47976 13.8369 4.68571 14.0429L5.34535 14.7026C5.44424 14.8015 5.57837 14.8571 5.71823 14.8571C5.85809 14.8571 5.99222 14.8015 6.09112 14.7026L7.68014 13.1136C7.88609 12.9077 7.88609 12.5737 7.68014 12.3678C7.4742 12.1619 7.14028 12.1619 6.93434 12.3678Z"
                                fill="white" />
                        </svg>

                        <span class="side-menu__label">Rekod Masjid</span>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Rekod Masjid</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('showEntityList') }}" class="side-menu__item">Senarai Masjid</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('showAdminList') }}" class="side-menu__item">Daftar Masjid</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('showBranchList') }}" class="side-menu__item">Profil Masjid</a>
                        </li>
                        <li class="slide">
                            <a href="#" class="side-menu__item">Permohonan Baharu</a>
                        </li>

                    </ul>
                </li>
                <!-- End::slide -->




                <li class="slide">
                    <a href="{{ route('compensation.list') }}" class="side-menu__item">
                        <!-- Compensation SVG here -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="side-menu__label">Compensation</span>
                    </a>
                </li>

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
