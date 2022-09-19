<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function index()
    {
        // view halaman Area
        $title = 'Data Area';
        $areas = Area::paginate(10);
        return view('pages.data.area', compact([
            'title',
            'areas',
        ]));
    }
    public function search(Request $request)
    {
        // proses cari data Area
        $title = 'Data Area';
        $areas = Area::query();
        // cari berdasarkan nama
        if ($request->has('name')) {
            $areas->where('nama_area', 'like', '%' . $request->name . '%')
                ->orWhere('nama_jalan', 'like', '%' . $request->name . '%');
        }
        // cari berdasarkan kode jabatan
        if ($request->has('uuid')) {
            $areas->where('uuid', 'like', '%' . $request->uuid . '%');
        }
        $areas = $areas->paginate(10);
        return view('pages.data.area', compact([
            'title',
            'areas',
        ]));
    }
    public function wilayah(Request $request)
    {
        // menampilkan data wilayah
        $kode_wilayah = Area::select('kode_wilayah')
            ->where('kode_area', $request->kode_area)
            ->groupBy('kode_wilayah')
            ->get();
        return response()->json($kode_wilayah);
    }
    public function get(Request $request)
    {
        // menampilkan data area
        try {
            $data = Area::where('kode_wilayah', $request->kode_wilayah)->get();
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function create()
    {
        // menampilkan form tambah data area
        $title = 'Tambah Data Area';
        $areas = Area::distinct('kode_area')->get(['kode_area', 'nama_area']);
        return view('pages.data.area_form', compact([
            'title',
            'areas',
        ]));
    }
    public function store(Request $request)
    {
        // proses validasi data
        $validated = $request->validate([
            'kode_area' => 'required',
            'kode_wilayah' => 'required',
            'kode_jalan' => 'required | unique:areas',
            'nama_jalan' => 'required',
        ], [
            'kode_area.required' => 'Kode Area tidak boleh kosong',
            'kode_wilayah.required' => 'Kode Wilayah tidak boleh kosong',
            'kode_jalan.required' => 'Kode Jalan tidak boleh kosong',
            'kode_jalan.unique' => 'Kode Jalan sudah ada',
            'nama_jalan.required' => 'Nama Jalan tidak boleh kosong',
        ]);
        // proses simpan data
        DB::beginTransaction();
        try {
            // tambahkan 0 jika kode jalan kurang dari 2 digit
            if ($request->kode_area < 10) {
                $kode_area = '0' . $request->kode_area;
            } else {
                $kode_area = $request->kode_area;
            }
            if ($request->kode_wilayah < 10) {
                $kode_wilayah = '0' . $request->kode_wilayah;
            } else {
                $kode_wilayah = $request->kode_wilayah;
            }
            if ($request->kode_jalan < 10) {
                $kode_jalan = '0' . $request->kode_jalan;
            } else {
                $kode_jalan = $request->kode_jalan;
            }
            $uuid = 'AREA-' . $kode_area . '.' . $kode_wilayah . '.' . $kode_jalan;
            $store = Area::create([
                'uuid' => $uuid,
                'kode_area' => $request->kode_area,
                'nama_area' => $request->nama_area,
                'kode_wilayah' => $request->kode_wilayah,
                'kode_jalan' => $request->kode_jalan,
                'nama_jalan' => $request->nama_jalan,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal disimpan : ' . $th->getMessage());
        }
    }
    public function edit($id)
    {
        // menampilkan form edit data area
        $title = 'Edit Data Area';
        $areas = Area::distinct('kode_area')->get(['kode_area', 'nama_area']);
        $data = Area::where('uuid', $id)->first();
        return view('pages.data.area_form', compact([
            'title',
            'areas',
            'data',
        ]));
    }
    public function update(Request $request)
    {
        // proses validasi data
        $validate = $request->validate([
            'kode_area' => 'required',
            'nama_area' => 'required',
            'kode_wilayah' => 'required',
            'kode_jalan' => 'required | unique:areas,kode_jalan,' . $request->uuid . ',uuid',
            'nama_jalan' => 'required',
        ], [
            'kode_area.required' => 'Kode Area tidak boleh kosong',
            'nama_area.required' => 'Nama Area tidak boleh kosong',
            'kode_wilayah.required' => 'Kode Wilayah tidak boleh kosong',
            'kode_jalan.required' => 'Kode Jalan tidak boleh kosong',
            'kode_jalan.unique' => 'Kode Jalan sudah digunakan',
            'nama_jalan.required' => 'Nama Jalan tidak boleh kosong',
        ]);
        // proses update data
        DB::beginTransaction();
        try {
            // tambahkan 0 jika kode jalan kurang dari 2 digit
            if ($request->kode_area < 10) {
                $kode_area = '0' . $request->kode_area;
            } else {
                $kode_area = $request->kode_area;
            }
            if ($request->kode_wilayah < 10) {
                $kode_wilayah = '0' . $request->kode_wilayah;
            } else {
                $kode_wilayah = $request->kode_wilayah;
            }
            if ($request->kode_jalan < 10) {
                $kode_jalan = '0' . $request->kode_jalan;
            } else {
                $kode_jalan = $request->kode_jalan;
            }
            $uuid = 'AREA-' . $kode_area . '.' . $kode_wilayah . '.' . $kode_jalan;
            //check kode sudah digunakan atau belum
            // $check = WorkOrder::where('area_id', $uuid)->count();
            // if ($check > 0) {
            //     return redirect()->back()->with('error', 'Kode sudah digunakan, data kode tidak dapat diubah');
            // }
            $update = Area::where('uuid', $request->uuid)->update([
                'uuid' => $uuid,
                'kode_area' => $request->kode_area,
                'nama_area' => $request->nama_area,
                'kode_wilayah' => $request->kode_wilayah,
                'kode_jalan' => $request->kode_jalan,
                'nama_jalan' => $request->nama_jalan,
            ]);
            DB::commit();
            return redirect()->route('area.edit', $update->uuid)->with('success', 'Data berhasil diubah');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal diubah : ' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
        // proses hapus data
        DB::beginTransaction();
        try {
            $delete = Area::where('uuid', $id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal dihapus : ' . $th->getMessage());
        }
    }
}
