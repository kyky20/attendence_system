<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class PresensiController extends Controller
{
     public function qr()
    {
        $token = Str::random(10);
        $url = url('/absen?token=' . $token);

        $qr = QrCode::size(300)->generate($url);

        return view('Presensi.qr', compact('qr'));
    }

    public function form(Request $request)
    {
        return view('Presensi.absen', [
            'token' => $request->token
        ]);
    }

    public function store(Request $request)
    {
        DB::table('presensis')->insert([
            'user_id' => $request->nama ?? 'guest',
            'waktu' => now(),
            'token' => $request->token
        ]);

        return view('Presensi.sukses');
    }
}
