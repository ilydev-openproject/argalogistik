<layout>
    <form wire:submit.prevent="savePurchase"
        class="group/design-root relative flex size-full min-h-screen flex-col justify-between overflow-x-hidden bg-slate-50 pt-6"
        style='font-family: Manrope, "Noto Sans", sans-serif;'>
        <div>
            <div class="flex items-center p-4 pb-4">
                {{-- Tombol Kembali --}}
                <a href="{{ route('logistic.dashboard') }}" class="text-slate-700">
                    <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z">
                        </path>
                    </svg>
                </a>
                <h2 class="flex-1 pr-6 text-center text-lg font-bold leading-tight tracking-[-0.015em] text-slate-900">
                    Input Belanja</h2>
            </div>
            <div class="space-y-6 p-4">
                <div class="space-y-4">
                    <!-- Dropdown Project -->
                    <div class="grid grid-cols-1 gap-4">
                        <label class="flex flex-col gap-2">
                            <div x-data="{ open: false, selectedLabel: 'Pilih Project' }" class="relative">
                                <!-- Tombol/Trigger untuk membuka dropdown -->
                                <div @click="open = !open"
                                    class="form-select flex h-12 w-full cursor-pointer items-center justify-between rounded-lg border border-slate-300 bg-white px-3 py-2 text-base text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span x-text="selectedLabel"></span>
                                    <svg class="ml-2 h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <!-- Daftar Opsi (Listbox) -->
                                <div x-show="open" @click.away="open = false"
                                    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-gray-300 py-1 text-base shadow-lg ring-1 border border-slate-200 focus:outline-none sm:text-sm">
                                    <ul>
                                        <li @click="selectedLabel = 'Pilih Project'; open = false; $wire.set('selectedProjectId', '')"
                                            class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-slate-900 hover:bg-blue-100">
                                            <span class="block truncate">Pilih Project</span>
                                        </li>
                                        @foreach ($projects as $project)
                                            <li wire:key="project-{{ $project->id }}"
                                                @click="selectedLabel = '{{ $project->name }} - {{ $project->location }}'; open = false; $wire.set('selectedProjectId', '{{ $project->id }}')"
                                                class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-slate-900 hover:bg-blue-100">
                                                <span class="block truncate">{{ $project->name }} -
                                                    {{ $project->location }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Input hidden untuk Livewire -->
                                <input type="hidden" wire:model.live="selectedProjectId">
                            </div>
                            @error('selectedProjectId')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex flex-col gap-2">
                            <p class="text-sm font-medium text-slate-700">Tanggal *</p>
                            <input wire:model="transactionDate"
                                class="form-input flex h-12 w-full rounded-lg border-slate-300 border bg-white p-3 text-base text-slate-900 placeholder:text-slate-400"
                                type="date" required />
                            @error('transactionDate')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </label>
                        <label class="flex flex-col gap-2">
                            <p class="text-sm font-medium text-slate-700">Nama Toko *</p>
                            <input wire:model="storeName"
                                class="form-input flex h-12 w-full rounded-lg border-slate-300 border bg-white p-3 text-base text-slate-900 placeholder:text-slate-400"
                                placeholder="Contoh: Supermarket" required />
                            @error('storeName')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <!-- Foto Nota -->
                    <div>
                        <p class="mb-2 text-sm font-medium text-slate-700">Foto Nota</p>
                        <div
                            class="relative flex h-48 w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg border-2 border-dashed border-slate-300  bg-slate-200">
                            <input type="file" wire:model="receiptPhoto" accept="image/*"
                                class="absolute inset-0 h-full w-full cursor-pointer opacity-0">
                            @if ($receiptPhoto)
                                <!-- Preview jika file dipilih -->
                                <div class="flex flex-col items-center">
                                    @if ($receiptPhoto->isPreviewable())
                                        <img src="{{ $receiptPhoto->temporaryUrl() }}"
                                            class="max-h-full max-w-full object-contain">
                                    @else
                                        <span class="material-symbols-outlined text-4xl text-slate-500">description</span>
                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $receiptPhoto->getClientOriginalName() }}
                                        </p>
                                    @endif
                                    <button type="button" wire:click="$set('receiptPhoto', null)"
                                        class="mt-2 text-xs text-red-500 hover:text-red-700">
                                        Hapus
                                    </button>
                                </div>
                            @else
                                <!-- Placeholder jika belum ada file -->
                                <div class="text-center text-slate-500">
                                    <span class="material-symbols-outlined text-4xl">add_a_photo</span>
                                    <p class="mt-1 text-sm">Klik untuk Tambah Foto</p>
                                </div>
                            @endif
                        </div>
                        @error('receiptPhoto')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Form Tambah Item -->
                <div class="rounded-xl bg-white p-4 shadow-sm">
                    <h3 class="pb-3 text-lg font-bold leading-tight tracking-[-0.015em] text-slate-900">Item Belanja
                    </h3>
                    <div class="space-y-4">
                        <label class="flex flex-col gap-2">
                            <p class="text-sm font-medium text-slate-700">Nama Item *</p>
                            <input wire:model="newItem.item_description"
                                class="form-input flex h-12 w-full rounded-lg border-slate-300 border bg-white p-3 text-base text-slate-900 placeholder:text-slate-400"
                                placeholder="Contoh: Semen Gresik 50kg" />
                            @error('newItem.item_description')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex flex-col gap-2">
                                <p class="text-sm font-medium text-slate-700">Satuan *</p>
                                <input wire:model="newItem.unit"
                                    class="form-input flex h-12 w-full rounded-lg border-slate-300 border bg-white p-3 text-base text-slate-900 placeholder:text-slate-400"
                                    placeholder="cth: pcs, sak" />
                                @error('newItem.unit')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="flex flex-col gap-2">
                                <p class="text-sm font-medium text-slate-700">Qty *</p>
                                <input wire:model.live="newItem.quantity"
                                    class="form-input flex h-12 w-full rounded-lg border-slate-300 border bg-white p-3 text-base text-slate-900 placeholder:text-slate-400"
                                    placeholder="0.00" type="number" min="0" step="0.01" />
                                @error('newItem.quantity')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex flex-col gap-2">
                                <p class="text-sm font-medium text-slate-700">Harga Satuan</p>
                                <input wire:model.live="newItem.unit_price"
                                    class="form-input flex h-12 w-full rounded-lg border-slate-300 border bg-white p-3 text-base text-slate-900 placeholder:text-slate-400"
                                    placeholder="Harga Satuan" type="number" min="0" step="0.01" />
                                @error('newItem.unit_price')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="flex flex-col gap-2">
                                <p class="text-sm font-medium text-slate-700">Diskon</p>
                                <input wire:model.live="newItem.discount_amount"
                                    class="form-input flex h-12 w-full rounded-lg border-slate-300 border bg-white p-3 text-base text-slate-900 placeholder:text-slate-400"
                                    placeholder="Diskon" type="number" min="0" value="0" step="0.01" />
                                @error('newItem.discount_amount')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>

                        <!-- Total Price - Read Only -->
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">Rp</span>
                            <input
                                value="Rp {{ number_format(($newItem['quantity'] ?? 0) * ($newItem['unit_price'] ?? 0) - ($newItem['discount_amount'] ?? 0), 0, ',', '.') }}"
                                readonly
                                class="form-input flex h-12 w-full rounded-lg border-slate-300 border bg-gray-100 p-3 pl-10 text-base font-bold text-slate-900 placeholder:text-slate-400" />
                        </div>

                        <button wire:click="addItem" type="button"
                            class="flex h-12 w-full cursor-pointer items-center justify-center rounded-lg bg-slate-800 px-5 text-base font-bold leading-normal tracking-[0.015em] text-white">
                            <span class="material-symbols-outlined me-2">
                                local_mall
                            </span>
                            <span class="truncate">Tambah Item</span>
                        </button>
                    </div>
                </div>

                <!-- Daftar Item -->
                @if (count($items) > 0)
                    <div class="divide-y divide-slate-100 rounded-xl bg-white shadow-sm">
                        @foreach ($items as $index => $item)
                            <div class="flex items-center justify-between gap-4 px-4 py-3" wire:key="item-{{ $item['id'] }}">
                                <div class="flex flex-col justify-center">
                                    <p class="line-clamp-1 text-base font-medium leading-normal text-slate-900">
                                        {{ $item['item_description'] }}
                                    </p>
                                    <p class="line-clamp-2 text-sm font-normal leading-normal text-slate-500">
                                        {{ number_format($item['quantity'], 2, ',', '.') }} {{ $item['unit'] }} x Rp
                                        {{ number_format($item['unit_price'], 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="flex shrink-0 items-center gap-2">
                                    <p class="text-base font-bold leading-normal text-slate-900">Rp
                                        {{ number_format($item['total_price'], 0, ',', '.') }}
                                    </p>
                                    <button type="button" wire:click="removeItem('{{ $item['id'] }}')"
                                        class="text-red-500 hover:text-red-700">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if ($errors->has('items') || session('error'))
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    @if ($errors->has('items'))
                                        {{ $errors->first('items') }}
                                    @elseif (session('error'))
                                        {{ session('error') }}
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="shadow-t-custom sticky bottom-0 bg-white p-4">
            <button type="submit"
                class="flex h-14 min-w-[84px] max-w-[480px] flex-1 cursor-pointer items-center justify-center overflow-hidden rounded-xl bg-amber-300 px-5 text-base font-bold leading-normal tracking-[0.015em] text-[#111714]">
                <span class="truncate">Simpan Belanja</span>
            </button>
        </div>

        <!-- Flash Message -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show"
                class="fixed bottom-4 right-4 z-50 rounded-md bg-green-500 px-4 py-2 text-white shadow-lg">
                <div class="flex items-center">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="ml-2 text-white hover:text-gray-200">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
            </div>
        @endif
    </form>

    <style>
        .shadow-t-custom {
            box-shadow: 0 -4px 6px -1px rgb(0 0 0 / 0.1), 0 -2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .form-input,
        .form-select {
            @apply focus:ring-2 focus:ring-blue-500 focus:border-transparent;
        }
    </style>
</layout>