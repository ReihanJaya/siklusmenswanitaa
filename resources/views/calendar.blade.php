<x-app-layout>
    <div class="space-y-4">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800 dark:text-gray-100">Kalender</h2>
                <p class="text-xs text-gray-500 mt-0.5">Catat dan pantau siklus haidmu</p>
            </div>
            <div class="text-[10px] border border-pink-200 dark:border-pink-800 bg-pink-50 dark:bg-pink-900/30 text-primary px-3 py-1.5 rounded-full font-bold uppercase tracking-wider" id="syncStatus">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-primary animate-pulse mr-1"></span>
                Syncing...
            </div>
        </div>

        <!-- Calendar Card -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-5">
            <!-- Calendar Header Navigation -->
            <div class="flex justify-between items-center mb-5">
                <button onclick="changeMonth(-1)" class="w-10 h-10 rounded-2xl flex items-center justify-center bg-gray-50 dark:bg-gray-700 hover:bg-pink-50 dark:hover:bg-pink-900/30 text-gray-600 dark:text-gray-300 hover:text-primary transition active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <h3 id="calendarMonth" class="text-base font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wide"></h3>
                <button onclick="changeMonth(1)" class="w-10 h-10 rounded-2xl flex items-center justify-center bg-gray-50 dark:bg-gray-700 hover:bg-pink-50 dark:hover:bg-pink-900/30 text-gray-600 dark:text-gray-300 hover:text-primary transition active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>

            <!-- Day Header -->
            <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-bold text-gray-400 dark:text-gray-500 mb-2 uppercase tracking-wider">
                <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
            </div>
            
            <!-- Calendar Grid -->
            <div id="calendarGrid" class="grid grid-cols-7 gap-1 text-center text-sm">
                <!-- Rendered by JS -->
            </div>
        </div>

        <!-- Legend -->
        <div class="flex flex-wrap justify-center gap-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 text-[10px] font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-400 shadow-sm shadow-red-200"></span> Haid</div>
            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-700 shadow-sm shadow-amber-200"></span> Flek</div>
            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-green-400 shadow-sm shadow-green-200"></span> Subur</div>
            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-purple-400 shadow-sm shadow-purple-200"></span> Ovulasi</div>
            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-200 shadow-sm"></span> Prediksi</div>
        </div>

        <!-- Date Action Panel -->
        <div id="dateActionPanel" class="hidden bg-white dark:bg-gray-800 border border-pink-100 dark:border-gray-700 rounded-3xl p-5 shadow-lg transition-all animate-slide-up">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-tr from-pink-500 to-purple-500 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25" /></svg>
                    </div>
                    <div>
                        <h4 id="selectedDateText" class="font-extrabold text-gray-800 dark:text-gray-200 text-base"></h4>
                        <p id="selectedDatePhase" class="text-[10px] text-gray-400 font-medium"></p>
                    </div>
                </div>
                <button onclick="closeActionPanel()" class="text-gray-400 hover:text-red-500 bg-gray-50 dark:bg-gray-700 rounded-xl p-2 transition active:scale-90">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- New Cycle Form -->
            <div id="newCycleForm" class="hidden">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Catat ini sebagai hari pertama haid?</p>
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wider">Durasi Haid</label>
                        <select id="periodLength" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm font-medium focus:ring-primary focus:border-primary">
                            <option value="3">3 Hari</option>
                            <option value="4">4 Hari</option>
                            <option value="5" selected>5 Hari</option>
                            <option value="6">6 Hari</option>
                            <option value="7">7 Hari</option>
                            <option value="8">8 Hari</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wider">Panjang Siklus</label>
                        <select id="cycleLength" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm font-medium focus:ring-primary focus:border-primary">
                            <option value="25">25 Hari</option>
                            <option value="26">26 Hari</option>
                            <option value="27">27 Hari</option>
                            <option value="28" selected>28 Hari</option>
                            <option value="29">29 Hari</option>
                            <option value="30">30 Hari</option>
                            <option value="31">31 Hari</option>
                            <option value="32">32 Hari</option>
                            <option value="35">35 Hari</option>
                        </select>
                    </div>
                </div>
                <button id="saveCycleBtn" onclick="saveCycleAction()" class="w-full bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 text-white font-bold rounded-2xl py-3.5 shadow-lg shadow-pink-200 dark:shadow-none transition active:scale-95 flex justify-center items-center text-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Mulai Siklus Haid
                </button>
            </div>

            <!-- Edit Day Form (Color Change) -->
            <div id="editDayForm" class="hidden">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Pilih kondisi darah untuk hari ini:</p>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <button onclick="saveColor('Merah')" class="py-3 px-3 border-2 border-red-200 hover:border-red-400 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded-2xl font-bold text-sm active:scale-95 transition flex flex-col items-center gap-1">
                        <span class="w-6 h-6 bg-red-400 rounded-full shadow-md shadow-red-200"></span>
                        <span>Merah</span>
                        <span class="text-[9px] font-medium text-red-400">Deras / Normal</span>
                    </button>
                    <button onclick="saveColor('Coklat')" class="py-3 px-3 border-2 border-amber-300 hover:border-amber-500 bg-amber-50 dark:bg-amber-900/20 text-amber-800 dark:text-amber-300 rounded-2xl font-bold text-sm active:scale-95 transition flex flex-col items-center gap-1">
                        <span class="w-6 h-6 bg-amber-700 rounded-full shadow-md shadow-amber-200"></span>
                        <span>Coklat</span>
                        <span class="text-[9px] font-medium text-amber-500">Flek / Awal-Akhir</span>
                    </button>
                </div>
            </div>

            <!-- Info for non-editable phases -->
            <div id="phaseInfoForm" class="hidden">
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-4 border border-gray-100 dark:border-gray-800">
                    <div class="flex items-start gap-3">
                        <div id="phaseInfoIcon" class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-lg"></div>
                        <div>
                            <h5 id="phaseInfoTitle" class="font-bold text-sm text-gray-800 dark:text-gray-200 mb-1"></h5>
                            <p id="phaseInfoDesc" class="text-xs text-gray-500 leading-relaxed"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Logic -->
    <script>
        let currentDate = new Date();
        let selectedDate = null;
        let selectedDateStr = null;
        let cyclesData = [];
        let predictionsData = [];
        let symptomsData = {};

        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        document.addEventListener('DOMContentLoaded', () => {
            fetchCycles();
        });

        async function fetchCycles() {
            try {
                updateSyncStatus('syncing');
                const response = await fetch('/api/cycles');
                const data = await response.json();
                cyclesData = data.cycles || [];
                symptomsData = data.symptoms || {};
                predictionsData = data.predictions || [];
                updateSyncStatus('synced');
                renderCalendar();
            } catch (error) {
                console.error("Failed to fetch cycles", error);
                updateSyncStatus('offline');
            }
        }

        function updateSyncStatus(status) {
            const el = document.getElementById('syncStatus');
            if (status === 'syncing') {
                el.innerHTML = '<span class="inline-block w-1.5 h-1.5 rounded-full bg-primary animate-pulse mr-1"></span> Syncing...';
                el.className = 'text-[10px] border border-pink-200 dark:border-pink-800 bg-pink-50 dark:bg-pink-900/30 text-primary px-3 py-1.5 rounded-full font-bold uppercase tracking-wider';
            } else if (status === 'synced') {
                el.innerHTML = '<span class="inline-block w-1.5 h-1.5 rounded-full bg-green-500 mr-1"></span> Tersinkronisasi';
                el.className = 'text-[10px] border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 px-3 py-1.5 rounded-full font-bold uppercase tracking-wider';
            } else {
                el.innerHTML = '<span class="inline-block w-1.5 h-1.5 rounded-full bg-red-500 mr-1"></span> Offline';
                el.className = 'text-[10px] border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/30 text-red-600 px-3 py-1.5 rounded-full font-bold uppercase tracking-wider';
            }
        }

        function changeMonth(step) {
            currentDate.setMonth(currentDate.getMonth() + step);
            renderCalendar();
            closeActionPanel();
        }

        function toDateStr(d) {
            return d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
        }

        function isSameDate(d1, d2) {
            return d1.getFullYear() === d2.getFullYear() && d1.getMonth() === d2.getMonth() && d1.getDate() === d2.getDate();
        }

        function getDateInfo(dateItem) {
            let dString = toDateStr(dateItem);
            let info = { type: 'normal', color: '', label: '' };

            // Check recorded cycles (highest priority)
            for (let c of cyclesData) {
                let start = new Date(c.start_date + 'T00:00:00');
                let end = c.end_date ? new Date(c.end_date + 'T00:00:00') : new Date(start.getTime() + (4 * 24*60*60*1000));
                if (dateItem >= start && dateItem <= end) {
                    let symptom = symptomsData[dString];
                    if (symptom && symptom.flow_intensity === 'Coklat') {
                        return { type: 'period-brown', color: 'bg-amber-700 text-white shadow-md shadow-amber-200 dark:shadow-none', label: 'Haid (Flek)' };
                    }
                    return { type: 'period-red', color: 'bg-red-400 text-white shadow-md shadow-red-200 dark:shadow-none', label: 'Haid' };
                }
            }

            // Check predictions
            for (let pred of predictionsData) {
                let pStart = new Date(pred.start_date + 'T00:00:00');
                let pEnd = new Date(pred.end_date + 'T00:00:00');
                let ovul = new Date(pred.ovulation_date + 'T00:00:00');
                let fertStart = new Date(pred.fertile_start + 'T00:00:00');
                let fertEnd = new Date(pred.fertile_end + 'T00:00:00');

                if (isSameDate(dateItem, ovul)) return { type: 'ovulation', color: 'bg-purple-400 text-white shadow-md shadow-purple-200 dark:shadow-none', label: 'Ovulasi' };
                if (dateItem >= fertStart && dateItem <= fertEnd) return { type: 'fertile', color: 'bg-green-400 text-white shadow-sm', label: 'Masa Subur' };
                if (dateItem >= pStart && dateItem <= pEnd) return { type: 'predicted', color: 'bg-red-200 text-red-800 dark:bg-red-900/40 dark:text-red-200', label: 'Prediksi Haid' };
            }

            return info;
        }

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            document.getElementById('calendarMonth').innerText = monthNames[month] + " " + year;

            const grid = document.getElementById('calendarGrid');
            grid.innerHTML = "";

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = new Date();

            // Blanks for offset
            for (let i = 0; i < firstDay; i++) {
                grid.innerHTML += `<div></div>`;
            }

            // Days
            for (let i = 1; i <= daysInMonth; i++) {
                let d = new Date(year, month, i);
                let dString = toDateStr(d);
                let info = getDateInfo(d);
                let isToday = isSameDate(d, today);
                let isSelected = selectedDate && isSameDate(d, selectedDate);

                let baseClasses = "w-full aspect-square flex items-center justify-center rounded-2xl font-semibold cursor-pointer transition-all text-xs ";
                
                if (isSelected) {
                    baseClasses += "ring-2 ring-primary ring-offset-2 dark:ring-offset-gray-800 ";
                }
                
                if (isToday) {
                    baseClasses += "border-2 border-pink-400 dark:border-pink-500 font-extrabold ";
                }

                if (info.color) {
                    baseClasses += info.color;
                } else {
                    baseClasses += "text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700";
                }

                grid.innerHTML += `
                    <div class="flex justify-center p-0.5">
                        <button onclick="selectDate('${dString}')" class="${baseClasses}" title="${info.label || ''}">
                            ${i}
                        </button>
                    </div>`;
            }
        }

        function selectDate(dateStr) {
            selectedDate = new Date(dateStr + 'T00:00:00');
            selectedDateStr = dateStr;
            renderCalendar();
            
            let info = getDateInfo(selectedDate);

            // Show Panel
            const panel = document.getElementById('dateActionPanel');
            panel.classList.remove('hidden');
            document.getElementById('selectedDateText').innerText = selectedDate.getDate() + " " + monthNames[selectedDate.getMonth()] + " " + selectedDate.getFullYear();
            document.getElementById('selectedDatePhase').innerText = info.label || 'Tidak ada data';

            // Hide all forms first
            document.getElementById('newCycleForm').classList.add('hidden');
            document.getElementById('editDayForm').classList.add('hidden');
            document.getElementById('phaseInfoForm').classList.add('hidden');

            if (info.type === 'period-red' || info.type === 'period-brown') {
                // Show color edit form for period days
                document.getElementById('editDayForm').classList.remove('hidden');
            } else if (info.type === 'ovulation') {
                showPhaseInfo('🟣', 'bg-purple-100 dark:bg-purple-900/30', 'Hari Ovulasi', 'Ini adalah hari ovulasi (pelepasan sel telur). Fase ini ditentukan otomatis oleh sistem dan tidak bisa diubah manual.');
            } else if (info.type === 'fertile') {
                showPhaseInfo('🟢', 'bg-green-100 dark:bg-green-900/30', 'Masa Subur', 'Kamu sedang dalam masa subur. Peluang kehamilan tinggi di periode ini. Warna ini ditentukan otomatis oleh sistem.');
            } else if (info.type === 'predicted') {
                showPhaseInfo('🔴', 'bg-red-100 dark:bg-red-900/30', 'Prediksi Haid', 'Ini adalah prediksi hari haidmu berikutnya berdasarkan data siklus yang sudah dicatat.');
            } else {
                // Show new cycle form for empty days
                document.getElementById('newCycleForm').classList.remove('hidden');
            }
            
            // Scroll to panel
            panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function showPhaseInfo(icon, bgClass, title, desc) {
            document.getElementById('phaseInfoForm').classList.remove('hidden');
            document.getElementById('phaseInfoIcon').innerText = icon;
            document.getElementById('phaseInfoIcon').className = `w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-lg ${bgClass}`;
            document.getElementById('phaseInfoTitle').innerText = title;
            document.getElementById('phaseInfoDesc').innerText = desc;
        }

        function closeActionPanel() {
            selectedDate = null;
            selectedDateStr = null;
            renderCalendar();
            document.getElementById('dateActionPanel').classList.add('hidden');
        }

        async function saveCycleAction() {
            const btn = document.getElementById('saveCycleBtn');
            const pLen = document.getElementById('periodLength').value;
            const cLen = document.getElementById('cycleLength').value;
            const origHTML = btn.innerHTML;
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 mr-2 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...`;
            btn.disabled = true;
            
            try {
                let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch('/api/cycles', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ start_date: selectedDateStr, period_length: parseInt(pLen), cycle_length: parseInt(cLen) })
                });
                
                const data = await response.json();
                if (data.success) {
                    await fetchCycles();
                    closeActionPanel();
                    showToast('Siklus haid berhasil dicatat! 🎉', 'success');
                } else {
                    showToast(data.message || "Gagal menyimpan.", 'error');
                }
            } catch(e) {
                showToast("Kesalahan koneksi.", 'error');
            }
            btn.innerHTML = origHTML;
            btn.disabled = false;
        }

        async function saveColor(colorType) {
            try {
                let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch('/api/symptoms', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ log_date: selectedDateStr, flow_intensity: colorType })
                });
                if (response.ok) {
                    await fetchCycles();
                    closeActionPanel();
                    showToast(colorType === 'Merah' ? 'Ditandai sebagai haid normal 🔴' : 'Ditandai sebagai flek 🟤', 'success');
                }
            } catch(e) {
                showToast("Kesalahan koneksi.", 'error');
            }
        }
    </script>
</x-app-layout>
