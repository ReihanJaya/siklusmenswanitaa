<x-app-layout>
    <div class="space-y-5">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800 dark:text-gray-100">Catatan Gejala</h2>
                <p class="text-xs text-gray-500 mt-0.5">Pantau gejala dan mood harianmu</p>
            </div>
            <div class="w-10 h-10 bg-gradient-to-tr from-pink-500 to-purple-500 rounded-xl flex items-center justify-center shadow-md shadow-pink-200 dark:shadow-none">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" /></svg>
            </div>
        </div>

        <!-- Input Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 space-y-5">
            <h3 class="font-extrabold text-base text-gray-800 dark:text-gray-200 flex items-center gap-2">
                <span class="text-lg">📝</span> 
                Catat Gejala Hari Ini
            </h3>

            <!-- Date Picker -->
            <div>
                <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Tanggal</label>
                <input type="date" id="symptomDate" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-3 text-sm font-medium focus:ring-primary focus:border-primary" value="{{ date('Y-m-d') }}">
            </div>

            <!-- Pain Level -->
            <div>
                <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Tingkat Nyeri</label>
                <div class="flex gap-2" id="painSelector">
                    <button onclick="selectPain(1)" data-val="1" class="pain-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">😊</span>
                        <span class="text-[9px] font-bold">Tidak</span>
                    </button>
                    <button onclick="selectPain(2)" data-val="2" class="pain-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">🙂</span>
                        <span class="text-[9px] font-bold">Ringan</span>
                    </button>
                    <button onclick="selectPain(3)" data-val="3" class="pain-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">😐</span>
                        <span class="text-[9px] font-bold">Sedang</span>
                    </button>
                    <button onclick="selectPain(4)" data-val="4" class="pain-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">😣</span>
                        <span class="text-[9px] font-bold">Berat</span>
                    </button>
                    <button onclick="selectPain(5)" data-val="5" class="pain-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">😭</span>
                        <span class="text-[9px] font-bold">Parah</span>
                    </button>
                </div>
            </div>

            <!-- Mood -->
            <div>
                <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Mood</label>
                <div class="flex gap-2 flex-wrap" id="moodSelector">
                    <button onclick="selectMood('Senang')" data-val="Senang" class="mood-btn px-4 py-2.5 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-sm font-medium transition active:scale-95 hover:border-pink-200 flex items-center gap-1.5">
                        <span>😄</span> Senang
                    </button>
                    <button onclick="selectMood('Biasa')" data-val="Biasa" class="mood-btn px-4 py-2.5 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-sm font-medium transition active:scale-95 hover:border-pink-200 flex items-center gap-1.5">
                        <span>😐</span> Biasa
                    </button>
                    <button onclick="selectMood('Sedih')" data-val="Sedih" class="mood-btn px-4 py-2.5 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-sm font-medium transition active:scale-95 hover:border-pink-200 flex items-center gap-1.5">
                        <span>😢</span> Sedih
                    </button>
                    <button onclick="selectMood('Marah')" data-val="Marah" class="mood-btn px-4 py-2.5 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-sm font-medium transition active:scale-95 hover:border-pink-200 flex items-center gap-1.5">
                        <span>😠</span> Marah
                    </button>
                    <button onclick="selectMood('Cemas')" data-val="Cemas" class="mood-btn px-4 py-2.5 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-sm font-medium transition active:scale-95 hover:border-pink-200 flex items-center gap-1.5">
                        <span>😰</span> Cemas
                    </button>
                </div>
            </div>

            <!-- Fatigue -->
            <div>
                <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Kelelahan</label>
                <div class="flex gap-2" id="fatigueSelector">
                    <button onclick="selectFatigue(1)" data-val="1" class="fatigue-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">💪</span>
                        <span class="text-[9px] font-bold">Segar</span>
                    </button>
                    <button onclick="selectFatigue(2)" data-val="2" class="fatigue-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">🙂</span>
                        <span class="text-[9px] font-bold">Biasa</span>
                    </button>
                    <button onclick="selectFatigue(3)" data-val="3" class="fatigue-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">😴</span>
                        <span class="text-[9px] font-bold">Lelah</span>
                    </button>
                    <button onclick="selectFatigue(4)" data-val="4" class="fatigue-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">🥱</span>
                        <span class="text-[9px] font-bold">Sangat</span>
                    </button>
                    <button onclick="selectFatigue(5)" data-val="5" class="fatigue-btn flex-1 flex flex-col items-center gap-1 py-3 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 transition active:scale-95 hover:border-pink-200">
                        <span class="text-xl">😩</span>
                        <span class="text-[9px] font-bold">Drop</span>
                    </button>
                </div>
            </div>

            <!-- Emotions -->
            <div>
                <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Emosi</label>
                <div class="flex gap-2 flex-wrap" id="emotionSelector">
                    <button onclick="selectEmotion('Stabil')" data-val="Stabil" class="emotion-btn px-4 py-2.5 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-sm font-medium transition active:scale-95 hover:border-pink-200 flex items-center gap-1.5">
                        <span>😌</span> Stabil
                    </button>
                    <button onclick="selectEmotion('Sensitif')" data-val="Sensitif" class="emotion-btn px-4 py-2.5 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-sm font-medium transition active:scale-95 hover:border-pink-200 flex items-center gap-1.5">
                        <span>🥺</span> Sensitif
                    </button>
                    <button onclick="selectEmotion('Mood Swing')" data-val="Mood Swing" class="emotion-btn px-4 py-2.5 rounded-xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-sm font-medium transition active:scale-95 hover:border-pink-200 flex items-center gap-1.5">
                        <span>🎭</span> Mood Swing
                    </button>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Catatan Tambahan</label>
                <textarea id="symptomNotes" rows="3" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-3 text-sm focus:ring-primary focus:border-primary resize-none" placeholder="Tuliskan catatan harimu di sini..."></textarea>
            </div>

            <!-- Save Button -->
            <button id="saveSymptomBtn" onclick="saveSymptom()" class="w-full bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 text-white font-bold rounded-2xl py-3.5 shadow-lg shadow-pink-200 dark:shadow-none transition active:scale-95 flex justify-center items-center text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                Simpan Catatan
            </button>
        </div>

        <!-- History Section -->
        <div>
            <h3 class="font-extrabold text-base text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                <span class="text-lg">📋</span> 
                Riwayat Gejala
            </h3>
            <div id="historyList" class="space-y-3">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 text-center">
                    <div class="text-gray-300 dark:text-gray-600 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                    <p class="text-sm text-gray-400 font-medium">Memuat riwayat...</p>
                </div>
            </div>
        </div>

        <div class="h-4"></div>
    </div>

    <script>
        // State
        let selectedPain = null;
        let selectedMood = null;
        let selectedFatigue = null;
        let selectedEmotion = null;

        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        function selectPain(val) {
            selectedPain = val;
            updateSelection('pain-btn', 'painSelector', val);
        }
        function selectMood(val) {
            selectedMood = val;
            updateSelectionByVal('mood-btn', 'moodSelector', val);
        }
        function selectFatigue(val) {
            selectedFatigue = val;
            updateSelection('fatigue-btn', 'fatigueSelector', val);
        }
        function selectEmotion(val) {
            selectedEmotion = val;
            updateSelectionByVal('emotion-btn', 'emotionSelector', val);
        }

        function updateSelection(btnClass, parentId, val) {
            document.querySelectorAll(`#${parentId} .${btnClass}`).forEach(btn => {
                if (parseInt(btn.dataset.val) === val) {
                    btn.classList.remove('border-gray-100', 'dark:border-gray-700', 'bg-gray-50', 'dark:bg-gray-700');
                    btn.classList.add('border-pink-400', 'bg-pink-50', 'dark:bg-pink-900/30', 'dark:border-pink-500');
                } else {
                    btn.classList.add('border-gray-100', 'dark:border-gray-700', 'bg-gray-50', 'dark:bg-gray-700');
                    btn.classList.remove('border-pink-400', 'bg-pink-50', 'dark:bg-pink-900/30', 'dark:border-pink-500');
                }
            });
        }

        function updateSelectionByVal(btnClass, parentId, val) {
            document.querySelectorAll(`#${parentId} .${btnClass}`).forEach(btn => {
                if (btn.dataset.val === val) {
                    btn.classList.remove('border-gray-100', 'dark:border-gray-700', 'bg-gray-50', 'dark:bg-gray-700');
                    btn.classList.add('border-pink-400', 'bg-pink-50', 'dark:bg-pink-900/30', 'dark:border-pink-500');
                } else {
                    btn.classList.add('border-gray-100', 'dark:border-gray-700', 'bg-gray-50', 'dark:bg-gray-700');
                    btn.classList.remove('border-pink-400', 'bg-pink-50', 'dark:bg-pink-900/30', 'dark:border-pink-500');
                }
            });
        }

        async function saveSymptom() {
            const logDate = document.getElementById('symptomDate').value;
            const notes = document.getElementById('symptomNotes').value;
            
            if (!logDate) {
                showToast('Pilih tanggal terlebih dahulu', 'warning');
                return;
            }
            if (!selectedPain && !selectedMood && !selectedFatigue && !selectedEmotion && !notes) {
                showToast('Isi minimal satu gejala', 'warning');
                return;
            }

            const btn = document.getElementById('saveSymptomBtn');
            const origHTML = btn.innerHTML;
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 mr-2 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...`;
            btn.disabled = true;

            try {
                let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch('/api/symptoms', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({
                        log_date: logDate,
                        pain_level: selectedPain,
                        mood: selectedMood,
                        fatigue: selectedFatigue,
                        emotions: selectedEmotion,
                        notes: notes
                    })
                });
                
                const data = await response.json();
                if (data.success) {
                    showToast('Gejala berhasil dicatat! 📝', 'success');
                    // Reset form
                    selectedPain = null; selectedMood = null; selectedFatigue = null; selectedEmotion = null;
                    document.querySelectorAll('.pain-btn, .mood-btn, .fatigue-btn, .emotion-btn').forEach(b => {
                        b.classList.add('border-gray-100', 'dark:border-gray-700', 'bg-gray-50', 'dark:bg-gray-700');
                        b.classList.remove('border-pink-400', 'bg-pink-50', 'dark:bg-pink-900/30', 'dark:border-pink-500');
                    });
                    document.getElementById('symptomNotes').value = '';
                    loadHistory();
                } else {
                    showToast('Gagal menyimpan gejala', 'error');
                }
            } catch (e) {
                showToast('Kesalahan koneksi', 'error');
            }
            
            btn.innerHTML = origHTML;
            btn.disabled = false;
        }

        async function loadHistory() {
            try {
                const response = await fetch('/api/symptoms');
                const data = await response.json();
                const list = document.getElementById('historyList');
                
                if (!data.symptoms || data.symptoms.length === 0) {
                    list.innerHTML = `
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 text-center">
                            <div class="text-gray-300 dark:text-gray-600 mb-2">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <p class="text-sm text-gray-400 font-medium">Belum ada catatan gejala</p>
                            <p class="text-xs text-gray-300 mt-1">Mulai catat gejalamu di atas</p>
                        </div>`;
                    return;
                }

                const painEmojis = { 1: '😊', 2: '🙂', 3: '😐', 4: '😣', 5: '😭' };
                const painLabels = { 1: 'Tidak nyeri', 2: 'Ringan', 3: 'Sedang', 4: 'Berat', 5: 'Parah' };
                const fatigueEmojis = { 1: '💪', 2: '🙂', 3: '😴', 4: '🥱', 5: '😩' };
                const fatigueLabels = { 1: 'Segar', 2: 'Biasa', 3: 'Lelah', 4: 'Sangat Lelah', 5: 'Drop' };
                const moodEmojis = { 'Senang': '😄', 'Biasa': '😐', 'Sedih': '😢', 'Marah': '😠', 'Cemas': '😰' };
                const emotionEmojis = { 'Stabil': '😌', 'Sensitif': '🥺', 'Mood Swing': '🎭' };

                list.innerHTML = data.symptoms.map(s => {
                    let date = new Date(s.log_date);
                    let dateStr = date.getDate() + ' ' + monthNames[date.getMonth()] + ' ' + date.getFullYear();
                    
                    let tags = [];
                    if (s.pain_level) tags.push(`<span class="inline-flex items-center gap-1 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-300 text-[10px] font-bold px-2 py-1 rounded-lg">${painEmojis[s.pain_level] || ''} ${painLabels[s.pain_level] || ''}</span>`);
                    if (s.mood) tags.push(`<span class="inline-flex items-center gap-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300 text-[10px] font-bold px-2 py-1 rounded-lg">${moodEmojis[s.mood] || ''} ${s.mood}</span>`);
                    if (s.fatigue) tags.push(`<span class="inline-flex items-center gap-1 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-300 text-[10px] font-bold px-2 py-1 rounded-lg">${fatigueEmojis[s.fatigue] || ''} ${fatigueLabels[s.fatigue] || ''}</span>`);
                    if (s.emotions) tags.push(`<span class="inline-flex items-center gap-1 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-300 text-[10px] font-bold px-2 py-1 rounded-lg">${emotionEmojis[s.emotions] || ''} ${s.emotions}</span>`);
                    
                    return `
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm transition hover:-translate-y-0.5">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-extrabold text-gray-800 dark:text-gray-200">${dateStr}</span>
                                <span class="text-[9px] text-gray-400 font-medium bg-gray-50 dark:bg-gray-700 px-2 py-1 rounded-lg">${s.flow_intensity || ''}</span>
                            </div>
                            <div class="flex flex-wrap gap-1.5 mb-2">
                                ${tags.join('')}
                            </div>
                            ${s.notes ? `<p class="text-xs text-gray-500 mt-2 bg-gray-50 dark:bg-gray-900/50 rounded-xl p-3 border border-gray-100 dark:border-gray-800">📝 ${s.notes}</p>` : ''}
                        </div>`;
                }).join('');
            } catch (e) {
                console.error('Failed to load history', e);
            }
        }

        // Load history on page load
        document.addEventListener('DOMContentLoaded', loadHistory);
    </script>
</x-app-layout>
