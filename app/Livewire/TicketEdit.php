<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Illuminate\Validation\Rules\File;

class TicketEdit extends Component
{
    public Ticket $editing;

    public function rules() { return [
        'editing.number' => 'required',
        'editing.date_received' => 'required',
        'editing.title' => 'required',
        'editing.issue' => 'required',
        'editing.requested_by' => 'required',
        'editing.client' => 'required',
        'editing.status_id' => 'required',
        'editing.product' => 'required',
        'editing.files' => 'required', File::types(['*'])->min(1024)->max(12 * 1024),
    ]; }

    public function edit(Ticket $tickets)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($tickets)) $this->editing = $tickets;

    }

    public function save()
    {
        $this->validate();

        $this->editing->save();
    }

    public function render(Ticket $tickets)
    {
        return view('livewire.ticket-edit', [
            'tickets' => $tickets,
        ]);
    }
}
