<x-layouts.app>
    <div class="relative flex mx-auto min-h-screen flex-col bg-slate-500 justify-center items-center group/design-root overflow-x-hidden p-4"
        style='font-family: Manrope, "Noto Sans", sans-serif;'>
        <!-- Background Image -->
        <div class="absolute top-0">
            <img src="{{ asset('logistic.jpg') }}" class="w-full h-64 -z-0 object-cover shadow-4xl shadow-gray-400"
                alt="Logistics Background">
        </div>

        <!-- Login Card -->
        <div
            class="p-8 relative z-10 flex flex-col justify-center items-center w-full max-w-sm bg-gray-200/70 backdrop-blur-[2px] rounded-xl shadow-xl">
            <div class="flex items-center justify-center gap-2 mb-6">
                <img src="{{ asset('logo.png') }}" class="w-12 h-auto" alt="Logo Arga">
                <h1 class="text-4xl font-bold text-slate-900">Arga Logistik</h1>
            </div>

            <div class="flex flex-col items-center w-full">
                <div class="text-center mb-10">
                    <p class="text-slate-600 mt-2">Catat pengeluaran belanja Anda dengan mudah.</p>
                </div>

                <!-- FORM LOGIN -->
                <form method="POST" class="w-full" action="{{ route('logistic.login.post') }}">
                    @csrf

                    <!-- Email/Nama Pengguna -->
                    <label class="flex flex-col gap-2 mb-2">
                        <p class="text-slate-700 text-sm font-medium">Email atau Nama Pengguna</p>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                person
                            </span>
                            <input
                                class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 pl-10 p-3 text-base font-bold"
                                type="email" name="email" value="{{ old('email') }}" required autofocus
                                placeholder="Masukkan email Anda" />
                        </div>
                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </label>

                    <!-- Password -->
                    <label class="flex flex-col gap-2">
                        <p class="text-slate-700 text-sm font-medium">Kata Sandi</p>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                lock
                            </span>
                            <input
                                class="form-input flex w-full rounded-lg text-slate-900 border-slate-300 bg-white h-12 placeholder:text-slate-400 pl-10 p-3 text-base font-bold"
                                type="password" name="password" required placeholder="Masukkan kata sandi" />
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </label>

                    <!-- Error Message untuk login gagal (bukan validasi) -->
                    @if ($errors->has('email') || session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm">
                            {{ $errors->first('email') ?? session('error') }}
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit"
                        class="flex min-w-[84px] w-full cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-5 bg-slate-800 text-slate-50 text-base font-bold leading-normal tracking-[0.015em] mt-8">
                        <span class="truncate">Login</span>
                    </button>
                </form>

                <!-- Forgot Password Link -->
                <a class="text-sm text-slate-600 hover:text-slate-800 mt-6" href="#">Lupa kata sandi?</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-0 left-0 right-0 shadow-t-custom p-4 text-center text-slate-50 text-sm">
            © 2025 CV. ARGA JAYA KONSTRUKSI | Sistem Logistik Internal
        </div>
    </div>
</x-layouts.app>