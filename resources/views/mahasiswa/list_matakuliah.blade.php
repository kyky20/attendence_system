<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mata Kuliah Saya – Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <style>
    :root { --maroon: #800020; --maroon-dark: #5a0016; --gray-bg: #f4f6f9; --nav-h: 65px; }
    body { font-family: 'Segoe UI', sans-serif; background: var(--gray-bg); padding-bottom: var(--nav-h); }

    /* TOP HEADER */
    .top-header {
      background: linear-gradient(135deg, var(--maroon-dark), var(--maroon));
      padding: 1rem 1.2rem 1.4rem;
      position: relative; overflow: hidden;
    }
    .top-header::after {
      content: ''; position: absolute; width: 160px; height: 160px; border-radius: 50%;
      background: rgba(255,255,255,0.05); bottom: -60px; right: -40px;
    }
    .top-header .title { color: #fff; font-weight: 700; font-size: 1.1rem; }
    .top-header small  { color: rgba(255,255,255,0.7); font-size: .78rem; }
    .back-btn {
      width: 36px; height: 36px; border-radius: 50%;
      background: rgba(255,255,255,0.15); border: none;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 1rem; cursor: pointer; text-decoration: none;
    }

    /* STATS STRIP */
    .stats-strip {
      display: flex; gap: .8rem;
      background: rgba(255,255,255,0.12); border-radius: 12px;
      padding: .8rem 1rem; margin-top: .8rem;
    }
    .stat-item { text-align: center; flex: 1; }
    .stat-item .val { color: #ffd700; font-weight: 700; font-size: 1.2rem; }
    .stat-item .lbl { color: rgba(255,255,255,0.7); font-size: .68rem; }

    /* MK CARD */
    .mk-card {
      background: #fff; border-radius: 16px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.07);
      overflow: hidden; cursor: pointer;
      transition: transform .2s, box-shadow .2s;
    }
    .mk-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(0,0,0,0.1); }
    .mk-card-header {
      padding: 1.1rem 1.2rem .8rem;
      position: relative;
    }
    .mk-card-icon {
      width: 44px; height: 44px; border-radius: 11px;
      display: flex; align-items: center; justify-content: center; font-size: 1.2rem; float: left; margin-right: .9rem;
    }
    .mk-code { font-size: .7rem; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; }
    .mk-name { font-size: .95rem; font-weight: 700; color: #1a1a2e; line-height: 1.3; }
    .mk-dosen{ font-size: .77rem; color: #888; }
    .mk-card-body { padding: 0 1.2rem .6rem; }
    .mk-meta-row {
      display: flex; flex-wrap: wrap; gap: .4rem; margin-bottom: .7rem;
    }
    .mk-tag {
      font-size: .72rem; padding: .2rem .55rem; border-radius: 20px;
      background: var(--gray-bg); color: #555;
      display: flex; align-items: center; gap: .25rem;
    }
    .mk-card-footer {
      border-top: 1px solid #f5f5f5; padding: .8rem 1.2rem;
      display: flex; align-items: center; gap: .8rem;
    }
    .attend-bar { flex: 1; }
    .attend-bar .bar-label {
      display: flex; justify-content: space-between;
      font-size: .72rem; margin-bottom: .25rem;
    }
    .progress { height: 7px; border-radius: 10px; }

    /* Detail Drawer / offcanvas style */
    .offcanvas { border-radius: 20px 20px 0 0 !important; }
    .offcanvas-header { border-bottom: none; padding: 1rem 1.2rem .5rem; }
    .detail-header {
      display: flex; align-items: center; gap: 1rem;
      padding: .5rem 0 1rem;
    }
    .detail-icon {
      width: 60px; height: 60px; border-radius: 14px;
      display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;
    }
    .session-row {
      display: flex; align-items: center; gap: .8rem;
      padding: .6rem 0; border-bottom: 1px solid #f5f5f5;
    }
    .session-row:last-child { border-bottom: none; }
    .sess-num {
      width: 28px; height: 28px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: .72rem; font-weight: 700; flex-shrink: 0;
    }
    .badge-hadir { background: rgba(25,135,84,0.12); color: #198754; }
    .badge-izin  { background: rgba(253,126,20,0.12); color: #fd7e14; }
    .badge-alpha { background: rgba(220,53,69,0.12);  color: #dc3545; }

    /* BOTTOM NAV */
    .bottom-nav {
      position: fixed; bottom: 0; left: 0; right: 0; height: var(--nav-h);
      background: #fff; border-top: 1px solid #eee;
      display: flex; z-index: 1000;
      box-shadow: 0 -4px 16px rgba(0,0,0,0.07);
    }
    .nav-item-btn {
      flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;
      border: none; background: none; color: #aaa; cursor: pointer;
      font-size: .65rem; font-weight: 600; gap: .2rem; transition: color .2s;
      text-decoration: none; padding: 0;
    }
    .nav-item-btn i { font-size: 1.3rem; }
    .nav-item-btn.active { color: var(--maroon); }
    .nav-fab {
      flex: 1; display: flex; align-items: center; justify-content: center;
      border: none; background: none; cursor: pointer; text-decoration: none;
    }
    .nav-fab .fab {
      width: 54px; height: 54px; background: linear-gradient(135deg, var(--maroon-dark), #c0003a);
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 1.5rem; box-shadow: 0 4px 16px rgba(128,0,32,0.35);
      margin-top: -20px; border: 3px solid #fff;
    }
  </style>
</head>
<body>

<!-- TOP HEADER -->
<div class="top-header">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <div class="d-flex align-items-center gap-2">
      <a href="{{ url('/' . request()->segment(1) . '/dashboard') }}" class="back-btn"><i class="bi bi-arrow-left"></i></a>
      <div>
        <div class="title">Mata Kuliah Saya</div>
        <small>Semester Genap 2025/2026</small>
      </div>
    </div>
    <span class="badge rounded-pill" style="background:rgba(255,255,255,0.15);color:#fff;font-size:.75rem;">5 MK</span>
  </div>
  <div class="stats-strip">
    <div class="stat-item"><div class="val">5</div><div class="lbl">Mata Kuliah</div></div>
    <div class="stat-item"><div class="val">14</div><div class="lbl">SKS Total</div></div>
    <div class="stat-item"><div class="val">87%</div><div class="lbl">Rata‑rata Hadir</div></div>
    <div class="stat-item"><div class="val">16</div><div class="lbl">Pertemuan/MK</div></div>
  </div>
</div>

<!-- CONTENT -->
<div class="p-3" style="max-width:640px;margin:auto;">
  <div id="mkGrid" class="d-flex flex-column gap-3"></div>
</div>

<!-- BOTTOM NAV -->
<nav class="bottom-nav">
  <a href="{{ url('/' . request()->segment(1) . '/dashboard') }}" class="nav-item-btn">
    <i class="bi bi-house-fill"></i><span>Beranda</span>
  </a>
  <a href="{{ url('/' . request()->segment(1) . '/list_matakuliah') }}" class="nav-item-btn active">
    <i class="bi bi-book"></i><span>Mata Kuliah</span>
  </a>
  <a href="{{ url('/' . request()->segment(1) . '/scan_qr') }}" class="nav-fab">
    <div class="fab"><i class="bi bi-qr-code-scan"></i></div>
  </a>
  <a href="#" class="nav-item-btn">
    <i class="bi bi-file-earmark-text"></i><span>Izin</span>
  </a>
  <a href="{{ url('/' . request()->segment(1) . '/profile') }}" class="nav-item-btn">
    <i class="bi bi-person-circle"></i><span>Profil</span>
  </a>
</nav>

<!-- Detail Offcanvas -->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="detailCanvas" style="height:85vh;">
  <div class="offcanvas-header">
    <div style="width:40px;height:4px;background:#ddd;border-radius:2px;margin:0 auto;"></div>
  </div>
  <div class="offcanvas-body pt-0">
    <div class="detail-header">
      <div class="detail-icon" id="detailIcon"></div>
      <div>
        <div style="font-size:.72rem;font-weight:700;letter-spacing:.8px;text-transform:uppercase;" id="detailCode"></div>
        <div style="font-size:1.1rem;font-weight:700;color:#1a1a2e;" id="detailName"></div>
        <div style="font-size:.8rem;color:#888;" id="detailDosen"></div>
      </div>
    </div>

    <!-- Attendance summary donut-ish -->
    <div class="d-flex gap-3 mb-4">
      <div class="p-3 rounded-3 text-center flex-fill" style="background:rgba(25,135,84,0.08);">
        <div style="font-size:1.4rem;font-weight:700;color:#198754;" id="detailHadir">0</div>
        <div style="font-size:.72rem;color:#888;">Hadir</div>
      </div>
      <div class="p-3 rounded-3 text-center flex-fill" style="background:rgba(253,126,20,0.08);">
        <div style="font-size:1.4rem;font-weight:700;color:#fd7e14;" id="detailIzin">0</div>
        <div style="font-size:.72rem;color:#888;">Izin</div>
      </div>
      <div class="p-3 rounded-3 text-center flex-fill" style="background:rgba(220,53,69,0.08);">
        <div style="font-size:1.4rem;font-weight:700;color:#dc3545;" id="detailAlpha">0</div>
        <div style="font-size:.72rem;color:#888;">Alpha</div>
      </div>
      <div class="p-3 rounded-3 text-center flex-fill" style="background:rgba(128,0,32,0.08);">
        <div style="font-size:1.4rem;font-weight:700;color:var(--maroon);" id="detailPct">0%</div>
        <div style="font-size:.72rem;color:#888;">Kehadiran</div>
      </div>
    </div>

    <div style="font-size:.85rem;font-weight:700;color:#1a1a2e;margin-bottom:.6rem;">Riwayat Pertemuan</div>
    <div id="sessionList"></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const mkData = [
    {
      kode:'MK001', nama:'Algoritma & Pemrograman', kelas:'TI-A', sks:3, dosen:'Dr. Rahmad S.',
      hari:'Senin', jam:'07:30 – 09:10', ruang:'Lab K.301', color:'#800020', icon:'bi-cpu-fill',
      hadir:14, izin:1, alpha:1, total:16,
      sessions: [
        {n:1, tgl:'3 Feb 2026', topik:'Pengantar Algoritma', status:'hadir'},
        {n:2, tgl:'10 Feb 2026', topik:'Variabel & Tipe Data', status:'hadir'},
        {n:3, tgl:'17 Feb 2026', topik:'Percabangan', status:'hadir'},
        {n:4, tgl:'24 Feb 2026', topik:'Perulangan', status:'izin'},
        {n:5, tgl:'3 Mar 2026', topik:'Fungsi & Prosedur', status:'hadir'},
        {n:6, tgl:'10 Mar 2026', topik:'Array', status:'hadir'},
        {n:7, tgl:'17 Mar 2026', topik:'Sorting', status:'hadir'},
        {n:8, tgl:'24 Mar 2026', topik:'UTS', status:'hadir'},
        {n:9, tgl:'7 Apr 2026', topik:'Rekursi', status:'hadir'},
        {n:10,tgl:'14 Apr 2026',topik:'Pointer',status:'alpha'},
        {n:11,tgl:'15 Apr 2026',topik:'Linked List',status:'hadir'},
      ]
    },
    {
      kode:'MK002', nama:'Basis Data', kelas:'TI-B', sks:3, dosen:'Dr. Dian M.Kom',
      hari:'Selasa', jam:'09:30 – 11:10', ruang:'R. B.202', color:'#0d6efd', icon:'bi-database-fill',
      hadir:13, izin:2, alpha:1, total:16,
      sessions: [
        {n:1, tgl:'4 Feb 2026',  topik:'ER Diagram', status:'hadir'},
        {n:2, tgl:'11 Feb 2026', topik:'Normalisasi 1NF', status:'hadir'},
        {n:3, tgl:'18 Feb 2026', topik:'Normalisasi 2NF', status:'izin'},
        {n:4, tgl:'25 Feb 2026', topik:'SQL DDL', status:'hadir'},
        {n:5, tgl:'4 Mar 2026',  topik:'SQL DML', status:'hadir'},
        {n:6, tgl:'11 Mar 2026', topik:'JOIN Tables', status:'hadir'},
        {n:7, tgl:'18 Mar 2026', topik:'Subquery', status:'alpha'},
        {n:8, tgl:'25 Mar 2026', topik:'UTS', status:'hadir'},
        {n:9, tgl:'8 Apr 2026',  topik:'Index & View', status:'hadir'},
        {n:10,tgl:'15 Apr 2026', topik:'Stored Procedure', status:'izin'},
      ]
    },
    {
      kode:'MK003', nama:'Rekayasa Perangkat Lunak', kelas:'TI-A', sks:3, dosen:'Ir. Budi W. M.T',
      hari:'Rabu', jam:'13:00 – 14:40', ruang:'R. C.101', color:'#198754', icon:'bi-gear-wide-connected',
      hadir:12, izin:1, alpha:3, total:16,
      sessions: [
        {n:1, tgl:'5 Feb 2026',  topik:'SDLC Overview', status:'hadir'},
        {n:2, tgl:'12 Feb 2026', topik:'Requirement Analysis', status:'hadir'},
        {n:3, tgl:'19 Feb 2026', topik:'UML Use Case', status:'alpha'},
        {n:4, tgl:'26 Feb 2026', topik:'UML Class Diagram', status:'hadir'},
        {n:5, tgl:'5 Mar 2026',  topik:'Design Pattern', status:'hadir'},
        {n:6, tgl:'12 Mar 2026', topik:'Testing', status:'alpha'},
        {n:7, tgl:'19 Mar 2026', topik:'Deployment', status:'hadir'},
        {n:8, tgl:'26 Mar 2026', topik:'UTS', status:'izin'},
        {n:9, tgl:'9 Apr 2026',  topik:'Agile Scrum', status:'hadir'},
        {n:10,tgl:'14 Apr 2026', topik:'Sprint Planning', status:'alpha'},
      ]
    },
    {
      kode:'MK004', nama:'Jaringan Komputer', kelas:'TI-C', sks:3, dosen:'Dr. Hana S.T',
      hari:'Kamis', jam:'15:00 – 16:40', ruang:'Lab N.202', color:'#fd7e14', icon:'bi-wifi',
      hadir:15, izin:0, alpha:1, total:16,
      sessions: [
        {n:1, tgl:'6 Feb 2026',  topik:'OSI Model', status:'hadir'},
        {n:2, tgl:'13 Feb 2026', topik:'TCP/IP', status:'hadir'},
        {n:3, tgl:'20 Feb 2026', topik:'Subnetting', status:'hadir'},
        {n:4, tgl:'27 Feb 2026', topik:'Routing', status:'hadir'},
        {n:5, tgl:'6 Mar 2026',  topik:'Switching', status:'hadir'},
        {n:6, tgl:'13 Mar 2026', topik:'Wireless LAN', status:'alpha'},
        {n:7, tgl:'20 Mar 2026', topik:'Firewall', status:'hadir'},
        {n:8, tgl:'27 Mar 2026', topik:'UTS', status:'hadir'},
      ]
    },
    {
      kode:'MK005', nama:'Sistem Operasi', kelas:'TI-B', sks:2, dosen:'Dr. Eko P. M.Kom',
      hari:'Jumat', jam:'08:00 – 09:40', ruang:'R. A.303', color:'#6f42c1', icon:'bi-hdd-fill',
      hadir:10, izin:2, alpha:4, total:16,
      sessions: [
        {n:1, tgl:'7 Feb 2026',  topik:'Intro OS', status:'hadir'},
        {n:2, tgl:'14 Feb 2026', topik:'Process Management', status:'hadir'},
        {n:3, tgl:'21 Feb 2026', topik:'Threading', status:'alpha'},
        {n:4, tgl:'28 Feb 2026', topik:'Scheduling', status:'hadir'},
        {n:5, tgl:'7 Mar 2026',  topik:'Memory Management', status:'alpha'},
        {n:6, tgl:'14 Mar 2026', topik:'Virtual Memory', status:'izin'},
        {n:7, tgl:'21 Mar 2026', topik:'File System', status:'hadir'},
        {n:8, tgl:'28 Mar 2026', topik:'UTS', status:'izin'},
        {n:9, tgl:'11 Apr 2026', topik:'I/O System', status:'hadir'},
        {n:10,tgl:'14 Apr 2026', topik:'Security OS', status:'alpha'},
      ]
    },
  ];

  const statusBadge = {
    hadir: '<span class="badge badge-hadir px-2 rounded-pill" style="font-size:.72rem;">Hadir</span>',
    izin:  '<span class="badge badge-izin  px-2 rounded-pill" style="font-size:.72rem;">Izin</span>',
    alpha: '<span class="badge badge-alpha px-2 rounded-pill" style="font-size:.72rem;">Alpha</span>',
  };

  function renderGrid() {
    const grid = document.getElementById('mkGrid');
    grid.innerHTML = '';
    mkData.forEach((m, i) => {
      const pct = Math.round((m.hadir / m.total) * 100);
      const barColor = pct >= 80 ? '#198754' : pct >= 60 ? '#fd7e14' : '#dc3545';
      grid.innerHTML += `
        <div class="mk-card" onclick="openDetail(${i})">
          <div class="mk-card-header" style="border-left:4px solid ${m.color};">
            <div class="mk-card-icon" style="background:${m.color}15;color:${m.color};">
              <i class="bi ${m.icon}"></i>
            </div>
            <div style="overflow:hidden;">
              <div class="mk-code" style="color:${m.color};">${m.kode}</div>
              <div class="mk-name">${m.nama}</div>
              <div class="mk-dosen"><i class="bi bi-person-fill me-1"></i>${m.dosen}</div>
            </div>
          </div>
          <div class="mk-card-body">
            <div class="mk-meta-row">
              <span class="mk-tag"><i class="bi bi-award"></i>${m.sks} SKS</span>
              <span class="mk-tag"><i class="bi bi-calendar3"></i>${m.hari}, ${m.jam}</span>
              <span class="mk-tag"><i class="bi bi-geo-alt"></i>${m.ruang}</span>
              <span class="mk-tag"><i class="bi bi-people"></i>Kelas ${m.kelas}</span>
            </div>
          </div>
          <div class="mk-card-footer">
            <div class="attend-bar">
              <div class="bar-label">
                <span style="font-size:.72rem;color:#888;">Kehadiran</span>
                <span style="font-size:.72rem;font-weight:700;color:${barColor};">${m.hadir}/${m.total} (${pct}%)</span>
              </div>
              <div class="progress">
                <div class="progress-bar" style="width:${pct}%;background:${barColor};border-radius:10px;"></div>
              </div>
            </div>
            <i class="bi bi-chevron-right text-muted" style="font-size:.9rem;"></i>
          </div>
        </div>`;
    });
  }

  const detailCanvas = new bootstrap.Offcanvas(document.getElementById('detailCanvas'));

  function openDetail(i) {
    const m = mkData[i];
    const pct = Math.round((m.hadir / m.total) * 100);
    document.getElementById('detailIcon').innerHTML = `<i class="bi ${m.icon}"></i>`;
    document.getElementById('detailIcon').style.background = m.color + '18';
    document.getElementById('detailIcon').style.color = m.color;
    document.getElementById('detailCode').textContent  = m.kode;
    document.getElementById('detailCode').style.color  = m.color;
    document.getElementById('detailName').textContent  = m.nama;
    document.getElementById('detailDosen').textContent = m.dosen + ' · ' + m.hari + ', ' + m.jam;
    document.getElementById('detailHadir').textContent = m.hadir;
    document.getElementById('detailIzin').textContent  = m.izin;
    document.getElementById('detailAlpha').textContent = m.alpha;
    document.getElementById('detailPct').textContent   = pct + '%';

    const sl = document.getElementById('sessionList');
    sl.innerHTML = '';
    m.sessions.forEach(s => {
      const bg = s.status === 'hadir' ? '#198754' : s.status === 'izin' ? '#fd7e14' : '#dc3545';
      sl.innerHTML += `
        <div class="session-row">
          <div class="sess-num" style="background:${bg}18;color:${bg};">${s.n}</div>
          <div class="flex-grow-1">
            <div style="font-size:.85rem;font-weight:600;">${s.topik}</div>
            <div style="font-size:.73rem;color:#888;">${s.tgl}</div>
          </div>
          ${statusBadge[s.status]}
        </div>`;
    });

    detailCanvas.show();
  }

  renderGrid();
</script>
</body>
</html>
