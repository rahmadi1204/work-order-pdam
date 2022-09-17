<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Traits\UploadFile;
use App\Models\Data\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    //trait upload file
    use UploadFile;
    // view halaman karyawan
    public function index()
    {
        $title = 'Data Karyawan';
        $staffs = Staff::paginate(10);
        return view('pages.data.staff', compact([
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
        if ($request->has('kode_jabatan')) {
            $staffs->where('kode_jabatan', 'like', '%' . $request->kode_jabatan . '%');
        }
        // cari berdasarkan nama jabatan
        if ($request->has('jabatan')) {
            $staffs->where('jabatan', 'like', '%' . $request->jabatan . '%');
        }
        $staffs = $staffs->paginate(10);
        return view('pages.data.staff', compact([
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
        return view('pages.data.staff', compact([
            'title',
            'staffs',
        ]));
    }
    public function create()
    {
        $title = 'Tambah Data Karyawan';
        return view('pages.data.staff_form', compact([
            'title',
        ]));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'kode_jabatan' => 'required',
            'kategori_jabatan' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'kode_jabatan.required' => 'Kode Jabatan tidak boleh kosong',
            'kategori_jabatan.required' => 'Kategori Jabatan tidak boleh kosong',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'File harus berupa gambar dengan format jpeg,png,jpg,gif,svg',
            'image.max' => 'Ukuran file maksimal 2MB',
        ]);
        // dd($request->all());
        DB::beginTransaction();
        try {
            $staff = new Staff();
            $staff->nama = $request->nama;
            $staff->kode_jabatan = $request->kode_jabatan;
            $staff->kategori_jabatan = $request->kategori_jabatan;
            $staff->jabatan = $request->jabatan;
            $staff->nip = $request->nip;
            $staff->ruang = $request->ruang;
            $staff->golongan = $request->golongan;
            $staff->jenjang = $request->jenjang;
            $staff->status = $request->status;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $destinationPath = '/images/staff';
                $fileData = $this->uploadPublic($image, $destinationPath, $staff, 'image');
                $staff->image = $fileData['path'] . '/' . $fileData['file_name'];
            }
            $staff->save();
            DB::commit();
            return redirect()->route('staff')->with('success', 'Data karyawan berhasil ditambahkan');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data karyawan gagal ditambahkan : ' . $th->getMessage());
        }
    }
    public function edit($id)
    {
        $title = 'Edit Data Karyawan';
        $data = Staff::where('uuid', $id)->first();
        return view('pages.data.staff_form', compact([
            'title',
            'data',
        ]));
    }
    public function update(Request $request, $id)
    {
        $validated = request()->validate([
            'nama' => 'required',
            'kode_jabatan' => 'required',
            'kategori_jabatan' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'kode_jabatan.required' => 'Kode Jabatan tidak boleh kosong',
            'kategori_jabatan.required' => 'Kategori Jabatan tidak boleh kosong',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'File harus berupa gambar dengan format jpeg,png,jpg,gif,svg',
            'image.max' => 'Ukuran file maksimal 2MB',
        ]);
        DB::beginTransaction();
        try {
            $staff = Staff::findOrFail($id);
            $staff->nama = $request->nama;
            $staff->kode_jabatan = $request->kode_jabatan;
            $staff->kategori_jabatan = $request->kategori_jabatan;
            $staff->jabatan = $request->jabatan;
            $staff->nip = $request->nip;
            $staff->ruang = $request->ruang;
            $staff->golongan = $request->golongan;
            $staff->jenjang = $request->jenjang;
            $staff->status = $request->status;
            if ($request->hasFile('image')) {
                if ($staff->image != null) {
                    $oldImage = $staff->image;
                    $this->deleteFile($oldImage);
                }
                $image = $request->file('image');
                $destinationPath = '/images/staff';
                $fileData = $this->uploadPublic($image, $destinationPath, $staff, 'image');
                $staff->image = $fileData['path'] . '/' . $fileData['file_name'];
            }
            $staff->save();
            DB::commit();
            return redirect()->route('staff')->with('success', 'Data karyawan berhasil diubah');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data karyawan gagal diubah : ' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $staff = Staff::findOrFail($id);
            if ($staff->image != null) {
                $oldImage = $staff->image;
                $this->deleteFile($oldImage);
            }
            $staff->delete();
            DB::commit();
            return redirect()->route('staff')->with('success', 'Data karyawan berhasil dihapus');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data karyawan gagal dihapus : ' . $th->getMessage());
        }
    }
}
