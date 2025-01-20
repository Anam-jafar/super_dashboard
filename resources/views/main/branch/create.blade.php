@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Tambah Cawangan Baru'" :breadcrumbs="[['label' => 'Cawangan', 'url' => 'javascript:void(0);'], ['label' => 'Cawangan Baru']]" />

            <form method="POST" action="{{ route('store', ['type' => 'branches']) }}" class="bg-white sm:p-2 text-xs">
                <!-- General Section -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Centre/Program -->
                    <div>
                        <label for="modalName" class="block font-medium text-gray-900">Centre/Program</label>
                        <input type="text" id="modalName" name="name" placeholder="Enter Centre/Program"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Singkatan -->
                    <div>
                        <label for="modalSname" class="block font-medium text-gray-900">Singkatan</label>
                        <input type="text" id="modalSname" name="sname" placeholder="Enter Singkatan"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Telefon -->
                    <div>
                        <label for="modalTel" class="block font-medium text-gray-900">Telefon</label>
                        <input type="tel" id="modalTel" name="tel" placeholder="Enter Telefon"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Emel -->
                    <div>
                        <label for="modalMel" class="block font-medium text-gray-900">Emel</label>
                        <input type="email" id="modalMel" name="mel" placeholder="Enter Emel"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Web -->
                    <div>
                        <label for="modalUrl" class="block font-medium text-gray-900">Web</label>
                        <input type="url" id="modalUrl" name="url" placeholder="Enter Web URL"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>
                </div>

                <!-- Address Section -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-8">
                    <!-- Alamat Baris 1 -->
                    <div class="sm:col-span-2">
                        <label for="modalAddr" class="block font-medium text-gray-900">Alamat Baris 1</label>
                        <input type="text" id="modalAddr" name="addr" placeholder="Enter Alamat Baris 1"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Alamat Baris 2 -->
                    <div class="sm:col-span-2">
                        <label for="modalAddr2" class="block font-medium text-gray-900">Alamat Baris 2</label>
                        <input type="text" id="modalAddr2" name="addr1" placeholder="Enter Alamat Baris 2"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Alamat Baris 3 -->
                    <div class="sm:col-span-2">
                        <label for="modalAddr3" class="block font-medium text-gray-900">Alamat Baris 3</label>
                        <input type="text" id="modalAddr3" name="addr2" placeholder="Enter Alamat Baris 3"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Daerah -->
                    <div>
                        <label for="modalDaerah" class="block font-medium text-gray-900">Daerah</label>
                        <input type="text" id="modalDaerah" name="daerah" placeholder="Enter Daerah"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Poskod -->
                    <div>
                        <label for="modalPoskod" class="block font-medium text-gray-900">Poskod</label>
                        <input type="text" id="modalPoskod" name="poskod" placeholder="Enter Poskod"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Negeri -->
                    <div>
                        <label for="modalState" class="block font-medium text-gray-900">Negeri</label>
                        <input type="text" id="modalState" name="state" placeholder="Enter Negeri"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>

                    <!-- Negara -->
                    <div>
                        <label for="modalCountry" class="block font-medium text-gray-900">Negara</label>
                        <input type="text" id="modalCountry" name="country" placeholder="Enter Negara"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm: border-gray-300 rounded-md h-[3rem]">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
