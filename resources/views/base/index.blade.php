@extends('layouts.base')

@section('content')

<div class="max-w-full mx-auto p-4 sm:p-6 bg-gray-100">
    <div class="flex flex-wrap -mx-4">
        <!-- Cards and Chart Container -->
        <div class="w-full lg:flex lg:space-x-4">
            <!-- Cards Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-4">
                <!-- First Card - Masjid -->
                <div class="bg-sky-500 rounded-lg p-6 text-white relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-sm font-medium opacity-90 uppercase tracking-wide mb-2">
                                JUMLAH MASJID DALAM SELANGOR <!-- Access Title -->
                            </h2>
                            <p class="text-4xl font-bold">{{ $objects['total_mosque']['value'] }}</p> <!-- Access Value -->
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
                                JUMLAH KARIAH MASJID DALAM SELANGOR <!-- Access Title -->
                            </h2>
                            <p class="text-4xl font-bold">{{ $objects['total_kariah']['value'] }}</p> <!-- Access Value -->
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
                                JUMLAH STAFF MASJID DALAM SELANGOR <!-- Access Title -->
                            </h2>
                            <p class="text-4xl font-bold">{{ $objects['total_staff']['value'] }}</p> <!-- Access Value -->
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
                        <h2 class="text-lg font-semibold text-gray-800">PERATUSAN JENIS MASJID SELURUH SELANGOR</h2>
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

        <div class="w-full mt-8">
            <div class="bg-white shadow-lg rounded-lg p-4 sm:p-6 overflow-x-auto">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Statistik Masjid Mengikut Daerah</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-200">
                                <th width='3%' rowspan='2' class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">#</th>
                                <th width='17%' rowspan='2' class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Daerah</th>
                                <th colspan='8' class="px-4 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Kategori Masjid</th>
                                <th rowspan='2' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Aktif</th>
                                <th rowspan='2' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Tidak Aktif</th>
                                <th rowspan='2' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Jumlah Masjid</th>
                            </tr>
                            <tr class="bg-gray-200">
                                <th width='6%' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Masjid Utama</th>
                                <th width='6%' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Surau</th>
                                <th width='6%' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Masjid Daerah</th>
                                <th width='6%' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Masjid Kariah</th>
                                <th width='6%' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Surau Jumaat</th>
                                <th width='6%' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Masjid Jamek</th>
                                <th width='6%' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Masjid Pengurusan</th>
                                <th width='6%' class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Masjid</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($tables as $tableName => $table)
                                @if ($tableName == 'statistic_of_mosques')
                                    @foreach ($table['districts'] as $index => $district)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $district['name'] }}</td>
                                            @foreach ($table['categories'] as $category)
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">
                                                    {{ $district['data'][$category] ?? 0 }}
                                                </td>
                                            @endforeach
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">{{ $district['active'] }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">{{ $district['inactive'] }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">{{ $district['total'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-yellow-500 text-white font-semibold">
                                        <td class="px-4 py-2 whitespace-nowrap text-sm" colspan="2">Jumlah</td>
                                        @foreach ($table['totals'] as $total)
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-right">{{ $total }}</td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
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
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Daerah</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($objects['total_members_each_district']['data'] as $key => $value)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $key }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-right">{{ number_format($value) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gender Distribution Cards -->
                <div class="space-y-6">
                    {{-- Male Card --}}
                    <div class="bg-sky-500 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold">Ahli Kariah (Lelaki)</h4>
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="text-4xl font-bold mb-2">{{ number_format($objects['total_male']['value']) }}</div>
                        <div class="text-lg opacity-90">40% Jumlah Ahli</div>
                    </div>

                    {{-- Female Card --}}
                    <div class="bg-pink-500 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold">Ahli Kariah (Wanita)</h4>
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="text-4xl font-bold mb-2">{{ number_format($objects['total_female']['value']) }}</div>
                        <div class="text-lg opacity-90">60% Jumlah Ahli</div>
                    </div>
                </div>

                <!-- Age Distribution Chart -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h4 class="text-lg font-semibold text-gray-800">Peringkat Umur Ahli Kariah</h4>
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
                        <h4 class="text-lg font-semibold text-gray-800">Peratusan Bangsa Ahli Kariah</h4>
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
                        <h4 class="text-lg font-semibold text-gray-800">Kategori Ahli Kariah</h4>
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

        {{var_dump($users)}}

    <!-- End -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pass data from Laravel backend to JavaScript
        const chartData = @json($objects['percentage_of_mosque_type']['data']);

        // Extract labels and values from the data
        const labels = Object.keys(chartData);
        const data = Object.values(chartData);

        // Initialize the pie chart
        const ctx = document.getElementById('masjidChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#DC2626', // Red
                        '#7C3AED', // Purple
                        '#059669', // Green
                        '#D97706', // Amber
                        '#2563EB'  // Blue
                    ].slice(0, labels.length), // Adjust colors based on the number of labels
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 12,
                                family: "'Arial', sans-serif"
                            },
                            padding: 20
                        }
                    }
                }
            }
        });
        // Age Distribution Chart
        const ageData = @json($objects['members_age_category']['data']);
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(ageData),
                datasets: [{
                    label: 'Jumlah Ahli',
                    data: Object.values(ageData),
                    backgroundColor: '#60A5FA',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Nationality Pie Chart
        const nationalityData = @json($objects['members_nationality_percentage']['data']);
        const nationalityCtx = document.getElementById('nationalityChart').getContext('2d');
        
        new Chart(nationalityCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(nationalityData),
                datasets: [{
                    data: Object.values(nationalityData),
                    backgroundColor: [
                        '#3B82F6', // Blue
                        '#10B981', // Green
                        '#F59E0B', // Yellow
                        '#EF4444', // Red
                        '#8B5CF6'  // Purple
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 12,
                                family: "'Arial', sans-serif"
                            },
                            padding: 20
                        }
                    }
                }
            }
        });

        // Category Column Chart
        const categoryData = @json($objects['members_category']['data']);
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(categoryData),
                datasets: [{
                    label: 'Jumlah Ahli',
                    data: Object.values(categoryData),
                    backgroundColor: '#8B5CF6',
                    borderRadius: 6,
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    });
</script>

@endsection