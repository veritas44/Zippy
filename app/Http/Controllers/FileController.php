<?php

namespace App\Http\Controllers;

use File;
use Zipper;
use Session;
use App\Archive;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request) {
        if ($request->hasFile('file')) {
            $filename = time() . str_random(3) . '.' . $request->file->extension();
            
            $request->file->storeAs('Uploaded_Files/' . Session::get('hash') . '/', $filename);

            return response('WIP', 200);
        }
        return response('Upload failed (is your file too large?)', 500);
    }

    public function zip($hash) {
        $files = storage_path('app/Uploaded_Files/' . $hash);
        
        if (File::exists($files)) {
            Zipper::make('archives/' . $hash . '.zip')->add($files)->close();
            File::deleteDirectory($files);
            $url = $this->generateUrl();
            
            Archive::create([
                'url' => $url,
                'filename' => $hash . '.zip'
            ]);

            return redirect('/' . $url);
        }

        return redirect('/');
    }

    public function downloadPage($url) {
        $file = Archive::where('url', $url)->first();
        if ($file) {
            return view('download', compact('url'));
        }

        return response()->view('errors.404', [], 404);
    }

    public function download($url) {
        $file = Archive::where('url', $url)->firstOrFail();
        return response()->download(public_path('archives/' . $file->filename));
    }

    protected function generateUrl($count = 4) {
        $url = str_random($count);
        if (Archive::where('url', $url)->first()) {
            $this->generateUrl($count++);
        }

        return $url;
    }
}
