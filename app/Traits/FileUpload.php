<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

trait FileUpload
{

    function uploadFile(UploadedFile $file, string $directory = 'uploads'): string
    {
        // Generate a unique filename
        $filename = 'book-it_' . time() . '.' . $file->getClientOriginalExtension();

        // check if directory exists, if not create it
        if (!is_dir(public_path($directory))) {
            mkdir(public_path($directory), 0755, true);
        }

        $file->move(public_path($directory), $filename);

        return '/' . $directory . '/' . $filename;
    }

    /**
     * Delete a file from the public directory if it exists.
     */
    public function deleteFile(string $filePath): bool
    {
        $fullPath = public_path($filePath);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
            return true;
        }
        return false;
    }
}
