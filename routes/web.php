<?php

use App\Livewire\CreateNote;
use App\Livewire\Dashboard;
use App\Livewire\LoginForm;
use Illuminate\Support\Facades\Route;

// Guest routes (for unauthenticated users)
Route::middleware('guest')
    ->group(function () {
        Route::get('/', LoginForm::class)->name('login');
    });

// Authenticated routes
Route::middleware('auth')
    ->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/notes/create', CreateNote::class)->name('notes.create');
    });
