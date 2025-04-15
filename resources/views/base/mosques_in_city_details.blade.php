@extends('layouts.app')

@section('styles')
@endsection

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <div class="mx-auto max-w-full bg-gray-100 p-4 sm:p-6">
        <div class="-mx-4 flex flex-wrap">
          <!-- Cards and Chart Container -->
          <div class="w-full lg:flex lg:space-x-24">
            <!-- Cards Container -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-2">
              <!-- First Card - Masjid -->
              <div class="relative overflow-hidden rounded-lg bg-sky-500 p-6 text-white">
                <div class="flex items-start justify-between">
                  <div>
                    <h2 class="mb-2 text-base !font-bold uppercase tracking-wide text-white opacity-90">
                      JUMLAH MASJID DALAM {{ $districts[$city] }} <!-- Access Title -->
                    </h2>
                    <p class="text-4xl font-bold">{{ $totalMosques }}</p> <!-- Access Value -->
                  </div>
                  <svg class="h-8 w-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                  </svg>
                </div>
              </div>

              <!-- Second Card - Ahli Kariah -->
              <div class="relative overflow-hidden rounded-lg bg-emerald-600 p-6 text-white">
                <div class="flex items-start justify-between">
                  <div>
                    <h2 class="mb-2 text-base !font-bold uppercase tracking-wide text-white opacity-90">
                      JUMLAH KARIAH MASJID DALAM {{ $districts[$city] }} <!-- Access Title -->
                    </h2>
                    <p class="text-4xl font-bold">{{ $totalKariah }}</p> <!-- Access Value -->
                  </div>
                  <svg class="h-8 w-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                  </svg>
                </div>
              </div>

              <!-- Third Card - Staff -->
              <div class="relative overflow-hidden rounded-lg bg-orange-500 p-6 text-white md:col-span-2 lg:col-span-2">
                <div class="flex items-start justify-between">
                  <div>
                    <h2 class="mb-2 text-base !font-bold uppercase tracking-wide text-white opacity-90">
                      JUMLAH STAFF MASJID DALAM {{ $districts[$city] }} <!-- Access Title -->
                    </h2>
                    <p class="text-4xl font-bold">{{ $totalStaff }}</p> <!-- Access Value -->
                  </div>
                  <svg class="h-8 w-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="mt-4 w-full lg:mt-0 lg:w-1/2">
              <div class="h-full rounded-lg bg-white p-6 shadow-lg">
                <div class="mb-6 flex items-start justify-between">
                  <h2 class="text-lg font-semibold text-gray-800">PERATUSAN STATUS MASJID SELURUH
                    {{ $districts[$city] }} </h2>
                  <button class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                      </path>
                    </svg>
                  </button>
                </div>
                <div class="relative h-[300px] w-full">
                  <canvas id="masjidChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- New Three Column Section -->
          <div class="mt-8 w-full">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
              {{-- Members by District Table --}}
              <div class="rounded-lg bg-white p-6 shadow-lg">
                <h4 class="mb-4 text-lg font-semibold text-gray-800">Statistik Masjid Mengikut Daerah</h4>
                <div class="max-h-[400px] overflow-y-auto">
                  <table class="min-w-full">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                          Kategori</th>
                        <th class="px-4 py-2 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                          Jumlah</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                      @php
                        $total = 0;
                      @endphp

                      @foreach ($categories as $code => $label)
                        @php
                          $jumlah = $districtTable->{str_replace(' ', '_', $code)} ?? 0;
                          $total += $jumlah;
                        @endphp
                        <tr class="hover:bg-gray-50">
                          <td class="px-4 py-2 text-sm text-gray-900">{{ $label }}</td>
                          <td class="px-4 py-2 text-right text-sm text-gray-500">{{ number_format($jumlah) }}</td>
                        </tr>
                      @endforeach

                      <!-- Active -->
                      <tr class="font-medium hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-900">Aktif</td>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">
                          {{ number_format($districtTable->Total_Active ?? 0) }}
                        </td>
                      </tr>

                      <!-- Tidak Aktif -->
                      <tr class="font-medium hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-900">Tidak Aktif</td>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">
                          {{ number_format($districtTable->Total_Inactive ?? 0) }}
                        </td>
                      </tr>

                      <!-- Total -->
                      <tr class="bg-gray-700 font-semibold text-white">
                        <td class="px-4 py-2 text-sm">Jumlah</td>
                        <td class="px-4 py-2 text-right text-sm">
                          {{ number_format($districtTable->Total ?? $total) }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              @php
                $totalMembers = $totalKariah_MaleFemale['total_male'] + $totalKariah_MaleFemale['total_female'];
                $malePercentage =
                    $totalMembers > 0 ? round(($totalKariah_MaleFemale['total_male'] / $totalMembers) * 100, 2) : 0;
                $femalePercentage =
                    $totalMembers > 0 ? round(($totalKariah_MaleFemale['total_female'] / $totalMembers) * 100, 2) : 0;
              @endphp

              <!-- Gender Distribution Cards -->
              <div class="flex h-full flex-col space-y-6">
                {{-- Male Card --}}
                <div class="flex-grow rounded-lg bg-sky-500 p-6 text-white">
                  <div class="mb-4 flex items-center justify-between">
                    <h2 class="mb-2 text-base !font-bold uppercase tracking-wide text-white opacity-90">
                      Ahli Kariah {{ $districts[$city] }}
                      (Lelaki)</h4>
                      <svg class="h-8 w-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                        </path>
                      </svg>
                  </div>
                  <div class="mb-2 text-4xl font-bold">{{ $totalKariah_MaleFemale['total_male'] }}</div>
                  <div class="text-lg opacity-90">{{ $malePercentage }}% Jumlah Ahli</div>
                </div>

                {{-- Female Card --}}
                <div class="flex-grow rounded-lg bg-pink-500 p-6 text-white">
                  <div class="mb-4 flex items-center justify-between">
                    <h2 class="mb-2 text-base !font-bold uppercase tracking-wide text-white opacity-90">
                      Ahli Kariah {{ $districts[$city] ?? 'N/A' }}
                      (Wanita)</h4>
                      <svg class="h-8 w-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                        </path>
                      </svg>
                  </div>
                  <div class="mb-2 text-4xl font-bold">{{ $totalKariah_MaleFemale['total_female'] }}
                  </div>
                  <div class="text-lg opacity-90">{{ $femalePercentage }}% Jumlah Ahli</div>
                </div>
              </div>

              <!-- Age Distribution Chart -->
              <div class="rounded-lg bg-white p-6 shadow-lg">
                <div class="mb-6 flex items-start justify-between">
                  <h4 class="text-lg font-semibold text-gray-800">Peringkat Umur Ahli Kariah
                    {{ $districts[$city] }} </h4>
                  <button class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                      </path>
                    </svg>
                  </button>
                </div>
                <div class="relative h-[400px] w-full">
                  <canvas id="ageChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- New Two Column Charts Section -->
          <div class="mt-8 w-full">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
              {{-- Nationality Distribution Pie Chart --}}
              <div class="rounded-lg bg-white p-6 shadow-lg">
                <div class="mb-6 flex items-start justify-between">
                  <h4 class="text-lg font-semibold text-gray-800">Peratusan Bangsa Ahli Kariah
                    {{ $districts[$city] }} </h4>
                  <button class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                      </path>
                    </svg>
                  </button>
                </div>
                <div class="relative h-[400px] w-full">
                  <canvas id="nationalityChart"></canvas>
                </div>
              </div>

              <!-- Member Category Column Chart -->
              <div class="rounded-lg bg-white p-6 shadow-lg">
                <div class="mb-6 flex items-start justify-between">
                  <h4 class="text-lg font-semibold text-gray-800">Kategori Ahli Kariah
                    {{ $city }} </h4>
                  <button class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                      </path>
                    </svg>
                  </button>
                </div>
                <div class="relative h-[400px] w-full">
                  <canvas id="categoryChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- End -->
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      // Helper function to check if all data values are zero or empty
      function hasData(values) {
        return values.some(value => value > 0);
      }

      function renderNoDataMessage(containerId) {
        const container = document.getElementById(containerId).parentElement;

        // Replace the canvas with a styled div
        container.innerHTML = `
                <div style="
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100%;
                    background-color: #f3f4f6; /* Light gray background */
                    border-radius: 12px; /* Circular corners */
                    border: 2px dashed #d1d5db; /* Dashed border */
                    color: #6b7280; /* Gray text */
                    font-size: 1.25rem; /* Larger font size */
                    font-weight: 600; /* Bold text */
                    text-align: center;
                ">
                    No Data Available
                </div>
            `;
      }


      // Mosque Data Pie Chart
      const mosqueData = @json($mosqueActiveInactive);
      const mosqueLabels = Object.keys(mosqueData);
      const mosqueValues = Object.values(mosqueData);

      if (hasData(mosqueValues)) {
        const mosqueCtx = document.getElementById('masjidChart').getContext('2d');
        new Chart(mosqueCtx, {
          type: 'pie',
          data: {
            labels: mosqueLabels,
            datasets: [{
              data: mosqueValues,
              backgroundColor: [
                '#DC2626', '#7C3AED'
              ].slice(0, mosqueLabels.length),
              borderWidth: 0
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'right'
              }
            }
          }
        });
      } else {
        renderNoDataMessage('masjidChart');
      }

      // Kariah Age Range Bar Chart
      const ageData = {
        '1-15 years': {{ $kariahPerAgeRange->range1_15 ?? 0 }},
        '15-30 years': {{ $kariahPerAgeRange->range15_30 ?? 0 }},
        '31-45 years': {{ $kariahPerAgeRange->range31_45 ?? 0 }},
        '46-60 years': {{ $kariahPerAgeRange->range46_60 ?? 0 }},
        '61-75 years': {{ $kariahPerAgeRange->range61_75 ?? 0 }},
        '75+ years': {{ $kariahPerAgeRange->range75_plus ?? 0 }}
      };

      const ageValues = Object.values(ageData);

      if (hasData(ageValues)) {
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        new Chart(ageCtx, {
          type: 'bar',
          data: {
            labels: Object.keys(ageData),
            datasets: [{
              label: 'Jumlah Ahli',
              data: ageValues,
              backgroundColor: '#60A5FA',
              borderRadius: 6
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false // Explicitly hide the legend
              },

            },
          }
        });
      } else {
        renderNoDataMessage('ageChart');
      }

      // Nationality Pie Chart
      const nationalityData = {
        'Malay': {{ $kariahNationality['Malay'] ?? 0 }},
        'Indo': {{ $kariahNationality['Indo'] ?? 0 }},
        'Chinese': {{ $kariahNationality['Chinese'] ?? 0 }},
        'Others': {{ $kariahNationality['others'] ?? 0 }}
      };

      const nationalityValues = Object.values(nationalityData);

      if (hasData(nationalityValues)) {
        const nationalityCtx = document.getElementById('nationalityChart').getContext('2d');
        new Chart(nationalityCtx, {
          type: 'pie',
          data: {
            labels: Object.keys(nationalityData),
            datasets: [{
              data: nationalityValues,
              backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
              borderWidth: 0
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false
          }
        });
      } else {
        renderNoDataMessage('nationalityChart');
      }

      // Kariah per Type Bar Chart
      const kariahData = {
        'Warga Emas': {{ $kariahPerType->warga_emas ?? 0 }},
        'Ibu Tunggal': {{ $kariahPerType->ibu_tunggal ?? 0 }},
        'Oku': {{ $kariahPerType->oku ?? 0 }},
        'Fakir Miskin': {{ $kariahPerType->fakir_miskin ?? 0 }},
        'Penerima Zakat': {{ $kariahPerType->penerima_zakat ?? 0 }},
        'PPRT': {{ $kariahPerType->pprt ?? 0 }},
        'Penerima JKM': {{ $kariahPerType->penerima_jkm ?? 0 }},
        'Pelajar': {{ $kariahPerType->pelajar ?? 0 }},
        'Pengangur': {{ $kariahPerType->pengangur ?? 0 }},
        'Bantuan Masjid': {{ $kariahPerType->bantuan_masjid ?? 0 }}
      };

      const kariahValues = Object.values(kariahData);

      if (hasData(kariahValues)) {
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
          type: 'bar',
          data: {
            labels: Object.keys(kariahData),
            datasets: [{
              label: '',
              data: kariahValues,
              backgroundColor: '#8B5CF6',
              borderRadius: 6,
              barThickness: 50
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false // Explicitly hide the legend
              },

            },
          }
        });
      } else {
        renderNoDataMessage('categoryChart');
      }
    });
  </script>
@endsection
