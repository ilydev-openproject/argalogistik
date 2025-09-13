<x-app>
    <div class="flex min-h-screen flex-col items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md space-y-6 overflow-hidden rounded-xl bg-white p-8 text-center shadow-md">
            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-xl border-2 border-dashed bg-gray-200">
                <span class="material-symbols-outlined text-3xl text-gray-500">construction</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Halaman Sedang Dibangun</h1>
            <p class="text-gray-600">
                Maaf, halaman ini belum tersedia. Tim kami sedang bekerja keras untuk menghadirkan pengalaman
                terbaik untuk Anda.
            </p>
            <a href="{{ route('logistic.dashboard') }}"
                class="inline-flex items-center font-medium text-blue-600 hover:text-blue-800">
                <span class="material-symbols-outlined mr-1">arrow_back</span> Kembali
            </a>
        </div>
    </div>
</x-app>