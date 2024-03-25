<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

// TODO: Phase 2

class NoteComponent extends Component
{
    public $ticket;
    public $body;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function render()
    {
        return view('livewire.note-component');
    }

    public function store()
    {
        $this->validate([
            'body' => ['required', 'string', 'max:255']
        ]);

        $this->ticket->notes()->create([
            'body' => $this->body,
            'user_id' => Auth::id()
        ]);

        $this->reset('body');

        session()->flash('message', 'Note added successfully.');
    }
}
