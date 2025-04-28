@extends('layouts.app')

@section('styles')
@endsection

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Daftar Institusi Baru'" :breadcrumbs="[['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'], ['label' => 'Daftar Institusi']]" />
      <x-alert />

      <form method="POST" action="{{ route('instituteCreate') }}" class="">
        @csrf
        <div class="space-y-2 rounded-lg bg-white px-4 py-8 text-xs shadow lg:px-8">

          <h3 class="mb-2 text-lg font-semibold">Maklumat Institusi </h3>
          <div>
            <x-required-warning-text />
          </div>
          <hr class="mb-4">

          <div class="grid-col-1 grid gap-6 lg:grid-cols-2">
            <x-input-field level="Nama Institusi" id="inst_name" name="name" type="text" placeholder=""
              :required="true" />
            <div class="grid grid-cols-2 gap-6">
              <!-- Institusi (Main Category) -->
              <x-input-field level="Institusi" id="inst_category" name="cate1" type="select" placeholder="Pilih"
                :valueList="$parameters['types']" :required="true" onchange="fetchInstitutionTypes(this.value)" />

              <!-- Jenis Institusi (Dependent Dropdown) -->
              <x-input-field level="Jenis Institusi" id="inst_type" name="cate" type="select" placeholder="Pilih"
                :valueList="[]" :required="true" />
            </div>
          </div>

          <div class="grid-col-1 grid gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-2 gap-6">
              <x-input-field level="Daerah" id="inst_district" name="rem8" type="select" placeholder="Pilih"
                :valueList="$parameters['districts']" :required="true" />
              <x-input-field level="Mukim" id="inst_sub_district" name="rem9" type="select" placeholder="Pilih"
                :valueList="[]" :required="true" />
            </div>
          </div>
        </div>
        <div class="mt-4 space-y-2 rounded-lg bg-white px-4 py-8 text-xs shadow lg:px-8">
          <h3 class="mb-2 text-lg font-semibold">Maklumat Terperinci (Jika Ada)</h3>
          <hr class="mb-4">

          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <x-input-field level="Alamat (Baris 1)" id="address1" name="addr" type="text" placeholder="" />
            <x-input-field level="Alamat (Baris 2)" id="address2" name="addr1" type="text" placeholder="" />

          </div>
          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-3 gap-4">
              <x-input-field level="Poskod" id="poskod" name="pcode" type="number" placeholder="" />

              <div class="mt-4 flex flex-col">
                <label for="citySearch" class="mb-4 font-normal text-gray-800">
                  Bandar
                </label>

                <div class="relative">
                  <!-- Search Input -->
                  <input type="text" id="citySearch" autocomplete="off" placeholder="Cari Bandar..."
                    class="h-[3rem] w-full rounded-lg border !border-[#6E829F] p-2 !text-gray-800">

                  <!-- Hidden Select (To store actual value for form submission) -->
                  <select id="city" name="city" class="hidden">
                    <option value="" disabled selected>Pilih</option>
                    @foreach ($parameters['cities'] as $key => $displayValue)
                      <option value="{{ $key }}">{{ $displayValue }}</option>
                    @endforeach
                  </select>

                  <!-- Search Results -->
                  <ul id="cityResults"
                    class="absolute z-10 mt-1 hidden max-h-48 w-full overflow-auto rounded-lg border border-gray-300 bg-white">
                  </ul>
                </div>
              </div>

              <x-input-field level="Negeri" id="negeri" name="state" type="select" placeholder="" :valueList="$parameters['states']"
                value="SEL" />
            </div>
          </div>

          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-1 items-end gap-6 lg:grid-cols-2">
              <div class="grid grid-cols-2 items-end gap-6">
                <x-input-field level="Nombor Telefon (Rasmi)" id="tel" name="hp" type="number"
                  placeholder="" />
                <x-input-field level="Nombor Fax" id="fax" name="fax" type="number" placeholder="" />
              </div>
              <x-input-field level="Emel (Rasmi)" id="emel" name="mel" type="email" placeholder="" />
            </div>

            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Website" id="web" name="web" type="text" placeholder="" />
              <x-input-field level="Media Social" id="social" name="rem10" type="text" placeholder="" />
            </div>
          </div>

          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Keluasan Institusi" id="area" name="rem13" type="number"
                placeholder="" />
              <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name="rem14" type="number"
                placeholder="" />
            </div>

            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Dun" id="dun" name="rem11" type="text" placeholder="" />

              <x-input-field level="Parlimen" id="parliament" name="rem12" type="text" placeholder="" />
            </div>
          </div>

          <div class="grid grid-cols-1 items-end gap-6 lg:grid-cols-2">
            <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name="rem15" type="date"
              placeholder="" />

            <x-input-field level="Koordinat Institusi" id="coordinates" name="location" type="text"
              placeholder="" />
          </div>

          <input type="hidden" name="sta" value=1 />
          <input type="hidden" name="country" value="MYS" />

        </div>

        <div class="mt-4 space-y-2 rounded-lg bg-white px-4 py-8 text-xs shadow lg:px-8">
          <h3 class="mb-2 text-lg font-semibold">Pegawai/Wakil Institusi (Jika Ada)</h3>
          <hr class="mb-4">

          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name="con1" type="text"
                placeholder="" />
              <x-input-field level="No. Kad Pengenalan" id="nric" name="ic" type="number"
                placeholder="" />
            </div>

            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Jawatan" id="pos" name="pos1" type="select" placeholder="Pilih"
                :valueList="$parameters['user_positions']" />
              <x-input-field level="Nombor Telefon" id="hp" name="tel1" type="number" placeholder="" />
            </div>
          </div>
          <br><br>
          <div class="!mt-8 flex justify-between">
            <a href="{{ route('instituteList') }}"
              class="ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg inline-flex items-center justify-center bg-gray-500 font-medium text-white hover:bg-gray-600">
              Kembali
            </a>

            <button
              class="ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg bg-indigo-500 font-semibold text-white hover:bg-indigo-600"
              type="submit">
              Simpan
            </button>

          </div>
        </div>
      </form>

    </div>
  </div>
@endsection

@section('scripts')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      let institusiDropdown = document.getElementById('inst_category');
      let jenisInstitusiDropdown = document.getElementById('inst_type');

      institusiDropdown.addEventListener('change', function() {
        fetchInstitutionTypes(this.value);
      });

      function fetchInstitutionTypes(categoryId) {
        jenisInstitusiDropdown.innerHTML = '<option value=""></option>';
        jenisInstitusiDropdown.disabled = true;

        if (!categoryId) {
          jenisInstitusiDropdown.innerHTML = '<option value="">Pilih Institusi Dahulu</option>';
          return;
        }

        fetch("{{ route('getInstitutionCategories') }}?category_id=" + categoryId)
          .then(response => response.json())
          .then(data => {
            jenisInstitusiDropdown.innerHTML = ''; // Clear options
            if (Object.keys(data).length > 0) {
              jenisInstitusiDropdown.disabled = false;
              jenisInstitusiDropdown.innerHTML =
                '<option value="">Pilih</option>';

              Object.entries(data).forEach(([code, prm]) => {
                jenisInstitusiDropdown.innerHTML +=
                  `<option value="${code}">${prm}</option>`;
              });
            } else {
              jenisInstitusiDropdown.innerHTML =
                '<option value="">Tiada Jenis Institusi</option>';
              jenisInstitusiDropdown.disabled = true;
            }
          })
          .catch(error => console.error('Error fetching types:', error));
      }
      let districtDropdown = document.getElementById('inst_district');
      let subDistrictDropdown = document.getElementById('inst_sub_district');

      districtDropdown.addEventListener('change', function() {
        fetchSubDistricts(this.value);
      });

      function fetchSubDistricts(districtId) {
        subDistrictDropdown.innerHTML = '<option value=""></option>';
        subDistrictDropdown.disabled = true;

        if (!districtId) {
          subDistrictDropdown.innerHTML = '<option value="">Pilih Daerah Dahulu</option>';
          return;
        }

        fetch("{{ route('getSubDistricts') }}?district_id=" + districtId)
          .then(response => response.json())
          .then(data => {
            subDistrictDropdown.innerHTML = ''; // Clear options
            if (Object.keys(data).length > 0) {
              subDistrictDropdown.disabled = false;
              subDistrictDropdown.innerHTML = '<option value="">Pilih</option>';

              Object.entries(data).forEach(([code, prm]) => {
                subDistrictDropdown.innerHTML +=
                  `<option value="${code}">${prm}</option>`;
              });
            } else {
              subDistrictDropdown.innerHTML = '<option value="">Tiada Mukim</option>';
              subDistrictDropdown.disabled = true;
            }
          })
          .catch(error => console.error('Error fetching sub-districts:', error));
      }
      const citySearchInput = document.getElementById("citySearch");
      const cityDropdown = document.getElementById("city");
      const cityResults = document.getElementById("cityResults");

      function fetchCities(searchValue = "") {
        fetch(`/mais/search-bandar?query=${searchValue}`)
          .then(response => response.json())
          .then(data => {
            cityResults.innerHTML = "";
            Object.keys(data).forEach(key => {
              const listItem = document.createElement("li");
              listItem.textContent = data[key];
              listItem.classList.add("p-2", "cursor-pointer", "hover:bg-gray-200");
              listItem.dataset.value = key;

              listItem.addEventListener("click", function() {
                citySearchInput.value = data[key];
                cityDropdown.value = key;
                cityResults.classList.add("hidden");
              });

              cityResults.appendChild(listItem);
            });

            if (Object.keys(data).length > 0) {
              cityResults.classList.remove("hidden");
            } else {
              cityResults.classList.add("hidden");
            }
          })
          .catch(error => console.error("Error fetching bandar:", error));
      }

      citySearchInput.addEventListener("focus", function() {
        fetchCities();
      });

      citySearchInput.addEventListener("input", function() {
        const searchValue = this.value.trim();
        fetchCities(searchValue);
      });

      document.addEventListener("click", function(event) {
        if (!citySearchInput.contains(event.target) && !cityResults.contains(event.target)) {
          cityResults.classList.add("hidden");
        }
      });

    });
  </script>
@endsection
