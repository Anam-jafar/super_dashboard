@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <x-page-header :title="'Kemaskini Pentadbir'" :breadcrumbs="[['label' => 'Pentadbir', 'url' => 'javascript:void(0);'], ['label' => 'Kemaskini Pentadbir']]" />
            <form method="POST" action="{{ route('updateProfile') }}" class="space-y-4">
                @csrf
                @method('PUT')
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
                            <input type="text" name="syslevel"
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
                        <label class="text-gray-900 font-medium mb-2">Tel Bimbit.</label>
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
                    <div class="grid grid-cols-2 gap-4">
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
