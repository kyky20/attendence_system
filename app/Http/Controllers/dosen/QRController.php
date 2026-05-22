<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Models\QRSession;

class QRController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'latitude' => 'required',
            'longitude' => 'required'

        ]);

        $token = Str::uuid();

        QRSession::create([

            'dosen_id' => Auth::id(),

            'kode_matakuliah' =>
                $request->kode_matakuliah,

            'pertemuan' =>
                $request->pertemuan,

            'tanggal' =>
                $request->tanggal,

            'waktu_mulai' =>
                $request->waktu_mulai,

            'token' => $token,

            'durasi' =>
                $request->durasi,

            'keterangan' =>
                $request->keterangan,

            'expired_at' =>
                now()->addSeconds($request->durasi),

            'status' => 'aktif',

            // GPS dosen
            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

          

        ]);

        return response()->json([

            'success' => true,

            'url' =>
            'https://outsider-remarry-janitor.ngrok-free.dev/mahasiswa/scan/' . $token

        ]);
    }
}