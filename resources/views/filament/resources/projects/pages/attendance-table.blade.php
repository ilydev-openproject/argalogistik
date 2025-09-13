<x-filament-panels::page>
    <div class="print-area">
        <x-filament::section>
            <x-slot name="heading">
                ABSENSI HARIAN
            </x-slot>

            <x-slot name="description">
                <div class="space-y-1 text-sm text-gray-500">
                    <p><strong>NAMA PROYEK</strong>: {{ $project->name }}</p>
                    <p><strong>LOKASI</strong>: {{ $project->location }}</p>
                </div>
            </x-slot>

            <form wire:submit.prevent="submit" id="attendanceForm" class="no-print">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <x-filament::button wire:click.prevent="previousWeek" color="gray">
                            < </x-filament::button>
                                <span class="text-lg font-medium">
                                    {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }}
                                </span>
                                <x-filament::button wire:click.prevent="nextWeek" color="gray">
                                    >
                                </x-filament::button>
                    </div>
                    <input type="date" wire:model.live="selectedDate"
                        class="w-48 p-2 rounded-md shadow-sm dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Pilih Tanggal" />
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-3 py-3">Nama & Profesi</th>
                                @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $dayIndex => $day)
                                    <th scope="col" class="px-3 py-3 text-center w-20">
                                        {{ ucfirst($day) }} <br>
                                        ({{ $startOfWeek->clone()->addDays($dayIndex)->format('d/m') }})
                                    </th>
                                @endforeach
                                <th scope="col" class="px-3 py-3 text-center w-20">Lembur</th>
                                <th scope="col" class="px-3 py-3 text-center w-24">Total Hari</th>
                                <th scope="col" class="px-3 py-3 text-center w-32">Upah Harian</th>
                                <th scope="col" class="px-3 py-3 text-center w-32">Total Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceData as $index => $record)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $record['name'] }} ({{ $record['role'] }})
                                    </td>
                                    @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $day)
                                        <td class="px-3 py-4 w-20">
                                            <input type="number" wire:model.live="attendanceData.{{ $index }}.{{ $day }}"
                                                min="0" max="1" step="0.5"
                                                class="w-full rounded-md shadow-sm dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 text-center" />
                                        </td>
                                    @endforeach
                                    <td class="px-3 py-4 w-20">
                                        <input type="number" wire:model.live="attendanceData.{{ $index }}.lembur" min="0"
                                            class="w-full rounded-md shadow-sm dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 text-center" />
                                    </td>
                                    <td class="px-3 py-4 text-center w-24">
                                        {{ array_sum(array_slice($record, 4, 6)) }}
                                    </td>
                                    <td class="px-3 py-4 text-center w-32">
                                        {{ 'Rp ' . number_format($record['upah_harian'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-4 text-center font-bold w-32">
                                        {{ 'Rp ' . number_format($this->getTotalWages()[$index]['total_upah'] ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex flex-col items-end justify-end gap-3 no-print">
                    <div class="flex items-center gap-2">
                        <label for="allowance" class="text-sm font-medium">Tunjangan:</label>
                        <input type="number" id="allowance" wire:model.live.debounce.500ms="totalAllowance" min="0"
                            class="w-32 rounded-md shadow-sm dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 text-center" />
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="advance" class="text-sm font-medium">Kasbon:</label>
                        <input type="number" id="advance" wire:model.live.debounce.500ms="totalAdvance" min="0"
                            class="w-32 rounded-md shadow-sm dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 text-center" />
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium">Total Gaji Bersih:</span>
                        <span class="text-lg font-bold">
                            {{ 'Rp ' . number_format($this->getTotalSalary(), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
        </x-filament::section>

        <div class="fi-form-actions mt-6 flex justify-end gap-x-3 no-print">
            <x-filament::button form="attendanceForm" type="submit" color="success">
                Simpan Absensi & Gaji
            </x-filament::button>
            <x-filament::button wire:click="openPayslip" color="primary">
                Cetak
            </x-filament::button>
        </div>
        </form>
    </div>
</x-filament-panels::page>