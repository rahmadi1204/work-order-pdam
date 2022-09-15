<?php

namespace App\Http\Controllers;

use App\Http\Traits\UploadFile;
use App\Imports\ClientImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    use UploadFile;
    public function index()
    {
        $title = 'Import Data';
        return view('pages.import', compact('title'));
    }
    public function store(Request $request)
    {
        try {
            $file = $request->file('file');
            $path = 'files/excel';
            $fileData = $this->uploadStorage($file, $path);
            $filePath = $fileData['path'] . '/' . $fileData['name'];
            $import = Excel::import(new ClientImport, $filePath);
            // $event = new ImportEvent('Import ' . $fileData['name'] . ' Success', auth()->user()->id);
            // event($event);
            // $activity = [
            //     'description' => 'Import ' . $fileData['name'],
            // ];
            // $this->activity($activity);
            return response()->json([
                'status' => 'success',
                'message' => 'Import ' . $fileData['name'] . ' Success',
            ]);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
            // $event = new ImportEvent('Import  Failed', auth()->user()->id);
        }
    }
}
