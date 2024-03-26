<?php

namespace App\Livewire;

use App\Models\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class MultipleFileUpload extends Component
{
    use WithFileUploads;

    public $ticketId;
    public $files = [];

    protected $listeners = ['ticketIdUpdated'];

    public function ticketIdUpdated($newTicketId)
    {
        $this->ticketId = $newTicketId;
    }

    public function updatedFiles()
    {
        $this->validate([
            'files.*' => 'image|max:1024',
        ]);

        foreach ($this->files as $file) {
            $path = $file->store('files');
            $fileName = $file->getClientOriginalName();
            $fileMimeType = $file->getClientMimeType();

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
