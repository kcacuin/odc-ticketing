<?php

namespace App\Livewire;

use App\Models\Status;
use App\Models\Ticket;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination;

    // public $search = '';
    // public $client = '';

    public $sortField;
    public $sortDirection = 'asc';
    public $queryString = ['sortField', 'sortDirection'];
    public $showFilters = false;

    public $filters = [
        'search' => '',
        'status' => '',
        'date-min' => null,
        'date-max' => null,
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // If sorting by a different field, default to ascending order
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    // public function render()
    // {
    //     $sortField = $this->sortField ?: 'date_received';

    //     $query = Ticket::query();

    //     $query->filter([
    //         'search' => $this->filters['search'] ?? '',
    //         // 'statuses' => $this->filters['status'] ?? '',
    //         // 'client' => $this->filters['client'] ?? '',
    //     ]);

    //     $query->when($this->filters['status'], fn($query, $status) => $query->where('status_id', $status));
    //     $query->when($this->filters['date-min'], fn($query, $date) => $query->where('data_received', '>=', Carbon::parse($date)));
    //     $query->when($this->filters['date-max'], fn($query, $date) => $query->where('data_received', '<=', Carbon::parse($date)));


    //     $tickets = $query->orderBy($sortField, $this->sortDirection)->paginate(15);

    //     return view('livewire.ticket-list', [
    //         'statuses' => Status::all(),
    //         'tickets' => $tickets,
    //     ]);
    // }
    public function render()
    {
        $sortField = $this->sortField ?: 'date_received';

        $query = Ticket::query();

        $query->when($this->filters['status'], fn($query, $status) => $query->where('status_id', $status));

        $query->when($this->filters['date-min'], function ($query, $date) {
            $query->where('date_received', '>=', Carbon::parse($date));
        });

        $query->when($this->filters['date-max'], function ($query, $date) {
            $query->where('date_received', '<=', Carbon::parse($date));
        });

        $query->filter([
            'search' => $this->filters['search'] ?? '',
            // 'status' => $this->filters['status'] ?? '',
            // 'client' => $this->filters['client'] ?? '',
        ]);

        $tickets = $query->orderBy($sortField, $this->sortDirection)->paginate(15);

        return view('livewire.ticket-list', [
            'statuses' => Status::all(),
            'tickets' => $tickets,
        ]);
    }

    // public function getRowsQueryProperty()
    // {
    //     $query = Ticket::query()
    //         ->when($this->filters['status'], fn($query, $status) => $query->where('status', $status))
    //         ->when($this->filters['date-min'], fn($query, $date) => $query->where('date', '>=', Carbon::parse($date)))
    //         ->when($this->filters['date-max'], fn($query, $date) => $query->where('date', '<=', Carbon::parse($date)))
    //         ->when($this->filters['search'], fn($query, $search) => $query->where('title', 'like', '%'.$search.'%'));

    //     return $this->applySorting($query);
    // }
}
