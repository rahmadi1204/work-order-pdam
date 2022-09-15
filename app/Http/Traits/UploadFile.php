<?php
namespace App\Http\Traits;

trait UploadFile
{
    public function uploadPublic($file, $path)
    {
        $fileName = $file->getClientOriginalName();
        $file->storeAs($path, $fileName, 'public');
        $fileData = [
            'name' => $fileName,
            'path' => $path,
            'url' => asset('storage/' . $path . '/' . $fileName),
        ];
        return $fileData;
    }
    public function uploadStorage($file, $path)
    {
        $fileName = $file->getClientOriginalName();
        $file->storeAs($path, $fileName);
        $fileData = [
            'name' => $fileName,
            'path' => $path,
            'url' => asset('storage/' . $path . '/' . $fileName),
        ];
        return $fileData;
    }
}
