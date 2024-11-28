@extends('layouts.loginLayout')

@section('content')
<div class="min-h-screen flex flex-col">
    <!-- Main Content -->
    <div class="flex-1 flex items-start justify-center p-6 sm:items-center">
        <div class="w-full max-w-[1000px]">
            <!-- Container for both panels -->
            <div class="w-full sm:flex sm:bg-white sm:rounded-2xl sm:shadow-xl sm:overflow-hidden">
                <!-- Left Panel (Hidden on mobile) -->
                <div class="hidden sm:flex sm:flex-col sm:flex-1 sm:p-12 sm:justify-start sm:bg-gray-50">
                    <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-blue-900 to-blue-500 bg-clip-text text-transparent">
                        Awfa tech
                    </h1>
                    <p class="text-xl text-gray-600">Sign in to continue to Dashboard</p>
                </div>

                <!-- Right Panel -->
                <div class="w-full sm:flex-1 sm:p-12">
                    <!-- Mobile Only Logo -->
                    <div class="sm:hidden space-y-4 mb-8">
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-900 to-blue-500 bg-clip-text text-transparent">
                            Awfa tech
                        </h1>
                        <div>
                            <h2 class="text-2xl font-normal">Sign in</h2>
                            <p class="text-base text-gray-600 mt-1">to continue to Awfa tech Dashboard</p>
                        </div>
                    </div>

                    <!-- Desktop Only Title -->
                    <div class="hidden sm:block mb-8">
                        <h2 class="text-2xl font-normal">Sign in</h2>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="" class="space-y-5">
                        @csrf
                        <div>
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                autocomplete="email" 
                                placeholder="Email or phone"
                                required
                                class="w-full px-3 py-3.5 text-base text-gray-900 border border-gray-300 rounded-md hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>
                        
                        <div>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                placeholder="Enter your password"
                                required
                                class="w-full px-3 py-3.5 text-base text-gray-900 border border-gray-300 rounded-md hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <div>
                            <a href="" class="text-sm text-blue-600 hover:text-blue-800">
                                Forgot password?
                            </a>
                        </div>
                        <p class="text-sm text-gray-500">Don't have an account? Contact admin to get an account.</p>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="min-w-[80px] px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Next
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Desktop Footer -->
            <footer class="hidden sm:flex w-full p-4 items-center justify-between text-sm text-gray-600">
                <select class="bg-transparent border-none text-sm text-gray-600 focus:outline-none focus:ring-0">
                    <option>English (United States)</option>
                    <option>Español</option>
                    <option>Français</option>
                </select>
                <div class="flex gap-8">
                    <a href="#" class="hover:text-gray-900">Help</a>
                    <a href="#" class="hover:text-gray-900">Privacy</a>
                    <a href="#" class="hover:text-gray-900">Terms</a>
                </div>
            </footer>
        </div>
    </div>

    <!-- Mobile Footer -->
    <footer class="sm:hidden w-full p-4 flex flex-wrap items-center justify-between text-sm text-gray-600 mt-auto">
        <select class="bg-transparent border-none text-sm text-gray-600 focus:outline-none focus:ring-0">
            <option>English (United States)</option>
            <option>Español</option>
            <option>Français</option>
        </select>
        <div class="flex gap-8">
            <a href="#" class="hover:text-gray-900">Help</a>
            <a href="#" class="hover:text-gray-900">Privacy</a>
            <a href="#" class="hover:text-gray-900">Terms</a>
        </div>
    </footer>
</div>
@endsection