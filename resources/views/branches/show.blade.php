@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Kemaskini Cawangan'" :breadcrumbs="[['label' => 'Cawangan', 'url' => 'javascript:void(0);'], ['label' => 'Kemaskini Cawangan']]" />

            <form method="POST" action="{{ route('updateBranch', $branch->id) }}" class="grid grid-cols-1 gap-6">
                @csrf
                @method('PUT')

                <!-- General Section -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Centre/Program -->
                    <div>
                        <label for="modalName" class="block text-sm font-medium text-gray-700">Centre/Program</label>
                        <input type="text" id="modalName" name="name" value="{{ old('name', $branch->name) }}"
                            placeholder="Enter Centre/Program"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Singkatan -->
                    <div>
                        <label for="modalSname" class="block text-sm font-medium text-gray-700">Singkatan</label>
                        <input type="text" id="modalSname" name="sname" value="{{ old('sname', $branch->sname) }}"
                            placeholder="Enter Singkatan"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>


                    <!-- Telefon -->
                    <div>
                        <label for="modalTel" class="block text-sm font-medium text-gray-700">Telefon</label>
                        <input type="tel" id="modalTel" name="tel" value="{{ old('tel', $branch->tel) }}"
                            placeholder="Enter Telefon"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Emel -->
                    <div>
                        <label for="modalMel" class="block text-sm font-medium text-gray-700">Emel</label>
                        <input type="email" id="modalMel" name="mel" value="{{ old('mel', $branch->mel) }}"
                            placeholder="Enter Emel"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Web -->
                    <div>
                        <label for="modalUrl" class="block text-sm font-medium text-gray-700">Web</label>
                        <input type="url" id="modalUrl" name="url" value="{{ old('url', $branch->url) }}"
                            placeholder="Enter Web URL"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <!-- Address Section -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-8">
                    <!-- Alamat Baris 1 -->
                    <div class="sm:col-span-2">
                        <label for="modalAddr" class="block text-sm font-medium text-gray-700">Alamat Baris 1</label>
                        <input type="text" id="modalAddr" name="addr" value="{{ old('addr', $branch->addr) }}"
                            placeholder="Enter Alamat Baris 1"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Alamat Baris 2 -->
                    <div class="sm:col-span-2">
                        <label for="modalAddr2" class="block text-sm font-medium text-gray-700">Alamat Baris 2</label>
                        <input type="text" id="modalAddr2" name="addr1" value="{{ old('addr1', $branch->addr1) }}"
                            placeholder="Enter Alamat Baris 2"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Alamat Baris 3 -->
                    <div class="sm:col-span-2">
                        <label for="modalAddr3" class="block text-sm font-medium text-gray-700">Alamat Baris 3</label>
                        <input type="text" id="modalAddr3" name="addr2" value="{{ old('addr2', $branch->addr2) }}"
                            placeholder="Enter Alamat Baris 3"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Daerah -->
                    <div>
                        <label for="modalDaerah" class="block text-sm font-medium text-gray-700">Daerah</label>
                        <input type="text" id="modalDaerah" name="daerah" value="{{ old('daerah', $branch->daerah) }}"
                            placeholder="Enter Daerah"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Poskod -->
                    <div>
                        <label for="modalPoskod" class="block text-sm font-medium text-gray-700">Poskod</label>
                        <input type="text" id="modalPoskod" name="poskod" value="{{ old('poskod', $branch->poskod) }}"
                            placeholder="Enter Poskod"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Negeri -->
                    <div>
                        <label for="modalState" class="block text-sm font-medium text-gray-700">Negeri</label>
                        <input type="text" id="modalState" name="state" value="{{ old('state', $branch->state) }}"
                            placeholder="Enter Negeri"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Negara -->
                    <div>
                        <label for="modalCountry" class="block text-sm font-medium text-gray-700">Negara</label>
                        <input type="text" id="modalCountry" name="country"
                            value="{{ old('country', $branch->country) }}" placeholder="Enter Negara"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        Kemaskini
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
