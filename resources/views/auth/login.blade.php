@extends('layouts.base')

@section('content')

    <div class="flex max-w-4xl w-full bg-white rounded-2xl border shadow-md">
        <!-- Left Side: Awfatect Login Message -->
        <div class="flex-1 bg-white text-black p-8 flex flex-col justify-start space-y-4 rounded-l-2xl">
            <h1 class="text-4xl font-semibold">Awfatect</h1>
            <h2 class="text-2xl">Sign in to continue to Dashboard</h2>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex-1 bg-white p-8 space-y-6 rounded-r-2xl">
            <h2 class="text-2xl font-semibold text-gray-800">Sign in</h2>
            <div class="space-y-4">
                <div class="space-y-2">
                    <input 
                        type="email" 
                        id="email" 
                        placeholder="Email or phone" 
                        class="w-full h-12 px-3 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                </div>
                <div class="space-y-2">
                    <input 
                        type="password" 
                        id="password" 
                        placeholder="Password" 
                        class="w-full h-12 px-3 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                </div>

            </div>
            <p class="text-sm text-gray-500">Don't have an account, contact with admin to get account.</p>

            <div class="flex items-center justify-end pt-4">
                <button class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Login</button>
            </div>
        </div>
    </div>

@endsection