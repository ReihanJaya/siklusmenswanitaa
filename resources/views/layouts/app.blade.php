<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Siklus — Tracker Haid</title>
        <meta name="description" content="Aplikasi pelacak siklus haid profesional untuk memantau kesehatan reproduksi wanita">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

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
            /* Page Load Animation */
            .page-transition {
                animation: fadeIn 0.4s ease-out forwards;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-slide-up {
                animation: slideUp 0.5s ease-out forwards;
            }
            
            /* Ripple Effect */
            .ripple {
                position: relative;
                overflow: hidden;
                transform: translate3d(0, 0, 0);
            }
            .ripple:after {
                content: "";
                display: block;
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                pointer-events: none;
                background-image: radial-gradient(circle, #000 10%, transparent 10.01%);
                background-repeat: no-repeat;
                background-position: 50%;
                transform: scale(10, 10);
                opacity: 0;
                transition: transform .5s, opacity 1s;
            }
            .ripple:active:after {
                transform: scale(0, 0);
                opacity: .2;
                transition: 0s;
            }

            /* Toast Animation */
            @keyframes toastIn {
                from { opacity: 0; transform: translateY(-20px) scale(0.95); }
                to { opacity: 1; transform: translateY(0) scale(1); }
            }
            @keyframes toastOut {
                from { opacity: 1; transform: translateY(0) scale(1); }
                to { opacity: 0; transform: translateY(-20px) scale(0.95); }
            }
            .toast-enter { animation: toastIn 0.3s ease-out forwards; }
            .toast-leave { animation: toastOut 0.3s ease-in forwards; }

            /* Scrollbar */
            .scrollbar-hide::-webkit-scrollbar { display: none; }
            .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

            /* Smooth transitions */
            * { -webkit-tap-highlight-color: transparent; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-800 dark:text-gray-200">
        <!-- Toast Container -->
        <div id="toastContainer" class="fixed top-4 left-1/2 -translate-x-1/2 z-[100] flex flex-col items-center gap-2 pointer-events-none w-full max-w-sm px-4"></div>

        <div class="min-h-screen bg-gradient-to-b from-pink-50 via-white to-pink-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 pb-24">
            <!-- App Header -->
            <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg shadow-sm sticky top-0 z-30 border-b border-pink-100/50 dark:border-gray-700">
                <div class="flex justify-between items-center max-w-7xl mx-auto px-4 py-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-gradient-to-tr from-pink-500 to-purple-500 rounded-xl flex items-center justify-center shadow-md shadow-pink-200 dark:shadow-none">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" /></svg>
                        </div>
                        <div>
                            <div class="text-lg font-extrabold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">Siklus</div>
                            <div class="text-[9px] text-gray-400 font-medium -mt-1 tracking-wider uppercase">Period Tracker</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-gray-400 hover:text-primary transition bg-gray-50 dark:bg-gray-700 px-3 py-1.5 rounded-lg font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 max-w-md mx-auto page-transition">
                {{ $slot }}
            </main>

            <!-- Bottom Navigation (5 tabs) -->
            <nav class="fixed bottom-0 w-full bg-white/95 dark:bg-gray-800/95 backdrop-blur-lg border-t border-pink-100/50 dark:border-gray-700 z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
                <div class="flex justify-around items-center h-16 max-w-md mx-auto relative" style="padding-bottom: env(safe-area-inset-bottom)">
                    <a href="{{ route('dashboard') }}" class="ripple flex-1 flex flex-col items-center justify-center h-full transition-all {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
                        <div class="{{ request()->routeIs('dashboard') ? 'bg-pink-50 dark:bg-pink-900/30 p-1.5 rounded-xl' : 'p-1.5' }} transition-all">
                            <svg class="w-5 h-5" fill="{{ request()->routeIs('dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                        </div>
                        <span class="text-[9px] font-semibold mt-0.5">Beranda</span>
                    </a>
                    <a href="{{ route('calendar') }}" class="ripple flex-1 flex flex-col items-center justify-center h-full transition-all {{ request()->routeIs('calendar') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
                        <div class="{{ request()->routeIs('calendar') ? 'bg-pink-50 dark:bg-pink-900/30 p-1.5 rounded-xl' : 'p-1.5' }} transition-all">
                            <svg class="w-5 h-5" fill="{{ request()->routeIs('calendar') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                        </div>
                        <span class="text-[9px] font-semibold mt-0.5">Kalender</span>
                    </a>
                    <a href="{{ route('symptoms') }}" class="ripple flex-1 flex flex-col items-center justify-center h-full transition-all {{ request()->routeIs('symptoms') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
                        <div class="{{ request()->routeIs('symptoms') ? 'bg-pink-50 dark:bg-pink-900/30 p-1.5 rounded-xl' : 'p-1.5' }} transition-all">
                            <svg class="w-5 h-5" fill="{{ request()->routeIs('symptoms') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" /></svg>
                        </div>
                        <span class="text-[9px] font-semibold mt-0.5">Gejala</span>
                    </a>
                    <a href="{{ route('education') }}" class="ripple flex-1 flex flex-col items-center justify-center h-full transition-all {{ request()->routeIs('education') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
                        <div class="{{ request()->routeIs('education') ? 'bg-pink-50 dark:bg-pink-900/30 p-1.5 rounded-xl' : 'p-1.5' }} transition-all">
                            <svg class="w-5 h-5" fill="{{ request()->routeIs('education') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                        </div>
                        <span class="text-[9px] font-semibold mt-0.5">Edukasi</span>
                    </a>
                    <a href="{{ route('chatbot') }}" class="ripple flex-1 flex flex-col items-center justify-center h-full transition-all {{ request()->routeIs('chatbot') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
                        <div class="{{ request()->routeIs('chatbot') ? 'bg-pink-50 dark:bg-pink-900/30 p-1.5 rounded-xl' : 'p-1.5' }} transition-all">
                            <svg class="w-5 h-5" fill="{{ request()->routeIs('chatbot') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" /></svg>
                        </div>
                        <span class="text-[9px] font-semibold mt-0.5">Ameng</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Global Toast Function -->
        <script>
            function showToast(message, type = 'success') {
                const container = document.getElementById('toastContainer');
                const colors = {
                    success: 'bg-emerald-500',
                    error: 'bg-red-500',
                    info: 'bg-blue-500',
                    warning: 'bg-amber-500',
                };
                const icons = {
                    success: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
                    error: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
                    info: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    warning: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
                };
                
                const toast = document.createElement('div');
                toast.className = `pointer-events-auto flex items-center gap-3 ${colors[type]} text-white px-5 py-3 rounded-2xl shadow-lg text-sm font-semibold toast-enter backdrop-blur-md`;
                toast.innerHTML = `${icons[type] || ''}<span>${message}</span>`;
                container.appendChild(toast);
                
                setTimeout(() => {
                    toast.classList.remove('toast-enter');
                    toast.classList.add('toast-leave');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        </script>
    </body>
</html>
