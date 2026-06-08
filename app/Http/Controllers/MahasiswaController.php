<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function dosenIndex()
    {
        $mahasiswas = Mahasiswa::with('user')
            ->withCount('presensis')
            ->orderBy('nama')
            ->get();

        return view('dosen.list_mahasiswa', compact('mahasiswas'));
    }

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
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:50', 'unique:mahasiswas,nim'],
            'nama' => ['required', 'string', 'max:255'],
            'jurusan' => ['required', 'string', 'max:255'],
            'angkatan' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'unique:mahasiswas,email'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'status' => ['required', Rule::in(['Aktif', 'Cuti', 'Non-Aktif'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'] ?? 'password'),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $validated['nim'],
            'nama' => $validated['nama'],
            'jurusan' => $validated['jurusan'],
            'angkatan' => $validated['angkatan'] ?? null,
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Mahasiswa::findOrFail($id);
        return view('edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:50', Rule::unique('mahasiswas', 'nim')->ignore($mahasiswa->id)],
            'nama' => ['required', 'string', 'max:255'],
            'jurusan' => ['required', 'string', 'max:255'],
            'angkatan' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($mahasiswa->user_id),
                Rule::unique('mahasiswas', 'email')->ignore($mahasiswa->id),
            ],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'status' => ['required', Rule::in(['Aktif', 'Cuti', 'Non-Aktif'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user = $mahasiswa->user;

        if (!$user) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'] ?? 'password'),
                'role' => 'mahasiswa',
            ]);
        } else {
            $user->update([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => filled($validated['password'] ?? null)
                    ? Hash::make($validated['password'])
                    : $user->password,
                'role' => 'mahasiswa',
            ]);
        }

        $mahasiswa->update([
            'user_id' => $user->id,
            'nim' => $validated['nim'],
            'nama' => $validated['nama'],
            'jurusan' => $validated['jurusan'],
            'angkatan' => $validated['angkatan'] ?? null,
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = $mahasiswa->user;

        $mahasiswa->delete();
        $user?->delete();

        return back()->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
