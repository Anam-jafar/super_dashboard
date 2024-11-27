@extends('layouts.loginLayout')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
    <div class="flex max-w-4xl w-full bg-white rounded-2xl border shadow-md overflow-hidden">
        <!-- Left Side: Awfatect Login Message (hidden on mobile) -->
        <div class="flex-1 bg-white text-black p-8 flex-col justify-start space-y-4 rounded-l-2xl hidden md:flex">
            <h1 class="text-4xl font-semibold">Awfatect</h1>
            <h2 class="text-2xl">Sign in to continue to Dashboard</h2>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex-1 bg-white p-8 space-y-6 rounded-r-2xl w-full md:w-auto">
            <h2 class="text-2xl font-semibold text-gray-800">Sign in</h2>
            <form action="" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="sr-only">Email or phone</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        placeholder="Email or phone" 
                        class="w-full h-12 px-3 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required
                        autofocus
                    >
                </div>
                <div class="space-y-2">
                    <label for="password" class="sr-only">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder="Password" 
                        class="w-full h-12 px-3 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required
                    >
                </div>

                <p class="text-sm text-gray-500">Don't have an account? Contact admin to get an account.</p>

                <div class="flex items-center justify-end pt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection