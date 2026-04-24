<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Siklus — Tracker Haid</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { -webkit-tap-highlight-color: transparent; }
    </style>
</head>

<body class="font-sans text-gray-800">

<div class="min-h-screen bg-pink-50 pb-28">

    <!-- HEADER -->
    <header class="bg-white shadow sticky top-0 z-40">
        <div class="flex justify-between items-center px-4 py-3 max-w-md mx-auto">
            <h1 class="font-bold text-pink-500">Siklus</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-xs bg-gray-100 px-3 py-1 rounded">Logout</button>
            </form>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="p-4 max-w-md mx-auto pb-32">
        {{ $slot }}
    </main>

</div>

<!-- ✅ NAVBAR FIX (INI YANG PENTING BANGET) -->
<nav class="fixed bottom-0 left-0 w-full bg-white border-t z-50"
     style="padding-bottom: env(safe-area-inset-bottom);">

    <div class="flex justify-around items-center h-16 max-w-md mx-auto">

        <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-xs">
            <span>🏠</span>
            <span>Home</span>
        </a>

        <a href="{{ route('calendar') }}" class="flex flex-col items-center text-xs">
            <span>📅</span>
            <span>Kalender</span>
        </a>

        <a href="{{ route('symptoms') }}" class="flex flex-col items-center text-xs">
            <span>📝</span>
            <span>Gejala</span>
        </a>

        <a href="{{ route('education') }}" class="flex flex-col items-center text-xs">
            <span>📚</span>
            <span>Edukasi</span>
        </a>

        <a href="{{ route('chatbot') }}" class="flex flex-col items-center text-xs">
            <span>🤖</span>
            <span>Chat</span>
        </a>

    </div>
</nav>

</body>
</html>