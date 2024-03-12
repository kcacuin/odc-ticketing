<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Ticket;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket, File $file)
    {
        // Delete the file
        $file->delete();

        Session::flash('delete-attached-success', 'Attached file deleted successfully!');

        // Redirect back to the ticket's edit page with the 'files' fragment
        return redirect()->back()->withFragment('files');
    }
}
