<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class TopNavigation extends Component
{
    public function logout(): Redirector|RedirectResponse
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        return view('livewire.top-navigation');
    }
}
