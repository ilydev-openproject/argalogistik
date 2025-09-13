<x-filament-panels::page>
    <div class="fi-section-header flex h-12 flex-row items-center justify-between gap-3 overflow-hidden px-6 no-print">
        <div class="flex items-center gap-3">
            <x-filament::button onclick="printDiv('print-area')" color="primary">
                Cetak Slip Gaji
            </x-filament::button>
        </div>
    </div>

    <div id="print-area" class="">
        <div class="p-8 bg-white rounded-2xl shadow-lg border border-gray-300">
            <!-- Kop / Header Logo -->
            <div class="flex items-center justify-between mb-6 border-b-2 border-gray-700 pb-3">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('logo.png') }}" alt="Logo Perusahaan" class="h-26 w-auto">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">CV. ARGA JAYA KONSTRUKSI</h2>
                        <p class="text-red-500 font-semibold">Design & Build</p>
                        <p class="text-sm text-gray-600">office , Ruko Royal Square Blok B1 .selatan IAIN Ngembal rejo
                            Kudus</p>
                        <a href="mailto:argaarchitect@gmail.com"
                            class="text-sm text-blue-600">argaarchitect@gmail.com</a>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="flex items-center justify-between mb-6  pb-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Slip Gajian Mingguan</h1>
                    <p class="text-sm text-gray-600">Periode:
                        <span class="font-medium">
                            {{ $startOfWeek->format('d M Y') }} - {{ $endOfWeek->format('d M Y') }}
                        </span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Proyek:</p>
                    <p class="font-semibold text-lg text-gray-800">{{ $project->name }}</p>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border border-gray-300 shadow-sm">
                    <thead class="text-xs text-gray-700 uppercase"
                        style="background-color:#38b2ac !important; color:white; -webkit-print-color-adjust:exact; print-color-adjust:exact;">
                        <tr>
                            <th scope="col" class="px-4 py-3 border border-gray-700 whitespace-nowrap">Nama & Profesi
                            </th>
                            @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $dayIndex => $day)
                                <th scope="col" class="px-3 py-3 text-center w-20 border border-gray-700 ">
                                    {{ ucfirst($day) }}<br>
                                    ({{ $startOfWeek->clone()->addDays($dayIndex)->format('d/m') }})
                                </th>
                            @endforeach
                            <th scope="col" class="px-3 py-3 text-center border border-gray-700">Lembur</th>
                            <th scope="col" class="px-3 py-3 text-center border border-gray-700 whitespace-nowrap">Total
                                Hari</th>
                            <th scope="col" class="px-3 py-3 text-center border border-gray-700 whitespace-nowrap">Upah
                                Harian</th>
                            <th scope="col" class="px-3 py-3 text-center border border-gray-700">Total Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceData as $index => $record)
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="px-4 py-3 font-medium text-gray-800 border border-gray-700 whitespace-nowrap">
                                    {{ $record['name'] }} <span class="text-sm text-gray-500">({{ $record['role'] }})</span>
                                </td>
                                @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $day)
                                    <td class="px-3 py-3 text-center border border-gray-700 text-gray-700">
                                        {{ $record[$day] ?? 'x' }}
                                    </td>
                                @endforeach
                                <td class="px-3 py-3 text-center border border-gray-700 text-gray-700">
                                    {{ $record['lembur'] ?? 0 }}
                                </td>
                                <td class="px-3 py-3 text-center border border-gray-700 text-gray-700">
                                    {{ array_sum(array_slice($record, 4, 6)) }}
                                </td>
                                <td class="px-3 py-3 text-center border border-gray-700 text-gray-700 whitespace-nowrap">
                                    {{ 'Rp ' . number_format($record['upah_harian'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td
                                    class="px-3 py-3 text-center font-bold text-green-700 border border-gray-700  whitespace-nowrap">
                                    {{ 'Rp ' . number_format($totalWages[$index]['total_upah'] ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Ringkasan -->
            <div class="mt-8 border-t-2 border-gray-700 pt-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Ringkasan Gajian</h2>
                <div class="flex flex-col items-end gap-2 text-sm text-gray-700">
                    <div class="flex justify-between w-full md:w-1/3">
                        <span class="font-medium">Total Upah Mingguan:</span>
                        <span
                            class="font-bold">{{ 'Rp ' . number_format(collect($totalWages)->sum('total_upah') ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between w-full md:w-1/3">
                        <span class="font-medium">Total Tunjangan:</span>
                        <span
                            class="font-bold">{{ 'Rp ' . number_format($weeklyPayment->total_allowance ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between w-full md:w-1/3">
                        <span class="font-medium">Total Kasbon:</span>
                        <span
                            class="font-bold text-red-500">{{ 'Rp ' . number_format($weeklyPayment->total_advance ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between w-full md:w-1/3 border-t-2 pt-2 mt-2">
                        <span class="font-medium text-lg">Total Gaji Bersih:</span>
                        <span
                            class="font-bold text-2xl text-green-600">{{ 'Rp ' . number_format(($weeklyPayment->paid_amount) ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @media print {
            #print-area * {
                border-color: #374151 !important;
                background: #ffffff !important;
                color: #000000 !important;
            }

            #print-area th,
            #print-area td {
                border: 1px solid #374151 !important;
            }
        }
    </style>
    <script>
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload();
        }
    </script>
</x-filament-panels::page>