<x-app-layout>
    <div class="space-y-5">
        <!-- Header Welcome + Profile Photo -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800 dark:text-gray-100">Hai, {{ auth()->user()->name }} 👋</h2>
                <p class="text-sm text-gray-500 mt-0.5">Bagaimana perasaanmu hari ini?</p>
            </div>
            <div class="relative group" id="profilePhotoWrapper">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-pink-400 to-purple-500 p-0.5 shadow-lg shadow-pink-200 dark:shadow-none cursor-pointer transition hover:scale-105 active:scale-95" onclick="document.getElementById('photoInput').click()">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile" class="w-full h-full object-cover rounded-[14px] bg-white" id="profilePhoto">
                </div>
                <div class="absolute -bottom-1 -right-1 bg-white dark:bg-gray-800 rounded-full p-1 shadow-md border border-pink-100">
                    <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" /></svg>
                </div>
                <input type="file" id="photoInput" accept="image/*" class="hidden" onchange="uploadPhoto(this)">
            </div>
        </div>

        @if(!$latestCycle)
            <!-- State: Empty (No Cycle Recorded) -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] p-8 text-center border border-gray-50 dark:border-gray-700 relative overflow-hidden">
                <div class="absolute -top-16 -right-16 w-40 h-40 bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-900/20 dark:to-purple-900/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-gradient-to-tr from-purple-100 to-pink-100 dark:from-purple-900/20 dark:to-pink-900/20 rounded-full blur-3xl"></div>
                
                <div class="bg-gradient-to-tr from-pink-100 to-purple-100 dark:from-pink-900/40 dark:to-purple-900/40 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-5 relative z-10 shadow-sm">
                    <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                </div>
                
                <h2 class="text-xl font-extrabold mb-2 relative z-10">Mulai Kenali Tubuhmu 🌸</h2>
                <p class="text-gray-500 text-sm mb-6 relative z-10 leading-relaxed">Silakan isi data haid terlebih dahulu di halaman Kalender. Siklus siap memprediksi masa haid dan masa suburmu!</p>
                
                <a href="{{ route('calendar') }}" class="inline-flex w-full justify-center bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 text-white font-bold py-3.5 px-4 rounded-2xl shadow-lg shadow-pink-200 dark:shadow-none transition active:scale-95 relative z-10">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                    Buka Kalender
                </a>
            </div>
        @else
            <!-- Circular Progress / Cycle Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-pink-50 dark:border-gray-700 p-6 flex flex-col items-center relative overflow-hidden">
                <!-- Decorative blurs -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-pink-100/60 dark:bg-pink-900/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-purple-100/60 dark:bg-purple-900/20 rounded-full blur-3xl"></div>
                
                <!-- Phase Badge -->
                @php
                    $phaseColors = [
                        'Fase Menstruasi' => 'bg-red-50 text-red-600 border-red-100 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800',
                        'Fase Folikular' => 'bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800',
                        'Masa Subur' => 'bg-green-50 text-green-600 border-green-100 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800',
                        'Fase Ovulasi' => 'bg-purple-50 text-purple-600 border-purple-100 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-800',
                        'Fase Luteal' => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-800',
                    ];
                    $phaseDots = [
                        'Fase Menstruasi' => 'bg-red-500 animate-pulse',
                        'Fase Folikular' => 'bg-blue-500',
                        'Masa Subur' => 'bg-green-500 animate-pulse',
                        'Fase Ovulasi' => 'bg-purple-500 animate-pulse',
                        'Fase Luteal' => 'bg-amber-500',
                    ];
                    $ringColor = match($currentPhaseName) {
                        'Fase Menstruasi' => 'stroke-red-400',
                        'Fase Folikular' => 'stroke-blue-400',
                        'Masa Subur' => 'stroke-green-400',
                        'Fase Ovulasi' => 'stroke-purple-500',
                        'Fase Luteal' => 'stroke-amber-400',
                        default => 'stroke-primary',
                    };
                    $dayColor = match($currentPhaseName) {
                        'Fase Menstruasi' => 'text-red-500',
                        'Fase Folikular' => 'text-blue-500',
                        'Masa Subur' => 'text-green-500',
                        'Fase Ovulasi' => 'text-purple-500',
                        'Fase Luteal' => 'text-amber-500',
                        default => 'text-primary',
                    };
                @endphp

                <div class="inline-flex space-x-1.5 items-center {{ $phaseColors[$currentPhaseName] ?? 'bg-pink-50 text-primary border-pink-100' }} px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider mb-5 border relative z-10">
                    <span class="w-2 h-2 rounded-full {{ $phaseDots[$currentPhaseName] ?? 'bg-primary' }}"></span>
                    <span>{{ $currentPhaseName }}</span>
                </div>
                
                <!-- Circular Progress Ring SVG -->
                <div class="relative w-52 h-52 mb-4">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                        <defs>
                            <linearGradient id="progressGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color: #ec4899" />
                                <stop offset="100%" style="stop-color: #a855f7" />
                            </linearGradient>
                        </defs>
                        <circle cx="50" cy="50" r="45" fill="none" class="stroke-gray-100 dark:stroke-gray-700" stroke-width="6"></circle>
                        <circle cx="50" cy="50" r="45" fill="none" class="{{ $ringColor }} transition-all duration-1000 ease-in-out" stroke-width="7" stroke-dasharray="283" stroke-dashoffset="{{ 283 - (283 * $progressPercent / 100) }}" stroke-linecap="round"></circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-[10px] text-gray-400 uppercase tracking-[0.2em] mb-1 font-semibold">Hari Ke</span>
                        <span class="text-5xl font-black {{ $dayColor }}">{{ $currentDay }}</span>
                        <span class="text-[10px] text-gray-400 mt-1">dari {{ $cycleLength }} hari</span>
                    </div>
                </div>

                <!-- Countdown to next period -->
                <div class="text-center w-full relative z-10">
                    <div class="text-2xl font-extrabold text-gray-800 dark:text-gray-100 mt-1">
                        @if($daysToNext > 0)
                            {{ $daysToNext }} Hari Lagi
                        @elseif($daysToNext == 0)
                            Diprediksi Hari Ini! 🔴
                        @else
                            Terlambat {{ abs($daysToNext) }} Hari
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Perkiraan haid berikutnya</p>
                </div>
                
                <!-- Phase description -->
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl w-full mt-5 p-4 border border-gray-100 dark:border-gray-800 text-left flex items-start space-x-3 relative z-10">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-[12px] leading-relaxed text-gray-500">{{ $currentPhaseDesc }}</p>
                </div>
            </div>

            <!-- Stats Grid (4 cards) -->
            <div class="grid grid-cols-2 gap-3">
                <!-- Haid Terakhir -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-50 dark:border-gray-700 relative overflow-hidden transition hover:-translate-y-0.5">
                    <div class="absolute -right-3 -bottom-3 opacity-10">
                        <svg class="w-14 h-14 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a.75.75 0 01.75.75v5.59l1.95-2.1a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0L6.2 7.26a.75.75 0 111.1-1.02l1.95 2.1V2.75A.75.75 0 0110 2z"/></svg>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-7 h-7 bg-red-50 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-red-500 uppercase tracking-wider">Haid Terakhir</span>
                    </div>
                    <div class="font-extrabold text-gray-800 dark:text-gray-100 text-sm">{{ $lastPeriodDateFormatted }}</div>
                </div>

                <!-- Haid Berikutnya -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-50 dark:border-gray-700 relative overflow-hidden transition hover:-translate-y-0.5">
                    <div class="absolute -right-3 -bottom-3 opacity-10">
                        <svg class="w-14 h-14 text-pink-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-7 h-7 bg-pink-50 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-pink-500 uppercase tracking-wider">Berikutnya</span>
                    </div>
                    <div class="font-extrabold text-gray-800 dark:text-gray-100 text-sm">{{ $nextPeriodDate->translatedFormat('d M Y') }}</div>
                </div>

                <!-- Masa Subur -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50/50 dark:from-gray-800 dark:to-gray-800 rounded-2xl p-4 shadow-sm border border-green-100 dark:border-gray-700 relative overflow-hidden transition hover:-translate-y-0.5">
                    <div class="absolute -right-3 -bottom-3 opacity-10">
                        <svg class="w-14 h-14 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-7 h-7 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">Masa Subur</span>
                    </div>
                    <div class="font-extrabold text-gray-800 dark:text-gray-100 text-sm">
                        {{ \Carbon\Carbon::parse($fertileWindowStart)->format('d') }} - {{ \Carbon\Carbon::parse($fertileWindowEnd)->translatedFormat('d M') }}
                    </div>
                </div>

                <!-- Ovulasi -->
                <div class="bg-gradient-to-br from-purple-50 to-fuchsia-50/50 dark:from-gray-800 dark:to-gray-800 rounded-2xl p-4 shadow-sm border border-purple-100 dark:border-gray-700 relative overflow-hidden transition hover:-translate-y-0.5">
                    <div class="absolute -right-3 -bottom-3 opacity-10">
                        <svg class="w-14 h-14 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-7 h-7 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider">Ovulasi</span>
                    </div>
                    <div class="font-extrabold text-gray-800 dark:text-gray-100 text-sm">
                        {{ \Carbon\Carbon::parse($ovulationDate)->translatedFormat('d F') }}
                    </div>
                </div>
            </div>

            <!-- Action: Catat Gejala -->
            <a href="{{ route('symptoms') }}" class="block w-full bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 text-white font-bold py-4 px-5 rounded-2xl shadow-lg shadow-pink-200 dark:shadow-none transition active:scale-95">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 rounded-xl p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold">Catat Gejala & Mood</div>
                            <div class="text-[10px] text-pink-100">Pantau kondisimu hari ini</div>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </div>
            </a>
        @endif

        <!-- Tips Section -->
        <div>
            <div class="flex justify-between items-end mb-3">
                <h3 class="font-bold text-gray-800 dark:text-gray-200">💡 Tips Harian</h3>
                <a href="{{ route('education') }}" class="text-xs text-primary font-semibold hover:underline">Lihat Semua →</a>
            </div>
            
            @php
                $tips = [
                    ['title' => 'Jaga Mood Tetap Stabil', 'desc' => 'Kurangi kafein dan perbanyak air putih saat mendekati masa PMS.', 'icon' => '😊', 'color' => 'from-pink-400 to-rose-400'],
                    ['title' => 'Olahraga Ringan Saat Haid', 'desc' => 'Yoga atau jalan kaki 30 menit bisa kurangi kram perut.', 'icon' => '🧘‍♀️', 'color' => 'from-purple-400 to-indigo-400'],
                    ['title' => 'Nutrisi Penting', 'desc' => 'Konsumsi makanan kaya zat besi seperti bayam dan dark chocolate.', 'icon' => '🍫', 'color' => 'from-amber-400 to-orange-400'],
                ];
                $randomTip = $tips[array_rand($tips)];
            @endphp
            
            <a href="{{ route('education') }}" class="block bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-50 dark:border-gray-700 p-4 transition hover:-translate-y-0.5 active:scale-[0.98]">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-br {{ $randomTip['color'] }} rounded-2xl w-12 h-12 flex items-center justify-center shadow-md flex-shrink-0 text-xl">
                        {{ $randomTip['icon'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-sm text-gray-800 dark:text-gray-100">{{ $randomTip['title'] }}</h4>
                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $randomTip['desc'] }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </div>
            </a>
        </div>
        
        <div class="h-4"></div>
    </div>

    <!-- Photo Upload Script -->
    <script>
        async function uploadPhoto(input) {
            if (!input.files || !input.files[0]) return;
            
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                showToast('Ukuran foto maksimal 2MB', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('photo', file);
            
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch('/api/profile/photo', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: formData
                });
                
                const data = await response.json();
                if (data.success) {
                    document.getElementById('profilePhoto').src = data.photo_url;
                    showToast('Foto profil berhasil diperbarui! 📸', 'success');
                } else {
                    showToast('Gagal mengupload foto', 'error');
                }
            } catch (e) {
                showToast('Kesalahan koneksi', 'error');
            }
        }
    </script>
</x-app-layout>
