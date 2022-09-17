<?php

namespace App\Http\Controllers;

use App\Http\Traits\UploadFile;
use App\Imports\ClientImport;
use App\Imports\StaffImport;
use App\Imports\WilayahImport;
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
    public function client(Request $request)
    {
        try {
            $file = $request->file('file');
            $path = 'files/excel';
            $fileData = $this->uploadStorage($file, $path);
            $filePath = $fileData['path'] . '/' . $fileData['name'];
            $import = Excel::import(new ClientImport, $filePath);
            return response()->json([
                'status' => 'success',
                'message' => 'Import Client ' . $fileData['name'] . ' Success',
            ]);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
            // $event = new ImportEvent('Import  Failed', auth()->user()->id);
        }
    }
    public function staff(Request $request)
    {
        try {
            $file = $request->file('file');
            $path = 'files/excel';
            $fileData = $this->uploadStorage($file, $path);
            $filePath = $fileData['path'] . '/' . $fileData['name'];
            $import = Excel::import(new StaffImport, $filePath);
            return response()->json([
                'status' => 'success',
                'message' => 'Import Staff ' . $fileData['name'] . ' Success',
            ]);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
            // $event = new ImportEvent('Import  Failed', auth()->user()->id);
        }
    }
    public function wilayah(Request $request)
    {
        try {
            $file = $request->file('file');
            $path = 'files/excel';
            $fileData = $this->uploadStorage($file, $path);
            $filePath = $fileData['path'] . '/' . $fileData['name'];
            $import = Excel::import(new WilayahImport, $filePath);
            return response()->json([
                'status' => 'success',
                'message' => 'Import Wilayah ' . $fileData['name'] . ' Success',
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
