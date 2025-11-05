<?php

use App\Livewire\CreateNote;
use App\Livewire\Dashboard;
use App\Livewire\EditNote;
use App\Livewire\LoginForm;
use Illuminate\Support\Facades\Route;

// Guest routes (for unauthenticated users)
Route::middleware('guest')
    ->group(function () {
        Route::get('/', LoginForm::class)->name('login');
    });

// Authenticated routes with rate limiting (60 requests per minute)
Route::middleware(['auth', 'throttle:60,1'])
    ->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/notes/create', CreateNote::class)->name('notes.create');
        Route::get('/notes/{note}/edit', EditNote::class)->name('notes.edit');
    });
