<?php

namespace App\Livewire;

use Livewire\Component;

class Breadcrumb extends Component
{
    public string $currentPage;

    public function render()
    {
        return view('livewire.breadcrumb');
    }
}
