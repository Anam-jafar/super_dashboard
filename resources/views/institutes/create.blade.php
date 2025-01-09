@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Tambah Masjid Baru'" :breadcrumbs="[['label' => 'Masjid', 'url' => 'javascript:void(0);'], ['label' => 'Tambah Masjid']]" />

            <form method="POST" action="#">
                @csrf
                <!-- Profile Section -->
                <div
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div>
                        <label for="modalName" class="ti-form-label">Mosque Name</label>
                        <input type="text" name="mosque_name" id="modalName" class="form-control" placeholder="Mosque Name">
                    </div>
                    <div>
                        <label for="modalContact" class="ti-form-label">Primary Contact</label>
                        <input type="text" name="primary_contact" id="modalContact" class="form-control"
                            placeholder="Primary Contact">
                    </div>
                    <div>
                        <label for="modalCategory" class="ti-form-label">Category</label>
                        <select name="category" id="modalCategory" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->prm }}">{{ $category->prm }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modalStatus" class="ti-form-label">Status</label>
                        <select name="status" id="modalStatus" class="form-control">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->val }}">{{ $status->prm }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modalGroup" class="ti-form-label">Group</label>
                        <select name="group" id="modalGroup" class="form-control">
                            @foreach ($areas as $area)
                                <option value="{{ $area->prm }}">{{ $area->prm }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modalEmail" class="ti-form-label">Email</label>
                        <input type="email" name="email" id="modalEmail" class="form-control" placeholder="Email">
                    </div>
                    <div>
                        <label for="modalPhone" class="ti-form-label">Mobile Phone</label>
                        <input type="tel" name="mobile_phone" id="modalPhone" class="form-control"
                            placeholder="Mobile Phone">
                    </div>
                </div>

                <!-- Address Section -->
                <div
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div class="sm:col-span-2">
                        <label for="modalAddress1" class="ti-form-label">Address Line 1</label>
                        <input type="text" name="address_line1" id="modalAddress1" class="form-control"
                            placeholder="Address Line 1">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="modalAddress2" class="ti-form-label">Address Line 2</label>
                        <input type="text" name="address_line2" id="modalAddress2" class="form-control"
                            placeholder="Address Line 2">
                    </div>
                    <div>
                        <label for="modalCity" class="ti-form-label">City</label>
                        <input type="text" name="city" id="modalCity" class="form-control" placeholder="City">
                    </div>
                    <div>
                        <label for="modalPcode" class="ti-form-label">Postal Code</label>
                        <input type="text" name="postal_code" id="modalPcode" class="form-control"
                            placeholder="Postal Code">
                    </div>
                    <div>
                        <label for="modalState" class="ti-form-label">State</label>
                        <select name="state" id="modalState" class="form-control">
                            @foreach ($states as $state)
                                <option value="{{ $state->prm }}">{{ $state->prm }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modalCountry" class="ti-form-label">Country</label>
                        <input type="text" name="country" id="modalCountry" class="form-control" placeholder="Country">
                    </div>
                </div>

                <!-- Additional Info Section -->
                <div
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div>
                        <label for="modalCustomerLink" class="ti-form-label">Customer Link</label>
                        <input type="text" name="customer_link" id="modalCustomerLink" class="form-control"
                            placeholder="Customer Link">
                    </div>
                    <div>
                        <label for="modalAppCode" class="ti-form-label">Directory / App Code</label>
                        <input type="text" name="app_code" id="modalAppCode" class="form-control"
                            placeholder="App Code">
                    </div>
                    <div>
                        <label for="modalCenterId" class="ti-form-label">Center ID</label>
                        <input type="text" name="center_id" id="modalCenterId" class="form-control"
                            placeholder="Center ID">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                        Submit
                    </button>
                </div>
            </form>




        </div>
    </div>
@endsection
