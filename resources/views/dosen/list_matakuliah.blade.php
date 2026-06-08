<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mata Kuliah - Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root { --maroon:#800020; --maroon-dark:#5a0016; --sidebar-w:260px; --gray-bg:#f4f6f9; }
    body { font-family:'Segoe UI', sans-serif; background:var(--gray-bg); }
    .sidebar { position:fixed; inset:0 auto 0 0; width:var(--sidebar-w); background:linear-gradient(180deg,var(--maroon-dark),var(--maroon)); color:#fff; overflow:auto; z-index:1000; }
    .sidebar-brand { padding:1.5rem 1.2rem 1rem; border-bottom:1px solid rgba(255,255,255,.12); }
    .logo-circle { width:48px; height:48px; border-radius:50%; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; margin-bottom:.6rem; }
    .sidebar-user { margin:.8rem 1rem; padding:.75rem; background:rgba(255,255,255,.1); border-radius:10px; display:flex; gap:.75rem; align-items:center; }
    .avatar { width:40px; height:40px; border-radius:50%; background:#ffd700; color:var(--maroon-dark); display:flex; align-items:center; justify-content:center; font-weight:700; }
    .nav-section-title { color:rgba(255,255,255,.45); font-size:.7rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:1rem 1.2rem .3rem; }
    .sidebar-nav a { display:flex; align-items:center; gap:.75rem; padding:.65rem 1.2rem; color:rgba(255,255,255,.75); text-decoration:none; font-size:.9rem; border-radius:0 25px 25px 0; margin:.1rem .8rem .1rem 0; }
    .sidebar-nav a:hover,.sidebar-nav a.active { background:rgba(255,255,255,.18); color:#fff; }
    .sidebar-footer { margin-top:2rem; padding:1rem; border-top:1px solid rgba(255,255,255,.12); }
    .main-content { margin-left:var(--sidebar-w); min-height:100vh; }
    .topbar { background:#fff; padding:.85rem 1.5rem; box-shadow:0 2px 10px rgba(0,0,0,.06); position:sticky; top:0; z-index:900; display:flex; justify-content:space-between; gap:1rem; align-items:center; }
    .page-title { font-weight:700; color:#1a1a2e; }
    .btn-maroon { background:linear-gradient(135deg,var(--maroon-dark),#c0003a); color:#fff; border:0; }
    .btn-maroon:hover { color:#fff; filter:brightness(.95); }
    .mk-card { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.06); border-top:4px solid var(--maroon); height:100%; }
    @media (max-width:991px) { .sidebar { position:static; width:100%; height:auto; } .main-content { margin-left:0; } }
  </style>
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="logo-circle"><i class="bi bi-mortarboard-fill"></i></div>
    <h5 class="mb-0">AMBASEN</h5>
    <small>Sistem Presensi Akademik</small>
  </div>
  <div class="sidebar-user">
    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
    <div>
      <div class="fw-semibold">{{ auth()->user()->name }}</div>
      <small class="text-white-50">{{ ucfirst(auth()->user()->role) }} / {{ auth()->user()->email }}</small>
    </div>
  </div>
  <div class="nav-section-title">Menu Utama</div>
  <nav class="sidebar-nav">
    <a href="/dosen/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a>
    <a href="/dosen/generate_qr"><i class="bi bi-qr-code-scan"></i> Generate QR</a>
    <a href="/dosen/list_mahasiswa"><i class="bi bi-people-fill"></i> Data Mahasiswa</a>
    <a href="/dosen/list_matakuliah" class="active"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
  </nav>
  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-link text-white-50 text-decoration-none p-0"><i class="bi bi-box-arrow-left me-2"></i>Keluar</button>
    </form>
  </div>
</aside>

<main class="main-content">
  <div class="topbar">
    <div>
      <div class="page-title">Mata Kuliah</div>
      <small class="text-muted">Data tersimpan di tabel matakuliah dan dipakai saat generate QR.</small>
    </div>
    <button class="btn btn-maroon rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
      <i class="bi bi-plus-lg me-1"></i>Tambah Mata Kuliah
    </button>
  </div>

  <div class="p-3 p-md-4">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="row g-3 mb-4">
      <div class="col-6 col-md-3"><div class="bg-white rounded-3 shadow-sm p-3 text-center"><div class="h3 mb-0" style="color:var(--maroon);">{{ $matakuliahs->count() }}</div><small class="text-muted">Total MK</small></div></div>
      <div class="col-6 col-md-3"><div class="bg-white rounded-3 shadow-sm p-3 text-center"><div class="h3 mb-0 text-success">{{ $matakuliahs->where('status', 'Aktif')->count() }}</div><small class="text-muted">Aktif</small></div></div>
      <div class="col-6 col-md-3"><div class="bg-white rounded-3 shadow-sm p-3 text-center"><div class="h3 mb-0 text-primary">{{ $matakuliahs->sum('sks') }}</div><small class="text-muted">Total SKS</small></div></div>
      <div class="col-6 col-md-3"><div class="bg-white rounded-3 shadow-sm p-3 text-center"><div class="h3 mb-0 text-warning">{{ $matakuliahs->sum('qr_sessions_count') }}</div><small class="text-muted">Sesi QR</small></div></div>
    </div>

    <div class="row g-3">
      @forelse($matakuliahs as $matakuliah)
        <div class="col-md-6 col-xl-4">
          <div class="mk-card p-3">
            <div class="d-flex justify-content-between gap-2">
              <div>
                <div class="small fw-bold text-uppercase" style="color:var(--maroon);">{{ $matakuliah->kode_matakuliah }}</div>
                <h6 class="fw-bold mb-1">{{ $matakuliah->nama_matakuliah }}</h6>
                <small class="text-muted">Kelas {{ $matakuliah->kelas ?? '-' }}</small>
              </div>
              <span class="badge h-25 {{ $matakuliah->status === 'Aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $matakuliah->status }}</span>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-3">
              <span class="badge text-bg-light"><i class="bi bi-award me-1"></i>{{ $matakuliah->sks }} SKS</span>
              <span class="badge text-bg-light"><i class="bi bi-clock me-1"></i>{{ optional($matakuliah->jadwal)->format('H:i') ?? '-' }}</span>
              <span class="badge text-bg-light"><i class="bi bi-geo-alt me-1"></i>{{ $matakuliah->ruang ?? '-' }}</span>
              <span class="badge text-bg-light"><i class="bi bi-qr-code me-1"></i>{{ $matakuliah->qr_sessions_count }} sesi</span>
            </div>
            <div class="d-flex gap-2 mt-3">
              <button class="btn btn-sm btn-outline-primary flex-fill" data-bs-toggle="modal" data-bs-target="#edit{{ $matakuliah->id }}"><i class="bi bi-pencil me-1"></i>Edit</button>
              <a href="/dosen/generate_qr" class="btn btn-sm btn-outline-dark flex-fill"><i class="bi bi-qr-code me-1"></i>QR</a>
              <form method="POST" action="{{ route('dosen.matakuliah.destroy', $matakuliah) }}" onsubmit="return confirm('Hapus mata kuliah ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="bg-white rounded-3 shadow-sm p-4 text-center text-muted">Belum ada mata kuliah.</div>
        </div>
      @endforelse
    </div>
  </div>
</main>

<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('dosen.matakuliah.store') }}" class="modal-content">
      @csrf
      <div class="modal-header text-white" style="background:var(--maroon);">
        <h5 class="modal-title">Tambah Mata Kuliah</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        @include('dosen.partials.matakuliah_form', ['matakuliah' => null])
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-maroon">Simpan</button>
      </div>
    </form>
  </div>
</div>

@foreach($matakuliahs as $matakuliah)
  <div class="modal fade" id="edit{{ $matakuliah->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <form method="POST" action="{{ route('dosen.matakuliah.update', $matakuliah) }}" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header text-white" style="background:var(--maroon);">
          <h5 class="modal-title">Edit Mata Kuliah</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          @include('dosen.partials.matakuliah_form', ['matakuliah' => $matakuliah])
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-maroon">Simpan</button>
        </div>
      </form>
    </div>
  </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
