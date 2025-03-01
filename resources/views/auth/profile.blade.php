@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <x-page-header :title="'Lihat Profil'" :breadcrumbs="[['label' => 'Profil', 'url' => 'javascript:void(0);'], ['label' => 'Lihat Profil']]" />
            <x-alert />

            <form method="POST" action="{{ route('updateProfile') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-4">
                    <h2 class="text-base font-medium">Profile Picture</h2>

                    <div class="flex flex-row gap-4">
                        <div
                            class="w-[150px] h-[150px] border border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                        </div>
                        <div class="flex flex-col justify-end gap-2">
                            <button
                                class="w-[12rem] h-[3rem] bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Muat Naik Imej
                            </button>
                            <p class="text-sm text-gray-500 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                use JPEG and PNG, best size 150x150 pixels. Keep it under 3MB
                            </p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-6">
                    <!-- Row 3: Left side 1 input (half space), right side 3 inputs -->
                    <div class="flex flex-col">
                        <label class="text-gray-900 font-medium mb-2">Nama</label>
                        <input type="text" name="name"
                            class="w-full p-2 h-[3rem] border border-gray-300 rounded-lg text-gray-600 bg-white"
                            value="{{ Auth::user()->name }}" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label class="text-gray-900 font-medium mb-2">System Level</label>
                            <input type="text" name="syslevel" readonly
                                class="w-full p-2 h-[3rem] border border-gray-300 rounded-lg text-gray-600 bg-white"
                                value="{{ Auth::user()->syslevel }}" />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-gray-900 font-medium mb-2">IC</label>
                            <input type="text" name="ic"
                                class="w-full p-2 h-[3rem] border border-gray-300 rounded-lg text-gray-600 bg-white"
                                value="{{ Auth::user()->ic }}" />
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-gray-900 font-medium mb-2">H/P** <sup>Cth. 0131234567 (Tiada - dan
                                ruang)<sup></label>
                        <input type="text" name="hp"
                            class="w-full p-2 h-[3rem] border border-gray-300 rounded-lg text-gray-600 bg-white"
                            value="{{ Auth::user()->hp }}" />
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-900 font-medium mb-2">Emel</label>
                        <input type="text" name="mel"
                            class="w-full p-2 h-[3rem] border border-gray-300 rounded-lg text-gray-600 bg-white"
                            value="{{ Auth::user()->mel }}" />
                    </div>

                </div>

                <fieldset class="border border-red-500 rounded-lg p-4">
                    <legend class="text-red-500 font-medium">Do not fill if you don't want to change your password</legend>
                    <div class="grid grid-cols-2 gap-4 mt-4 mb-4">
                        <div class="flex flex-col">
                            <label class="text-gray-900 font-medium mb-2">Current Password</label>
                            <input type="text" name="current_password"
                                class="w-full p-2 h-[3rem] border border-gray-300 rounded-lg text-gray-600 bg-white"
                                placeholder="Enter current password" />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-gray-900 font-medium mb-2">New Password</label>
                            <input type="text" name="new_password"
                                class="w-full p-2 h-[3rem] border border-gray-300 rounded-lg text-gray-600 bg-white"
                                placeholder="Enter new password" />
                        </div>
                    </div>
                </fieldset>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
@endsection
