<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CycleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $latestCycle = $user->menstrualCycles()->latest('start_date')->first();
        $allCycles = $user->menstrualCycles()->orderBy('start_date', 'desc')->get();

        // Defaults
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
            
            // Next period date
            $nextPeriodDate = $startDate->copy()->addDays($cycleLength);
            
            // If nextPeriodDate is in the past, advance to the next occurrence
            while ($nextPeriodDate->copy()->startOfDay()->lt($today) && $today->diffInDays($nextPeriodDate) > 0) {
                $nextPeriodDate->addDays($cycleLength);
            }
            
            // Calculate which cycle we're in relative to the start
            $totalDaysSinceStart = (int) $startDate->diffInDays($today);
            
            // Current day in the current cycle (modulo cycleLength, but at least 1)
            $currentDay = ($totalDaysSinceStart % $cycleLength) + 1;
            
            // If we're exactly at the start of a new cycle
            if ($currentDay > $cycleLength) {
                $currentDay = 1;
            }
            
            // Ensure currentDay is always valid (never negative or zero)
            $currentDay = max(1, min($currentDay, $cycleLength));
            
            // Ovulation is 14 days before next period
            $ovulationDay = $cycleLength - 14;
            $ovulationDate = $startDate->copy()->addDays((ceil($totalDaysSinceStart / $cycleLength) * $cycleLength) + $ovulationDay - 1);
            
            // Recalculate ovulation based on the current cycle's start
            $currentCycleStart = $startDate->copy()->addDays(floor($totalDaysSinceStart / $cycleLength) * $cycleLength);
            $ovulationDate = $currentCycleStart->copy()->addDays($ovulationDay - 1);
            
            // Fertile window: 5 days before ovulation to 1 day after
            $fertileWindowStart = $ovulationDate->copy()->subDays(5);
            $fertileWindowEnd = $ovulationDate->copy()->addDays(1);
            
            // Next period date from current cycle
            $nextPeriodDate = $currentCycleStart->copy()->addDays($cycleLength);
            
            // Determine current phase based on currentDay
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
        
        // Calculate progress percentage
        $progressPercent = $latestCycle ? min(100, max(0, (($currentDay - 1) / $cycleLength) * 100)) : 0;
        
        // Days to next period
        $daysToNext = $nextPeriodDate ? (int) now()->startOfDay()->diffInDays($nextPeriodDate->copy()->startOfDay(), false) : 0;

        return view('dashboard', compact(
            'latestCycle',
            'nextPeriodDate',
            'fertileWindowStart',
            'fertileWindowEnd',
            'ovulationDate',
            'currentPhaseName',
            'currentPhaseDesc',
            'currentDay',
            'progressPercent',
            'daysToNext',
            'lastPeriodDateFormatted',
            'cycleLength',
            'periodDays'
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

    public function getCycles()
    {
        $cycles = auth()->user()->menstrualCycles()->orderBy('start_date', 'asc')->get();
        $symptoms = auth()->user()->symptomLogs()->get()->keyBy(function($item) {
            return $item->log_date->format('Y-m-d');
        });

        // Calculate predictions for next 3 cycles
        $latest = $cycles->last();
        $predictions = [];
        if ($latest) {
            $periodDays = $latest->end_date 
                ? Carbon::parse($latest->start_date)->diffInDays(Carbon::parse($latest->end_date)) + 1 
                : 5;
            $cycleLength = $latest->cycle_length;
            
            for ($i = 1; $i <= 3; $i++) {
                $nextStart = Carbon::parse($latest->start_date)->addDays($cycleLength * $i);
                $ovulationDay = $cycleLength - 14;
                $ovulation = $nextStart->copy()->addDays($ovulationDay - 1);
                $fertileStart = $ovulation->copy()->subDays(5);
                $fertileEnd = $ovulation->copy()->addDays(1);
                
                $predictions[] = [
                    'start_date' => $nextStart->toDateString(),
                    'end_date' => $nextStart->copy()->addDays($periodDays - 1)->toDateString(),
                    'period_days' => $periodDays,
                    'ovulation_date' => $ovulation->toDateString(),
                    'fertile_start' => $fertileStart->toDateString(),
                    'fertile_end' => $fertileEnd->toDateString(),
                ];
            }
        }
        
        return response()->json([
            'cycles' => $cycles,
            'symptoms' => $symptoms,
            'predictions' => $predictions
        ]);
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'period_length' => 'nullable|integer|min:1|max:14',
            'cycle_length' => 'nullable|integer|min:20|max:45',
        ]);
        
        $periodLength = $request->period_length ?? 5;
        $cycleLength = $request->cycle_length ?? 28;

        // Find existing cycle to avoid duplicates
        $exists = auth()->user()->menstrualCycles()->where('start_date', $request->start_date)->first();
        if ($exists) {
            // Update existing instead of error
            $exists->update([
                'end_date' => Carbon::parse($request->start_date)->addDays($periodLength - 1)->toDateString(),
                'cycle_length' => $cycleLength,
            ]);
            return response()->json(['success' => true, 'cycle' => $exists, 'updated' => true]);
        }

        $cycle = auth()->user()->menstrualCycles()->create([
            'start_date' => $request->start_date,
            'end_date' => Carbon::parse($request->start_date)->addDays($periodLength - 1)->toDateString(), 
            'cycle_length' => $cycleLength
        ]);

        return response()->json(['success' => true, 'cycle' => $cycle]);
    }

    public function storeSymptomAjax(Request $request)
    {
        $request->validate([
            'log_date' => 'required|date',
            'flow_intensity' => 'nullable|string',
            'pain_level' => 'nullable|integer|min:1|max:5',
            'mood' => 'nullable|string',
            'fatigue' => 'nullable|integer|min:1|max:5',
            'emotions' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
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
