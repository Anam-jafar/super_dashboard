@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Kemaskini Pentadbir'" :breadcrumbs="[['label' => 'Pentadbir', 'url' => 'javascript:void(0);'], ['label' => 'Kemaskini Pentadbir']]" />

            <form method="POST" action="{{ route('update', ['type' => 'admins', 'id' => $entity->id]) }}"
                class="py-8 px-4 lg:px-8 rounded-lg shadow bg-white text-xs">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="name" class="ti-form-label">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $entity->name) }}"
                            class="form-control h-[3rem]" required>
                    </div>

                    <!-- Level Sistem -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="syslevel" class="ti-form-label">Level Sistem</label>
                        <select id="syslevel" name="syslevel" class="form-control h-[3rem]" required>
                            @foreach ($syslevels as $syslevel)
                                <option value="{{ $syslevel->prm }}"
                                    {{ $syslevel->prm == old('syslevel', $entity->syslevel) ? 'selected' : '' }}>
                                    {{ $syslevel->prm }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nombor KP -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="ic" class="ti-form-label">Nombor KP</label>
                        <input type="text" id="ic" name="ic" value="{{ old('ic', $entity->ic) }}"
                            class="form-control h-[3rem]" required>
                    </div>

                    <!-- Capaian Sistem -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="sysaccess" class="ti-form-label">Capaian Sistem</label>
                        <input type="text" id="sysaccess" name="sysaccess"
                            value="{{ old('sysaccess', $entity->sysaccess) }}" class="form-control h-[3rem]" required>
                    </div>

                    <!-- Tel. Bimbit -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="hp" class="ti-form-label">Tel. Bimbit</label>
                        <input type="text" id="hp" name="hp" value="{{ old('hp', $entity->hp) }}"
                            class="form-control h-[3rem]" required>
                    </div>

                    <!-- Tarikh Mula -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="jobstart" class="ti-form-label">Tarikh Mula</label>
                        <input type="date" id="jobstart" name="jobstart"
                            value="{{ old('jobstart', $entity->jobstart) }}" class="form-control h-[3rem]" required>
                    </div>

                    <!-- Emel -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="mel" class="ti-form-label">Emel</label>
                        <input type="email" id="mel" name="mel" value="{{ old('mel', $entity->mel) }}"
                            class="form-control h-[3rem]" required>
                    </div>

                    <!-- Status -->
                    <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                        <label for="status" class="ti-form-label">Status</label>
                        <select id="status" name="status" class="form-control h-[3rem]" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->val }}"
                                    {{ $status->val == old('status', $entity->status) ? 'selected' : '' }}>
                                    {{ $status->prm }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                        Kemaskini
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
