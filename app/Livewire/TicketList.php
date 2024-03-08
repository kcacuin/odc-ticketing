<?php

namespace App\Livewire;

use App\Livewire\DataTable\WithPerPagePagination;
use App\Livewire\DataTable\WithBulkActions;
use App\Livewire\DataTable\WithCachedRows;
use App\Livewire\DataTable\WithSorting;
use App\Models\Status;
use App\Models\Ticket;
use Carbon\Carbon;
use Livewire\Component;

class TicketList extends Component
{
    use WithPerPagePagination, WithBulkActions, WithCachedRows, WithSorting;

    public $id;
    public $showDeleteModal = false;
    // public $showFilters = false;
    public $filters = [
        'search' => '',
        'status' => '',
        'date-min' => null,
        'date-max' => null,
    ];

    public $queryString = ['sorts'];


    public function updatedFilters()
    {
        $this->resetPage();
    }
    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->notify('You\'ve deleted '.$deleteCount.' tickets');
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        // $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getRowsQueryProperty()
    {
        $query = Ticket::query()
            ->when($this->filters['status'], fn($query, $status) => $query->where('status_id', $status))
            ->when($this->filters['date-min'], fn($query, $date) => $query->where('date_received', '>=', Carbon::parse($date)))
            ->when($this->filters['date-max'], fn($query, $date) => $query->where('date_received', '<=', Carbon::parse($date)));
        $query->filter([
            'search' => $this->filters['search'] ?? '',
            // 'status' => $this->filters['status'] ?? '',
            // 'client' => $this->filters['client'] ?? '',
        ]);

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.ticket-list', [
            'statuses' => Status::all(),
            'tickets' => $this->rows,
        ]);
    }
}
