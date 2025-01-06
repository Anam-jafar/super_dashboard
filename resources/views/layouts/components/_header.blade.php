
<header class="app-header sticky" id="header">

<!-- Start::main-header-container -->
<div class="main-header-container container-fluid">

    <!-- Start::header-content-left -->
    <div class="header-content-left">

        <!-- Start::header-element -->
        <div class="header-element">
            <div class="horizontal-logo">
                <a href="{{url('index')}}" class="header-logo">
                    <img src="{{asset('build/assets/images/brand-logos/desktop-logo.png')}}" alt="logo" class="desktop-logo">
                    <img src="{{asset('build/assets/images/brand-logos/toggle-dark.png')}}" alt="logo" class="toggle-dark">
                    <img src="{{asset('build/assets/images/brand-logos/desktop-dark.png')}}" alt="logo" class="desktop-dark">
                    <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" alt="logo" class="toggle-logo">
                    <img src="{{asset('build/assets/images/brand-logos/toggle-white.png')}}" alt="logo" class="toggle-white">
                    <img src="{{asset('build/assets/images/brand-logos/desktop-white.png')}}" alt="logo" class="desktop-white">
                </a>
            </div>
        </div>
        <!-- End::header-element -->

        <!-- Start::header-element -->
        <div class="header-element mx-lg-0">
            <a aria-label="Hide Sidebar"
                class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
        </div>
        <!-- End::header-element -->

    </div>
    <!-- End::header-content-left -->

    <!-- Start::header-content-right -->
    <ul class="header-content-right">

        <!-- Start::header-element -->
        <li class="header-element md:!hidden block">
            <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal"
                data-hs-overlay="#header-responsive-search">
                <!-- Start::header-link-icon -->
                <i class="bi bi-search header-link-icon"></i>
                <!-- End::header-link-icon -->
            </a>
        </li>
        <!-- End::header-element -->



        <!-- Start::header-element -->
        <!-- light and dark theme -->
        <li class="header-element header-theme-mode hidden !items-center sm:block md:!px-[0.5rem] px-2">
            <a aria-label="anchor"
                class="hs-dark-mode-active:hidden flex hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium transition-all text-xs dark:bg-bgdark dark:hover:bg-black/20 text-textmuted dark:text-textmuted/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                href="javascript:void(0);" data-hs-theme-click-value="dark">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 header-link-icon" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </a>
            <a aria-label="anchor"
                class="hs-dark-mode-active:flex hidden hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium text-defaulttextcolor  transition-all text-xs dark:bg-bodybg dark:bg-bgdark dark:hover:bg-black/20  dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                href="javascript:void(0);" data-hs-theme-click-value="light">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 header-link-icon" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
            </a>
        </li>
        <!-- End light and dark theme -->

        <!-- End::header-element -->

        <!-- Start::header-element -->
        <li class="header-element ti-dropdown hs-dropdown">
            <!-- Start::header-link|dropdown-toggle -->
            <a href="javascript:void(0);" class="header-link hs-dropdown-toggle ti-dropdown-toggle"
                id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <div class="flex items-center">
                    <div>
                        <img src="{{asset('build/assets/images/faces/15.jpg')}}" alt="img" class="avatar avatar-sm mb-0">
                    </div>
                </div>
            </a>
            <!-- End::header-link|dropdown-toggle -->
            <ul class="main-header-dropdown hs-dropdown-menu ti-dropdown-menu pt-0 overflow-hidden header-profile-dropdown hidden"
                aria-labelledby="mainHeaderProfile">
                <li>
                    <div
                        class="ti-dropdown-item text-center border-b border-defaultborder dark:border-defaultborder/10 block">
                        <span>
                        {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                        </span>
                        <span class="block text-xs text-textmuted dark:text-textmuted/50">{{ Auth::check() ? Auth::user()->syslevel : 'System Level' }}</span>
                    </div>
                </li>
                <li><a class="ti-dropdown-item flex items-center" href="{{route('profile')}}"><i
                            class="fe fe-user p-1 rounded-full bg-primary/10 text-primary me-2 text-[1rem]"></i>Profile</a>
                </li>
                <li><a class="ti-dropdown-item flex items-center" href="{{route('activityLogs')}}"><i
                            class="fe fe-activity p-1 rounded-full bg-primary/10 text-primary me-2 text-[1rem]"></i>Activity Logs</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="ti-dropdown-item flex items-center w-full text-left">
                            <i class="fe fe-lock p-1 rounded-full bg-primary/10 text-primary ut me-2 text-[1rem]"></i>
                            Log Out
                        </button>
                    </form>
                </li>

                        
            </ul>
        </li>
        <!-- End::header-element -->

        <!-- Start::header-element -->
        <li class="header-element">
            <!-- Start::header-link|switcher-icon -->
            <a href="javascript:void(0);" class="header-link switcher-icon" data-hs-overlay="#hs-overlay-switcher">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 header-link-icon" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </a>
            <!-- End::header-link|switcher-icon -->
        </li>
        <!-- End::header-element -->

    </ul>
    <!-- End::header-content-right -->

</div>
<!-- End::main-header-container -->

</header>
