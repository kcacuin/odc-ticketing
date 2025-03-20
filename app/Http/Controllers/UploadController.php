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
}

