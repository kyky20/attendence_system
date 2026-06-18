<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Presensi;
use App\Models\QRSession;
use App\Models\Matakuliah;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $mahasiswa = $user->mahasiswaProfile;

        // Get all active matakuliahs (same as dashboard)
        $matakuliahs = Matakuliah::where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        // Counting logic: base total on QRSessions (each session = 1 pertemuan)
        // Alpha = QR session exists but no presensi record for this mahasiswa
        $totalHadir = 0;
        $totalIzin = 0;
        $totalAlpha = 0;
        $totalPertemuan = 0;
        $courseBreakdown = [];

        // Total SKS (same as dashboard)
        $totalSks = $matakuliahs->sum('sks');

        foreach ($matakuliahs as $mk) {
            // Get all QR sessions for this matakuliah
            $mkSessions = QRSession::where('matakuliah_id', $mk->id)->get();
            $mkTotal = $mkSessions->count();

            if ($mkTotal === 0) continue;

            $mkHadir = 0;
            $mkIzin = 0;
            $mkAlpha = 0;

            foreach ($mkSessions as $session) {
                $presensi = Presensi::where('qr_session_id', $session->id)
                    ->where('mahasiswa_id', $user->id)
                    ->first();

                if ($presensi) {
                    if ($presensi->status === 'hadir') {
                        $mkHadir++;
                        $totalHadir++;
                    } elseif ($presensi->status === 'izin') {
                        $mkIzin++;
                        $totalIzin++;
                    } else {
                        $mkAlpha++;
                        $totalAlpha++;
                    }
                } else {
                    // No presensi record = Alpha
                    $mkAlpha++;
                    $totalAlpha++;
                }
                $totalPertemuan++;
            }

            $mkPercentage = $mkTotal > 0 ? round(($mkHadir / $mkTotal) * 100) : 0;

            $courseBreakdown[] = [
                'nama'  => $mk->nama_matakuliah,
                'hadir' => $mkHadir,
                'izin'  => $mkIzin,
                'alpha' => $mkAlpha,
                'total' => $mkTotal,
                'pct'   => $mkPercentage,
                'color' => $mkPercentage >= 80 ? '#198754' : ($mkPercentage >= 60 ? '#fd7e14' : '#dc3545'),
            ];
        }

        $persentaseKehadiran = $totalPertemuan > 0
            ? round(($totalHadir / $totalPertemuan) * 100)
            : 0;

        return view('mahasiswa.profile', compact(
            'mahasiswa',
            'totalHadir',
            'totalIzin',
            'totalAlpha',
            'totalPertemuan',
            'persentaseKehadiran',
            'courseBreakdown',
            'totalSks'
        ));
    }

    /**
     * Web: Update profile (nama, no_hp, alamat).
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'no_hp'   => 'nullable|string|max:20',
            'alamat'  => 'nullable|string|max:500',
        ]);

        $user->update([
            'name'    => $validated['name'],
            'address' => $validated['alamat'] ?? $user->address,
        ]);

        if ($mahasiswa = $user->mahasiswaProfile) {
            $mahasiswa->update([
                'nama'  => $validated['name'],
                'no_hp' => $validated['no_hp'] ?? $mahasiswa->no_hp,
            ]);
        }

        return redirect()->route('mahasiswa.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Web: Update password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'password_lama'      => ['required', 'string'],
            'password_baru'      => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($validated['password_lama'], $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak cocok.']);
        }

        $user->update([
            'password' => Hash::make($validated['password_baru']),
        ]);

        return redirect()->route('mahasiswa.profile')->with('success', 'Password berhasil diubah.');
    }

    /**
     * API: Get profile data for Android.
     */
    public function apiShow(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $mahasiswa = $user->mahasiswaProfile;

        // Attendance stats (same QRSession-based logic)
        $matakuliahs = Matakuliah::where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        $totalHadir = 0;
        $totalIzin = 0;
        $totalAlpha = 0;
        $totalPertemuan = 0;
        $courseBreakdown = [];

        foreach ($matakuliahs as $mk) {
            $mkSessions = QRSession::where('matakuliah_id', $mk->id)->get();
            $mkTotal = $mkSessions->count();

            if ($mkTotal === 0) continue;

            $mkHadir = 0;
            $mkIzin = 0;
            $mkAlpha = 0;

            foreach ($mkSessions as $session) {
                $presensi = Presensi::where('qr_session_id', $session->id)
                    ->where('mahasiswa_id', $user->id)
                    ->first();

                if ($presensi) {
                    if ($presensi->status === 'hadir') { $mkHadir++; $totalHadir++; }
                    elseif ($presensi->status === 'izin') { $mkIzin++; $totalIzin++; }
                    else { $mkAlpha++; $totalAlpha++; }
                } else {
                    $mkAlpha++; $totalAlpha++;
                }
                $totalPertemuan++;
            }

            $mkPercentage = $mkTotal > 0 ? round(($mkHadir / $mkTotal) * 100) : 0;

            $courseBreakdown[] = [
                'nama'  => $mk->nama_matakuliah,
                'hadir' => $mkHadir,
                'izin'  => $mkIzin,
                'alpha' => $mkAlpha,
                'total' => $mkTotal,
                'pct'   => $mkPercentage,
                'color' => $mkPercentage >= 80 ? '#198754' : ($mkPercentage >= 60 ? '#fd7e14' : '#dc3545'),
            ];
        }

        $persentaseKehadiran = $totalPertemuan > 0
            ? round(($totalHadir / $totalPertemuan) * 100)
            : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'name'       => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone,
                'address'    => $user->address,
                'nim'        => $mahasiswa?->nim,
                'nama'       => $mahasiswa?->nama,
                'jurusan'    => $mahasiswa?->jurusan,
                'angkatan'   => $mahasiswa?->angkatan,
                'no_hp'      => $mahasiswa?->no_hp,
                'status'     => $mahasiswa?->status,
                'totalSks'   => $matakuliahs->sum('sks'),
                'attendance' => [
                    'persentase'  => $persentaseKehadiran,
                    'totalHadir'  => $totalHadir,
                    'totalIzin'   => $totalIzin,
                    'totalAlpha'  => $totalAlpha,
                    'totalPertemuan' => $totalPertemuan,
                    'courseBreakdown' => $courseBreakdown,
                ],
            ],
        ]);
    }

    public function apiUpdate(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'nullable|string|max:500',
            'jurusan'   => 'nullable|string|max:100',
            'angkatan'  => 'nullable|string|max:4',
            'no_hp'     => 'nullable|string|max:20',
        ]);

        // Update user table
        $user->update([
            'name'    => $validated['name'],
            'address' => $validated['address'] ?? $user->address,
        ]);

        // Update mahasiswa profile if exists
        if ($mahasiswa = $user->mahasiswaProfile) {
            $mahasiswa->update([
                'nama'     => $validated['name'],
                'jurusan'  => $validated['jurusan'] ?? $mahasiswa->jurusan,
                'angkatan' => $validated['angkatan'] ?? $mahasiswa->angkatan,
                'no_hp'    => $validated['no_hp'] ?? $mahasiswa->no_hp,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => [
                'name'     => $user->name,
                'address'  => $user->address,
                'jurusan'  => $user->mahasiswaProfile?->jurusan,
                'angkatan' => $user->mahasiswaProfile?->angkatan,
                'no_hp'    => $user->mahasiswaProfile?->no_hp,
            ],
        ]);
    }
}
