<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Livewire\WithPagination;

class TicketController extends Controller
{
    use WithPagination;

    public $image;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('livewire.pages.ticket.index', [
            'tickets' => Ticket::latest()->with('user')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Ticket $ticket)
    {
        $lastTicketNumber = Ticket::max('number');
        $nextTicketNumber = sprintf('%03d', ($lastTicketNumber + 1));

        return view('livewire.pages.ticket.create', [
            'nextTicketNumber' => $nextTicketNumber,
            // 'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateTicket();

        $this->setUserId($validatedData);

        // * Set default value of 1 for 'status_id'
        $this->setStatusId($validatedData, 1);

        Ticket::create(array_merge($validatedData, [
            'files' => request()->file('files')->store('attached_files'),
        ]));

        // session()->flash('message', 'Ticket created successfully.');

        return redirect('/tickets')->with('success', 'Added new incident! Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('livewire.pages.ticket.show', [
            'ticket' => $ticket,
            'comments' => $ticket->comments()->latest()->with('user')->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('livewire.pages.ticket.edit', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        // dd('Update method called', $request->all(), $ticket);
        $validatedData = $this->validateTicket($ticket);

        // * Update the status_id only if it's present in the request
        if ($request->has('status_id')) {
            $validatedData['status_id'] = $request->input('status_id');
        }

        if ($validatedData['files'] ?? false) {
            $validatedData['files'] = request()->file('files')->store('attached_files');
        }

        $ticket->update($validatedData);

        return back()->with('success', 'Incident Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return back()->with('success', 'Post Deleted!');
    }

    // *sets the 'user_id' in the $validatedData array to the ID of the currently authenticated user
    protected function setUserId(array &$validatedData)
    {
        $validatedData['user_id'] = auth()->id();
    }

    // * sets the 'status_id' in the $validatedData array to the provided $statusId
    protected function setStatusId(array &$validatedData, $statusId)
    {
        if (!isset($validatedData['status_id'])) {
            $validatedData['status_id'] = $statusId;
        }
    }


    protected function validateTicket(?Ticket $ticket = null): array
    {
        $ticket ??= new Ticket();

        return request()->validate(array_merge([
            'number' => 'required',
            'date_received' => 'required',
            'requested_by' => 'required',
            'client' => 'required',
            'product' => 'required',
            'issue' => 'required',
            'files' => 'required', File::types(['*'])->min(1024)->max(12 * 1024),
        ]));
    }
}
