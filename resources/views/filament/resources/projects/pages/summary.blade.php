<x-filament-panels::page>
    {{-- Container Utama --}}
    <div class="space-y-6" id="printable-area">

        <div id="print-area" class="bg-gray-400 p-2 rounded-2xl" style="background-color: #E6E6E6;">
            {{-- Judul Halaman --}}
            <div class="fi-section rounded-xl text-center shadow-sm ring-1 ring-gray-950/5 p-6 mb-4 bg-transparent">
                <h2 class="text-xl font-bold text-black">Laporan Ringkasan Keuangan {{ $project->name }}</h2>
            </div>

            {{-- Detail Proyek --}}
            <div class="rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-black">Detail Proyek</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    {{-- Nama Proyek --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 ">Nama Proyek</h4>
                        <p class="mt-1 text-xl font-bold text-black dark:text-white" style="color: #121300">
                            {{ $project->name }}
                        </p>
                    </div>

                    {{-- Nama Klien --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 ">Nama Klien</h4>
                        <p class="mt-1 text-xl font-bold text-black dark:text-white" style="color: #121300">
                            {{ $project->client_name }}
                        </p>
                    </div>

                    {{-- Alamat Klien --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 ">Alamat Klien</h4>
                        <p class="mt-1 text-xl font-bold text-black dark:text-white" style="color: #121300">
                            {{ $project->client_address ?? 'Tidak Diketahui' }}
                        </p>
                    </div>

                    {{-- Lokasi Proyek --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 ">Lokasi Proyek</h4>
                        <p class="mt-1 text-xl font-bold text-black dark:text-white" style="color: #121300">
                            {{ $project->location ?? 'Tidak Diketahui' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Keuangan Utama --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                {{-- Total RAB --}}
                <div class="bg-[#0D022B] text-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-sm font-semibold flex items-center gap-2">
                        <x-heroicon-s-chart-bar class="h-5 w-5" />
                        Total RAB
                    </h3>
                    <p class="mt-2 text-3xl font-bold whitespace-nowrap">
                        Rp {{ number_format($project->total_rab, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Total Uang Masuk --}}
                <div class="bg-[#2E0D64] text-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-sm font-semibold flex items-center gap-2">
                        <x-heroicon-s-banknotes class="h-5 w-5" />
                        Total Uang Masuk
                    </h3>
                    <p class="mt-2 text-3xl font-bold whitespace-nowrap">
                        Rp {{ number_format($totalIncoming, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Total Pengeluaran --}}
                <div class="bg-[#FC2B94] text-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-sm font-semibold flex items-center gap-2">
                        <x-heroicon-s-archive-box class="h-5 w-5" />
                        Total Pengeluaran
                    </h3>
                    <p class="mt-2 text-3xl font-bold whitespace-nowrap">
                        Rp {{ number_format($totalExpenses, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Margin Keuntungan --}}
                <div class="bg-[#FB5403] text-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-sm font-semibold flex items-center gap-2">
                        <x-heroicon-s-arrow-up-right class="h-5 w-5" />
                        Margin Keuntungan
                    </h3>
                    <p class="mt-2 text-3xl font-bold whitespace-nowrap">
                        Rp {{ number_format($profitMargin, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Alokasi Anggaran --}}
            <div class="fi-section bg-transparent rounded-xl mt-6">
                <h3 class="text-lg font-semibold text-black ps-6">Alokasi Anggaran (% & Nominal)</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    {{-- Logistik --}}
                    <div class="bg-[#0D022B] text-white p-6 rounded-2xl shadow-lg">
                        <h4 class="text-sm font-semibold flex items-center gap-2">
                            <x-heroicon-s-truck class="h-5 w-5" />
                            Pengeluaran Logistik
                        </h4>
                        <p class="mt-2 text-2xl font-bold">
                            Rp {{ number_format($totalLogistics, 0, ',', '.') }}
                        </p>
                        <div class="w-full bg-[#2E0D64] rounded-full h-3 mt-3 overflow-hidden">
                            <div class="h-3 bg-gradient-to-r from-[#FC2B94] to-[#FB5403]"
                                style="width: {{ $logisticsPercentage }}%"></div>
                        </div>
                        <p class="mt-1 text-sm font-medium">
                            {{ number_format($logisticsPercentage, 2) }}%
                        </p>
                    </div>

                    {{-- Tenaga Kerja --}}
                    <div class="bg-[#FB5403] text-white p-6 rounded-2xl shadow-lg">
                        <h4 class="text-sm font-semibold flex items-center gap-2">
                            <x-heroicon-s-users class="h-5 w-5" />
                            Pembayaran Tenaga Kerja
                        </h4>
                        <p class="mt-2 text-2xl font-bold">
                            Rp {{ number_format($totalLabor, 0, ',', '.') }}
                        </p>
                        <div class="w-full bg-[#0D022B] rounded-full h-3 mt-3 overflow-hidden">
                            <div class="h-3 bg-gradient-to-r from-[#FC2B94] to-[#2E0D64]"
                                style="width: {{ $laborPercentage }}%"></div>
                        </div>
                        <p class="mt-1 text-sm font-medium">
                            {{ number_format($laborPercentage, 2) }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Print --}}
        <div class="fi-section rounded-xl shadow-sm ring-1 ring-gray-950/5 p-6 flex justify-end">
            <button onclick="exportToPDF()"
                class="bg-green-400 text-black px-8 py-4 rounded-lg hover:bg-blue-700 transition-all"> Export ke
                PDF</button>
        </div>

    </div>

    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Pastikan semua elemen tetap terbaca dengan jelas */
            .fi-section {
                color: black !important;
                background-color: white !important;
            }

            /* Hilangkan background warna pekat di print */
            .bg-[#0D022B],
            .bg-[#2E0D64],
            .bg-[#FC2B94],
            .bg-[#FB5403] {
                background-color: transparent !important;
            }

            /* Hilangkan shadow pada elemen */
            .shadow-lg,
            .shadow-sm {
                box-shadow: none !important;
            }

            /* Mengubah warna teks menjadi hitam dan background putih */
            .text-white {
                color: black !important;
            }

            .text-black {
                color: black !important;
            }

            /* Pastikan elemen tetap sesuai dalam ukuran A4 */
            @page {
                size: A4 portrait;
                margin: 5mm;
            }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script>
        function exportToPDF() {
            const element = document.getElementById('print-area');

            // Mendapatkan tanggal saat ini
            const today = new Date();
            const formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

            // Nama proyek
            const projectName = "{{ $project->name }}";

            // Mengubah nama file dengan menambahkan tanggal dan nama proyek
            const fileName = `${formattedDate}_${projectName.replace(/\s+/g, '_')}_laporan_keuangan.pdf`;

            const opt = {
                margin: 0.5,
                filename: fileName,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: null
                },
                jsPDF: {
                    unit: 'cm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf().set(opt).from(element).save();
        }
    </script>

</x-filament-panels::page>