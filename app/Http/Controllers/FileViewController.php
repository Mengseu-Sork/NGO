<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileViewController extends Controller
{
    public function viewFile($path)
    {
        // Build full storage path (adjust if your files are elsewhere)
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found.');
        }

        // Get the file mime type
        $mimeType = mime_content_type($fullPath);

        // Return the file to display in browser
        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
        ]);
    }

}
