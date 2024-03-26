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
        $temporaryFiles = TemporaryFile::all();

        $validator = Validator::make($request->all(), $this->rules(null));

        if ($validator->fails()) {
            foreach ($temporaryFiles as $temporaryFile) {
                Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
                $temporaryFile->delete();
            }

            return redirect()->back()->withInput()->withErrors($validator);
        }

        $existingTicket = Ticket::where('number', $request->input('number'))->exists();

        if ($existingTicket) {
            return redirect()->back()->withErrors(['number' => 'Ticket number is already taken'])->withInput();
        }

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

        Session::flash('create-ticket-success', 'Incident created successfully.');
        return redirect('/tickets');
    }

    public function show($ticket)
    {
        $ticket = Ticket::where('number', $ticket)->firstOrFail();
        $files = File::where('ticket_id', $ticket->id)->get();
        $notes = $ticket->notes()->latest()->with('user')->paginate(10);

        $previousStatus = session('previousStatus');
        $newStatus = session('newStatus');

        return view('livewire.pages.ticket.show', [
            'ticket' => $ticket,
            'notes' => $notes,
            'previousStatus' => $previousStatus,
            'newStatus' => $newStatus,
            'files' => $files,
        ]);
    }

    public function edit($ticket)
    {
        $ticket = Ticket::where('number', $ticket)->firstOrFail();
        $files = File::where('ticket_id', $ticket->id)->get();

        return view('livewire.pages.ticket.edit', [
            'ticket' => $ticket,
            'files' => $files,
        ]);
    }

    public function update(Request $request, $ticket)
    {
        $ticket = Ticket::where('number', $ticket)->firstOrFail();
        $temporaryFiles = TemporaryFile::all();
    
        $validator = Validator::make($request->all(), $this->rules($ticket->id));
    
        $existingTicket = Ticket::where('number', $request->input('number'))->where('id', '!=', $ticket->id)->exists();
    
        if ($existingTicket) {
            return redirect()->back()->withErrors(['number' => 'Ticket number is already taken'])->withInput();
        }
    
        if ($validator->fails()) {
            foreach ($temporaryFiles as $temporaryFile) {
                Storage::deleteDirectory('attached_files/tmp/' . $temporaryFile->folder);
                $temporaryFile->delete();
            }
    
            return redirect()->back()->withInput()->withErrors($validator);
        }
    
        $validatedData = $validator->validated();
    
        $changes = $this->getTicketChanges($ticket, $validatedData);
        foreach ($changes as $field => $change) {
            DB::table('ticket_changes')->insert([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'field' => $field,
                'previous_value' => $change['old'],
                'new_value' => $change['new'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        if ($temporaryFiles->isNotEmpty()) {
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
            $oldFileIds = $ticket->files->pluck('id')->toArray();
            $newFileIds = $newData['files'];
    
            if ($oldFileIds !== $newFileIds) {
                $oldFiles = $ticket->files->pluck('name')->toArray();
    
                $newFiles = File::whereIn('id', $newFileIds)->pluck('name')->toArray();
    
                $changes['files'] = ['old' => $oldFiles, 'new' => $newFiles];
            }
        } else {
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
        $doc = new DOMDocument();
        $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXPath($doc);

        $trixDivs = $xpath->query("//div[contains(@class, 'trix-content')]");

        foreach ($trixDivs as $trixDiv) {
            while ($trixDiv->firstChild) {
                $trixDiv->parentNode->insertBefore($trixDiv->firstChild, $trixDiv);
            }
            $trixDiv->parentNode->removeChild($trixDiv);
        }

        $comments = $xpath->query("//comment()[contains(.,'[if BLOCK]><![endif]') or contains(.,'[if ENDBLOCK]><![endif]')]");

        foreach ($comments as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        $html = preg_replace('/^\s+|\n|\r|\s+$/m', '', $doc->saveHTML());
        return $html;
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

    protected function setUserId(array &$validatedData)
    {
        $validatedData['user_id'] = auth()->id();
    }

    protected function setStatusId(array &$validatedData, $statusId)
    {
        if (!isset($validatedData['status_id'])) {
            $validatedData['status_id'] = $statusId;
        }
    }

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
        ];
    }

}
