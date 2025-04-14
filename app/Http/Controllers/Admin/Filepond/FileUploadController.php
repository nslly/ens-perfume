<?php

namespace App\Http\Controllers\Admin\Filepond;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('images')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    
        $file = $request->file('images');    
        $path = $file->store('products', 'public');
        $filename = basename($path);
    
        return response()->json([
            'id' => $filename,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
            'url' => Storage::url($path)
        ]);

        
    }

    public function load(Request $request)
    {
        $filename = $request->query('id');
        $path = storage_path('app/public/' . $filename); 

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function delete(Request $request)
    {
        $filename = $request->getContent(); // Get raw content

        $path = storage_path('app/public/' . $filename); 

        if (file_exists($path)) {
            unlink($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
