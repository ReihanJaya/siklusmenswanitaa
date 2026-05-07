<x-app-layout>
<div class="space-y-4">

    {{-- ── HEADER ──────────────────────────────────────────────────── --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Kalender 📅</h2>
            <p class="text-xs text-gray-400 mt-0.5">Klik tanggal untuk tandai hari haid</p>
        </div>
        <div id="syncStatus" class="flex items-center gap-1.5 text-[10px] border border-pink-200 bg-pink-50 text-pink-500 px-3 py-1.5 rounded-full font-bold uppercase tracking-wider">
            <span class="w-1.5 h-1.5 rounded-full bg-pink-400 animate-pulse"></span>
            Memuat...
        </div>
    </div>

    {{-- ── CALENDAR CARD ───────────────────────────────────────────── --}}
    <div id="calendarContainer" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 touch-pan-y select-none">

        {{-- Month Navigation --}}
        <div class="flex justify-between items-center mb-5">
            <button id="prevMonth" class="w-10 h-10 rounded-2xl flex items-center justify-center bg-gray-50 hover:bg-pink-50 text-gray-500 hover:text-pink-500 transition active:scale-90">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <h3 id="calendarMonth" class="text-base font-extrabold text-gray-800 uppercase tracking-wide"></h3>
            <button id="nextMonth" class="w-10 h-10 rounded-2xl flex items-center justify-center bg-gray-50 hover:bg-pink-50 text-gray-500 hover:text-pink-500 transition active:scale-90">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

        {{-- Day Headers --}}
        <div class="grid grid-cols-7 text-center text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-wider">
            <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
        </div>

        {{-- Calendar Grid --}}
        <div id="calendarGrid" class="grid grid-cols-7 text-center text-sm gap-y-1"></div>

        {{-- Hint --}}
        <p class="text-center text-[10px] text-gray-300 mt-4">Ketuk tanggal untuk tandai hari haid</p>
    </div>

    {{-- ── LEGEND ──────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap justify-center gap-x-4 gap-y-2 bg-white rounded-2xl shadow-sm border border-gray-100 px-4 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-gradient-to-br from-pink-500 to-red-500 shadow-sm shadow-pink-200"></span>Haid</div>
        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-600 shadow-sm"></span>Flek</div>
        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-green-400 shadow-sm shadow-green-200"></span>Subur</div>
        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-purple-500 shadow-sm shadow-purple-200"></span>Ovulasi</div>
        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full border-2 border-dashed border-pink-300"></span>Prediksi</div>
    </div>

    {{-- ── DAY DETAIL PANEL ────────────────────────────────────────── --}}
    <div id="dayPanel" class="hidden bg-white rounded-3xl shadow-lg border border-pink-100 overflow-hidden">

        {{-- Panel Header --}}
        <div class="bg-gradient-to-r from-pink-500 to-purple-500 px-5 py-4 flex items-center justify-between">
            <div>
                <p id="panelDate" class="text-white font-extrabold text-lg"></p>
                <p id="panelPhase" class="text-pink-100 text-xs font-medium mt-0.5"></p>
            </div>
            <button id="closePanelBtn" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-xl flex items-center justify-center transition active:scale-90">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-5 space-y-4">

            {{-- Flow Intensity Selector (shown for period days) --}}
            <div id="flowSelector" class="hidden">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Intensitas Darah</p>
                <div class="grid grid-cols-4 gap-2" id="flowBtns">
                    <button data-flow="spotting" onclick="setFlow('spotting')" class="flow-btn flex flex-col items-center gap-1 py-3 rounded-2xl border-2 border-amber-200 bg-amber-50 active:scale-95 transition">
                        <span class="w-5 h-5 rounded-full bg-amber-700"></span>
                        <span class="text-[10px] font-bold text-amber-700">Flek</span>
                    </button>
                    <button data-flow="light" onclick="setFlow('light')" class="flow-btn flex flex-col items-center gap-1 py-3 rounded-2xl border-2 border-rose-200 bg-rose-50 active:scale-95 transition">
                        <span class="w-5 h-5 rounded-full bg-rose-300"></span>
                        <span class="text-[10px] font-bold text-rose-500">Sedikit</span>
                    </button>
                    <button data-flow="medium" onclick="setFlow('medium')" class="flow-btn flex flex-col items-center gap-1 py-3 rounded-2xl border-2 border-pink-200 bg-pink-50 active:scale-95 transition">
                        <span class="w-5 h-5 rounded-full bg-pink-500"></span>
                        <span class="text-[10px] font-bold text-pink-600">Sedang</span>
                    </button>
                    <button data-flow="heavy" onclick="setFlow('heavy')" class="flow-btn flex flex-col items-center gap-1 py-3 rounded-2xl border-2 border-red-200 bg-red-50 active:scale-95 transition">
                        <span class="w-5 h-5 rounded-full bg-red-600"></span>
                        <span class="text-[10px] font-bold text-red-600">Deras</span>
                    </button>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div id="actionBtns" class="space-y-2.5"></div>

            {{-- Phase Info (for non-editable days) --}}
            <div id="phaseInfo" class="hidden bg-gray-50 rounded-2xl p-4 border border-gray-100">
                <div class="flex items-start gap-3">
                    <span id="phaseInfoIcon" class="text-xl flex-shrink-0"></span>
                    <div>
                        <h5 id="phaseInfoTitle" class="font-bold text-sm text-gray-800 mb-1"></h5>
                        <p id="phaseInfoDesc" class="text-xs text-gray-500 leading-relaxed"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ── JAVASCRIPT ──────────────────────────────────────────────────────── --}}
<script>
const MONTHS = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
const DAYS_ID = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];

let currentDate   = new Date();
let selectedStr   = null;
let cyclesData    = [];
let periodDaysMap = {};   // { "2026-05-07": "medium", ... }
let predictionsData = [];
let symptomsData  = {};

// ── INIT ──────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    fetchData();
    document.getElementById('prevMonth').addEventListener('click', () => changeMonth(-1));
    document.getElementById('nextMonth').addEventListener('click', () => changeMonth(1));
    document.getElementById('closePanelBtn').addEventListener('click', closePanel);

    // Touch swipe support
    let tx = 0;
    const cal = document.getElementById('calendarContainer');
    cal.addEventListener('touchstart', e => tx = e.touches[0].clientX, {passive:true});
    cal.addEventListener('touchend', e => {
        const dx = tx - e.changedTouches[0].clientX;
        if (Math.abs(dx) > 50) changeMonth(dx > 0 ? 1 : -1);
    }, {passive:true});
});

// ── FETCH DATA ────────────────────────────────────────────────────────
async function fetchData() {
    setSyncStatus('loading');
    try {
        const res = await fetch('/api/cycles');
        const data = await res.json();
        cyclesData = data.cycles || [];
        predictionsData = data.predictions || [];
        symptomsData = data.symptoms || {};

        periodDaysMap = {};
        (data.period_days || []).forEach(pd => {
            periodDaysMap[pd.date] = pd.flow_intensity || 'medium';
        });

        setSyncStatus('synced');
        renderCalendar();
    } catch(e) {
        setSyncStatus('offline');
        console.error(e);
    }
}

function setSyncStatus(s) {
    const el = document.getElementById('syncStatus');
    const states = {
        loading: ['bg-pink-50 border-pink-200 text-pink-500', 'bg-pink-400 animate-pulse', 'Memuat...'],
        synced:  ['bg-green-50 border-green-200 text-green-600', 'bg-green-500', 'Tersinkronisasi'],
        offline: ['bg-red-50 border-red-200 text-red-500', 'bg-red-400', 'Offline'],
    };
    const [cls, dot, label] = states[s] || states.loading;
    el.className = `flex items-center gap-1.5 text-[10px] border ${cls} px-3 py-1.5 rounded-full font-bold uppercase tracking-wider`;
    el.innerHTML = `<span class="w-1.5 h-1.5 rounded-full ${dot}"></span>${label}`;
}

// ── DATE HELPERS ──────────────────────────────────────────────────────
function pad(n) { return String(n).padStart(2,'0'); }
function toStr(d) { return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`; }
function isSame(a,b) { return a.getFullYear()===b.getFullYear()&&a.getMonth()===b.getMonth()&&a.getDate()===b.getDate(); }

// ── GET DATE STATUS ───────────────────────────────────────────────────
function getStatus(ds) {
    if (periodDaysMap[ds] !== undefined) {
        const flow = periodDaysMap[ds];
        const colors = {
            spotting: 'bg-amber-700 text-white',
            light:    'bg-rose-300 text-white',
            medium:   'bg-gradient-to-br from-pink-500 to-rose-500 text-white shadow-sm shadow-pink-300',
            heavy:    'bg-gradient-to-br from-red-500 to-rose-600 text-white shadow-sm shadow-red-300',
        };
        return { type:'period', flow, cls: colors[flow] || colors.medium };
    }
    for (const p of predictionsData) {
        if (ds === p.ovulation_date)
            return { type:'ovulation', cls:'bg-purple-500 text-white shadow-sm shadow-purple-200' };
        if (ds >= p.fertile_start && ds <= p.fertile_end)
            return { type:'fertile', cls:'bg-green-100 text-green-700 ring-1 ring-green-300' };
        if (ds >= p.start_date && ds <= p.end_date)
            return { type:'predicted', cls:'border-2 border-dashed border-pink-300 text-pink-400' };
    }
    return { type:'normal', cls:'' };
}

// ── RENDER CALENDAR ───────────────────────────────────────────────────
function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    document.getElementById('calendarMonth').textContent = `${MONTHS[month]} ${year}`;

    const grid = document.getElementById('calendarGrid');
    grid.innerHTML = '';

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month+1, 0).getDate();
    const today = new Date();

    // Blank cells
    for (let i = 0; i < firstDay; i++) {
        grid.insertAdjacentHTML('beforeend', '<div></div>');
    }

    for (let i = 1; i <= daysInMonth; i++) {
        const d   = new Date(year, month, i);
        const ds  = toStr(d);
        const st  = getStatus(ds);
        const isToday    = isSame(d, today);
        const isSelected = ds === selectedStr;

        let cellCls = 'mx-auto w-9 h-9 flex items-center justify-center rounded-full font-semibold text-xs cursor-pointer transition-all duration-150 active:scale-90 ';

        if (st.cls) {
            cellCls += st.cls + ' ';
        } else {
            cellCls += 'text-gray-600 hover:bg-pink-50 hover:text-pink-500 ';
        }
        if (isToday && st.type === 'normal') {
            cellCls += 'ring-2 ring-pink-400 font-extrabold text-pink-500 ';
        }
        if (isSelected) {
            cellCls += 'ring-2 ring-offset-2 ring-pink-500 ';
        }

        grid.insertAdjacentHTML('beforeend', `
            <div class="flex justify-center py-0.5">
                <button onclick="selectDate('${ds}')" class="${cellCls}" title="${st.type}">${i}</button>
            </div>`);
    }
}

function changeMonth(step) {
    currentDate.setMonth(currentDate.getMonth() + step);
    closePanel();
    renderCalendar();
}

// ── SELECT DATE → SHOW PANEL ──────────────────────────────────────────
function selectDate(ds) {
    selectedStr = ds;
    renderCalendar();

    const d    = new Date(ds + 'T00:00:00');
    const st   = getStatus(ds);
    const label = `${d.getDate()} ${MONTHS[d.getMonth()]} ${d.getFullYear()}`;

    document.getElementById('panelDate').textContent  = label;
    document.getElementById('dayPanel').classList.remove('hidden');

    // Reset sub-sections
    document.getElementById('flowSelector').classList.add('hidden');
    document.getElementById('phaseInfo').classList.add('hidden');
    document.getElementById('actionBtns').innerHTML = '';

    if (st.type === 'period') {
        document.getElementById('panelPhase').textContent = 'Hari Haid — ketuk untuk ubah intensitas atau hapus';
        showFlowSelector(periodDaysMap[ds]);
        renderActionBtns([
            { label:'🗑️ Hapus Hari Ini dari Haid', cls:'w-full py-3 rounded-2xl border-2 border-red-200 bg-red-50 text-red-600 font-bold text-sm active:scale-95 transition', onclick:`removePeriodDay('${ds}')` }
        ]);
    } else if (st.type === 'ovulation') {
        document.getElementById('panelPhase').textContent = 'Hari Ovulasi';
        showPhaseInfo('🟣','Hari Ovulasi','Ini adalah prediksi hari ovulasi. Peluang kehamilan tertinggi.');
    } else if (st.type === 'fertile') {
        document.getElementById('panelPhase').textContent = 'Masa Subur';
        showPhaseInfo('🟢','Masa Subur','Kamu sedang dalam masa subur. Peluang kehamilan tinggi.');
    } else if (st.type === 'predicted') {
        document.getElementById('panelPhase').textContent = 'Prediksi Haid';
        showPhaseInfo('🔴','Prediksi Haid','Ini prediksi hari haid berikutnya. Tandai manual jika haid benar mulai.');
        renderActionBtns([
            { label:'🩸 Tandai Sebagai Haid', cls:'w-full py-3 rounded-2xl bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold text-sm shadow-md shadow-pink-200 active:scale-95 transition', onclick:`addPeriodDay('${ds}')` }
        ]);
    } else {
        document.getElementById('panelPhase').textContent = 'Hari Normal';
        renderActionBtns([
            { label:'🩸 Tandai Sebagai Hari Haid', cls:'w-full py-3 rounded-2xl bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold text-sm shadow-md shadow-pink-200 active:scale-95 transition', onclick:`addPeriodDay('${ds}')` }
        ]);
    }

    document.getElementById('dayPanel').scrollIntoView({ behavior:'smooth', block:'nearest' });
}

function renderActionBtns(btns) {
    document.getElementById('actionBtns').innerHTML = btns
        .map(b => `<button class="${b.cls}" onclick="${b.onclick}">${b.label}</button>`)
        .join('');
}

function showFlowSelector(current) {
    document.getElementById('flowSelector').classList.remove('hidden');
    document.querySelectorAll('.flow-btn').forEach(btn => {
        const isActive = btn.dataset.flow === current;
        btn.classList.toggle('ring-2', isActive);
        btn.classList.toggle('ring-offset-1', isActive);
        btn.classList.toggle('ring-pink-400', isActive);
        btn.classList.toggle('scale-105', isActive);
    });
}

function showPhaseInfo(icon, title, desc) {
    const el = document.getElementById('phaseInfo');
    el.classList.remove('hidden');
    document.getElementById('phaseInfoIcon').textContent  = icon;
    document.getElementById('phaseInfoTitle').textContent = title;
    document.getElementById('phaseInfoDesc').textContent  = desc;
}

function closePanel() {
    selectedStr = null;
    document.getElementById('dayPanel').classList.add('hidden');
    renderCalendar();
}

// ── API CALLS ─────────────────────────────────────────────────────────
function csrf() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

async function addPeriodDay(ds) {
    try {
        const r = await fetch('/api/period-days/toggle', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':csrf(), 'Accept':'application/json' },
            body: JSON.stringify({ date: ds, flow_intensity: 'medium' })
        });
        const data = await r.json();
        if (data.success) {
            periodDaysMap[ds] = 'medium';
            closePanel();
            await fetchData();
            showToast('✅ Hari haid berhasil ditandai!', 'success');
        }
    } catch(e) { showToast('Gagal menyimpan', 'error'); }
}

async function removePeriodDay(ds) {
    if (!confirm('Hapus tanggal ini dari hari haid?')) return;
    try {
        const r = await fetch('/api/period-days/toggle', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':csrf(), 'Accept':'application/json' },
            body: JSON.stringify({ date: ds })
        });
        const data = await r.json();
        if (data.success) {
            delete periodDaysMap[ds];
            closePanel();
            await fetchData();
            showToast('🗑️ Hari haid dihapus', 'success');
        }
    } catch(e) { showToast('Gagal menghapus', 'error'); }
}

async function setFlow(intensity) {
    if (!selectedStr) return;
    try {
        const r = await fetch('/api/period-days/flow', {
            method: 'PATCH',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':csrf(), 'Accept':'application/json' },
            body: JSON.stringify({ date: selectedStr, flow_intensity: intensity })
        });
        const data = await r.json();
        if (data.success) {
            periodDaysMap[selectedStr] = intensity;
            showFlowSelector(intensity);
            renderCalendar();
            const labels = { spotting:'Flek 🟤', light:'Sedikit 🩹', medium:'Sedang 🔴', heavy:'Deras 💧' };
            showToast(`Intensitas: ${labels[intensity]}`, 'success');
        }
    } catch(e) { showToast('Gagal menyimpan', 'error'); }
}
</script>
</x-app-layout>
