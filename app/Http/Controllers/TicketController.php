<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use DOMComment;
use App\Models\Status;
use App\Models\Note;
use App\Models\TemporaryFile;
use App\Models\File;
use App\Models\Ticket;
use App\Models\TicketChange;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        // $statusTimeline = $ticket->getStatusTimeline();

        $previousStatus = session('previousStatus');
        $newStatus = session('newStatus');

        return view('livewire.pages.ticket.show', [
            'ticket' => $ticket,
            'notes' => $notes,
            'previousStatus' => $previousStatus,
            'newStatus' => $newStatus,
            'files' => $files,
            // 'statusTimeline' => $statusTimeline,
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
    // public function update(Request $request, $ticket)
    // {
    //     $ticket = Ticket::where('number', $ticket)->firstOrFail();
    //     // * Retrieve all temporary files
    //     $temporaryFiles = TemporaryFile::all();

    //     // * Validate the request data
    //     $validator = Validator::make($request->all(), $this->rules($ticket->id)); // Pass the current ticket id to the rules method

    //     // * Check if the ticket number already exists
    //     $existingTicket = Ticket::where('number', $request->input('number'))->where('id', '!=', $ticket->id)->exists();

    //     if ($existingTicket) {
    //         // * Ticket number is already taken, redirect back with error message
    //         return redirect()->back()->withErrors(['number' => 'Ticket number is already taken'])->withInput();
    //     }

    //     if ($validator->fails()) {
    //         // * Delete temporary files
    //         foreach ($temporaryFiles as $temporaryFile) {
    //             Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
    //             $temporaryFile->delete();
    //         }

    //         // * Redirect back with input and errors
    //         return redirect()->back()->withInput()->withErrors($validator);
    //     }

    //     $validatedData = $validator->validated();

    //     $changes = $this->getTicketChanges($ticket, $validatedData);
    //     foreach ($changes as $field => $change) {
    //         // Log the changes to a custom table
    //         DB::table('ticket_changes')->insert([
    //             'ticket_id' => $ticket->id,
    //             'user_id' => Auth::id(),
    //             'field' => $field,
    //             'previous_value' => $change['old'], // Previous value
    //             'new_value' => $change['new'],
    //             'created_at' => now(), // Or the appropriate timestamp
    //             'updated_at' => now(), // Or the appropriate timestamp
    //         ]);
    //     }

    //     if ($temporaryFiles->isNotEmpty()) {
    //         // * Store temporary files
    //         foreach ($temporaryFiles as $temporaryFile) {
    //             Storage::copy(
    //                 'attached_files/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->file_name,
    //                 'attached_files/' . $temporaryFile->folder . '/' . $temporaryFile->file_name
    //             );
    //             File::create([
    //                 'ticket_id' => $ticket->id,
    //                 'file_name' => $temporaryFile->file_name,
    //                 'file_path' => $temporaryFile->folder . '/' . $temporaryFile->file_name,
    //             ]);
    //             Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
    //             $temporaryFile->delete();
    //         }
    //     }

    //     $ticket->update($validatedData);

    //     Session::flash('update-ticket-success', 'Incident was updated successfully!');

    //     // return redirect('/tickets');
    //     // return redirect()->back();
    //     return redirect()->route('tickets.show', ['ticket' => $ticket->number]);
    // }
    public function update(Request $request, $ticket)
    {
        $ticket = Ticket::where('number', $ticket)->firstOrFail();
        // Retrieve all temporary files
        $temporaryFiles = TemporaryFile::all();
    
        // Validate the request data
        $validator = Validator::make($request->all(), $this->rules($ticket->id));
    
        // Check if the ticket number already exists
        $existingTicket = Ticket::where('number', $request->input('number'))->where('id', '!=', $ticket->id)->exists();
    
        if ($existingTicket) {
            // Ticket number is already taken, redirect back with error message
            return redirect()->back()->withErrors(['number' => 'Ticket number is already taken'])->withInput();
        }
    
        if ($validator->fails()) {
            // Delete temporary files
            foreach ($temporaryFiles as $temporaryFile) {
                Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
                $temporaryFile->delete();
            }
    
            // Redirect back with input and errors
            return redirect()->back()->withInput()->withErrors($validator);
        }
    
        $validatedData = $validator->validated();
    
        $changes = $this->getTicketChanges($ticket, $validatedData);
        foreach ($changes as $field => $change) {
            // Log the changes to a custom table
            DB::table('ticket_changes')->insert([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'field' => $field,
                'previous_value' => $change['old'], // Previous value
                'new_value' => $change['new'],
                'created_at' => now(), // Or the appropriate timestamp
                'updated_at' => now(), // Or the appropriate timestamp
            ]);
        }
    
        if ($temporaryFiles->isNotEmpty()) {
            // Store temporary files
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
    
                // Log file addition
                TicketChange::createWithFileChange(
                    $ticket->id, 
                    Auth::id(), 
                    'files', 
                    null, 
                    $temporaryFile->file_name, 
                    true, 
                    false, 
                    $temporaryFile->file_name, 
                    $temporaryFile->folder . '/' . $temporaryFile->file_name
                );
    
                Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
                $temporaryFile->delete();
            }
        }
    
        $ticket->update($validatedData);
    
        Session::flash('update-ticket-success', 'Incident was updated successfully!');
    
        // return redirect('/tickets');
        // return redirect()->back();
        return redirect()->route('tickets.show', ['ticket' => $ticket->number]);
    }

    /**
     * Get changes in ticket fields.
     */
    private function getTicketChanges($ticket, $newData)
    {
        $changes = [];
    
        if ($ticket->number != $newData['number']) {
            $changes['number'] = ['old' => $ticket->number, 'new' => $newData['number']];
        }

        if ($ticket->status_id != $newData['status_id']) {
            $newStatus = Status::findOrFail($newData['status_id']);
            $changes['status'] = ['old' => $ticket->status->name, 'new' => $newStatus->name];
        }
    
        if ($ticket->date_received != $newData['date_received']) {
            $changes['date_received'] = ['old' => $ticket->date_received, 'new' => $newData['date_received']];
        }
    
        if ($ticket->title != $newData['title']) {
            $changes['title'] = ['old' => $ticket->title, 'new' => $newData['title']];
        }

        $previousIssue = $this->removeTrixContent($ticket->issue);
        $newIssue = $this->removeTrixContent($newData['issue']);

        if ($previousIssue !== $newIssue) {
            $changes['issue'] = ['old' => $previousIssue, 'new' => $newIssue];
        }

        if ($ticket->files) {
            // Retrieve the IDs of the files associated with the ticket
            $oldFileIds = $ticket->files->pluck('id')->toArray();
            $newFileIds = $newData['files'];
    
            if ($oldFileIds !== $newFileIds) {
                // Retrieve the names of the old files
                $oldFiles = $ticket->files->pluck('name')->toArray();
    
                // Retrieve the names of the new files (assuming they are passed in $newData)
                $newFiles = File::whereIn('id', $newFileIds)->pluck('name')->toArray();
    
                $changes['files'] = ['old' => $oldFiles, 'new' => $newFiles];
            }
        } else {
            // If no files are associated with the ticket, consider it as a change
            if (!empty($newData['files'])) {
                $changes['files'] = ['old' => [], 'new' => $newData['files']];
            }
        }
    
        if ($ticket->requested_by != $newData['requested_by']) {
            $changes['requested_by'] = ['old' => $ticket->requested_by, 'new' => $newData['requested_by']];
        }
    
        if ($ticket->client != $newData['client']) {
            $changes['client'] = ['old' => $ticket->client, 'new' => $newData['client']];
        }
    
        if ($ticket->product != $newData['product']) {
            $changes['product'] = ['old' => $ticket->product, 'new' => $newData['product']];
        }

        return $changes;
    }
    
    private function removeTrixContent($html)
    {
        // Load the HTML string into a DOMDocument
        $doc = new DOMDocument();
        $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Create a DOMXPath instance to query the DOM
        $xpath = new DOMXPath($doc);

        // Find all div elements with the class 'trix-content'
        $trixDivs = $xpath->query("//div[contains(@class, 'trix-content')]");

        // Remove each found div element while preserving its children
        foreach ($trixDivs as $trixDiv) {
            // Move all children of the trix div to its parent
            while ($trixDiv->firstChild) {
                $trixDiv->parentNode->insertBefore($trixDiv->firstChild, $trixDiv);
            }
            // Remove the trix div itself
            $trixDiv->parentNode->removeChild($trixDiv);
        }

        // Find all comments matching the specified content
        $comments = $xpath->query("//comment()[contains(.,'[if BLOCK]><![endif]') or contains(.,'[if ENDBLOCK]><![endif]')]");

        // Remove each found comment
        foreach ($comments as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // Remove whitespaces
        $html = preg_replace('/^\s+|\n|\r|\s+$/m', '', $doc->saveHTML());
        // Return the modified HTML
        return $html;
    }


//     private function encapsulateIssue($issue)
//     {
//         // *
// //         $openingDiv = '<div class="trix-content">
// // <!--[if BLOCK]><![endif]-->    ';
// //         $closingDiv = '
// // <!--[if BLOCK]><![endif]-->
// // </div>';
//         $openingDiv = '<div class="trix-content"><!--[if BLOCK]><![endif]-->';
//         $closingDiv = '<!--[if BLOCK]><![endif]--></div>';

//         if (!Str::contains($issue, $openingDiv) && !Str::contains($issue, $closingDiv)) {
//             return $openingDiv . $issue . $closingDiv;
//         }

//         return $issue;
//     }


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
            'status_id' => 'nullable',
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
