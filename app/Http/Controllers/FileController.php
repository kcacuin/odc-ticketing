<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Ticket;
use App\Models\TicketChange;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket, File $file)
    {
        $file->delete();

        TicketChange::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'field' => 'files',
            'file_deleted' => true,
            'file_name' => $file->file_name,
            'file_path' => $file->file_path,
        ]);

        Session::flash('delete-attached-success', 'Attached file deleted successfully!');

        return redirect()->back()->withFragment('files');
    }
}
