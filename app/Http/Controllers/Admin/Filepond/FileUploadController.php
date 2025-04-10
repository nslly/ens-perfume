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
        $request->validate([
            'images' => 'required|array', // Keep this as 'images'
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);
    
        $uploadedFiles = [];
        
        foreach ($request->file('images') as $file) {
            $path = $file->store('public/uploads');
            $filename = basename($path);
            
            $uploadedFiles[] = [
                'id' => $filename,
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'type' => $file->getMimeType(),
                'url' => Storage::url($path)
            ];
        }
    
        return response()->json($uploadedFiles);
    }

    public function load(Request $request)
    {
        $filename = $request->query('id');
        $path = storage_path('app/public/uploads/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function delete(Request $request)
    {
        if (!$request->isMethod('delete')) {
            return response()->json(['error' => 'Method Not Allowed'], 405);
        }

        $filename = $request->input('id');
        $path = storage_path('app/public/uploads/' . $filename);

        if (file_exists($path)) {
            unlink($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
