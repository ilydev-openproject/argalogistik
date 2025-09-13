// Versi cache Anda. Naikkan versi ini saat Anda mengubah file cache.
const CACHE_NAME = "logistik-arga-v1.0.1";
// Daftar file yang ingin Anda cache (secara statis).
// Anda bisa menambahkan CSS, JS, gambar penting lainnya.
// Untuk aplikasi Laravel, caching dinamis lebih kompleks,
// jadi kita fokus pada file inti dulu.
const urlsToCache = [
    // "/",
    // "/css/app.css", // Sesuaikan dengan path CSS Anda jika menggunakan Vite/Asset Build
    // "/js/app.js", // Sesuaikan dengan path JS Anda jika menggunakan Vite/Asset Build
    // "/logo.png", // Ikon dari manifest
    // Tambahkan file statis penting lainnya jika perlu
];

// Instal Service Worker
self.addEventListener("install", (event) => {
    // Lakukan caching file-file penting
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                console.log("Membuka cache");
                return cache.addAll(urlsToCache);
            })
            .catch((error) => {
                console.error("Gagal meng-cache file awal:", error);
                // Jangan biarkan install gagal hanya karena cache awal gagal
                // Aplikasi masih bisa berjalan, hanya tidak offline untuk file ini
            })
    );
});

// Aktivasi Service Worker (bersihkan cache lama jika ada)
self.addEventListener("activate", (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Fetch event - Intersep permintaan jaringan
self.addEventListener("fetch", (event) => {
    event.respondWith(
        // Coba ambil dari cache dulu
        caches.match(event.request).then((response) => {
            // Jika ditemukan di cache, kembalikan
            if (response) {
                return response;
            }
            // Jika tidak ada di cache, ambil dari jaringan
            return fetch(event.request).then((response) => {
                // Periksa apakah kita mendapat respons yang valid
                if (
                    !response ||
                    response.status !== 200 ||
                    response.type !== "basic"
                ) {
                    return response;
                }

                var responseToCache = response.clone();

                caches.open(CACHE_NAME).then((cache) => {
                    // Hanya cache permintaan GET
                    if (event.request.method === "GET") {
                        cache.put(event.request, responseToCache);
                    }
                });

                return response;
            });
        })
    );
});
