<Layout>
    <div class="relative min-h-screen bg-slate-200 font-sans py-4"
        style='font-family: Manrope, "Noto Sans", sans-serif;'>

        <!-- Background Image (Opsional) -->
        <!-- <div class="absolute inset-0 z-10">
            <img src="{{ asset('logistic.jpg') }}" class="w-full h-full object-cover opacity-20"
                alt="Background Logistik">
        </div> -->

        <div class="relative z-20">
            <!-- Enhanced Header -->
            <div class="max-w-6xl mx-auto mb-8 sm:mb-8 p-4"> {{-- Reduced bottom margin --}}
                <div class="flex items-center justify-between"> {{-- Flex container for icon and text --}}
                    <div class="flex items-center justify-between w-full"> {{-- Flex for icon and title --}}
                        {{-- Cooler Icon using Material Symbols --}}
                        <h1 class="text-2xl xs:text-3xl sm:text-4xl font-bold text-slate-900 truncate"> {{-- Truncate
                            long
                            titles --}}
                            Dashboard Logistik
                        </h1>
                        <span
                            class="material-symbols-outlined text-3xl sm:text-4xl text-amber-600 bg-slate-400/20 p-4 rounded-full">inventory_2</span>
                    </div>
                    {{-- You can add a user avatar/info button here on the right if needed in the future --}}
                    {{-- <div>...</div> --}}
                </div>
                <p class="text-slate-500 text-base sm:text-lg leading-relaxed"> {{-- Slightly smaller base text --}}
                    Selamat datang, {{ auth()->user()->name }}!
                </p>
            </div>

            <!-- Summary Cards -->
            <div class="max-w-6xl mx-auto overflow-x-hidden">
                <div class="flex relative ps-4 pe-4 overflow-x-scroll sm:flex-row gap-4 sm:gap-6"
                    style="scrollbar-width: none; scroll-behavior: smooth;">
                    <!-- Total Pengeluaran -->
                    <div
                        class="flex flex-col justify-end items-start min-w-[275px] min-h-[178px] relative bg-gradient-to-br from-rose-500 to-red-500 rounded-2xl p-6 border border-white/20 shadow-lg text-center">

                        <div class="flex justify-center mb-3">
                            <div class="p-3 bg-white/20 rounded-full absolute top-4 right-4">
                                <span class="material-symbols-outlined text-4xl text-white">payments</span>
                            </div>
                        </div>
                        <h2 class="text-3xl font-bold text-white">
                            Rp {{ number_format($totalSpent, 0, ',', '.') }}
                        </h2>
                        <p class="text-slate-100 text-sm mt-1">Total Pengeluaran</p>
                    </div>

                    <!-- Total Transaksi -->
                    <div
                        class="flex flex-col justify-end items-start min-w-[275px] min-h-[178px] relative bg-gradient-to-br from-pink-500 to-fuchsia-500 rounded-2xl p-6 border border-white/20 shadow-lg text-center">
                        <div class="flex justify-center mb-3">
                            <div class="p-3 bg-white/20 rounded-full absolute top-4 right-4">
                                <span class="material-symbols-outlined text-8xl text-white">receipt_long</span>
                            </div>
                        </div>
                        <h2 class="text-6xl font-bold text-white">{{ $totalTransactions }}</h2>
                        <span class="text-slate-100 text-sm mt-1">Total Transaksi</span>
                    </div>


                    <!-- Belanja Bulan Ini -->
                    <div
                        class="flex flex-col justify-end items-start min-w-[275px] min-h-[178px] relative bg-gradient-to-br from-orange-400 to-pink-500 rounded-2xl p-6 border border-white/20 shadow-lg text-center">

                        <div class="flex justify-center mb-3">
                            <div class="p-3 bg-white/20 rounded-full absolute top-4 right-4">
                                <span class="material-symbols-outlined text-4xl text-white">event</span>
                            </div>
                        </div>
                        <h2 class="text-6xl font-bold text-white">{{ $monthlyTransactions }}</h2>
                        <p class="text-slate-100 text-sm mt-1">Belanja Bulan Ini</p>
                    </div>

                </div>
            </div>
            <!-- End Enhanced Header & Summary Cards -->

            <!-- Main Menu Cards -->
            <div class="max-w-6xl mx-auto p-2">
                <h2 class="text-xl font-bold text-slate-700 my-4 ms-4">Menu Utama</h2>
                <div class="grid grid-cols-4 gap-4 p-4">
                    <!-- Dashboard -->
                    <a href="{{ route('logistic.purchase') }}" class="flex flex-col items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-emerald-500 p-4 bg-emerald-300/20 rounded-full"
                            style="font-size: 28px;">
                            shopping_cart
                        </span>
                        <span class="text-sm text-slate-700 whitespace-nowrap">Belanja</span>
                    </a>
                    <a href="{{ route('coming.soon') }}" class="flex flex-col items-center justify-center gap-2">
                        <!-- History -->
                        <span class="material-symbols-outlined text-amber-500 p-4 bg-amber-300/20 rounded-full"
                            style="font-size: 28px;">
                            history
                        </span>
                        <span class="text-sm text-slate-700 whitespace-nowrap">History</span>
                    </a>

                    <a href="{{ route('coming.soon') }}" class="flex flex-col items-center justify-center gap-2">
                        <!-- Statistik -->
                        <span class="material-symbols-outlined text-pink-500 p-4 bg-pink-300/20 rounded-full"
                            style="font-size: 28px;">
                            finance_mode
                        </span>
                        <span class="text-sm text-slate-700 whitespace-nowrap">Statistik</span>
                    </a>

                    <a href="{{ route('coming.soon') }}" class="flex flex-col items-center justify-center gap-2">
                        <!-- Admin -->
                        <span class="material-symbols-outlined text-blue-500 p-4 bg-blue-300/20 rounded-full"
                            style="font-size: 28px;">
                            passkey
                        </span>
                        <span class="text-sm text-slate-700 whitespace-nowrap">Admin</span>
                    </a>

                    <a href="{{ route('coming.soon') }}" class="flex flex-col items-center justify-center gap-2">
                        <!-- Setting -->
                        <span class="material-symbols-outlined text-fuchsia-500 p-4 bg-fuchsia-300/20 rounded-full"
                            style="font-size: 28px;">
                            settings
                        </span>
                        <span class="text-sm text-slate-700 whitespace-nowrap">Setting</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}"
                        class="flex flex-col items-center justify-center">
                        @csrf
                        <button type="submit"
                            class="flex flex-col items-center justify-center gap-2 bg-transparent border-none cursor-pointer">
                            <span class="material-symbols-outlined text-indigo-500 p-4 bg-indigo-300/20 rounded-full"
                                style="font-size: 28px;">
                                logout
                            </span>
                            <span class="text-sm text-slate-700 whitespace-nowrap">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            <!-- End Main Menu Cards -->
            <!-- Riwayat Belanja Terakhir -->
            <div class="max-w-6xl mx-auto p-2 mt-8"> <!-- Tambahkan margin top untuk spasi -->
                <h2 class="text-xl font-bold text-slate-700 my-4 ms-4">Riwayat Belanja Terakhir</h2>

                @if ($recentTransactions->isEmpty())
                    <div class="bg-white rounded-xl shadow p-6 text-center text-slate-500">
                        <p>Belum ada riwayat belanja.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4 p-4">
                        @foreach ($recentTransactions as $transaction)
                            <div
                                class="flex flex-col items-start justify-center gap-2 bg-white rounded-xl border-l-8 shadow border-l-violet-600 p-4 transition-transform duration-200 hover:scale-[1.01]">
                                {{-- Nama Proyek --}}
                                <p class="text-sm font-medium text-slate-700">
                                    {{ $transaction->project->name ?? 'Proyek Tidak Diketahui' }}
                                </p>

                                {{-- Nama Toko dan Total Harga --}}
                                <span class="text-md font-semibold text-slate-500">
                                    {{ $transaction->store_name }} - {{ $transaction->total_formatted }}
                                </span>

                                {{-- Tanggal dan Ikon --}}
                                <div class="flex items-center gap-2 text-indigo-500">
                                    <span class="material-symbols-outlined text-base">schedule</span>
                                    <span class="text-sm">
                                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('H:i, l j F Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <x-footer></x-footer>
    </div>
</Layout>