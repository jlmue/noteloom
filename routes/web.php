<?php

use App\Livewire\CreateNote;
use App\Livewire\Dashboard;
use App\Livewire\EditNote;
use App\Livewire\LoginForm;
use Illuminate\Support\Facades\Route;

// TODO: add rate limiting in livewire components
// Guest routes with strict rate limiting (prevent brute force attacks)
Route::middleware(['guest', 'throttle:20,1'])
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
