<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Data\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $title = 'User List';
        return view('pages.admin.user', compact('title'));
    }
    public function query($request)
    {
        $query = User::query();
        if ($request->role != null) {
            $query->where('role', 'like', '%' . $request->role . '%');
        }
        if ($request->name != null) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        return $query;
    }
    public function get(Request $request)
    {
        $data = $this->query($request);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $action = '<div class="d-flex justify-content-center">';
                $action .= '<a href="' . route('user.edit', $data->uuid) . '" class="btn btn-info mx-1"><i class="fas fa-pencil-alt"></i>Edit</a>';
                if (auth()->user()->id != $data->id) {
                    $action .= '<a href="#" onclick="deleteConfirm(' . $data->id . ',`' . $data->name . '`)" class="btn btn-danger mx-1" ><i class="fas fa-trash-alt"></i>Delete</a>';
                } else {
                    $action .= '<a href="#" class="btn btn-secondary mx-1 disabled"><i class="fas fa-trash-alt"></i>Delete</a>';
                }
                $action .= '</div>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function create()
    {
        $title = 'Create User';
        $staff = Staff::where('user_id', null)->get();
        $roles = User::distinct()->get(['role']);
        return view('pages.admin.user_form', compact([
            'title',
            'staff',
            'roles',
        ]));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'staff_id' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role tidak boleh kosong',
            'staff_id.required' => 'Staff tidak boleh kosong',
        ]);
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = bcrypt($request->password);
            $user->save();
            DB::commit();
            if ($request->staff_id != null) {
                $staff = Staff::where('uuid', $request->staff_id)->firstOrFail();
                $staff->user_id = $user->uuid;
                $staff->save();
            }
            return redirect()->route('user')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception$e) {
            DB::rollback();
            return redirect()->back()->with('error', 'User gagal ditambahkan : ' . $e->getMessage());
        }
    }
}
