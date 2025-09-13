<html>

<head>
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Manrope%3Awght%40400%3B500%3B700%3B800&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
        onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <meta charset="utf-8" />
    <title>Stitch Design</title>
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="max-w-sm mx-auto">
    <div class="relative flex size-full min-h-screen flex-col bg-slate-50 justify-between group/design-root overflow-x-hidden"
        style='font-family: Manrope, "Noto Sans", sans-serif;'>
        <div>
            <div class="flex items-center bg-white p-4 pb-3 shadow-sm">
                <button class="text-slate-700">
                    <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z">
                        </path>
                    </svg>
                </button>
                <h2 class="text-slate-900 text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-6">
                    Input Belanja</h2>
            </div>
            <div class="p-4 space-y-6">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex flex-col gap-2">
                            <p class="text-slate-700 text-sm font-medium">Tanggal</p>
                            <input
                                class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 p-3 text-base"
                                type="date" value="20/07/2024" />
                        </label>
                        <label class="flex flex-col gap-2">
                            <p class="text-slate-700 text-sm font-medium">Nama Toko</p>
                            <input
                                class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 p-3 text-base"
                                placeholder="Contoh: Supermarket" value="" />
                        </label>
                    </div>
                    <div>
                        <p class="text-slate-700 text-sm font-medium mb-2">Foto Nota</p>
                        <div
                            class="w-full h-48 rounded-lg bg-slate-200 flex items-center justify-center border-2 border-dashed border-slate-300 cursor-pointer">
                            <div class="text-center text-slate-500">
                                <span class="material-symbols-outlined text-4xl">add_a_photo</span>
                                <p class="mt-1 text-sm">Tambah Foto</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm">
                    <h3 class="text-slate-900 text-lg font-bold leading-tight tracking-[-0.015em] pb-3">Item Belanja
                    </h3>
                    <div class="space-y-4">
                        <input
                            class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 p-3 text-base"
                            placeholder="Nama Item" value="" />
                        <div class="grid grid-cols-2 gap-4">
                            <input
                                class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 p-3 text-base"
                                placeholder="Satuan (cth: pcs)" value="" />
                            <input
                                class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 p-3 text-base"
                                placeholder="Qty" type="number" value="" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <input
                                class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 p-3 text-base"
                                placeholder="Harga Satuan" type="number" value="" />
                            <input
                                class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 p-3 text-base"
                                placeholder="Diskon" type="number" value="" />
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">Rp</span>
                            <input
                                class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 pl-10 p-3 text-base font-bold"
                                placeholder="Total Price" type="number" value="" />
                        </div>
                        <button
                            class="flex w-full cursor-pointer items-center justify-center rounded-lg h-12 px-5 bg-slate-800 text-white text-base font-bold leading-normal tracking-[0.015em]">
                            <span class="material-symbols-outlined mr-2">add_shopping_cart</span>
                            <span class="truncate">Tambah Item</span>
                        </button>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm divide-y divide-slate-100">
                    <div class="flex items-center gap-4 px-4 py-3 justify-between">
                        <div class="flex flex-col justify-center">
                            <p class="text-slate-900 text-base font-medium leading-normal line-clamp-1">Sabun Mandi</p>
                            <p class="text-slate-500 text-sm font-normal leading-normal line-clamp-2">2 pcs x Rp 5.000
                            </p>
                        </div>
                        <div class="shrink-0">
                            <p class="text-slate-900 text-base font-bold leading-normal">Rp 10.000</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 px-4 py-3 justify-between">
                        <div class="flex flex-col justify-center">
                            <p class="text-slate-900 text-base font-medium leading-normal line-clamp-1">Beras</p>
                            <p class="text-slate-500 text-sm font-normal leading-normal line-clamp-2">1 kg x Rp 12.000
                            </p>
                        </div>
                        <div class="shrink-0">
                            <p class="text-slate-900 text-base font-bold leading-normal">Rp 12.000</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 px-4 py-3 justify-between">
                        <div class="flex flex-col justify-center">
                            <p class="text-slate-900 text-base font-medium leading-normal line-clamp-1">Pasta Gigi</p>
                            <p class="text-slate-500 text-sm font-normal leading-normal line-clamp-2">1 pcs x Rp 5.000
                            </p>
                        </div>
                        <div class="shrink-0">
                            <p class="text-slate-900 text-base font-bold leading-normal">Rp 5.000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-t-custom p-4">
            <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-5 flex-1 bg-[#38e07b] text-[#111714] text-base font-bold leading-normal tracking-[0.015em]">
                <span class="truncate">Simpan Belanja</span>
            </button>
        </div>
    </div>
    <style>
        .shadow-t-custom {
            box-shadow: 0 -4px 6px -1px rgb(0 0 0 / 0.1), 0 -2px 4px -2px rgb(0 0 0 / 0.1);
        }
    </style>

</body>

</html>