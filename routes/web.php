<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CycleController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CycleController::class, 'index'])->name('dashboard');
    Route::post('/cycles', [CycleController::class, 'store'])->name('cycles.store');
    
    // Calendar View
    Route::get('/kalender', [CycleController::class, 'calendar'])->name('calendar');

    // Symptoms View
    Route::get('/gejala', [CycleController::class, 'symptoms'])->name('symptoms');

    // API Routes for AJAX
    Route::get('/api/cycles', [CycleController::class, 'getCycles']);
    Route::post('/api/cycles', [CycleController::class, 'storeAjax']);
    Route::post('/api/symptoms', [CycleController::class, 'storeSymptomAjax']);
    Route::get('/api/symptoms', [CycleController::class, 'getSymptomHistory']);
    Route::post('/api/profile/photo', [ProfileController::class, 'uploadPhoto']);
    
    Route::get('/edukasi', function () {
        return view('education');
    })->name('education');

    Route::get('/chatbot', function () {
        return view('chatbot');
    })->name('chatbot');
    
    // Auth profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
