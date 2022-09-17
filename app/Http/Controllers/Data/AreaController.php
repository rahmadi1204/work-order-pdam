<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    // view halaman Area
    public function index()
    {
        $title = 'Data Area';
        $areas = Area::paginate(10);
        return view('pages.data.area', compact([
            'title',
            'areas',
        ]));
    }
    // proses cari data Area
    public function search(Request $request)
    {
        $title = 'Data Area';
        $areas = Area::query();
        // cari berdasarkan nama
        if ($request->has('name')) {
            $areas->where('nama_area', 'like', '%' . $request->name . '%')
                ->orWhere('nama_kelurahan', 'like', '%' . $request->name . '%')
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
    public function kelurahan(Request $request)
    {
        $kelurahan = Area::select('kode_kelurahan', 'nama_kelurahan')
            ->where('kode_area', $request->kode_area)
            ->groupBy('kode_kelurahan', 'nama_kelurahan')
            ->get();
        return response()->json($kelurahan);
    }
    public function get(Request $request)
    {
        try {
            $data = Area::where('kode_kelurahan', $request->kelurahan)->get();
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
        $title = 'Tambah Data Area';
        $areas = Area::distinct('kode_area')->get(['kode_area', 'nama_area']);
        return view('pages.data.area_form', compact([
            'title',
            'areas',
        ]));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_area' => 'required',
            'kode_kelurahan' => 'required',
            'nama_kelurahan' => 'required',
            'kode_jalan' => 'required',
            'nama_jalan' => 'required',
        ], [
            'kode_area.required' => 'Kode Area tidak boleh kosong',
            'kode_kelurahan.required' => 'Kode Kelurahan tidak boleh kosong',
            'nama_kelurahan.required' => 'Nama Kelurahan tidak boleh kosong',
            'kode_jalan.required' => 'Kode Jalan tidak boleh kosong',
            'nama_jalan.required' => 'Nama Jalan tidak boleh kosong',
        ]);
        DB::beginTransaction();
        try {
            $store = Area::create([
                'uuid' => 'AREA-' . $request->kode_jalan,
                'kode_area' => $request->kode_area,
                'nama_area' => $request->nama_area,
                'kode_kelurahan' => $request->kode_kelurahan,
                'nama_kelurahan' => $request->nama_kelurahan,
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
        $validate = $request->validate([
            'kode_area' => 'required',
            'nama_area' => 'required',
            'kode_kelurahan' => 'required',
            'nama_kelurahan' => 'required',
            'kode_jalan' => 'required | unique:areas,kode_jalan,' . $request->uuid . ',uuid',
            'nama_jalan' => 'required',
        ], [
            'kode_area.required' => 'Kode Area tidak boleh kosong',
            'nama_area.required' => 'Nama Area tidak boleh kosong',
            'kode_kelurahan.required' => 'Kode Kelurahan tidak boleh kosong',
            'nama_kelurahan.required' => 'Nama Kelurahan tidak boleh kosong',
            'kode_jalan.required' => 'Kode Jalan tidak boleh kosong',
            'kode_jalan.unique' => 'Kode Jalan sudah digunakan',
            'nama_jalan.required' => 'Nama Jalan tidak boleh kosong',
        ]);
        DB::beginTransaction();
        try {
            $update = Area::where('uuid', $request->uuid)->update([
                'kode_area' => $request->kode_area,
                'nama_area' => $request->nama_area,
                'kode_kelurahan' => $request->kode_kelurahan,
                'nama_kelurahan' => $request->nama_kelurahan,
                'kode_jalan' => $request->kode_jalan,
                'nama_jalan' => $request->nama_jalan,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal diubah : ' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
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
