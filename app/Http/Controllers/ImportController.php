<?php

namespace App\Http\Controllers;

use App\Http\Traits\UploadFile;
use App\Imports\ClientImport;
use App\Imports\KelurahanImport;
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
            // $path = 'files/excel';
            // $fileData = $this->uploadStorage($file, $path);
            // $filePath = $fileData['path'] . '/' . $fileData['name'];
            $import = Excel::import(new ClientImport, $file);
            return response()->json([
                'status' => 'success',
                'message' => 'Import Client ' . $file->getClientOriginalName() . ' Success',
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
            // $path = 'files/excel';
            // $fileData = $this->uploadStorage($file, $path);
            // $filePath = $fileData['path'] . '/' . $fileData['name'];
            $import = Excel::import(new StaffImport, $file);
            return response()->json([
                'status' => 'success',
                'message' => 'Import Staff ' . $file->getClientOriginalName() . ' Success',
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
            // $path = 'files/excel';
            // $fileData = $this->uploadStorage($file, $path);
            // $filePath = $fileData['path'] . '/' . $fileData['name'];
            $import = Excel::import(new WilayahImport, $file);
            return response()->json([
                'status' => 'success',
                'message' => 'Import Wilayah ' . $file->getClientOriginalName() . ' Success',
            ]);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
            // $event = new ImportEvent('Import  Failed', auth()->user()->id);
        }
    }
    public function kelurahan(Request $request)
    {
        try {
            $file = $request->file('file');
            // $path = 'files/excel';
            // $fileData = $this->uploadStorage($file, $path);
            // $filePath = $fileData['path'] . '/' . $fileData['name'];
            $import = Excel::import(new KelurahanImport, $file);
            return response()->json([
                'status' => 'success',
                'message' => 'Import Kelurahan ' . $file->getClientOriginalName() . ' Success',
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
