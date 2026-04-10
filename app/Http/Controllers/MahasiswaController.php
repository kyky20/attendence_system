<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $data = Mahasiswa::all();
        return view('index', compact('data'));
    }

    public function create()
    {
        $data = Mahasiswa::all();
        return view('create', compact('data'));
    }

    public function store(Request $request)
    {
        Mahasiswa::create($request->all());
        return redirect('/mahasiswa')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Mahasiswa::findOrFail($id);
        return view('edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Mahasiswa::findOrFail($id);
        $data->update($request->all());

        return redirect('/mahasiswa')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = Mahasiswa::findOrFail($id);
        $data->delete();

        return redirect('/mahasiswa')->with('success', 'Data berhasil dihapus');
    }
}
