<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;

class TicketShow extends Component
{
    public function render(Ticket $ticket)
    {
        return view('livewire.ticket-show' , [
            'ticket' => $ticket,
            'comments' => $ticket->comments()->latest()->with('user')->paginate(10),
        ]);
    }
}
