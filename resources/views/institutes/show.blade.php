@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Edit Mosque'" :breadcrumbs="[['label' => 'Mosque', 'url' => 'javascript:void(0);'], ['label' => 'Edit Mosque']]" />

            <form method="POST" action="{{ route('update', ['type' => 'mosques', 'id' => $entity->id]) }}">
                @csrf
                @method('PUT')
                <!-- Profile Section -->
                <div
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div>
                        <label for="modalName" class="ti-form-label">Mosque Name</label>
                        <input type="text" name="name" id="modalName" class="form-control" placeholder="Mosque Name"
                            value="{{ old('name', $entity->name) }}">
                    </div>
                    <div>
                        <label for="modalContact" class="ti-form-label">Primary Contact</label>
                        <input type="text" name="hp" id="modalContact" class="form-control"
                            placeholder="Primary Contact" value="{{ old('hp', $entity->hp) }}">
                    </div>
                    <div>
                        <label for="modalCategory" class="ti-form-label">Category</label>
                        <select name="cate" id="modalCategory" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->prm }}"
                                    {{ $category->prm == old('category', $entity->cate) ? 'selected' : '' }}>
                                    {{ $category->prm }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modalStatus" class="ti-form-label">Status</label>
                        <select name="sta" id="modalStatus" class="form-control">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->val }}"
                                    {{ $status->val == old('status', $entity->sta) ? 'selected' : '' }}>
                                    {{ $status->prm }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modalGroup" class="ti-form-label">Group</label>
                        <select name="cate1" id="modalGroup" class="form-control">
                            @foreach ($areas as $area)
                                <option value="{{ $area->prm }}"
                                    {{ $area->prm == old('group', $entity->cate1) ? 'selected' : '' }}>
                                    {{ $area->prm }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modalEmail" class="ti-form-label">Email</label>
                        <input type="email" name="mel" id="modalEmail" class="form-control" placeholder="Email"
                            value="{{ old('email', $entity->mel) }}">
                    </div>
                    <div>
                        <label for="modalPhone" class="ti-form-label">Mobile Phone</label>
                        <input type="tel" name="tel" id="modalPhone" class="form-control" placeholder="Mobile Phone"
                            value="{{ old('mobile_phone', $entity->tel) }}">
                    </div>
                </div>

                <!-- Address Section -->
                <div
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div class="sm:col-span-2">
                        <label for="modalAddress1" class="ti-form-label">Address Line 1</label>
                        <input type="text" name="addr" id="modalAddress1" class="form-control"
                            placeholder="Address Line 1" value="{{ old('address_line1', $entity->addr) }}">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="modalAddress2" class="ti-form-label">Address Line 2</label>
                        <input type="text" name="addr1" id="modalAddress2" class="form-control"
                            placeholder="Address Line 2" value="{{ old('address_line2', $entity->addr1) }}">
                    </div>
                    <div>
                        <label for="modalCity" class="ti-form-label">City</label>
                        <input type="text" name="city" id="modalCity" class="form-control" placeholder="City"
                            value="{{ old('city', $entity->city) }}">
                    </div>
                    <div>
                        <label for="modalPcode" class="ti-form-label">Postal Code</label>
                        <input type="text" name="pcode" id="modalPcode" class="form-control" placeholder="Postal Code"
                            value="{{ old('postal_code', $entity->pcode) }}">
                    </div>
                    <div>
                        <label for="modalState" class="ti-form-label">State</label>
                        <select name="state" id="modalState" class="form-control">
                            @foreach ($states as $state)
                                <option value="{{ $state->prm }}"
                                    {{ $state->prm == old('state', $entity->state) ? 'selected' : '' }}>
                                    {{ $state->prm }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modalCountry" class="ti-form-label">Country</label>
                        <input type="text" name="country" id="modalCountry" class="form-control" placeholder="Country"
                            value="{{ old('country', $entity->country) }}">
                    </div>
                </div>

                <!-- Additional Info Section -->
                <div
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div>
                        <label for="modalCustomerLink" class="ti-form-label">Customer Link</label>
                        <input type="text" name="rem1" id="modalCustomerLink" class="form-control"
                            placeholder="Customer Link" value="{{ old('customer_link', $entity->rem1) }}">
                    </div>
                    <div>
                        <label for="modalAppCode" class="ti-form-label">Directory / App Code</label>
                        <input type="text" name="rem2" id="modalAppCode" class="form-control"
                            placeholder="App Code" value="{{ old('app_code', $entity->rem2) }}">
                    </div>
                    <div>
                        <label for="modalCenterId" class="ti-form-label">Center ID</label>
                        <input type="text" name="rem3" id="modalCenterId" class="form-control"
                            placeholder="Center ID" value="{{ old('center_id', $entity->rem3) }}">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
