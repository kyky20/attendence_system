<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Mahasiswa – Ambasen</title>
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

    /* PAGE SPECIFIC */
    .section-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .table-toolbar {
      padding: 1.2rem 1.5rem;
      border-bottom: 1px solid #f0f0f0;
      display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem;
    }
    .table-toolbar h6 { font-weight: 700; color: #1a1a2e; margin: 0; }
    .search-box {
      position: relative; min-width: 220px;
    }
    .search-box input {
      border-radius: 25px; border: 1.5px solid #e0e0e0;
      padding: .45rem 1rem .45rem 2.2rem; font-size: 0.85rem; width: 100%;
    }
    .search-box input:focus { border-color: var(--maroon); box-shadow: 0 0 0 3px rgba(128,0,32,0.1); outline: none; }
    .search-box .bi-search { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); color: #aaa; }
    .btn-add {
      background: linear-gradient(135deg, var(--maroon-dark), #c0003a);
      color: #fff; border: none; border-radius: 25px;
      padding: .45rem 1.2rem; font-size: 0.88rem; font-weight: 600; cursor: pointer;
      display: flex; align-items: center; gap: .4rem; transition: transform .15s, box-shadow .15s;
    }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(128,0,32,0.3); }
    .table { margin: 0; }
    .table thead th {
      background: var(--gray-bg); font-size: 0.78rem; font-weight: 700;
      color: #555; text-transform: uppercase; letter-spacing: .5px; border: none; padding: .85rem 1rem;
    }
    .table tbody td { font-size: 0.88rem; vertical-align: middle; border-color: #f0f0f0; padding: .85rem 1rem; }
    .table tbody tr:hover { background: #fafafa; }
    .avatar-sm {
      width: 36px; height: 36px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: .85rem; flex-shrink: 0;
    }
    .btn-icon {
      width: 30px; height: 30px; border-radius: 8px; border: none; cursor: pointer;
      display: inline-flex; align-items: center; justify-content: center; font-size: .85rem;
      transition: transform .15s;
    }
    .btn-icon:hover { transform: scale(1.1); }
    .btn-edit   { background: rgba(13,110,253,0.1); color: #0d6efd; }
    .btn-delete { background: rgba(220,53,69,0.1);  color: #dc3545; }
    .pagination-area { padding: .9rem 1.5rem; border-top: 1px solid #f0f0f0; }

    /* MODAL */
    .modal-header { background: linear-gradient(135deg, var(--maroon-dark), var(--maroon)); color: #fff; border: none; }
    .modal-header .btn-close { filter: invert(1); }
    .modal-footer { border-top: 1px solid #f0f0f0; }
    .form-label { font-weight: 600; font-size: 0.83rem; color: #444; }
    .form-control, .form-select {
      border-radius: 8px; border: 1.5px solid #e0e0e0; font-size: 0.9rem; padding: .55rem .9rem;
    }
    .form-control:focus, .form-select:focus { border-color: var(--maroon); box-shadow: 0 0 0 3px rgba(128,0,32,0.12); }
    .btn-save { background: linear-gradient(135deg, var(--maroon-dark), #c0003a); color: #fff; border: none; border-radius: 8px; padding: .55rem 1.5rem; font-weight: 600; }

    /* Toast */
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
    <a href="/dosen/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a>
    <a href="/dosen/generate_qr"><i class="bi bi-qr-code-scan"></i> Generate QR</a>
    <a href="/dosen/list_mahasiswa" class="active"><i class="bi bi-people-fill"></i> Data Mahasiswa</a>
    <a href="/dosen/list_matakuliah"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
  </nav>
  <div class="nav-section-title">Lainnya</div>
  <nav class="sidebar-nav">
    <a href="/dosen/profile"><i class="bi bi-person-circle"></i> Profil</a>
    <a href="#"><i class="bi bi-gear-fill"></i> Pengaturan</a>
  </nav>
  <div class="sidebar-footer">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" ><i class="bi bi-box-arrow-left"></i> Keluar</a>
  </div>
</aside>

<div class="main-content">
  <div class="topbar">
    <div class="d-flex align-items-center gap-3">
      <button class="btn-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
      <div>
        <div class="page-title">Data Mahasiswa</div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/dosen/dashboard" style="color:var(--maroon);">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Mahasiswa</li>
          </ol>
        </nav>
      </div>
    </div>
    <button class="btn-add" onclick="openAddModal()">
      <i class="bi bi-plus-lg"></i> Tambah Mahasiswa
    </button>
  </div>

  <div class="p-3 p-md-4">

    <!-- Filter bar -->
    <div class="d-flex gap-2 flex-wrap mb-3">
      <select class="form-select form-select-sm" style="width:auto;border-radius:20px;font-size:.82rem;" id="filterProdi" onchange="renderTable()">
        <option value="">Semua Prodi</option>
        <option value="Teknik Informatika">Teknik Informatika</option>
        <option value="Sistem Informasi">Sistem Informasi</option>
      </select>
      <select class="form-select form-select-sm" style="width:auto;border-radius:20px;font-size:.82rem;" id="filterAngkatan" onchange="renderTable()">
        <option value="">Semua Angkatan</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
      </select>
    </div>

    <div class="section-card">
      <div class="table-toolbar">
        <div>
          <h6><i class="bi bi-people me-2" style="color:var(--maroon);"></i>Daftar Mahasiswa</h6>
          <small class="text-muted" id="totalInfo">Menampilkan 0 data</small>
        </div>
        <div class="search-box">
          <i class="bi bi-search"></i>
          <input type="text" id="searchInput" placeholder="Cari nama / NIM..." oninput="renderTable()"/>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Mahasiswa</th>
              <th>NIM</th>
              <th>Prodi</th>
              <th>Angkatan</th>
              <th>Kehadiran</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="mahasiswaTable"></tbody>
        </table>
      </div>

      <div class="pagination-area d-flex align-items-center justify-content-between">
        <small class="text-muted" id="pageInfo"></small>
        <div class="d-flex gap-1" id="paginationBtns"></div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL: Add/Edit -->
<div class="modal fade" id="modalMahasiswa" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"><i class="bi bi-person-plus me-2"></i>Tambah Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="editIndex"/>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap *</label>
            <input type="text" class="form-control" id="fNama" placeholder="Contoh: Andi Pratama" required/>
          </div>
          <div class="col-md-6">
            <label class="form-label">NIM *</label>
            <input type="text" class="form-control" id="fNim" placeholder="Contoh: M001" required/>
          </div>
          <div class="col-md-6">
            <label class="form-label">Program Studi *</label>
            <select class="form-select" id="fProdi">
              <option value="Teknik Informatika">Teknik Informatika</option>
              <option value="Sistem Informasi">Sistem Informasi</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Angkatan *</label>
            <select class="form-select" id="fAngkatan">
              <option>2022</option><option>2023</option><option selected>2024</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" id="fEmail" placeholder="email@student.ac.id"/>
          </div>
          <div class="col-md-6">
            <label class="form-label">No. HP</label>
            <input type="text" class="form-control" id="fHp" placeholder="08xx-xxxx-xxxx"/>
          </div>
          <div class="col-12">
            <label class="form-label">Status</label>
            <select class="form-select" id="fStatus">
              <option value="Aktif">Aktif</option>
              <option value="Cuti">Cuti</option>
              <option value="Non-Aktif">Non-Aktif</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button class="btn-save btn" onclick="saveMahasiswa()"><i class="bi bi-save me-1"></i>Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL: Delete Confirm -->
<div class="modal fade" id="modalDelete" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow">
      <div class="modal-body text-center p-4">
        <div style="font-size:3rem;color:#dc3545;"><i class="bi bi-trash3-fill"></i></div>
        <h6 class="mt-2 fw-bold">Hapus Mahasiswa?</h6>
        <p class="text-muted small" id="deleteConfirmText">Data akan dihapus permanen.</p>
        <div class="d-flex gap-2 justify-content-center mt-3">
          <button class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-danger btn-sm px-3" onclick="confirmDelete()">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
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
  // ── DUMMY DATA ──
  let mahasiswaData = [
    { nama:'Andi Pratama',    nim:'M001', prodi:'Teknik Informatika', angkatan:'2022', email:'andi@student.ac.id',   hp:'08111111111', kehadiran:92, status:'Aktif' },
    { nama:'Budi Santoso',    nim:'M002', prodi:'Teknik Informatika', angkatan:'2022', email:'budi@student.ac.id',   hp:'08222222222', kehadiran:85, status:'Aktif' },
    { nama:'Citra Dewi',      nim:'M003', prodi:'Sistem Informasi',   angkatan:'2023', email:'citra@student.ac.id',  hp:'08333333333', kehadiran:78, status:'Aktif' },
    { nama:'Dian Rahmadhani', nim:'M004', prodi:'Teknik Informatika', angkatan:'2023', email:'dian@student.ac.id',   hp:'08444444444', kehadiran:60, status:'Cuti'  },
    { nama:'Eko Firmansyah',  nim:'M005', prodi:'Sistem Informasi',   angkatan:'2022', email:'eko@student.ac.id',    hp:'08555555555', kehadiran:45, status:'Non-Aktif' },
    { nama:'Fina Sari',       nim:'M006', prodi:'Teknik Informatika', angkatan:'2024', email:'fina@student.ac.id',   hp:'08666666666', kehadiran:95, status:'Aktif' },
    { nama:'Gilang Wicaksono',nim:'M007', prodi:'Sistem Informasi',   angkatan:'2024', email:'gilang@student.ac.id', hp:'08777777777', kehadiran:88, status:'Aktif' },
    { nama:'Hani Permata',    nim:'M008', prodi:'Teknik Informatika', angkatan:'2022', email:'hani@student.ac.id',   hp:'08888888888', kehadiran:72, status:'Aktif' },
    { nama:'Irfan Hakim',     nim:'M009', prodi:'Sistem Informasi',   angkatan:'2023', email:'irfan@student.ac.id',  hp:'08999999999', kehadiran:90, status:'Aktif' },
    { nama:'Jeni Kusuma',     nim:'M010', prodi:'Teknik Informatika', angkatan:'2024', email:'jeni@student.ac.id',   hp:'08100000000', kehadiran:83, status:'Aktif' },
  ];

  const ROWS_PER_PAGE = 7;
  let currentPage = 1;
  let deleteIndex = null;

  const colors = ['#800020','#0d6efd','#198754','#fd7e14','#6f42c1','#0dcaf0','#d63384'];

  function initials(name) {
    return name.split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase();
  }
  function avatarColor(i) { return colors[i % colors.length]; }

  function getFiltered() {
    const q      = document.getElementById('searchInput').value.toLowerCase();
    const prodi  = document.getElementById('filterProdi').value;
    const angktn = document.getElementById('filterAngkatan').value;
    return mahasiswaData.filter(m =>
      (m.nama.toLowerCase().includes(q) || m.nim.toLowerCase().includes(q)) &&
      (prodi  ? m.prodi === prodi    : true) &&
      (angktn ? m.angkatan === angktn : true)
    );
  }

  function renderTable() {
    const filtered = getFiltered();
    const total    = filtered.length;
    const pages    = Math.ceil(total / ROWS_PER_PAGE);
    if (currentPage > pages) currentPage = 1;

    const start = (currentPage - 1) * ROWS_PER_PAGE;
    const slice = filtered.slice(start, start + ROWS_PER_PAGE);

    document.getElementById('totalInfo').textContent = `Menampilkan ${total} data mahasiswa`;
    document.getElementById('pageInfo').textContent  = `Halaman ${currentPage} dari ${pages || 1}`;

    const tb = document.getElementById('mahasiswaTable');
    tb.innerHTML = '';
    if (slice.length === 0) {
      tb.innerHTML = '<tr><td colspan="8" class="text-center text-muted py-4"><i class="bi bi-inbox"></i> Tidak ada data</td></tr>';
    }
    slice.forEach((m, i) => {
      const idx    = mahasiswaData.indexOf(m);
      const color  = avatarColor(idx);
      const kelas  = m.kehadiran >= 80 ? 'text-success' : m.kehadiran >= 60 ? 'text-warning' : 'text-danger';
      const sBadge = m.status === 'Aktif'
        ? 'badge rounded-pill px-2' + ' text-bg-success'
        : m.status === 'Cuti'
        ? 'badge rounded-pill px-2 text-bg-warning'
        : 'badge rounded-pill px-2 text-bg-secondary';

      tb.innerHTML += `
        <tr>
          <td class="text-muted">${start + i + 1}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div class="avatar-sm" style="background:${color}20;color:${color};">${initials(m.nama)}</div>
              <div>
                <div class="fw-600">${m.nama}</div>
                <small class="text-muted">${m.email}</small>
              </div>
            </div>
          </td>
          <td><code>${m.nim}</code></td>
          <td>${m.prodi}</td>
          <td>${m.angkatan}</td>
          <td>
            <div class="d-flex align-items-center gap-1">
              <div class="progress flex-grow-1" style="height:6px;width:60px;">
                <div class="progress-bar ${m.kehadiran>=80?'bg-success':m.kehadiran>=60?'bg-warning':'bg-danger'}"
                  style="width:${m.kehadiran}%;"></div>
              </div>
              <small class="${kelas} fw-600">${m.kehadiran}%</small>
            </div>
          </td>
          <td><span class="${sBadge}">${m.status}</span></td>
          <td>
            <button class="btn-icon btn-edit me-1" onclick="openEditModal(${idx})" title="Edit"><i class="bi bi-pencil"></i></button>
            <button class="btn-icon btn-delete" onclick="openDeleteModal(${idx})" title="Hapus"><i class="bi bi-trash3"></i></button>
          </td>
        </tr>`;
    });

    // Pagination
    const pb = document.getElementById('paginationBtns');
    pb.innerHTML = '';
    for (let p = 1; p <= pages; p++) {
      pb.innerHTML += `
        <button class="btn btn-sm ${p===currentPage?'text-white':'btn-light'}" 
          style="${p===currentPage?'background:var(--maroon);border-color:var(--maroon);':''}"
          onclick="goPage(${p})">${p}</button>`;
    }
  }

  function goPage(p) { currentPage = p; renderTable(); }

  // ── MODALS ──
  const modalMhs  = new bootstrap.Modal(document.getElementById('modalMahasiswa'));
  const modalDel  = new bootstrap.Modal(document.getElementById('modalDelete'));

  function openAddModal() {
    document.getElementById('modalTitle').innerHTML = '<i class="bi bi-person-plus me-2"></i>Tambah Mahasiswa';
    document.getElementById('editIndex').value = '';
    ['fNama','fNim','fEmail','fHp'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('fProdi').value    = 'Teknik Informatika';
    document.getElementById('fAngkatan').value = '2024';
    document.getElementById('fStatus').value   = 'Aktif';
    modalMhs.show();
  }

  function openEditModal(idx) {
    const m = mahasiswaData[idx];
    document.getElementById('modalTitle').innerHTML = '<i class="bi bi-pencil-square me-2"></i>Edit Mahasiswa';
    document.getElementById('editIndex').value = idx;
    document.getElementById('fNama').value     = m.nama;
    document.getElementById('fNim').value      = m.nim;
    document.getElementById('fProdi').value    = m.prodi;
    document.getElementById('fAngkatan').value = m.angkatan;
    document.getElementById('fEmail').value    = m.email;
    document.getElementById('fHp').value       = m.hp;
    document.getElementById('fStatus').value   = m.status;
    modalMhs.show();
  }

  function saveMahasiswa() {
    const nama     = document.getElementById('fNama').value.trim();
    const nim      = document.getElementById('fNim').value.trim();
    if (!nama || !nim) { alert('Nama dan NIM wajib diisi!'); return; }

    const obj = {
      nama, nim,
      prodi:    document.getElementById('fProdi').value,
      angkatan: document.getElementById('fAngkatan').value,
      email:    document.getElementById('fEmail').value,
      hp:       document.getElementById('fHp').value,
      kehadiran: Math.floor(Math.random() * 40) + 60,
      status:   document.getElementById('fStatus').value,
    };

    const idx = document.getElementById('editIndex').value;
    if (idx === '') {
      mahasiswaData.unshift(obj);
      showToast('Mahasiswa berhasil ditambahkan!', 'success');
    } else {
      obj.kehadiran = mahasiswaData[idx].kehadiran;
      mahasiswaData[idx] = obj;
      showToast('Data mahasiswa berhasil diperbarui!', 'success');
    }
    modalMhs.hide();
    renderTable();
  }

  function openDeleteModal(idx) {
    deleteIndex = idx;
    document.getElementById('deleteConfirmText').textContent =
      `Yakin hapus "${mahasiswaData[idx].nama}" (${mahasiswaData[idx].nim})?`;
    modalDel.show();
  }

  function confirmDelete() {
    mahasiswaData.splice(deleteIndex, 1);
    modalDel.hide();
    renderTable();
    showToast('Data mahasiswa berhasil dihapus.', 'danger');
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

  renderTable();
</script>
</body>
</html>
