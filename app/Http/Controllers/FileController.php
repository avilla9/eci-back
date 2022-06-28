<?php

namespace App\Http\Controllers;

use App\Helper\Media;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Upload;

class FileController extends Controller {

    public function index() {
        $files = File::all();

        return view('files.index', [
            'files' => $files
        ]);
    }

    public function store(Request $request) {
        $fileName = auth()->id()
            . '_'
            . time()
            . '.'
            . $request->file->extension();

        $type = $request->file->getClientMimeType();
        $size = $request->file->getSize();
        $request->file->move(public_path('file'), $fileName);
        $path = asset('file/' . strtolower($fileName));

        File::create([
            'title' => $request->get('title'),
            'overview' => $request->get('overview'),
            'user_id' => auth()->id(),
            'media_name' => $fileName,
            'media_type' => $type,
            'media_size' => $size,
            'media_path' => $path,
        ]);

        return back()->with('message', 'Archivo cargado con éxito');

        /* $request->validate([
            'title' => 'required:max:255',
            'overview' => 'required',
        ]);

        if ($file = $request->file('media')) {
            $fileData = $this->uploads($file, 'user/avatar/');
            $media = File::create([
                'title' => $request->get('title'),
                'overview' => $request->get('overview'),
                'media_name' => $fileData['fileName'],
                'media_type' => $fileData['fileType'],
                'media_path' => $fileData['filePath'],
                'media_size' => $fileData['fileSize']
            ]);

            return $media;
        } else {
            return back()->with('message', 'error');
            back()->with('message', 'Your file is submitted Successfully');
        } */


        /* $request->validate([
            'title' => 'required:max:255',
            'overview' => 'required',
        ]);

        auth()->user()->files()->create([
            'title' => $request->get('title'),
            'overview' => $request->get('overview'),
        ]);

        return back()->with('message', 'Your file is submitted Successfully'); */
    }

    public function upload(Request $request) {
        /* $uploadedFile = $request->file('file');
        $filename = time() . $uploadedFile->getClientOriginalName();

        Storage::disk('local')->putFileAs(
            'files/' . $filename,
            $uploadedFile,
            $filename
        );

        $upload = new Upload;
        $upload->filename = $filename;

        $upload->user()->associate(auth()->user());

        $upload->save();

        return response()->json([
            'id' => $upload->id
        ]); */
    }
}
