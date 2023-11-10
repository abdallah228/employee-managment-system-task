<?php
namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class functions
{
    public static function uploadMedia(UploadedFile $file, $destinationPath = 'media')
    {
        // Generate a unique filename
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($destinationPath, $filename, 'public');
        return $filePath;
    }
}
