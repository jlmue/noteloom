<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class Footer extends Component
{
    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        return view('livewire.footer', [
            'year' => date('Y'),
        ]);
    }
}
