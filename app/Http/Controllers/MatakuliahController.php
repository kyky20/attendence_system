<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MatakuliahController extends Controller
{
    public function dosenIndex()
    {
        $matakuliahs = Matakuliah::withCount(['qrSessions'])
            ->where(function ($query) {
                $query->where('dosen_id', Auth::id())
                    ->orWhereNull('dosen_id');
            })
            ->orderBy('nama_matakuliah')
            ->get();

        return view('dosen.list_matakuliah', compact('matakuliahs'));
    }

    public function mahasiswaIndex()
    {
        $matakuliahs = Matakuliah::with([
                'qrSessions.presensis' => function ($query) {
                    $query->where('mahasiswa_id', Auth::id());
                },
                'dosen',
            ])
            ->where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        return view('mahasiswa.list_matakuliah', compact('matakuliahs'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        Matakuliah::create($validated + [
            'dosen_id' => Auth::id(),
        ]);

        return back()->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function update(Request $request, Matakuliah $matakuliah)
    {
        $validated = $this->validated($request, $matakuliah);

        $matakuliah->update($validated + [
            'dosen_id' => $matakuliah->dosen_id ?? Auth::id(),
        ]);

        return back()->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();

        return back()->with('success', 'Mata kuliah berhasil dihapus.');
    }

    private function validated(Request $request, ?Matakuliah $matakuliah = null): array
    {
        return $request->validate([
            'kode_matakuliah' => [
                'required',
                'string',
                'max:50',
                Rule::unique('matakuliah', 'kode_matakuliah')->ignore($matakuliah?->id),
            ],
            'nama_matakuliah' => ['required', 'string', 'max:255'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'nilai' => ['nullable', 'integer', 'min:0', 'max:100'],
            'jadwal' => ['nullable', 'date_format:H:i'],
            'ruang' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::in(['Aktif', 'Non-Aktif'])],
        ]);
    }
}
