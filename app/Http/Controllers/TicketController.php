<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Note;
use App\Models\TemporaryFile;
use App\Models\File;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Features\SupportFileUploads\WithFileUploads;
class TicketController extends Controller
{
    use WithFileUploads;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('livewire.pages.ticket.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Ticket $ticket, Request $request)
    {
        $lastTicketNumber = Ticket::max('number');
        $nextTicketNumber = sprintf('%03d', ($lastTicketNumber + 1));

        return view('livewire.pages.ticket.create', [
            'nextTicketNumber' => $nextTicketNumber,
            'ticket' => $ticket,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // * Retrieve all temporary files
        $temporaryFiles = TemporaryFile::all();

        // * Validate the request data
        $validator = Validator::make($request->all(), $this->rules(null));

        if ($validator->fails()) {
            // * Delete temporary files
            foreach ($temporaryFiles as $temporaryFile) {
                Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
                $temporaryFile->delete();
            }

            // * Redirect back with input and errors
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // * Check if the ticket number already exists
        $existingTicket = Ticket::where('number', $request->input('number'))->exists();

        if ($existingTicket) {
            // * Ticket number is already taken, redirect back with error message
            return redirect()->back()->withErrors(['number' => 'Ticket number is already taken'])->withInput();
        }

        // * Validation passed, proceed with storing ticket and files
        $validatedData = $validator->validated();
        $this->setUserId($validatedData);
        $this->setStatusId($validatedData, 1);
        $ticket = Ticket::create($validatedData);

        foreach ($temporaryFiles as $temporaryFile) {
            Storage::copy(
                'attached_files/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->file_name,
                'attached_files/' . $temporaryFile->folder . '/' . $temporaryFile->file_name
            );
            File::create([
                'ticket_id' => $ticket->id,
                'file_name' => $temporaryFile->file_name,
                'file_path' => $temporaryFile->folder . '/' . $temporaryFile->file,
            ]);
            Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
            $temporaryFile->delete();
        }

        // * Flash message and redirect
        Session::flash('create-ticket-success', 'Incident created successfully.');
        return redirect('/tickets');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Ticket $ticket)
    // {
    //     $files = File::where('ticket_id', $ticket->id)->get();

    //     return view('livewire.pages.ticket.show', [
    //         'ticket' => $ticket,
    //         'notes' => $ticket->notes()->latest()->with('user')->paginate(10),
    //         'files' => $files,
    //     ]);
    // }
    public function show($ticket)
    {
        $ticket = Ticket::where('number', $ticket)->firstOrFail();
        $files = File::where('ticket_id', $ticket->id)->get();
        $notes = $ticket->notes()->latest()->with('user')->paginate(10);
        $statusTimeline = $ticket->getStatusTimeline();

        $previousStatus = session('previousStatus');
        $newStatus = session('newStatus');

        return view('livewire.pages.ticket.show', [
            'ticket' => $ticket,
            'notes' => $notes,
            'previousStatus' => $previousStatus,
            'newStatus' => $newStatus,
            'files' => $files,
            'statusTimeline' => $statusTimeline,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Ticket $ticket)
    // {
    //     $files = File::where('ticket_id', $ticket->id)->get();

    //     return view('livewire.pages.ticket.edit', [
    //         'ticket' => $ticket,
    //         'files' => $files,
    //     ]);
    // }

    public function edit($ticket)
    {
        $ticket = Ticket::where('number', $ticket)->firstOrFail();
        $files = File::where('ticket_id', $ticket->id)->get();

        return view('livewire.pages.ticket.edit', [
            'ticket' => $ticket,
            'files' => $files,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $ticket)
    {
        $ticket = Ticket::where('number', $ticket)->firstOrFail();
        // * Retrieve all temporary files
        $temporaryFiles = TemporaryFile::all();

        // * Validate the request data
        $validator = Validator::make($request->all(), $this->rules($ticket->id)); // Pass the current ticket id to the rules method

        // * Check if the ticket number already exists
        $existingTicket = Ticket::where('number', $request->input('number'))->where('id', '!=', $ticket->id)->exists();

        if ($existingTicket) {
            // * Ticket number is already taken, redirect back with error message
            return redirect()->back()->withErrors(['number' => 'Ticket number is already taken'])->withInput();
        }

        if ($validator->fails()) {
            // * Delete temporary files
            foreach ($temporaryFiles as $temporaryFile) {
                Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
                $temporaryFile->delete();
            }

            // * Redirect back with input and errors
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $validatedData = $validator->validated();

        // * Update the status_id only if it's present in the request
        if ($request->has('status_id')) {
            $newStatus = Status::findOrFail($request->input('status_id'));
            $this->updateTicketStatus($ticket, $newStatus);
        }

        if ($temporaryFiles->isNotEmpty()) {
            // * Store temporary files
            foreach ($temporaryFiles as $temporaryFile) {
                Storage::copy(
                    'attached_files/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->file_name,
                    'attached_files/' . $temporaryFile->folder . '/' . $temporaryFile->file_name
                );
                File::create([
                    'ticket_id' => $ticket->id,
                    'file_name' => $temporaryFile->file_name,
                    'file_path' => $temporaryFile->folder . '/' . $temporaryFile->file_name,
                ]);
                Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
                $temporaryFile->delete();
            }
        }

        $ticket->update($validatedData);

        Session::flash('update-ticket-success', 'Incident was updated successfully!');

        // return redirect('/tickets');
        return redirect()->back();
    }

    /**
     * Update ticket status and create a note for the status change.
     */
    private function updateTicketStatus($ticket, $newStatus)
    {
        $previousStatus = $ticket->status->name;
        
        // Update ticket status
        $ticket->status_id = $newStatus->id;
        $ticket->save();

        // Create a new note to track the status change
        Note::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'previous_status' => $previousStatus,
            'new_status' => $newStatus->name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket)
    {
        $ticket = Ticket::where('number', $ticket)->firstOrFail();
        $ticket->delete();

        return back()->with('success', 'Ticket has been moved to archive.');
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

    // protected function validateTicket(?Ticket $ticket = null): array
    // {
    //     $ticket ??= new Ticket();

    //     return request()->validate(array_merge([
    //         'number' => 'required',
    //         'date_received' => 'required',
    //         'title' => 'required',
    //         'issue' => 'required',
    //         'requested_by' => 'required',
    //         'client' => 'required',
    //         'product' => 'required',
    //         'files.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpeg,jpg,gif,svg|max:5120',
    //     ]));
    // }
    protected function rules($currentTicketId): array
    {
        return [
            'number' => [
                'required', 'max:8',
                Rule::unique('tickets')->ignore($currentTicketId),
            ],
            'date_received' => 'required',
            'title' => 'required',
            'issue' => 'required',
            'requested_by' => 'required',
            'client' => 'required',
            'product' => 'required',
            // 'files.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpeg,jpg,gif,svg|max:5120',
        ];
    }

}
