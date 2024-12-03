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
                                JUMLAH MASJID DALAM SELANGOR
                            </h2>
                            <p class="text-4xl font-bold">507</p>
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
                                JUMLAH AHLI KARIAH DALAM SELANGOR
                            </h2>
                            <p class="text-4xl font-bold">664,740</p>
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
                                JUMLAH STAFF MASJID DALAM SELANGOR
                            </h2>
                            <p class="text-4xl font-bold">6,872</p>
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
    </div>

    <!-- Table -->
   <!-- Table -->
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
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">1</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">PETALING</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">16</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">17</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">59</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">36</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">56</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">92</td>
                    </tr>
                    <!-- Add more rows following the same pattern -->
                    <tr class="bg-gray-50 hover:bg-gray-100">
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">2</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">GOMBAK</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">1</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">8</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">5</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">30</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">15</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">29</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-right">44</td>
                    </tr>
                    <!-- Add remaining rows... -->

                    <!-- Total Row -->
                    <tr class="bg-yellow-500 text-white font-semibold">
                        <td class="px-4 py-2 whitespace-nowrap text-sm" colspan="2">Jumlah</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">1</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">54</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">0</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">47</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">326</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">111</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">317</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right">428</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('masjidChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Masjid', 'Masjid Kariah', 'Masjid Pengurusan', 'Surau', 'Masjid Utama'],
                datasets: [{
                    data: [70, 15, 8, 5, 2],
                    backgroundColor: [
                        '#DC2626', // Red for Masjid
                        '#7C3AED', // Purple for Masjid Kariah
                        '#059669', // Green for Masjid Pengurusan
                        '#D97706', // Amber for Surau
                        '#2563EB'  // Blue for Masjid Utama
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
    });
</script>