@extends('layouts.app')

@section('styles')
@endsection

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Kemaskini Maklumat Institusi'" :breadcrumbs="[
          ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
          ['label' => 'Kemaskini Maklumat Institusi'],
      ]" />

      <form method="POST" action="{{ route('instituteEdit', ['id' => $institute->id]) }}" class="">
        @csrf

        <div class="space-y-2 rounded-lg bg-white px-4 py-8 text-xs shadow lg:px-8">
          <h3 class="mb-2 text-lg font-semibold">Maklumat Institusi</h3>
          <div>
            <x-required-warning-text />
          </div>
          <hr class="mb-4">
          <div class="grid-col-1 grid gap-6 md:grid-cols-2">
            <div class="grid grid-cols-2 gap-6">
              <x-input-field level="Institusi" id="inst_category" name="cate1" type="select" placeholder="Pilih"
                value="{{ $institute->cate1 }}" :valueList="$parameters['types']" :required="true" />
              <x-input-field level="Jenis Institusi" id="inst_type" name="cate" type="select" placeholder="Pilih"
                value="{{ $institute->cate }}" :valueList="$parameters['categories']" :required="true" />
            </div>

            <x-input-field level="Nama Institusi" id="inst_name" name="name" type="text"
              placeholder="Enter Institute Name" value="{{ $institute->name }}" :required="true" />
          </div>

          <div class="grid-col-1 grid gap-6 md:grid-cols-2">
            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Emel (Rasmi)" id="emel" name="mel" type="email" placeholder=""
                value="{{ $institute->mel ?? '' }}" />
              <x-input-field level="Nombor Telefon (Rasmi)" id="tel" name="hp" type="text" placeholder=""
                value="{{ $institute->hp ?? '' }}" />
            </div>
            <div class="grid grid-cols-2 items-end gap-6">

              <x-input-field level="Nombor Fax" id="fax" name="fax" type="text" placeholder=""
                value="{{ $institute->fax ?? '' }}" />
              <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name="rem15" type="date"
                placeholder="" value="{{ $institute->rem15 ?? '' }}" />
            </div>

          </div>
          <div class="grid-col-1 grid gap-6 md:grid-cols-2">
            <div class="grid-col-1 grid gap-6 md:grid-cols-2">
              <x-input-field level="Status" id="inst_type" name="sta" type="select" placeholder="Pilih"
                value="{{ $institute->sta }}" :valueList="$parameters['user_statuses']" />
              <x-input-field level="Tarikh Naik Taraf" id="upgrade_date" name="upgrade_date" type="date"
                placeholder="" />
            </div>
            <div class="grid-col-1 grid gap-6 md:grid-cols-2">
              <div class="mb-4 flex items-end space-x-2">
                <div class="inline-flex items-center justify-center outline-none">
                  <input type="checkbox" id="upgrade_institute" name="upgrade_institute"
                    class="h-5 w-5 rounded-sm border !border-[#6E829F] !text-gray-800 focus:ring-gray-500"
                    {{ old('upgrade_institute', false) ? 'checked' : '' }}>
                </div>

                <label for="upgrade_institute" class="text-sm text-gray-700">
                  Naik Taraf Intitusi
                </label>
              </div>
            </div>

          </div>
        </div>

        <div class="mt-4 space-y-2 rounded-lg bg-white px-4 py-8 text-xs shadow lg:px-8">
          <h3 class="mb-2 text-lg font-semibold">Maklumat Tambahan</h3>
          <hr class="mb-4">
          <div class="grid grid-cols-2 items-end gap-6">
            <x-input-field level="Dun" id="dun" name="rem11" type="text" placeholder=""
              value="{{ $institute->rem11 ?? '' }}" />

            <x-input-field level="Parlimen" id="parliament" name="rem12" type="text" placeholder=""
              value="{{ $institute->rem12 ?? '' }}" />
          </div>
          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Keluasan Institusi" id="area" name="rem13" type="text" placeholder=""
                value="{{ $institute->rem13 ?? '' }}" />
              <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name="rem14" type="text"
                placeholder="" value="{{ $institute->rem14 ?? '' }}" />
            </div>
            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Website" id="web" name="web" type="text" placeholder=""
                value="{{ $institute->web ?? '' }}" />
              <x-input-field level="Media Sosial" id="social" name="rem10" type="text" placeholder=""
                value="{{ $institute->rem10 ?? '' }}" />
            </div>
          </div>
        </div>

        <div class="mt-4 space-y-2 rounded-lg bg-white px-4 py-8 text-xs shadow lg:px-8">
          <h3 class="mb-2 text-lg font-semibold">Alamat Institusi</h3>
          <hr class="mb-4">
          <div class="grid grid-cols-1 items-end gap-6 lg:grid-cols-2">
            <x-input-field level="Alamat (Baris 1)" id="address1" name="addr" type="text" placeholder=""
              value="{{ $institute->addr ?? '' }}" />
            <x-input-field level="Alamat (Baris 2)" id="address2" name="addr1" type="text" placeholder=""
              value="{{ $institute->addr1 ?? '' }}" />
          </div>
          <div class="grid-col-1 !mb-4 grid gap-6 md:grid-cols-2">
            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Daerah" id="inst_district" name="rem8" type="select" placeholder="Pilih"
                value="{{ $institute->rem8 }}" :valueList="$parameters['districts']" />
              <x-input-field level="Mukim" id="inst_sub_district" name="rem9" type="select" placeholder="Pilih"
                value="{{ $institute->rem9 }}" :valueList="$parameters['subdistricts']" />
            </div>
            <div class="grid grid-cols-2 items-end gap-6">
              <div class="mt-4 flex flex-col">
                <label for="citySearch" class="mb-4 font-normal text-gray-800">
                  Bandar
                </label>

                <div class="relative">
                  <!-- Search Input -->
                  <input type="text" id="citySearch" autocomplete="off" placeholder="Cari Bandar..."
                    class="h-[3rem] w-full rounded-lg border !border-[#6E829F] p-2 !text-gray-800"
                    value="{{ $parameters['cities'][$institute->city] ?? '' }}">

                  <!-- Hidden Select (To store actual value for form submission) -->
                  <select id="city" name="city" class="hidden">
                    <option value="" disabled {{ old('city', $institute->city) === null ? 'selected' : '' }}>
                      Pilih
                    </option>
                    @foreach ($parameters['cities'] as $key => $displayValue)
                      <option value="{{ $key }}"
                        {{ old('city', $institute->city) == $key ? 'selected' : '' }}>
                        {{ $displayValue }}
                      </option>
                    @endforeach
                  </select>

                  <!-- Search Results -->
                  <ul id="cityResults"
                    class="absolute z-10 hidden max-h-48 w-full overflow-auto rounded-lg border border-gray-300 bg-white">
                  </ul>
                </div>
              </div>
              <x-input-field level="Negeri" id="negeri" name="state" type="select" placeholder=""
                value="{{ $institute->state ?? '' }}" :valueList="$parameters['states']" />
            </div>

          </div>
          <div class="grid grid-cols-1 items-end gap-6 lg:grid-cols-2">
            <x-input-field level="Poskod" id="poskod" name="pcode" type="text" placeholder=""
              value="{{ $institute->pcode ?? '' }}" />

            <x-input-field level="Koordinat Institusi" id="coordinates" name="location" type="text" placeholder=""
              value="{{ $institute->location ?? '' }}" />
          </div>
        </div>

        <div class="mt-4 space-y-2 rounded-lg bg-white px-4 py-8 text-xs shadow lg:px-8">
          <h3 class="mb-2 text-lg font-semibold">Pegawai/Wakil Institusi</h3>
          <hr class="mb-4">

          <div class="grid grid-cols-1 items-end gap-6 lg:grid-cols-2">
            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name="con1" type="text"
                placeholder="" value="{{ $institute->con1 ?? '' }}" />
              <x-input-field level="No. Kad Pengenalan" id="nric" name="ic" type="text" placeholder=""
                value="{{ $institute->ic ?? '' }}" />
            </div>

            <div class="grid grid-cols-2 items-end gap-6">
              <x-input-field level="Jawatan" id="pos" name="pos1" type="select" placeholder="Pilih"
                value="{{ $institute->pos1 ?? '' }}" :valueList="$parameters['user_positions']" />
              <x-input-field level="Nombor Telefon" id="hp" name="tel1" type="text" placeholder=""
                value="{{ $institute->tel1 ?? '' }}" />
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
              Kemaskini
            </button>
          </div>
        </div>

      </form>

      <div class="mt-4 space-y-2 rounded-lg bg-white px-4 py-8 text-xs shadow lg:px-8">
        <button id="toggleBtn"
          class="flex w-full items-center justify-between text-left text-lg font-semibold focus:outline-none">
          <h3 class="mb-2 text-lg font-semibold">Sejarah Maklumat Institusi</h3>
          <span id="arrow"
            class="fe fe-chevron-down rotate-[0deg] transform text-xl font-semibold text-gray-500 transition-transform duration-300"></span>
        </button>

        <div id="collapsibleContent" class="mt-4 hidden text-sm">
          <hr class="mb-4">

          @if ($history->isEmpty())
            <p>Tiada data dijumpai.</p>
          @else
            <div class="overflow-x-auto">
              <table class="w-full text-left text-xs">
                <thead class="uppercase text-gray-700">
                  <tr>
                    <th class="px-4 py-2">Bil</th> <!-- New column for serial number -->
                    <th class="px-4 py-2">Tarikh Pendaftaran</th>
                    <th class="px-4 py-2">Institusi</th>
                    <th class="px-4 py-2">Jenis Institusi</th>
                    <th class="px-4 py-2">Di Naiktaraf Pada</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($history as $item)
                    <tr>
                      <td class="px-4 py-2">{{ $loop->iteration }}</td> <!-- Serial number -->
                      <td class="px-4 py-2">{{ $item->registration_date }}</td>
                      <td class="px-4 py-2">{{ $item->Type->prm ?? '-' }}</td>
                      <td class="px-4 py-2">{{ $item->Category->prm ?? '-' }}</td>
                      <td class="px-4 py-2">{{ $item->upgrade_date }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>

      </div>
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
    const btn = document.getElementById("toggleBtn");
    const content = document.getElementById("collapsibleContent");
    const arrow = document.getElementById("arrow");

    let isOpen = false;

    btn.addEventListener("click", () => {
      isOpen = !isOpen;
      content.classList.toggle("hidden", !isOpen);
      arrow.style.transform = isOpen ? "rotate(-180deg)" : "rotate(0deg)";
    });
  </script>
@endsection
