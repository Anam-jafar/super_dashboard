<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Awfatech Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-gray-100" x-data="{ sidebarOpen: false, profileOpen: false }">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 bg-white border-b z-20 h-16 flex items-center justify-between px-4">
        <div class="flex items-center space-x-2">
            <!-- Mobile: Sidebar Dropdown Trigger -->
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded hover:bg-gray-200 focus:ring focus:ring-gray-300 sm:hidden" aria-expanded="false" :aria-expanded="sidebarOpen.toString()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="sr-only">Toggle sidebar menu</span>
            </button>

            <!-- Desktop: Collapse Sidebar Button -->
            <button @click="sidebarOpen = !sidebarOpen" class="hidden sm:block p-2 rounded hover:bg-gray-200 focus:ring focus:ring-gray-300" aria-expanded="false" :aria-expanded="sidebarOpen.toString()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="sr-only">Toggle sidebar</span>
            </button>

            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-900 to-blue-600 bg-clip-text text-transparent">
                Sistem Laporan Kewangan MAIS
            </h1>


        </div>

        <!-- Profile Menu -->
        <div class="relative">
            <!-- Profile Menu Button -->
            <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2" aria-haspopup="true" aria-expanded="false" aria-controls="profileMenu">
                <img src="{{ asset('assets/temp/sd_default_profile.svg') }}" alt="Profile" class="w-8 h-8 rounded-full">
                <span class="text-gray-700 hidden sm:inline">
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Profile Menu Dropdown -->
            <div x-show="profileOpen" @click.away="profileOpen = false" class="absolute right-0 mt-2 bg-white shadow-md rounded-md w-48 py-1" x-cloak id="profileMenu">
                <!-- Profile Button -->
                <button @click="window.location.href='{{ route('profile') }}'" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">
                    Profile
                </button>
                <!-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a> -->
                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">Logout</button>
                </form>
            </div>

        </div>
    </nav>
    <!-- Mobile: Sidebar Dropdown -->
    <div x-show="sidebarOpen" @click.away="sidebarOpen = false" class="fixed inset-0 z-30 sm:hidden" x-cloak>
        <div class="fixed inset-0 bg-gray-800 bg-opacity-50" aria-hidden="true"></div>
        <nav class="relative bg-white w-64 h-full overflow-y-auto">
            <div class="p-4">
                <button @click="sidebarOpen = false" class="text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="sr-only">Close sidebar</span>
                </button>
                <ul class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
                    <li>
                        <a href="{{ route('index') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('index') ? 'bg-gray-200 text-gray-900' : '' }}">
                            <img src="{{ asset('assets/temp/sd_dashboard.svg') }}" alt="Mosque Icon" class="h-6 w-6 ml-3 mr-3">
                            <span x-show="sidebarOpen">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('showEntityList') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('showEntityList') ? 'bg-gray-200 text-gray-900' : '' }}">
                            <img src="{{ asset('assets/temp/sd_mosque03.svg') }}" alt="Masjid Icon" class="h-6 w-6 ml-3 mr-3">
                            <span x-show="sidebarOpen">Masjid</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('showAdminList') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('showAdminList') ? 'bg-gray-200 text-gray-900' : '' }}">
                            <img src="{{ asset('assets/temp/sd_account.svg') }}" alt="Admin Icon" class="h-6 w-6 ml-3 mr-3">
                            <span x-show="sidebarOpen">Admin</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('showBranchList') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('showBranchList') ? 'bg-gray-200 text-gray-900' : '' }}">
                            <img src="{{ asset('assets/temp/sd_branch.svg') }}" alt="Branch Icon" class="h-6 w-6 ml-3 mr-3">
                            <span x-show="sidebarOpen">Branch</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('compensation.list') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('showBranchList') ? 'bg-gray-200 text-gray-900' : '' }}">
                            <img src="{{ asset('assets/temp/compensation.svg') }}" alt="Branch Icon" class="h-6 w-6 ml-3 mr-3">
                            <span x-show="sidebarOpen">Kaffarah</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

<!-- Desktop: Sidebar -->
<nav class="fixed top-16 left-0 bottom-0 bg-white border-r z-10 transition-all duration-300 ease-in-out 
    hidden lg:block" 
    :class="sidebarOpen ? 'w-64' : 'w-20'">
    <ul class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
        <li>
            <a href="{{ route('index') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('index') ? 'bg-gray-200 text-gray-900' : '' }}">
                <img src="{{ asset('assets/temp/sd_dashboard.svg') }}" alt="Mosque Icon" class="h-6 w-6 ml-3 mr-3">
                <span x-show="sidebarOpen">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('showEntityList') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('showEntityList') ? 'bg-gray-200 text-gray-900' : '' }}">
                <img src="{{ asset('assets/temp/sd_mosque03.svg') }}" alt="Masjid Icon" class="h-6 w-6 ml-3 mr-3">
                <span x-show="sidebarOpen">Masjid</span>
            </a>
        </li>
        <li>
            <a href="{{ route('showAdminList') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('showAdminList') ? 'bg-gray-200 text-gray-900' : '' }}">
                <img src="{{ asset('assets/temp/sd_account.svg') }}" alt="Admin Icon" class="h-6 w-6 ml-3 mr-3">
                <span x-show="sidebarOpen">Admin</span>
            </a>
        </li>
        <li>
            <a href="{{ route('showBranchList') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('showBranchList') ? 'bg-gray-200 text-gray-900' : '' }}">
                <img src="{{ asset('assets/temp/sd_branch.svg') }}" alt="Branch Icon" class="h-6 w-6 ml-3 mr-3">
                <span x-show="sidebarOpen">Branch</span>
            </a>
        </li>
        <li>
            <a href="{{ route('compensation.list') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200 {{ request()->routeIs('showBranchList') ? 'bg-gray-200 text-gray-900' : '' }}">
                <img src="{{ asset('assets/temp/compensation.svg') }}" alt="Branch Icon" class="h-6 w-6 ml-3 mr-3">
                <span x-show="sidebarOpen">Kaffarah</span>
            </a>
        </li>
    </ul>
</nav>


    <!-- Main Content -->
    <main class="pt-16 px-4 transition-all duration-300 sm:ml-20" :class="{'sm:ml-64': sidebarOpen}">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-8 py-4 text-center text-sm text-gray-600">
        <strong>Awfatech</strong> &mdash; This product is for <em>internal use only</em>. All rights reserved &copy; {{ date('Y') }}.
    </footer>


    <script>
        // This script is needed to prevent Flash of Unstyled Content (FOUC) with Alpine.js
        document.addEventListener('alpine:init', () => {
            Alpine.data('layout', () => ({
                sidebarOpen: window.innerWidth >= 640, // Open by default on larger screens
                profileOpen: false
            }))
        })
    </script>
</body>
</html>
