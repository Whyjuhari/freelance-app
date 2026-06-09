<?php

use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjekController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Untuk Project
Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::resource('projects', ProjekController::class);
    Route::patch('projects/{project}/complete', [ProjekController::class, 'complete'])
        ->name('projects.complete');
});



// Untuk Tugas
Route::middleware(['auth', 'verified'])->group(function () {

    // Route::get('/tasks', TaskTable::class)->name('tasks.index');
    Route::resource('tasks', TugasController::class);


    Route::patch('/tasks/{task}/toggle', [TugasController::class, 'toggle'])
        ->name('tasks.toggle');
});




// Untuk Klien
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('client', ClientController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('keuangan', KeuanganController::class)
        ->except(['create', 'show', 'edit']);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/csv', [LaporanController::class, 'exportCsv'])->name('laporan.export.csv');
    Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
});

// Time Tracking
Route::middleware(['auth', 'verified'])->prefix('time-tracking')->name('time-tracking.')->group(function () {
    Route::get('/', [TimeLogController::class, 'index'])->name('index');
    Route::post('/start', [TimeLogController::class, 'start'])->name('start');
    Route::post('/{timeLog}/stop', [TimeLogController::class, 'stop'])->name('stop');
    Route::post('/manual', [TimeLogController::class, 'store'])->name('store');
    Route::put('/{timeLog}', [TimeLogController::class, 'update'])->name('update');
    Route::delete('/{timeLog}', [TimeLogController::class, 'destroy'])->name('destroy');
    Route::get('/projects/{project}/tasks', [TimeLogController::class, 'getTasks'])->name('projects.tasks');
});

Route::middleware(['auth'])->prefix('ai')->group(function () {
    Route::get('/', [AiAssistantController::class, 'index'])->name('ai.index');
});

// routes/api.php (atau routes/web.php jika pakai session auth)
Route::middleware(['auth', 'throttle:30,1'])->prefix('api/ai')->group(function () {
    Route::post('/chat', [AiAssistantController::class, 'chat'])->name('ai.chat');
    Route::get('/history', [AiAssistantController::class, 'history'])->name('ai.history');
    Route::delete('/history', [AiAssistantController::class, 'clearHistory'])->name('ai.clearHistory');
    Route::get('/stats', [AiAssistantController::class, 'stats'])->name('ai.stats');
    Route::post('/change-model', [AiAssistantController::class, 'changeModel'])->name('ai.changeModel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
