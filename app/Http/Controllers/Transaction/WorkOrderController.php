<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Data\Staff;
use App\Models\Transaction\WorkOrder;
use App\Models\Types\TypeWorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller
{
    public function request()
    {
        $title = 'Request Work Order';
        $type = TypeWorkOrder::all();
        return view('pages.transaction.work_order', compact([
            'title',
            'type',
        ]));
    }
    public function create()
    {
        $title = 'Tambah Data Work Order';
        $types = TypeWorkOrder::all();
        $staff = Staff::where('kategori_jabatan', '!=', 'DIREKSI')->get();
        return view('pages.transaction.work_order_form', compact([
            'title',
            'types',
            'staff',
        ]));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tgl_work_order' => 'required',
            'jenis_work_order' => 'required',
            'staff_id' => 'required',
        ], [
            'tgl_work_order.required' => 'Tanggal Work Order tidak boleh kosong',
            'jenis_work_order.required' => 'Jenis Work Order tidak boleh kosong',
            'staff_id.required' => 'Staff tidak boleh kosong',
        ]
        );
        DB::beginTransaction();
        try {
            $workOrder = new WorkOrder();
            $workOrder->tgl_work_order = Carbon::parse($request->tgl_work_order)->format('Y-m-d');
            $workOrder->type_id = $request->jenis_work_order;
            $workOrder->staff_id = $request->staff_id;
            $workOrder->client_id = $request->client_id;
            $workOrder->document_id = $request->document_id;
            $workOrder->latitude = $request->latitude;
            $workOrder->longitude = $request->longitude;
            $workOrder->google_maps = $request->google_maps;
            $workOrder->deskripsi = $request->deskripsi;
            $workOrder->keterangan = $request->keterangan;
            $workOrder->save();
            DB::commit();
            return redirect()->route('work-order.request')->with('success', 'Data Work Order berhasil ditambahkan');
        } catch (\Exception$e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data Work Order gagal ditambahkan : ' . $e->getMessage());
        }
    }
}
