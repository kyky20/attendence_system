<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Matakuliah;
use App\Models\Presensi;
use App\Models\QRSession;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $mahasiswaProfile = $user->mahasiswaProfile;

        // Get all active matakuliahs
        $matakuliahs = Matakuliah::where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        // Counting logic: base total on QRSessions (each session = 1 pertemuan)
        // Alpha = QR session exists but no presensi record for this mahasiswa
        $hadirCount = 0;
        $izinCount = 0;
        $absenCount = 0;
        $totalPertemuan = 0;
        $mkProgress = [];

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
                        $hadirCount++;
                    } elseif ($presensi->status === 'izin') {
                        $mkIzin++;
                        $izinCount++;
                    } else {
                        $mkAlpha++;
                        $absenCount++;
                    }
                } else {
                    // No presensi record = Alpha
                    $mkAlpha++;
                    $absenCount++;
                }
                $totalPertemuan++;
            }

            $mkPercentage = $mkTotal > 0 ? round(($mkHadir / $mkTotal) * 100) : 0;

            $mkProgress[] = [
                'nama'  => $mk->nama_matakuliah,
                'hadir' => $mkHadir,
                'izin'  => $mkIzin,
                'alpha' => $mkAlpha,
                'total' => $mkTotal,
                'pct'   => $mkPercentage,
                'color' => $mkPercentage >= 80 ? '#198754' : ($mkPercentage >= 60 ? '#fd7e14' : '#dc3545'),
            ];
        }

        $attendancePercentage = $totalPertemuan > 0
            ? round(($hadirCount / $totalPertemuan) * 100)
            : 0;

        // Get latest izin pengajuan
        $izinData = Izin::where('mahasiswa_id', $user->id)
            ->with('matakuliah')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($i) {
                return [
                    'mk' => $i->matakuliah?->nama_matakuliah ?? $i->kode_matakuliah ?? '-',
                    'tgl' => $i->tanggal ? Carbon::parse($i->tanggal)->format('d M Y') : '-',
                    'jenis' => $i->jenis,
                    'status' => $i->status,
                    'color' => $i->status === 'Disetujui' ? '#198754' : ($i->status === 'Ditolak' ? '#dc3545' : '#fd7e14'),
                ];
            });

        // Get latest presensi history (through qrSession)
        $riwayat = Presensi::where('mahasiswa_id', $user->id)
            ->with('qrSession.matakuliah')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($p) {
                $tanggal = $p->qrSession?->tanggal;
                $tanggalFormatted = $tanggal ? Carbon::parse($tanggal)->format('d M Y') : '-';

                $waktuScan = $p->waktu_scan;
                $waktuFormatted = $waktuScan ? (is_string($waktuScan) ? substr($waktuScan, 11, 5) : $waktuScan->format('H:i')) : '-';

                return [
                    'mk' => $p->qrSession?->matakuliah?->nama_matakuliah ?? '-',
                    'tgl' => $tanggalFormatted,
                    'waktu' => $waktuFormatted,
                    'status' => $p->status,
                    'color' => $p->status === 'hadir' ? '#198754' : ($p->status === 'izin' ? '#fd7e14' : '#dc3545'),
                ];
            });

        return view('mahasiswa.dashboard', [
            'attendancePercentage' => $attendancePercentage,
            'hadirCount' => $hadirCount,
            'izinCount' => $izinCount,
            'absenCount' => $absenCount,
            'totalPresensis' => $totalPertemuan,
            'totalMatakuliah' => $matakuliahs->count(),
            'totalSks' => $matakuliahs->sum('sks'),
            'mkProgress' => $mkProgress,
            'izinData' => $izinData,
            'riwayat' => $riwayat,
            'mahasiswaProfile' => $mahasiswaProfile,
        ]);
    }
    public function apiDashboard()
    {
        $user = Auth::user();
        $mahasiswaProfile = $user->mahasiswaProfile;

        $matakuliahs = Matakuliah::where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        // Same QRSession-based logic as index()
        $hadirCount = 0;
        $izinCount = 0;
        $absenCount = 0;
        $totalPertemuan = 0;
        $mkProgress = [];

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
                    if ($presensi->status === 'hadir') {
                        $mkHadir++;
                        $hadirCount++;
                    } elseif ($presensi->status === 'izin') {
                        $mkIzin++;
                        $izinCount++;
                    } else {
                        $mkAlpha++;
                        $absenCount++;
                    }
                } else {
                    $mkAlpha++;
                    $absenCount++;
                }
                $totalPertemuan++;
            }

            $mkPercentage = $mkTotal > 0 ? round(($mkHadir / $mkTotal) * 100) : 0;

            $mkProgress[] = [
                'nama'  => $mk->nama_matakuliah,
                'hadir' => $mkHadir,
                'izin'  => $mkIzin,
                'alpha' => $mkAlpha,
                'total' => $mkTotal,
                'pct'   => $mkPercentage,
                'color' => $mkPercentage >= 80 ? '#198754' : ($mkPercentage >= 60 ? '#fd7e14' : '#dc3545'),
            ];
        }

        $attendancePercentage = $totalPertemuan > 0
            ? round(($hadirCount / $totalPertemuan) * 100)
            : 0;

        $izinData = Izin::where('mahasiswa_id', $user->id)
            ->with('matakuliah')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($i) {
                return [
                    'mk' => $i->matakuliah?->nama_matakuliah ?? '-',
                    'tgl' => $i->tanggal
                        ? Carbon::parse($i->tanggal)->format('d M Y')
                        : '-',
                    'jenis' => $i->jenis,
                    'status' => $i->status,
                    'color' => $i->status === 'Disetujui'
                        ? '#198754'
                        : ($i->status === 'Ditolak' ? '#dc3545' : '#fd7e14'),
                ];
            });

        $riwayat = Presensi::where('mahasiswa_id', $user->id)
            ->with('qrSession.matakuliah')
            ->orderByDesc('waktu_scan')
            ->take(5)
            ->get()
            ->map(function ($p) {

                $tanggal = $p->qrSession?->tanggal;

                return [
                    'mk' => $p->qrSession?->matakuliah?->nama_matakuliah ?? '-',
                    'tgl' => $tanggal
                        ? Carbon::parse($tanggal)->format('d M Y')
                        : '-',
                    'waktu' => $p->waktu_scan,
                    'status' => $p->status,
                    'color' => $p->status === 'hadir'
                        ? '#198754'
                        : ($p->status === 'izin' ? '#fd7e14' : '#dc3545'),
                ];
            });

        return response()->json([
            'attendancePercentage' => $attendancePercentage,
            'hadirCount' => $hadirCount,
            'izinCount' => $izinCount,
            'absenCount' => $absenCount,
            'totalPresensis' => $totalPertemuan,
            'totalMatakuliah' => $matakuliahs->count(),
            'totalSks' => $matakuliahs->sum('sks'),
            'mkProgress' => $mkProgress,
            'izinData' => $izinData,
            'riwayat' => $riwayat,
            'mahasiswa' => [
                'nama' => $user->name,
                'nim' => $mahasiswaProfile?->nim,
            ],
        ]);
    }
}
