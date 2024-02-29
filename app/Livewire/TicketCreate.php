<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketCreate extends Component
{
    use WithFileUploads;
    public $nextTicketNumber;

    // public function mount()
    // {
    //     $this->nextTicketNumber = sprintf('%03d', (Ticket::max('number') + 1));
    //     $this->date_received = now()->format('Y-m-d');
    // }

    public function render(Ticket $ticket)
    {
        $lastTicketNumber = Ticket::max('number');
        $nextTicketNumber = sprintf('%03d', ($lastTicketNumber + 1));

        return view('livewire.ticket-create', [
            'nextTicketNumber' => $nextTicketNumber,
            'ticket' => $ticket,
        ]);
    }

    // public function render(Ticket $ticket)
    // {
    //     $lastTicketNumber = Ticket::max('number');
    //     $nextTicketNumber = sprintf('%03d', ($lastTicketNumber + 1));

    //     return view('livewire.ticket-create', [
    //         'nextTicketNumber' => $nextTicketNumber,
    //         'ticket' => ticket,
    //     ]);
    // }
}
