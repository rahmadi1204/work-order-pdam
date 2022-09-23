<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Whatsapp;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function index()
    {
        $title = 'Whatsapp';
        $data = Whatsapp::first();
        if (substr($data->phone, 0, 2) == '62') {
            $phone = '0' . substr($data->phone, 2);
        } else {
            $phone = $data->phone;
        }
        return view('pages.admin.whatsapp', compact([
            'title',
            'data',
            'phone',
        ]));
    }
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'phone' => 'required',
            'url_server' => 'required',
        ]);
        try {
            $data = Whatsapp::findOrFail($id);
            $request->phone = str_replace(array('(', ')', '-', ' ', '_'), '', $request->phone);
            if (substr($request->phone, 0, 1) == '0') {
                $phone = '62' . substr($request->phone, 1);
            } elseif (substr($request->phone, 0, 2) == '62') {
                $phone = $request->phone;
            } else {
                $phone = $request->phone;
            }
            $data->phone = $phone;
            $data->url_server = $request->url_server;
            $data->save();
            return redirect()->route('whatsapp')->with('success', 'Data berhasil diubah');
        } catch (\Throwable$th) {
            return redirect()->route('whatsapp')->with('error', 'Data gagal diubah : ' . $th->getMessage());
        }
    }
}
