<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
    public function send(Request $request)
    {
        $validate = $request->validate([
            'receiver' => 'required',
            'message' => 'required',
        ]);
        try {
            $data = Whatsapp::first();
            $request->receiver = str_replace(array('(', ')', '-', ' ', '_'), '', $request->receiver);
            if (substr($request->receiver, 0, 1) == '0') {
                $receiver = '62' . substr($request->receiver, 1);
            } elseif (substr($request->receiver, 0, 2) == '62') {
                $receiver = $request->receiver;
            } else {
                $receiver = $request->receiver;
            }
            $file = $request->file('file');
            // $file = public_path('images/avatar.png');
            $response = Http::attach('file', file_get_contents($file), $file->getClientOriginalName())
            // $response = Http::attach('file', file_get_contents($file), 'avatar.png')
                ->post($data->url_server . '/api/send?from=' . $data->phone, [
                    'receiver' => $receiver,
                    'message' => $request->message,
                ]);
            if (isset($response['success']) && $response['success'] == true) {
                return redirect()->route('whatsapp')->with('success', 'Pesan berhasil dikirim');
            } else {
                return redirect()->route('whatsapp')->with('error', 'Pesan gagal : ' . $response['message']);
            }
        } catch (\Throwable$th) {
            return redirect()->route('whatsapp')->with('error', 'Pesan gagal dikirim : ' . $th->getMessage());
        }
    }
}
