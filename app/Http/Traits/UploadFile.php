<?php
namespace App\Http\Traits;

trait UploadFile
{
    public function uploadPublic($file, $path)
    {
        $fileName = $file->getClientOriginalName();
        $file->storeAs($path, $fileName, 'public');
        $fileData = [
            'file_name' => $fileName,
            'path' => $path,
            'url' => asset($path . '/' . $fileName),
        ];
        return $fileData;
    }
    public function uploadStorage($file, $path)
    {
        $fileName = $file->getClientOriginalName();
        $file->storeAs($path, $fileName);
        $fileData = [
            'file_name' => $fileName,
            'path' => $path,
            'url' => asset('storage/' . $path . '/' . $fileName),
        ];
        return $fileData;
    }
    public function deleteFile($path)
    {
        $path = storage_path('app/public' . $path);
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
