<!DOCTYPE html>
<html lang="en">

<head>
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- Meta Tags untuk PWA -->
    <meta name="theme-color" content="#38e07b" /> <!-- Sesuaikan dengan theme_color di manifest -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Logistik Arga">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Manrope%3Awght%40400%3B500%3B700%3B800&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
        onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>{{ $title ?? 'Logistik' }}</title>

    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <!-- You can include global CSS or JS here -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

    </style>
    @fluxAppearance
</head>

<body>
    {{ $slot }}
    @fluxScripts

    <script>
        // Cek apakah browser mendukung Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('Service Worker terdaftar dengan scope:', registration.scope);
                    })
                    .catch((error) => {
                        console.log('Pendaftaran Service Worker gagal:', error);
                    });
            });
        }
    </script>
</body>

</html>