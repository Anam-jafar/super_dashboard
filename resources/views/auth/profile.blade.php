@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <x-page-header :title="'Lihat Profil'" :breadcrumbs="[['label' => 'Profil', 'url' => 'javascript:void(0);'], ['label' => 'Lihat Profil']]" />
            <x-alert />

            <form method="POST" action="{{ route('updateProfile') }}" class="space-y-4 bg-white p-6 rounded-lg shadow">
                @csrf
                @method('PUT')
                <x-required-warning-text />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <x-input-field level="Nama" id="name" name="name" type="text" placeholder=""
                        value="{{ Auth::user()->name }}" :required="true" />


                    <div class="grid grid-cols-2 gap-4">
                        <x-input-field level="Peringkat Pengguna" id="syslevel" name="syslevel" type="text"
                            placeholder="" disabled="true" value="{{ Auth::user()->UserGroup->prm }}" />
                        <x-input-field level="No Kad Pengenalan" id="ic" name="ic" type="text" placeholder=""
                            value="{{ Auth::user()->ic }}" :required="true" />
                    </div>
                </div>
                <div class="grid grid-cols1 md:grid-cols-2 gap-4">
                    <x-input-field level="Nombor Telefon" id="hp" name="hp" type="text" placeholder=""
                        value="{{ Auth::user()->hp }}" :required="true" />
                    <x-input-field level="Emel" id="mel" name="mel" type="text" placeholder=""
                        value="{{ Auth::user()->mel }}" :required="true" />

                </div>
                <br>
                <br>

                <fieldset class="border border-red-500 rounded-lg p-4">
                    <legend class="text-red-500 font-medium">Jangan isi jika anda tidak mahu menukar kata laluan anda
                    </legend>
                    <div class="grid grid-cols1 md:grid-cols-2 gap-4 mt-4 mb-4">
                        <x-input-field level="Kata Laluan Semasa" id="current_password" name="current_password"
                            type="password" placeholder="********" />
                        <x-input-field level="Kata Laluan Baru" id="new_password" name="new_password" type="password"
                            placeholder="********" />
                    </div>
                </fieldset>

                <div class="flex justify-between mt-8">
                    <a href="{{ route('index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-medium ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg inline-flex items-center justify-center">
                        Kembali
                    </a>

                    <button
                        class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                        type="submit">
                        Simpan
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
@endsection
