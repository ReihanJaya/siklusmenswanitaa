<?php

namespace App\Http\Controllers;

use App\Models\PeriodDay;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CycleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $latestCycle = $user->menstrualCycles()->latest('start_date')->first();

        $nextPeriodDate = null;
        $fertileWindowStart = null;
        $fertileWindowEnd = null;
        $ovulationDate = null;
        $currentPhaseName = 'Belum Ada Data';
        $currentPhaseDesc = 'Silakan isi data haid terlebih dahulu di halaman Kalender.';
        $currentDay = 0;
        $lastPeriodDateFormatted = null;
        $cycleLength = 28;
        $periodDays = 5;

        if ($latestCycle) {
            $cycleLength = (int) $latestCycle->cycle_length;
            $periodDays = $latestCycle->end_date
                ? (int) Carbon::parse($latestCycle->start_date)->diffInDays(Carbon::parse($latestCycle->end_date)) + 1
                : 5;

            $today = now()->startOfDay();
            $startDate = Carbon::parse($latestCycle->start_date)->startOfDay();
            $lastPeriodDateFormatted = $startDate->translatedFormat('d F Y');

            $nextPeriodDate = $startDate->copy()->addDays($cycleLength);
            $totalDaysSinceStart = (int) $startDate->diffInDays($today);
            $currentDay = ($totalDaysSinceStart % $cycleLength) + 1;
            $currentDay = max(1, min($currentDay, $cycleLength));

            $ovulationDay = $cycleLength - 14;
            $currentCycleStart = $startDate->copy()->addDays(floor($totalDaysSinceStart / $cycleLength) * $cycleLength);
            $ovulationDate = $currentCycleStart->copy()->addDays($ovulationDay - 1);
            $fertileWindowStart = $ovulationDate->copy()->subDays(5);
            $fertileWindowEnd = $ovulationDate->copy()->addDays(1);
            $nextPeriodDate = $currentCycleStart->copy()->addDays($cycleLength);

            if ($currentDay <= $periodDays) {
                $currentPhaseName = 'Fase Menstruasi';
                $currentPhaseDesc = 'Lapisan rahim meluruh. Wajar jika terasa kram perut, nyeri punggung, dan perubahan mood.';
            } elseif ($currentDay <= $ovulationDay - 5) {
                $currentPhaseName = 'Fase Folikular';
                $currentPhaseDesc = 'Tubuh mempersiapkan sel telur baru. Energi dan mood cenderung meningkat di fase ini.';
            } elseif ($currentDay >= $ovulationDay - 5 && $currentDay <= $ovulationDay + 1) {
                if ($currentDay == $ovulationDay) {
                    $currentPhaseName = 'Fase Ovulasi';
                    $currentPhaseDesc = 'Puncak masa subur! Sel telur dilepaskan dari ovarium. Peluang kehamilan tertinggi di hari ini.';
                } else {
                    $currentPhaseName = 'Masa Subur';
                    $currentPhaseDesc = 'Kamu sedang dalam masa subur. Peluang kehamilan tinggi di periode ini.';
                }
            } else {
                $currentPhaseName = 'Fase Luteal';
                $currentPhaseDesc = 'Masa pra-haid (PMS). Kamu mungkin merasa lebih sensitif, kembung, atau mudah lelah.';
            }
        }

        $progressPercent = $latestCycle ? min(100, max(0, (($currentDay - 1) / $cycleLength) * 100)) : 0;
        $daysToNext = $nextPeriodDate ? (int) now()->startOfDay()->diffInDays($nextPeriodDate->copy()->startOfDay(), false) : 0;

        return view('dashboard', compact(
            'latestCycle', 'nextPeriodDate', 'fertileWindowStart', 'fertileWindowEnd',
            'ovulationDate', 'currentPhaseName', 'currentPhaseDesc', 'currentDay',
            'progressPercent', 'daysToNext', 'lastPeriodDateFormatted', 'cycleLength', 'periodDays'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'cycle_length' => 'required|integer|min:20|max:45'
        ]);
        auth()->user()->menstrualCycles()->create($request->all());
        return redirect()->route('dashboard')->with('success', 'Siklus berhasil ditambahkan.');
    }

    public function calendar()
    {
        return view('calendar');
    }

    // ─── TOGGLE PERIOD DAY (MANUAL) ───────────────────────────────────────────
    public function togglePeriodDay(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'flow_intensity' => 'nullable|string|in:spotting,light,medium,heavy',
        ]);

        $user = auth()->user();
        $existing = $user->periodDays()->where('date', $request->date)->first();

        if ($existing) {
            $existing->delete();
            $this->syncCycleFromPeriodDays($user, $request->date);
            return response()->json(['success' => true, 'action' => 'removed']);
        }

        $day = $user->periodDays()->create([
            'date' => $request->date,
            'flow_intensity' => $request->flow_intensity ?? 'medium',
        ]);
        $this->syncCycleFromPeriodDays($user, $request->date);
        return response()->json(['success' => true, 'action' => 'added', 'day' => $day]);
    }

    // ─── UPDATE FLOW INTENSITY ────────────────────────────────────────────────
    public function updatePeriodDayFlow(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'flow_intensity' => 'required|string|in:spotting,light,medium,heavy',
        ]);

        $user = auth()->user();
        $day = $user->periodDays()->updateOrCreate(
            ['date' => $request->date],
            ['flow_intensity' => $request->flow_intensity]
        );

        $this->syncCycleFromPeriodDays($user, $request->date);
        return response()->json(['success' => true, 'day' => $day]);
    }

    // ─── SYNC: period_days → menstrual_cycles ─────────────────────────────────
    private function syncCycleFromPeriodDays($user, string $dateStr): void
    {
        // Get all period days sorted
        $allDates = $user->periodDays()
            ->orderBy('date')
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->values()
            ->toArray();

        // Group into consecutive clusters
        $clusters = [];
        $current = [];
        foreach ($allDates as $d) {
            if (empty($current)) {
                $current = [$d];
            } else {
                $prev = Carbon::parse(end($current));
                $curr = Carbon::parse($d);
                if ($curr->diffInDays($prev) === 1) {
                    $current[] = $d;
                } else {
                    $clusters[] = $current;
                    $current = [$d];
                }
            }
        }
        if (!empty($current)) $clusters[] = $current;

        // Find which cluster $dateStr belongs to
        $targetCluster = null;
        foreach ($clusters as $cluster) {
            if (in_array($dateStr, $cluster)) {
                $targetCluster = $cluster;
                break;
            }
        }

        if (!$targetCluster) {
            // Day was removed and no cluster → clean up orphan cycle records near this date
            $user->menstrualCycles()
                ->where(function ($q) use ($dateStr) {
                    $q->where('start_date', $dateStr)
                      ->orWhere('end_date', $dateStr);
                })->delete();
            return;
        }

        $start = $targetCluster[0];
        $end   = end($targetCluster);

        // Calculate cycle_length from gap with previous cluster
        $clusterIndex = array_search($targetCluster, $clusters);
        $prevCycleLength = 28;
        if ($clusterIndex > 0) {
            $prevCluster = $clusters[$clusterIndex - 1];
            $gap = Carbon::parse($prevCluster[0])->diffInDays(Carbon::parse($start));
            $prevCycleLength = max(20, min(45, (int) $gap));
        }

        // Upsert: find nearby cycle and update, or create
        $existingCycle = $user->menstrualCycles()
            ->whereBetween('start_date', [
                Carbon::parse($start)->subDays(3)->toDateString(),
                Carbon::parse($start)->addDays(3)->toDateString(),
            ])->first();

        if ($existingCycle) {
            $existingCycle->update([
                'start_date'   => $start,
                'end_date'     => $end,
                'cycle_length' => $prevCycleLength,
            ]);
        } else {
            $user->menstrualCycles()->create([
                'start_date'   => $start,
                'end_date'     => $end,
                'cycle_length' => $prevCycleLength,
            ]);
        }
    }

    // ─── GET CYCLES (AJAX) ────────────────────────────────────────────────────
    public function getCycles()
    {
        $user = auth()->user();
        $cycles = $user->menstrualCycles()->orderBy('start_date')->get();
        $periodDays = $user->periodDays()->orderBy('date')->get();
        $symptoms = $user->symptomLogs()->get()->keyBy(fn($s) => $s->log_date->format('Y-m-d'));

        // Predictions based on latest cycle
        $predictions = [];
        $latest = $cycles->last();
        if ($latest) {
            $periodLen = $latest->end_date
                ? Carbon::parse($latest->start_date)->diffInDays($latest->end_date) + 1
                : 5;
            $cycleLen = $latest->cycle_length;

            for ($i = 1; $i <= 3; $i++) {
                $nextStart = Carbon::parse($latest->start_date)->addDays($cycleLen * $i);
                $ovulDay   = $cycleLen - 14;
                $ovulation = $nextStart->copy()->addDays($ovulDay - 1);
                $predictions[] = [
                    'start_date'     => $nextStart->toDateString(),
                    'end_date'       => $nextStart->copy()->addDays($periodLen - 1)->toDateString(),
                    'ovulation_date' => $ovulation->toDateString(),
                    'fertile_start'  => $ovulation->copy()->subDays(5)->toDateString(),
                    'fertile_end'    => $ovulation->copy()->addDays(1)->toDateString(),
                ];
            }
        }

        return response()->json([
            'cycles'      => $cycles,
            'period_days' => $periodDays,
            'symptoms'    => $symptoms,
            'predictions' => $predictions,
        ]);
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'start_date'    => 'required|date',
            'period_length' => 'nullable|integer|min:1|max:14',
            'cycle_length'  => 'nullable|integer|min:20|max:45',
        ]);

        $periodLength = $request->period_length ?? 5;
        $cycleLength  = $request->cycle_length ?? 28;

        $exists = auth()->user()->menstrualCycles()->where('start_date', $request->start_date)->first();
        if ($exists) {
            $exists->update([
                'end_date'     => Carbon::parse($request->start_date)->addDays($periodLength - 1)->toDateString(),
                'cycle_length' => $cycleLength,
            ]);
            return response()->json(['success' => true, 'cycle' => $exists, 'updated' => true]);
        }

        $cycle = auth()->user()->menstrualCycles()->create([
            'start_date'   => $request->start_date,
            'end_date'     => Carbon::parse($request->start_date)->addDays($periodLength - 1)->toDateString(),
            'cycle_length' => $cycleLength,
        ]);

        return response()->json(['success' => true, 'cycle' => $cycle]);
    }

    public function storeSymptomAjax(Request $request)
    {
        $request->validate([
            'log_date'       => 'required|date',
            'flow_intensity' => 'nullable|string',
            'pain_level'     => 'nullable|integer|min:1|max:5',
            'mood'           => 'nullable|string',
            'fatigue'        => 'nullable|integer|min:1|max:5',
            'emotions'       => 'nullable|string',
            'notes'          => 'nullable|string|max:500',
        ]);

        $symptom = auth()->user()->symptomLogs()->updateOrCreate(
            ['log_date' => $request->log_date],
            $request->only(['flow_intensity', 'pain_level', 'mood', 'fatigue', 'emotions', 'notes'])
        );

        return response()->json(['success' => true, 'symptom' => $symptom]);
    }

    public function getSymptomHistory()
    {
        $symptoms = auth()->user()->symptomLogs()
            ->orderBy('log_date', 'desc')
            ->limit(50)
            ->get();

        return response()->json(['symptoms' => $symptoms]);
    }

    public function symptoms()
    {
        return view('symptoms');
    }
}
