<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Ticket;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request, Ticket $ticket)
    // {
    //     $data = $request->validate([
    //         'body' => ['required', 'string', 'max:255']
    //     ]);

        
    //     $ticket->notes()->create([...$data, 'user_id' => $request->user()->id]);

    //     return to_route('tickets.show', $ticket)->withFragment('notes');
    // }

    public function store(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:255']
        ]);

        $previousStatus = $ticket->status->name; 

        $note = $ticket->notes()->create([
            'body' => $data['body'],
            'previous_status' => $previousStatus, 
            'new_status' => $ticket->status->name, 
            'user_id' => $request->user()->id
        ]);

        // Retrieve the new status after creating the note
        $newStatus = $ticket->status->name;

        return redirect()->route('tickets.show', $ticket)->with([
            'previousStatus' => $previousStatus,
            'newStatus' => $newStatus
        ])->withFragment('notes');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket, Note $note)
    {
        // $this->authorize('delete', $note);

        $note->delete();

        return to_route('tickets.show', $ticket)->withFragment('notes');
    }
}
