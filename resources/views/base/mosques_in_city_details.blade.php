@extends('layouts.base')

@section('content')

<div class="max-w-full mx-auto p-4 sm:p-6 bg-gray-100">
    <div class="flex flex-wrap -mx-4">
        <!-- Cards and Chart Container -->
        <div class="w-full lg:flex lg:space-x-24">
            <!-- Cards Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                <!-- First Card - Masjid -->
                <div class="bg-sky-500 rounded-lg p-6 text-white relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-sm font-medium opacity-90 uppercase tracking-wide mb-2">
                                JUMLAH MASJID DALAM {{$city}} <!-- Access Title -->
                            </h2>
                            <p class="text-4xl font-bold">{{ $totalMosques }}</p> <!-- Access Value -->
                        </div>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Second Card - Ahli Kariah -->
                <div class="bg-emerald-600 rounded-lg p-6 text-white relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-sm font-medium opacity-90 uppercase tracking-wide mb-2">
                                JUMLAH KARIAH MASJID DALAM  {{$city}}  <!-- Access Title -->
                            </h2>
                            <p class="text-4xl font-bold">{{ $totalKariah }}</p> <!-- Access Value -->
                        </div>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Third Card - Staff -->
                <div class="bg-orange-500 rounded-lg p-6 text-white relative overflow-hidden md:col-span-2 lg:col-span-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-sm font-medium opacity-90 uppercase tracking-wide mb-2">
                                JUMLAH STAFF MASJID DALAM  {{$city}}  <!-- Access Title -->
                            </h2>
                            <p class="text-4xl font-bold">{{ $totalStaff }}</p> <!-- Access Value -->
                        </div>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            

            <!-- Pie Chart -->
            <div class="w-full lg:w-1/2 mt-4 lg:mt-0">
                <div class="bg-white shadow-lg rounded-lg p-6 h-full">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">PERATUSAN STATUS MASJID SELURUH  {{$city}}  </h2>
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
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
        <div class="w-full mt-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Members by District Table --}}
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Jumlah Ahli Kariah Mengikut Daerah</h4>
                    <div class="overflow-y-auto max-h-[400px]">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php
                                    $total = 0; // Initialize total variable
                                @endphp

                                @foreach ($kariahPerMosqueType as $category => $jumlah)
                                    @php
                                        $total += $jumlah; // Add each category's amount to total
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $category }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-right">{{ number_format($jumlah) }}</td>
                                    </tr>
                                @endforeach

                                <!-- Total Row with bold text and darker background -->
                                <tr class="bg-gray-700 text-white font-semibold">
                                    <td class="px-4 py-2 text-sm">Jumlah</td>
                                    <td class="px-4 py-2 text-sm text-right">{{ number_format($total) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



                <!-- Gender Distribution Cards -->
                <div class="space-y-6 flex flex-col h-full">
                    {{-- Male Card --}}
                    <div class="bg-sky-500 rounded-lg p-6 text-white flex-grow">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold">Ahli Kariah  {{$city}} (Lelaki)</h4>
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="text-4xl font-bold mb-2">{{ $totalKariah_MaleFemale['total_male'] }}</div>
                        <div class="text-lg opacity-90">40% Jumlah Ahli</div>
                    </div>

                    {{-- Female Card --}}
                    <div class="bg-pink-500 rounded-lg p-6 text-white flex-grow">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold">Ahli Kariah  {{$city}}  (Wanita)</h4>
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="text-4xl font-bold mb-2">{{ $totalKariah_MaleFemale['total_female'] }}</div>
                        <div class="text-lg opacity-90">60% Jumlah Ahli</div>
                    </div>
                </div>


                <!-- Age Distribution Chart -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h4 class="text-lg font-semibold text-gray-800">Peringkat Umur Ahli Kariah  {{$city}} </h4>
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
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
        <div class="w-full mt-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Nationality Distribution Pie Chart --}}
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h4 class="text-lg font-semibold text-gray-800">Peratusan Bangsa Ahli Kariah  {{$city}} </h4>
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="relative h-[400px] w-full">
                        <canvas id="nationalityChart"></canvas>
                    </div>
                </div>

                <!-- Member Category Column Chart -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h4 class="text-lg font-semibold text-gray-800">Kategori Ahli Kariah  {{$city}} </h4>
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
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
                        legend: { position: 'right' }
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
                options: { responsive: true, maintainAspectRatio: false }
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

