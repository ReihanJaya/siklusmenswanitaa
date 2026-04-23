<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Siklus - Teman Kesehatan Wanitamu</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#ec4899', // Pink 500
                        secondary: '#a855f7', // Purple 500
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased bg-pink-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col items-center justify-center p-4">
    
    <div class="max-w-md w-full text-center space-y-8">
        <!-- Logo / Icon -->
        <div class="w-32 h-32 bg-gradient-to-tr from-pink-400 to-purple-500 rounded-full mx-auto flex items-center justify-center shadow-lg shadow-pink-200 dark:shadow-none">
            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
        </div>

        <div>
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-600">Siklus</h1>
            <p class="mt-3 text-lg text-gray-500 dark:text-gray-400">Pahami tubuhmu, catat pola haidmu, dan dapatkan prediksi cerdas untuk masa subur.</p>
        </div>

        <div class="pt-8 space-y-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block w-full bg-primary hover:bg-pink-600 text-white font-bold py-3 px-4 rounded-full shadow-md transition transform hover:scale-105">
                        Lanjut ke Beranda
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full bg-primary hover:bg-pink-600 text-white font-bold py-3 px-4 rounded-full shadow-md transition transform hover:scale-105">
                        Masuk
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full bg-white dark:bg-gray-800 text-primary dark:text-pink-400 font-bold py-3 px-4 rounded-full shadow-md border border-pink-200 dark:border-gray-700 transition transform hover:scale-105">
                            Daftar Akun Baru
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</body>
</html>
