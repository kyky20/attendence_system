<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mata Kuliah – Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <style>
    :root { --maroon: #800020; --maroon-dark: #5a0016; --sidebar-w: 260px; --gray-bg: #f4f6f9; }
    body { font-family: 'Segoe UI', sans-serif; background: var(--gray-bg); }

    /* SIDEBAR */
    .sidebar {
      position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh;
      background: linear-gradient(180deg, var(--maroon-dark) 0%, var(--maroon) 100%);
      display: flex; flex-direction: column; z-index: 1000; transition: transform .3s; overflow-y: auto;
    }
    .sidebar-brand { padding: 1.5rem 1.2rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.12); }
    .sidebar-brand .logo-circle {
      width: 48px; height: 48px; background: rgba(255,255,255,0.15); border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      border: 2px solid rgba(255,255,255,0.3); margin-bottom: .6rem;
    }
    .sidebar-brand .logo-circle i { color: #fff; font-size: 1.4rem; }
    .sidebar-brand h5 { color: #fff; font-weight: 700; letter-spacing: 1.5px; margin: 0; font-size: 1.1rem; }
    .sidebar-brand small { color: rgba(255,255,255,0.6); font-size: 0.75rem; }
    .sidebar-user {
      margin: .8rem 1rem; padding: .75rem; background: rgba(255,255,255,0.1); border-radius: 10px;
      display: flex; align-items: center; gap: .75rem;
    }
    .sidebar-user .avatar {
      width: 40px; height: 40px; border-radius: 50%; background: #ffd700;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: var(--maroon-dark); font-size: 1rem;
    }
    .sidebar-user .info .name { color: #fff; font-size: 0.88rem; font-weight: 600; }
    .sidebar-user .info .role { color: rgba(255,255,255,0.6); font-size: 0.75rem; }
    .nav-section-title {
      color: rgba(255,255,255,0.45); font-size: 0.7rem; font-weight: 700;
      letter-spacing: 1px; text-transform: uppercase; padding: 1rem 1.2rem .3rem;
    }
    .sidebar-nav a {
      display: flex; align-items: center; gap: .75rem; padding: .65rem 1.2rem;
      color: rgba(255,255,255,0.75); text-decoration: none; font-size: 0.9rem;
      border-radius: 0 25px 25px 0; margin: .1rem .8rem .1rem 0; transition: all .2s;
    }
    .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.18); color: #fff; }
    .sidebar-nav a.active { font-weight: 600; }
    .sidebar-nav a i { font-size: 1rem; width: 22px; }
    .sidebar-footer { margin-top: auto; padding: 1rem; border-top: 1px solid rgba(255,255,255,0.12); }
    .sidebar-footer a {
      display: flex; align-items: center; gap: .6rem; color: rgba(255,255,255,0.7);
      text-decoration: none; font-size: 0.88rem; padding: .5rem .8rem; border-radius: 8px; transition: background .2s;
    }
    .sidebar-footer a:hover { background: rgba(255,255,255,0.1); color: #fff; }
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 999; }
    .main-content { margin-left: var(--sidebar-w); min-height: 100vh; transition: margin .3s; }
    .topbar {
      background: #fff; padding: .85rem 1.5rem;
      display: flex; align-items: center; justify-content: space-between;
      box-shadow: 0 2px 10px rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 999;
    }
    .topbar .page-title { font-weight: 700; font-size: 1.1rem; color: #1a1a2e; }
    .topbar .breadcrumb { font-size: 0.78rem; margin: 0; }
    .btn-toggle { display: none; background: none; border: none; font-size: 1.4rem; color: #555; }
    .btn-add {
      background: linear-gradient(135deg, var(--maroon-dark), #c0003a);
      color: #fff; border: none; border-radius: 25px;
      padding: .45rem 1.2rem; font-size: 0.88rem; font-weight: 600; cursor: pointer;
      display: flex; align-items: center; gap: .4rem; transition: transform .15s, box-shadow .15s;
    }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(128,0,32,0.3); }

    /* MK Card Grid */
    .mk-card {
      background: #fff; border-radius: 14px; padding: 1.4rem;
      box-shadow: 0 2px 12px rgba(0,0,0,0.07); height: 100%;
      border-top: 4px solid transparent;
      transition: transform .2s, box-shadow .2s;
      position: relative; overflow: hidden;
    }
    .mk-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .mk-card::before {
      content: '';
      position: absolute; top: -20px; right: -20px;
      width: 80px; height: 80px; border-radius: 50%;
      opacity: .07;
    }
    .mk-icon {
      width: 50px; height: 50px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem; margin-bottom: 1rem;
    }
    .mk-code { font-size: 0.72rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
    .mk-name { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin-bottom: .3rem; line-height: 1.3; }
    .mk-kelas { font-size: 0.8rem; color: #888; }
    .mk-meta { display: flex; gap: .5rem; flex-wrap: wrap; margin-top: .8rem; }
    .mk-meta .tag {
      font-size: 0.75rem; padding: .2rem .65rem; border-radius: 20px;
      background: var(--gray-bg); color: #555;
      display: flex; align-items: center; gap: .3rem;
    }
    .mk-actions { display: flex; gap: .5rem; margin-top: 1rem; }
    .btn-mk-action {
      flex: 1; padding: .4rem; border-radius: 8px; border: none;
      font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: all .15s;
    }
    .btn-mk-edit   { background: rgba(13,110,253,0.1); color: #0d6efd; }
    .btn-mk-delete { background: rgba(220,53,69,0.1);  color: #dc3545; }
    .btn-mk-qr     { background: rgba(128,0,32,0.1);   color: var(--maroon); }
    .btn-mk-edit:hover   { background: #0d6efd; color: #fff; }
    .btn-mk-delete:hover { background: #dc3545; color: #fff; }
    .btn-mk-qr:hover     { background: var(--maroon); color: #fff; }

    /* MODAL */
    .modal-header { background: linear-gradient(135deg, var(--maroon-dark), var(--maroon)); color: #fff; border: none; }
    .modal-header .btn-close { filter: invert(1); }
    .form-label { font-weight: 600; font-size: 0.83rem; color: #444; }
    .form-control, .form-select {
      border-radius: 8px; border: 1.5px solid #e0e0e0; font-size: 0.9rem; padding: .55rem .9rem;
    }
    .form-control:focus, .form-select:focus { border-color: var(--maroon); box-shadow: 0 0 0 3px rgba(128,0,32,0.12); }
    .btn-save { background: linear-gradient(135deg, var(--maroon-dark), #c0003a); color: #fff; border: none; border-radius: 8px; padding: .55rem 1.5rem; font-weight: 600; }
    .toast-container { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999; }

    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .sidebar-overlay.show { display: block; }
      .main-content { margin-left: 0; }
      .btn-toggle { display: block; }
    }
  </style>
</head>
<body>

<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="logo-circle"><i class="bi bi-mortarboard-fill"></i></div>
    <h5>AMBASEN</h5>
    <small>Sistem Presensi Akademik</small>
  </div>
  <div class="sidebar-user">
    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
    <div class="info">
      <div class="name">{{ auth()->user()->name }}</div>
      <div class="role">{{ ucfirst(auth()->user()->role) }} / {{ auth()->user()->email }}</div>
    </div>
  </div>
  <div class="nav-section-title">Menu Utama</div>
  <nav class="sidebar-nav">
    <a href="{{ url('/' . request()->segment(1) . '/dashboard') }}"><i class="bi bi-grid-fill"></i> Dashboard</a>
    <a href="{{ url('/' . request()->segment(1) . '/generate_qr') }}"><i class="bi bi-qr-code-scan"></i> Generate QR</a>
    <a href="{{ url('/' . request()->segment(1) . '/list_mahasiswa') }}"><i class="bi bi-people-fill"></i> Data Mahasiswa</a>
    <a href="{{ url('/' . request()->segment(1) . '/list_matakuliah') }}" class="active"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
  </nav>
  <div class="nav-section-title">Lainnya</div>
  <nav class="sidebar-nav">
    <a href="{{ url('/' . request()->segment(1) . '/profile') }}"><i class="bi bi-person-circle"></i> Profil</a>
    <a href="#"><i class="bi bi-gear-fill"></i> Pengaturan</a>
  </nav>
  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100"><input type="hidden" name="_token" value="{{ csrf_token() }}"><a href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="bi bi-box-arrow-left"></i> Keluar</a></form>
  </div>
</aside>

<div class="main-content">
  <div class="topbar">
    <div class="d-flex align-items-center gap-3">
      <button class="btn-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
      <div>
        <div class="page-title">Mata Kuliah</div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/' . request()->segment(1) . '/dashboard') }}" style="color:var(--maroon);">Dashboard</a></li>
            <li class="breadcrumb-item active">Mata Kuliah</li>
          </ol>
        </nav>
      </div>
    </div>
    <button class="btn-add" onclick="openAddModal()">
      <i class="bi bi-plus-lg"></i> Tambah Mata Kuliah
    </button>
  </div>

  <div class="p-3 p-md-4">

    <!-- Summary -->
    <div class="row g-3 mb-4">
      <div class="col-6 col-md-3">
        <div class="p-3 bg-white rounded-3 shadow-sm text-center">
          <div style="font-size:1.8rem;font-weight:700;color:var(--maroon);" id="cntTotal">0</div>
          <div style="font-size:.78rem;color:#888;">Total Mata Kuliah</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 bg-white rounded-3 shadow-sm text-center">
          <div style="font-size:1.8rem;font-weight:700;color:#198754;" id="cntAktif">0</div>
          <div style="font-size:.78rem;color:#888;">Aktif Semester Ini</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 bg-white rounded-3 shadow-sm text-center">
          <div style="font-size:1.8rem;font-weight:700;color:#0d6efd;" id="cntSks">0</div>
          <div style="font-size:.78rem;color:#888;">Total SKS Diampu</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 bg-white rounded-3 shadow-sm text-center">
          <div style="font-size:1.8rem;font-weight:700;color:#fd7e14;" id="cntMhs">0</div>
          <div style="font-size:.78rem;color:#888;">Total Mahasiswa</div>
        </div>
      </div>
    </div>

    <div id="mkGrid" class="row g-3"></div>
  </div>
</div>

<!-- MODAL Add/Edit -->
<div class="modal fade" id="modalMk" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="mkModalTitle"><i class="bi bi-book-fill me-2"></i>Tambah Mata Kuliah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="mkEditIdx"/>
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Kode MK *</label>
            <input type="text" class="form-control" id="mkKode" placeholder="MK001"/>
          </div>
          <div class="col-md-8">
            <label class="form-label">Nama Mata Kuliah *</label>
            <input type="text" class="form-control" id="mkNama" placeholder="Algoritma & Pemrograman"/>
          </div>
          <div class="col-md-6">
            <label class="form-label">Kelas</label>
            <input type="text" class="form-control" id="mkKelas" placeholder="TI-A"/>
          </div>
          <div class="col-md-3">
            <label class="form-label">SKS</label>
            <input type="number" class="form-control" id="mkSks" min="1" max="6" value="3"/>
          </div>
          <div class="col-md-3">
            <label class="form-label">Mhs</label>
            <input type="number" class="form-control" id="mkMhs" min="1" value="35"/>
          </div>
          <div class="col-md-6">
            <label class="form-label">Hari</label>
            <select class="form-select" id="mkHari">
              <option>Senin</option><option>Selasa</option><option>Rabu</option>
              <option>Kamis</option><option>Jumat</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Jam</label>
            <input type="text" class="form-control" id="mkJam" placeholder="07:30 – 09:10"/>
          </div>
          <div class="col-md-6">
            <label class="form-label">Ruang</label>
            <input type="text" class="form-control" id="mkRuang" placeholder="Lab K.301"/>
          </div>
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <select class="form-select" id="mkStatus">
              <option>Aktif</option><option>Non-Aktif</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button class="btn-save btn" onclick="saveMk()"><i class="bi bi-save me-1"></i>Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL Delete -->
<div class="modal fade" id="modalDelMk" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow">
      <div class="modal-body text-center p-4">
        <div style="font-size:3rem;color:#dc3545;"><i class="bi bi-trash3-fill"></i></div>
        <h6 class="mt-2 fw-bold">Hapus Mata Kuliah?</h6>
        <p class="text-muted small" id="mkDeleteText">Data akan dihapus permanen.</p>
        <div class="d-flex gap-2 justify-content-center mt-3">
          <button class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-danger btn-sm px-3" onclick="confirmDeleteMk()">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="toast-container">
  <div id="mainToast" class="toast align-items-center border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="toastMsg">Berhasil!</div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  let mkData = [
    { kode:'MK001', nama:'Algoritma & Pemrograman', kelas:'TI-A', sks:3, mhs:38, hari:'Senin',  jam:'07:30 – 09:10', ruang:'Lab K.301', status:'Aktif',    color:'#800020', icon:'bi-cpu-fill' },
    { kode:'MK002', nama:'Basis Data',               kelas:'TI-B', sks:3, mhs:35, hari:'Selasa', jam:'09:30 – 11:10', ruang:'R. B.202',  status:'Aktif',    color:'#0d6efd', icon:'bi-database-fill' },
    { kode:'MK003', nama:'Rekayasa Perangkat Lunak', kelas:'TI-A', sks:3, mhs:40, hari:'Rabu',   jam:'13:00 – 14:40', ruang:'R. C.101',  status:'Aktif',    color:'#198754', icon:'bi-gear-wide-connected' },
    { kode:'MK004', nama:'Jaringan Komputer',        kelas:'TI-C', sks:3, mhs:32, hari:'Kamis',  jam:'15:00 – 16:40', ruang:'Lab N.202', status:'Aktif',    color:'#fd7e14', icon:'bi-wifi' },
    { kode:'MK005', nama:'Sistem Operasi',           kelas:'TI-B', sks:2, mhs:36, hari:'Jumat',  jam:'08:00 – 09:40', ruang:'R. A.303',  status:'Non-Aktif',color:'#6f42c1', icon:'bi-hdd-fill' },
  ];

  let deleteIdx = null;
  const modalMk    = new bootstrap.Modal(document.getElementById('modalMk'));
  const modalDelMk = new bootstrap.Modal(document.getElementById('modalDelMk'));

  function renderGrid() {
    const grid = document.getElementById('mkGrid');
    grid.innerHTML = '';
    mkData.forEach((m, i) => {
      grid.innerHTML += `
        <div class="col-sm-6 col-lg-4" id="mk-card-${i}">
          <div class="mk-card" style="border-top-color:${m.color};">
            <div class="mk-icon" style="background:${m.color}18;color:${m.color};">
              <i class="bi ${m.icon}"></i>
            </div>
            <div class="mk-code" style="color:${m.color};">${m.kode}</div>
            <div class="mk-name">${m.nama}</div>
            <div class="mk-kelas"><i class="bi bi-people me-1"></i>Kelas ${m.kelas}</div>
            <div class="mk-meta">
              <span class="tag"><i class="bi bi-award"></i>${m.sks} SKS</span>
              <span class="tag"><i class="bi bi-people"></i>${m.mhs} Mhs</span>
              <span class="tag"><i class="bi bi-calendar3"></i>${m.hari}</span>
              <span class="tag"><i class="bi bi-clock"></i>${m.jam}</span>
              <span class="tag"><i class="bi bi-geo-alt"></i>${m.ruang}</span>
              <span class="badge rounded-pill ${m.status==='Aktif'?'text-bg-success':'text-bg-secondary'} ms-auto">${m.status}</span>
            </div>
            <div class="mk-actions">
              <button class="btn-mk-action btn-mk-edit" onclick="openEditMk(${i})"><i class="bi bi-pencil me-1"></i>Edit</button>
              <button class="btn-mk-action btn-mk-delete" onclick="openDeleteMk(${i})"><i class="bi bi-trash3 me-1"></i>Hapus</button>
              <button class="btn-mk-action btn-mk-qr" onclick="window.location.href='generate_qr.html'"><i class="bi bi-qr-code me-1"></i>QR</button>
            </div>
          </div>
        </div>`;
    });

    document.getElementById('cntTotal').textContent = mkData.length;
    document.getElementById('cntAktif').textContent = mkData.filter(m => m.status === 'Aktif').length;
    document.getElementById('cntSks').textContent   = mkData.reduce((a, m) => a + m.sks, 0);
    document.getElementById('cntMhs').textContent   = mkData.reduce((a, m) => a + m.mhs, 0);
  }

  function openAddModal() {
    document.getElementById('mkModalTitle').innerHTML = '<i class="bi bi-book-fill me-2"></i>Tambah Mata Kuliah';
    document.getElementById('mkEditIdx').value = '';
    ['mkKode','mkNama','mkKelas','mkJam','mkRuang'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('mkSks').value    = '3';
    document.getElementById('mkMhs').value    = '35';
    document.getElementById('mkHari').value   = 'Senin';
    document.getElementById('mkStatus').value = 'Aktif';
    modalMk.show();
  }

  function openEditMk(i) {
    const m = mkData[i];
    document.getElementById('mkModalTitle').innerHTML = '<i class="bi bi-pencil-square me-2"></i>Edit Mata Kuliah';
    document.getElementById('mkEditIdx').value = i;
    document.getElementById('mkKode').value   = m.kode;
    document.getElementById('mkNama').value   = m.nama;
    document.getElementById('mkKelas').value  = m.kelas;
    document.getElementById('mkSks').value    = m.sks;
    document.getElementById('mkMhs').value    = m.mhs;
    document.getElementById('mkHari').value   = m.hari;
    document.getElementById('mkJam').value    = m.jam;
    document.getElementById('mkRuang').value  = m.ruang;
    document.getElementById('mkStatus').value = m.status;
    modalMk.show();
  }

  const palette = ['#800020','#0d6efd','#198754','#fd7e14','#6f42c1','#0dcaf0','#d63384'];
  const icons   = ['bi-cpu-fill','bi-database-fill','bi-gear-wide-connected','bi-wifi','bi-hdd-fill','bi-code-slash','bi-diagram-3-fill'];

  function saveMk() {
    const kode = document.getElementById('mkKode').value.trim();
    const nama = document.getElementById('mkNama').value.trim();
    if (!kode || !nama) { alert('Kode dan Nama Mata Kuliah wajib diisi!'); return; }

    const idx = document.getElementById('mkEditIdx').value;
    const obj = {
      kode, nama,
      kelas:  document.getElementById('mkKelas').value,
      sks:    parseInt(document.getElementById('mkSks').value) || 3,
      mhs:    parseInt(document.getElementById('mkMhs').value) || 35,
      hari:   document.getElementById('mkHari').value,
      jam:    document.getElementById('mkJam').value,
      ruang:  document.getElementById('mkRuang').value,
      status: document.getElementById('mkStatus').value,
      color:  idx !== '' ? mkData[idx].color : palette[mkData.length % palette.length],
      icon:   idx !== '' ? mkData[idx].icon  : icons[mkData.length % icons.length],
    };

    if (idx === '') {
      mkData.push(obj);
      showToast('Mata kuliah berhasil ditambahkan!', 'success');
    } else {
      mkData[idx] = obj;
      showToast('Mata kuliah berhasil diperbarui!', 'success');
    }
    modalMk.hide();
    renderGrid();
  }

  function openDeleteMk(i) {
    deleteIdx = i;
    document.getElementById('mkDeleteText').textContent = `Yakin hapus "${mkData[i].nama}"?`;
    modalDelMk.show();
  }

  function confirmDeleteMk() {
    mkData.splice(deleteIdx, 1);
    modalDelMk.hide();
    renderGrid();
    showToast('Mata kuliah berhasil dihapus.', 'danger');
  }

  function showToast(msg, type) {
    const toast = document.getElementById('mainToast');
    toast.className = `toast align-items-center border-0 text-bg-${type}`;
    document.getElementById('toastMsg').textContent = msg;
    new bootstrap.Toast(toast, { delay: 3000 }).show();
  }

  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('overlay').classList.toggle('show');
  }
  function closeSidebar() {
    document.getElementById('sidebar').classList.remove('show');
    document.getElementById('overlay').classList.remove('show');
  }

  renderGrid();
</script>
</body>
</html>
