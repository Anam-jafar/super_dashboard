@extends('layouts.base')

@section('content')
    <!-- Check if you're on the profile page -->
    @if (request()->routeIs('profile'))
        <div class="max-w-full mx-auto p-4 sm:p-6 bg-gray-100">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Profile</h1>

                @if (session('success'))
                    <div class="p-4 mb-6 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-r-lg animate-fade-in-down">
                        {{ session('success') }}
                    </div>
                @elseif ($errors->any())
                    <div class="p-4 mb-6 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-r-lg animate-fade-in-down">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <!-- Tabs -->
                <div class="mb-4">
                    <ul class="flex border-b">
                        <li class="-mb-px mr-1">
                            <button class="bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700 font-semibold" 
                                    onclick="changeTab(event, 'tab-info')">Information</button>
                        </li>
                        <li class="mr-1">
                            <button class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" 
                                    onclick="changeTab(event, 'tab-password')">Change Password</button>
                        </li>
                    </ul>
                </div>



                <!-- Tab Content -->
                <div id="tab-content">
                    <!-- Information Tab -->
                    <div id="tab-info" class="tab-content">
                        <form method="POST" action="{{ route('updateProfile') }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="ic" class="block text-sm font-medium text-gray-700">IC</label>
                                    <input type="text" id="ic" name="ic" value="{{ Auth::user()->ic }}" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">System Level</label>
                                    <input type="text" id="phone" name="syslevel" value="{{ Auth::user()->syslevel }}" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="email" name="mel" value="{{ Auth::user()->mel }}" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" id="phone" name="hp" value="{{ Auth::user()->hp }}" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Branch</label>
                                    <input type="number" id="phone" name="sch_id" value="{{ Auth::user()->sch_id }}" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Password Tab -->
                    <div id="tab-password" class="tab-content hidden">
<form method="POST" action="{{ route('updatePassword') }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
            <input type="password" id="current_password" name="current_password" 
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('current_password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="password" id="new_password" name="new_password" 
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('new_password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit" 
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300">
            Update Password
        </button>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function changeTab(event, tabId) {

            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(tab => tab.classList.add('hidden'));

            // Show the selected tab
            document.getElementById(tabId).classList.remove('hidden');

            // Update tab styles
            const tabs = document.querySelectorAll('.flex.border-b button');
            tabs.forEach(tab => {
                tab.classList.remove('text-blue-700', 'border-l', 'border-t', 'border-r', 'rounded-t');
                tab.classList.add('text-blue-500', 'hover:text-blue-800');
            });
            event.target.classList.add('text-blue-700', 'border-l', 'border-t', 'border-r', 'rounded-t');
        }
    </script>
@endsection
