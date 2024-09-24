<?php

use App\Livewire\Dashboard;
use App\Livewire\ExibirLog;
use App\Livewire\Login;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/', Login::class)->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/log', ExibirLog::class)->name('log');
});
