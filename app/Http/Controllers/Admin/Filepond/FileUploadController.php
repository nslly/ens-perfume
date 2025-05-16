<?php

namespace App\Http\Controllers\Admin\Filepond;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    
        $file = $request->file('image');    
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
        $id = $request->get('id');

        if (str_contains($id, '..')) {
            abort(403, 'Forbidden');
        }

        if (!str_contains($id, '/')) {
            $id = "products/{$id}";
        }

        $path = storage_path("app/public/{$id}");

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path);
    }





    public function delete(Request $request)
    {
        $filename = $request->getContent();

        $path = storage_path('app/public/' . $filename); 

        if (file_exists($path)) {
            unlink($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
