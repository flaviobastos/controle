<?php

use App\Livewire\Login;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/', Login::class)->name('login');
});

/* Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', index::class)->name('dashboard');
}); */
