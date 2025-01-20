<aside class="app-sidebar" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ url('index') }}" class="header-logo">
            <img src="{{ asset('assets/icons/sd_logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/icons/sd_logo_half.svg') }}" alt="logo" class="toggle-dark">

            <img src="{{ asset('assets/icons/sd_logo_full.svg') }}" alt="logo" class="desktop-dark"
                style="height: 70px; width: 140px;">

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
                <li class="slide__category"><span class="category-name">Utama</span></li>
                <!-- End::slide__category -->

                <li class="slide">
                    <a href="{{ route('index') }}" class="side-menu__item">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>

                        <span class="side-menu__label">Utama</span>
                    </a>
                </li>




                <li class="slide">
                    <a href="{{ route('showList', ['type' => 'mosques']) }}" class="side-menu__item">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" viewBox="0 0 24 24">
                            <path
                                d="M6.75 24H17.25C17.7471 23.9995 18.2236 23.8017 18.5752 23.4501C18.9267 23.0987 19.1244 22.6221 19.125 22.125V1.875C19.1244 1.37791 18.9267 0.901334 18.5752 0.549832C18.2236 0.197997 17.7471 0.000595446 17.25 0L6.75 0C6.25291 0.000595446 5.77633 0.197997 5.42483 0.549832C5.07333 0.901334 4.8756 1.37791 4.875 1.875V22.125C4.8756 22.6221 5.07333 23.0987 5.42483 23.4501C5.77633 23.8017 6.25291 23.9995 6.75 24ZM17.25 23.25H6.75C6.45172 23.2497 6.16575 23.1311 5.95484 22.9202C5.74392 22.7092 5.62529 22.4233 5.625 22.125V21.75H18.375V22.125C18.3747 22.4233 18.2561 22.7092 18.0452 22.9202C17.8342 23.1311 17.5483 23.2497 17.25 23.25ZM13.2683 0.75L12.8933 1.5H11.1067L10.7317 0.75H13.2683ZM6.75 0.75H9.89325L10.5393 2.04263C10.5705 2.10496 10.6184 2.15739 10.6777 2.19401C10.737 2.23064 10.8053 2.25003 10.875 2.25H13.125C13.1946 2.24996 13.2629 2.23055 13.3221 2.19392C13.3813 2.15729 13.4291 2.10491 13.4603 2.04263L14.1068 0.75H17.25C17.5483 0.750303 17.8342 0.868921 18.0452 1.0795C18.2561 1.29075 18.3747 1.57672 18.375 1.875V21H5.625V1.875C5.62529 1.57672 5.74392 1.29075 5.95484 1.0795C6.16575 0.868921 6.45172 0.750303 6.75 0.75Z"
                                fill="white" fill-opacity="0.7" />
                            <path
                                d="M8.25 19.125C8.25 19.2244 8.28951 19.3198 8.35984 19.3902C8.43016 19.4605 8.52554 19.5 8.625 19.5H15.375C15.4744 19.5 15.5698 19.4605 15.6402 19.3902C15.7105 19.3198 15.75 19.2244 15.75 19.125V12.516C16.2187 11.8989 16.4811 11.1498 16.5 10.375C16.5 8.39967 14.4273 7.36313 13.1887 6.74327C13.0313 6.66451 12.855 6.57676 12.7043 6.49539C12.835 6.39101 12.9407 6.25863 13.0135 6.108C13.0863 5.95736 13.1244 5.79232 13.125 5.62501C13.125 5.52556 13.0855 5.43017 13.0152 5.35984C12.9448 5.28952 12.8495 5.25001 12.75 5.25001C12.6505 5.25001 12.5552 5.28952 12.4848 5.35984C12.4145 5.43017 12.375 5.52556 12.375 5.62501C12.375 5.69917 12.353 5.77168 12.3118 5.83335C12.2706 5.89501 12.212 5.94308 12.1435 5.9718C12.075 6.00052 11.9996 6.01395 11.9268 6.0098C11.8541 5.98167 11.7873 5.97261 11.7348 5.92017C11.6824 5.8644 11.6467 5.77757 11.6322 5.70484C11.6177 5.63209 11.6251 5.55669 11.6535 5.48817C11.6819 5.41965 11.73 5.36108 11.7917 5.31321C11.8533 5.26533 11.9258 5.23335 12 5.23335C12.0995 5.23335 12.1948 5.19384 12.2652 5.12351C12.3355 5.05319 12.375 4.9578 12.375 4.85835C12.375 4.75889 12.3355 4.66351 12.2652 4.59317C12.1948 4.52285 12.0995 4.48335 12 4.48335C11.7675 4.48235 11.5404 4.57043 11.3502 4.72432C11.1601 4.87823 11.0164 5.09464 10.939 5.34727C10.8616 5.59988 10.8543 5.87115 10.9182 6.1281C10.9822 6.38499 11.1141 6.61647 11.2957 6.79501C11.1446 6.91039 10.9691 7.01601 10.8113 7.10993C9.57267 7.72979 7.5 8.76633 7.5 10.3751C7.51891 11.1498 7.78128 11.8989 8.25 12.516V19.125ZM12.75 18.75H11.25V16.5C11.25 16.3011 11.329 16.1103 11.4697 15.9697C11.6103 15.8291 11.8011 15.75 12 15.75C12.1989 15.75 12.3897 15.8291 12.5303 15.9697C12.671 16.1103 12.75 16.3011 12.75 16.5V18.75ZM13.5 18.75V16.5C13.5 16.1022 13.3419 15.7206 13.0607 15.4393C12.7794 15.1581 12.3978 15 12 15C11.6022 15 11.2206 15.1581 10.9393 15.4393C10.6581 15.7206 10.5 16.1022 10.5 16.5V18.75H9V12.75H15V18.75H13.5ZM11.1469 7.41413C11.4415 7.27733 11.7265 7.12073 12 6.94539C12.2735 7.12073 12.5585 7.27733 12.8531 7.41413C14.0071 7.99167 15.75 8.86353 15.75 10.3755C15.7332 10.96 15.5412 11.526 15.1988 12H8.80125C8.45882 11.5259 8.26674 10.9598 8.25 10.3751C8.25 8.86353 9.993 7.99127 11.1469 7.41413Z"
                                fill="white" fill-opacity="0.7" />
                        </svg>



                        <span class="side-menu__label">Masjid</span>
                    </a>
                </li>

                <li class="slide">
                    <a href="{{ route('showList', ['type' => 'admins']) }}" class="side-menu__item">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20H22V18C22 16.3431 20.6569 15 19 15C18.0444 15 17.1931 15.4468 16.6438 16.1429M17 20H7M17 20V18C17 17.3438 16.8736 16.717 16.6438 16.1429M7 20H2V18C2 16.3431 3.34315 15 5 15C5.95561 15 6.80686 15.4468 7.35625 16.1429M7 20V18C7 17.3438 7.12642 16.717 7.35625 16.1429M7.35625 16.1429C8.0935 14.301 9.89482 13 12 13C14.1052 13 15.9065 14.301 16.6438 16.1429M15 7C15 8.65685 13.6569 10 12 10C10.3431 10 9 8.65685 9 7C9 5.34315 10.3431 4 12 4C13.6569 4 15 5.34315 15 7ZM21 10C21 11.1046 20.1046 12 19 12C17.8954 12 17 11.1046 17 10C17 8.89543 17.8954 8 19 8C20.1046 8 21 8.89543 21 10ZM7 10C7 11.1046 6.10457 12 5 12C3.89543 12 3 11.1046 3 10C3 8.89543 3.89543 8 5 8C6.10457 8 7 8.89543 7 10Z" />
                        </svg>


                        <span class="side-menu__label">Admin</span>
                    </a>
                </li>

                <li class="slide">
                    <a href="{{ route('showList', ['type' => 'branches']) }}" class="side-menu__item">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9H20.4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 15H20.4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5V21.5" />
                            <circle cx="18" cy="5" r="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <circle cx="4" cy="16" r="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>


                        <span class="side-menu__label">Seting Asas</span>
                    </a>
                </li>


                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="side-menu__label">Tetapan Matrix</span>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Tetapan Matrix</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('metrix.compensation.list', ['type' => 'kaffarah']) }}"
                                class="side-menu__item">Kaffarah</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('metrix.settings.list', ['type' => 'fidyah']) }}"
                                class="side-menu__item">Fidyah</a>
                        </li>
                    </ul>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                        </svg>
                        <span class="side-menu__label">Audit Trail</span>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Audit Trail</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('activityLogs') }}" class="side-menu__item">Activity Logs</a>
                        </li>
                    </ul>
                </li>
                <!-- End::slide -->








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
