<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awfatect Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-gray-100" x-data="{ sidebarOpen: true, profileOpen: false }">
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

            <h1 class="text-xl font-semibold text-gray-800">Awfatect</h1>
        </div>

        <!-- Profile Menu -->
        <div class="relative">
            <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2" aria-haspopup="true" :aria-expanded="profileOpen.toString()">
                <img src="https://via.placeholder.com/40" alt="Profile" class="w-8 h-8 rounded-full">
                <span class="text-gray-700 hidden sm:inline">John Doe</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="profileOpen" @click.away="profileOpen = false" class="absolute right-0 mt-2 bg-white shadow-md rounded-md w-48 py-1" x-cloak>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
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
                <ul class="mt-6 space-y-4">
                    <li>
                        <a href="#" class="flex items-center text-gray-700 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <!-- Add more menu items as needed -->
                </ul>
            </div>
        </nav>
    </div>

    <!-- Desktop: Sidebar -->
    <nav class="fixed top-16 left-0 bottom-0 bg-white border-r z-10 transition-all duration-300 ease-in-out hidden sm:block"
        :class="sidebarOpen ? 'w-64' : 'w-20'">
        <ul class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>
<!-- 
                <a href="{{ route('dashboard.create') }}" class="flex items-center p-2 rounded-md hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen">Create</span>
                </a> -->
            </li>
            <!-- Add more menu items as needed -->
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="pt-16 px-4 transition-all duration-300 sm:ml-20" :class="{'sm:ml-64': sidebarOpen}">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-8 py-4 text-center text-sm text-gray-600">
        <p>&copy; 2024 Awfatect. All rights reserved.</p>
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