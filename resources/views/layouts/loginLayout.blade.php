<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awfatect Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="min-h-screen bg-gray-100">
    <main class="flex items-center justify-center min-h-screen p-6 transition-all duration-300 ease-in-out">
        @yield('content')
    </main>

    <footer class="p-4 flex items-center justify-between text-sm text-gray-600 transition-all duration-300 ease-in-out"
            :class="sidebarOpen ? 'ml-64' : 'ml-20'">
        <select class="border-none bg-transparent">
            <option>English (United States)</option>
            <option>Español</option>
            <option>Français</option>
        </select>
        <div class="flex gap-4">
            <a href="#" class="hover:text-gray-900">Help</a>
            <a href="#" class="hover:text-gray-900">Privacy</a>
            <a href="#" class="hover:text-gray-900">Terms</a>
        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('navbar', () => ({
                sidebarOpen: true,
                profileOpen: false,
                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                },
                toggleProfile() {
                    this.profileOpen = !this.profileOpen;
                }
            }));
        });
    </script>
</body>
</html>
