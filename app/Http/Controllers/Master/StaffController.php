<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Data\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    // view halaman karyawan
    public function index()
    {
        $title = 'Data Karyawan';
        $staffs = Staff::with(['category'])->paginate(10);
        return view('pages.master.staff', compact([
            'title',
            'staffs',
        ]));
    }
    // proses cari data karyawan
    public function search(Request $request)
    {
        $title = 'Data Karyawan';
        $staffs = Staff::query();
        // cari berdasarkan nama
        if ($request->has('name')) {
            $staffs->where('nama', 'like', '%' . $request->name . '%');
        }
        // cari berdasarkan kode jabatan
        if ($request->has('category_id')) {
            $staffs->where('category_id', 'like', '%' . $request->category_id . '%');
        }
        // cari berdasarkan nama jabatan
        if ($request->has('jabatan')) {
            $staffs->whereRelation('category', 'jabatan', 'like', '%' . $request->jabatan . '%');
        }
        $staffs = $staffs->paginate(10);
        return view('pages.master.staff', compact([
            'title',
            'staffs',
        ]));
    }
    // proses filter status client
    public function filter(Request $request)
    {
        $title = 'Data Karyawan';
        $staffs = Staff::query();
        if ($request->has('category') && $request->category != 'all') {
            $staffs->whereRelation('category', 'kategori', $request->category);
        }
        $staffs = $staffs->paginate(10);
        return view('pages.master.staff', compact([
            'title',
            'staffs',
        ]));
    }
    public function create()
    {
        $title = 'Tambah Data Karyawan';
        return view('pages.master.staff_create', compact([
            'title',
        ]));
    }
}
