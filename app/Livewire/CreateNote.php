<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Form component for creating new notes
 */
class CreateNote extends Component
{
    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('required|min:10')]
    public string $content = '';

    public bool $is_important = false;

    /**
     * Save new note and redirect to dashboard
     */
    public function save()
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

    /**
     * Cancel and navigate back
     */
    public function cancel(): void
    {
        $this->js('window.history.back()');
    }

    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        return view('livewire.create-note');
    }
}
