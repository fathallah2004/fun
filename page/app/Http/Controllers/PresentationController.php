<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PresentationController extends Controller
{
    public function index()
    {
        $folders = Folder::orderBy('order')->get();
        
        return view('presentation.index', compact('folders'));
    }

    public function showFolder($slug)
    {
        $folder = Folder::where('slug', $slug)->with('media')->firstOrFail();
        
        return view('presentation.folder', compact('folder'));
    }

    public function signedMedia($id)
    {
        $media = \App\Models\Media::findOrFail($id);
        
        $path = storage_path('app/public/' . $media->path);
        
        if (!file_exists($path)) {
            // Fallback to public directory if file not in storage
            $publicPath = public_path($media->path);
            if (file_exists($publicPath)) {
                return response()->file($publicPath);
            }
            abort(404);
        }

        return response()->file($path);
    }

    public function gallery()
    {
        $folders = Folder::with('media')->orderBy('order')->get();
        
        return view('presentation.gallery', compact('folders'));
    }
}
