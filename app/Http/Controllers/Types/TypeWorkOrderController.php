<?php

namespace App\Http\Controllers\Types;

use App\Http\Controllers\Controller;
use App\Models\Data\Staff;
use App\Models\Types\TypeWorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TypeWorkOrderController extends Controller
{
    public function index()
    {
        $title = 'Jenis Work Orders';
        return view('pages.types.work_order_type', compact('title'));
    }
    public function query($request)
    {
        $query = TypeWorkOrder::query();
        if ($request->kode_work_order != null) {
            $query->where('kode_work_order', 'like', '%' . $request->kode_work_order . '%');
        }
        if ($request->jenis_work_order != null) {
            $query->where('jenis_work_order', 'like', '%' . $request->jenis_work_order . '%');
        }
        if ($request->responder != null) {
            $query->where('responder', 'like', '%' . $request->responder . '%');
        }
        return $query;
    }
    public function get(Request $request)
    {
        $data = $this->query($request);
        return DataTables::of($data)
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" name="id[]" value="' . $data->id . '">';
            })
            ->addIndexColumn()
            ->editColumn('tgl_work_order', function ($data) {
                return Carbon::parse($data->tgl_work_order)->format('Y M d');
            })
            ->addColumn('action', function ($data) {
                $action = '<div class="d-flex justify-content-center">';
                $action .= '<a href="' . route('type.work-order.edit', $data->kode_work_order) . '" class="btn btn-info mx-1"><i class="fas fa-pencil-alt"></i>Edit</a>';
                $action .= '<a href="#" onclick="deleteConfirm(' . $data->id . ',`' . $data->jenis_work_order . '`)" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i>Delete</a>';
                $action .= '</div>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function create()
    {
        $title = 'Tambah Jenis Work Order';
        $types = TypeWorkOrder::select('jenis_work_order', 'kode_work_order')->distinct('kode_work_order')->get();
        $staffs = Staff::where('kategori_jabatan', '!=', 'DIREKSI')->select('kategori_jabatan')->distinct('kategori_jabatan')->get();
        return view('pages.types.work_order_type_form', compact([
            'title',
            'types',
            'staffs',
        ]));
    }
    public function store(Request $request)
    {
        // validasi data
        $request->validate([
            'no_work_order' => 'required',
            'kode_work_order' => 'required|unique:type_work_orders',
            'jenis_work_order' => 'required',
            'kategori_jabatan' => 'required',
        ], [
            'no_work_order.required' => 'Nomor Work Order tidak boleh kosong',
            'kode_work_order.required' => 'Kode Work Order tidak boleh kosong',
            'kode_work_order.unique' => 'Kode Work Order sudah ada',
            'jenis_work_order.required' => 'Jenis Work Order tidak boleh kosong',
            'kategori_jabatan.required' => 'Unit Petugas tidak boleh kosong',
        ]);
        DB::beginTransaction();
        try {
            // simpan data
            $data = new TypeWorkOrder();
            $data->no_work_order = $request->no_work_order;
            $data->kode_work_order = $request->kode_work_order;
            $data->jenis_work_order = $request->jenis_work_order;
            $data->pts = $request->pts;
            $data->responder = $request->kategori_jabatan;
            $data->keterangan = $request->keterangan;
            $data->save();
            DB::commit();
            return redirect()->route('type.work-order')->with('success', 'Data berhasil disimpan');
        } catch (\Exception$e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal disimpan ' . $e->getMessage());
        }

    }
    public function edit($id)
    {
        $title = 'Edit Jenis Work Order';
        $types = TypeWorkOrder::select('jenis_work_order', 'kode_work_order')->distinct('kode_work_order')->get();
        $staffs = Staff::where('kategori_jabatan', '!=', 'DIREKSI')->select('kategori_jabatan')->distinct('kategori_jabatan')->get();
        $data = TypeWorkOrder::where('kode_work_order', $id)->firstOrFail();
        return view('pages.types.work_order_type_form', compact([
            'title',
            'types',
            'staffs',
            'data',
        ]));
    }
    public function update(Request $request, $id)
    {
        // validasi data
        $request->validate([
            'no_work_order' => 'required',
            'kode_work_order' => 'required|unique:type_work_orders,uuid,' . $id,
            'jenis_work_order' => 'required',
            'kategori_jabatan' => 'required',
        ], [
            'no_work_order.required' => 'Nomor Work Order tidak boleh kosong',
            'kode_work_order.required' => 'Kode Work Order tidak boleh kosong',
            'kode_work_order.unique' => 'Kode Work Order sudah ada',
            'jenis_work_order.required' => 'Jenis Work Order tidak boleh kosong',
            'kategori_jabatan.required' => 'Unit Petugas tidak boleh kosong',
        ]);
        DB::beginTransaction();
        try {
            // simpan data
            $data = TypeWorkOrder::where('uuid', $id)->firstOrFail();
            $data->no_work_order = $request->no_work_order;
            $data->kode_work_order = $request->kode_work_order;
            $data->jenis_work_order = $request->jenis_work_order;
            $data->pts = $request->pts;
            $data->responder = $request->kategori_jabatan;
            $data->keterangan = $request->keterangan;
            $data->save();
            DB::commit();
            return redirect()->route('type.work-order')->with('success', 'Data berhasil disimpan');
        } catch (\Exception$e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal disimpan ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $data = TypeWorkOrder::find($id);
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
            ]);
        } catch (\Exception$e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal dihapus ' . $e->getMessage(),
            ]);
        }
    }
}
