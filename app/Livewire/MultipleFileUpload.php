<?php

namespace App\Livewire;

use App\Models\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class MultipleFileUpload extends Component
{
    use WithFileUploads;

    public $ticketId; // Change $number to $ticketId
    public $files = [];

    // Listen for the custom event and update $ticketId
    protected $listeners = ['ticketIdUpdated'];

    public function ticketIdUpdated($newTicketId)
    {
        $this->ticketId = $newTicketId;
    }

    public function updatedFiles()
    {
        $this->validate([
            'files.*' => 'image|max:1024', // Example validation rules, adjust as needed
        ]);

        foreach ($this->files as $file) {
            $path = $file->store('files'); // Store the file in the 'storage/app/files' directory
            $fileName = $file->getClientOriginalName();
            $fileMimeType = $file->getClientMimeType();

            // Create a new record in the files table
            File::create([
                'file_name' => $fileName,
                'file_path' => $path,
                'file_mime_type' => $fileMimeType,
                'ticket_id' => $this->ticketId,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.multiple-file-upload');
    }

}
