<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateNote extends Component
{
    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('required|min:10')]
    public string $content = '';

    public bool $is_important = false;

    public function save(): RedirectResponse
    {
        $this->validate();

        Note::query()
            ->create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'content' => $this->content,
                'is_important' => $this->is_important,
            ]);

        session()->flash('success', 'Note created successfully!');

        return redirect()->route('dashboard');
    }

    public function cancel(): RedirectResponse
    {
        return redirect()->route('dashboard');
    }

    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        return view('livewire.create-note');
    }
}
