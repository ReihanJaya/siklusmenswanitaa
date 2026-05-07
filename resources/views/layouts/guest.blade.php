<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Siklus') }} — Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Tailwind & Alpine via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            primary: '#ec4899',
                            secondary: '#a855f7',
                            pink: {
                                50: '#fdf2f8', 100: '#fce7f3', 200: '#fbcfe8', 300: '#f9a8d4',
                                400: '#f472b6', 500: '#ec4899', 600: '#db2777', 700: '#be185d',
                                800: '#9d174d', 900: '#831843',
                            },
                            purple: {
                                50: '#faf5ff', 100: '#f3e8ff', 200: '#e9d5ff', 300: '#d8b4fe',
                                400: '#c084fc', 500: '#a855f7', 600: '#9333ea', 700: '#7e22ce',
                                800: '#6b21a8', 900: '#581c87',
                            }
                        }
                    }
                }
            }
        </script>

        <style>
            /* Animated gradient orbs */
            .orb {
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                opacity: 0.5;
                animation: float 8s ease-in-out infinite;
            }
            .orb-1 {
                width: 350px; height: 350px;
                background: linear-gradient(135deg, #ec4899, #a855f7);
                top: -80px; left: -80px;
                animation-delay: 0s;
            }
            .orb-2 {
                width: 300px; height: 300px;
                background: linear-gradient(135deg, #a855f7, #6366f1);
                bottom: -60px; right: -60px;
                animation-delay: -3s;
            }
            .orb-3 {
                width: 200px; height: 200px;
                background: linear-gradient(135deg, #f472b6, #f9a8d4);
                top: 50%; right: 10%;
                animation-delay: -5s;
            }

            @keyframes float {
                0%, 100% { transform: translate(0, 0) scale(1); }
                25% { transform: translate(30px, -30px) scale(1.05); }
                50% { transform: translate(-20px, 20px) scale(0.95); }
                75% { transform: translate(15px, 10px) scale(1.02); }
            }

            /* Glassmorphism card */
            .glass-card {
                background: rgba(255, 255, 255, 0.75);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.4);
            }

            /* Form entrance animation */
            .slide-up {
                animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
            }
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Input focus glow */
            .input-glow:focus {
                box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.15), 0 0 20px rgba(236, 72, 153, 0.08);
            }

            /* Gradient button shimmer */
            .btn-shimmer {
                position: relative;
                overflow: hidden;
            }
            .btn-shimmer::after {
                content: '';
                position: absolute;
                top: 0; left: -100%;
                width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.5s;
            }
            .btn-shimmer:hover::after {
                left: 100%;
            }

            /* Particles background */
            .particle {
                position: absolute;
                width: 4px; height: 4px;
                background: rgba(236, 72, 153, 0.3);
                border-radius: 50%;
                animation: rise 6s linear infinite;
            }
            @keyframes rise {
                0% { opacity: 0; transform: translateY(100vh) scale(0); }
                50% { opacity: 1; }
                100% { opacity: 0; transform: translateY(-20vh) scale(1); }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden bg-gradient-to-br from-pink-50 via-white to-purple-50">

            <!-- Animated Orbs -->
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>

            <!-- Floating particles -->
            @for ($i = 0; $i < 12; $i++)
                <div class="particle" style="left: {{ rand(5, 95) }}%; animation-delay: {{ $i * 0.5 }}s; animation-duration: {{ rand(5, 9) }}s;"></div>
            @endfor

            <!-- Branding -->
            <div class="relative z-10 mb-6 text-center slide-up" style="animation-delay: 0.1s;">
                <a href="/" class="inline-flex flex-col items-center group">
                    <div class="w-16 h-16 bg-gradient-to-tr from-pink-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-pink-200/50 group-hover:shadow-pink-300/60 transition-all duration-300 group-hover:scale-105 group-hover:rotate-3">
                        <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h1 class="mt-3 text-2xl font-black bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">Siklus</h1>
                </a>
            </div>

            <!-- Glass Card -->
            <div class="relative z-10 w-full max-w-md mx-4 slide-up" style="animation-delay: 0.2s;">
                <div class="glass-card rounded-3xl shadow-xl shadow-pink-100/30 px-8 py-8 sm:px-10 sm:py-10">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <p class="relative z-10 mt-8 text-xs text-gray-400 slide-up" style="animation-delay: 0.4s;">
                © {{ date('Y') }} Siklus — Teman Kesehatan Wanitamu 💕
            </p>
        </div>
    </body>
</html>
