<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class UploadController extends Controller
{
    public function tmpUpload(Request $request)
    {
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $file_name = $file->getClientOriginalName();
            $folder = uniqid('attached_file', true);
            $file->storeAs('attached_files/tmp/' . $folder, $file_name);

            TemporaryFile::create([
                'folder' => $folder,
                'file_name' => $file_name,
            ]);

            return $folder;
        }
        return '';
    }

    public function tmpDelete(Request $request)
    {
        $temporaryFile = TemporaryFile::where('folder', request()->getContent())->first();
        if ($temporaryFile) {
            Storage::deleteDirectory('attached_files/tmp/'. $temporaryFile->folder);
            $temporaryFile->delete();
        }

        return response()->noContent();
    }

    public function trixAttachmentStore()
    {
        request()->validate([
            'attachment' => ['required', 'file'],
        ]);
        $path = request()->file('attachment')->store('trix-attachements', 'public');
        return [
            'image_url' => Storage::disk('public')->url($path),
        ];
    }

    // public function tmpLoad($folder, $file_name)
    // {
    // $filePath = 'attached_files/tmp/' . $folder . '/' . $file_name;

    // if (Storage::exists($filePath)) {
    //     return response()->file(storage_path('app/' . $filePath));
    // }

    // return response()->json(['error' => 'File not found'], 404);
    // }

    // public function tmpLoad($id)
    // {
    //     // Retrieve the file object from the database or wherever it's stored
    //     $file = File::findOrFail($id);

    //     // Set the file path and name
    //     $filePath = storage_path('app/' . $file->file_path);
    //     $fileName = $file->file_name;

    //     // Check if the file exists
    //     if (!file_exists($filePath)) {
    //         abort(404, 'File not found');
    //     }

    //     // Return the file as a response with the appropriate headers
    //     return Response::download($filePath, $fileName, [
    //         'Content-Disposition' => 'inline; filename="' . $fileName . '"',
    //     ]);
    // }
}

