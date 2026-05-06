<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Scan QR – Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <style>
    :root { --maroon: #800020; --maroon-dark: #5a0016; --gray-bg: #f4f6f9; --nav-h: 65px; }
    body { font-family: 'Segoe UI', sans-serif; background: var(--gray-bg); padding-bottom: var(--nav-h); }

    /* TOP HEADER */
    .top-header {
      background: linear-gradient(135deg, var(--maroon-dark), var(--maroon));
      padding: 1rem 1.2rem;
    }
    .top-header .title { color: #fff; font-weight: 700; font-size: 1.1rem; }
    .top-header small  { color: rgba(255,255,255,0.7); font-size: .78rem; }
    .back-btn {
      width: 36px; height: 36px; border-radius: 50%;
      background: rgba(255,255,255,0.15); border: none;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 1rem; cursor: pointer; text-decoration: none;
    }

    /* SCAN VIEWPORT */
    .scan-viewport-wrap {
      background: #1a1a2e;
      display: flex; align-items: center; justify-content: center;
      height: 320px; position: relative; overflow: hidden;
    }
    .scan-frame {
      width: 230px; height: 230px; position: relative;
    }
    /* Corner markers */
    .scan-frame::before, .scan-frame::after,
    .scan-frame .corner-br, .scan-frame .corner-tl2 {
      content: '';
      position: absolute; width: 30px; height: 30px; border: 3px solid #ffd700;
    }
    .scan-frame::before { top: 0; left: 0; border-right: none; border-bottom: none; border-radius: 4px 0 0 0; }
    .scan-frame::after  { top: 0; right: 0; border-left: none; border-bottom: none; border-radius: 0 4px 0 0; }
    .scan-frame .corner-br {
      bottom: 0; right: 0; border-left: none; border-top: none; border-radius: 0 0 4px 0;
      position: absolute;
    }
    .scan-frame .corner-bl {
      content: '';
      position: absolute;
      bottom: 0; left: 0; width: 30px; height: 30px;
      border: 3px solid #ffd700;
      border-right: none; border-top: none; border-radius: 0 0 0 4px;
    }
    /* Scan beam */
    .scan-beam {
      position: absolute; left: 0; right: 0; top: 0;
      height: 2px; background: linear-gradient(90deg, transparent, #ffd700, transparent);
      animation: scanMove 2s linear infinite;
    }
    .scan-beam.paused { animation-play-state: paused; }
    @keyframes scanMove { 0%{top:0} 100%{top:230px} }

    /* QR placeholder inside frame */
    .qr-placeholder {
      width: 100%; height: 100%;
      display: flex; align-items: center; justify-content: center;
      border: 1px dashed rgba(255,255,255,0.15); border-radius: 4px;
    }

    /* Step indicators */
    .step-bar {
      display: flex; align-items: center; justify-content: center; gap: .4rem;
      padding: .8rem;
    }
    .step-dot {
      width: 28px; height: 28px; border-radius: 50%;
      border: 2px solid #ddd; display: flex; align-items: center; justify-content: center;
      font-size: .7rem; font-weight: 700; color: #aaa; background: #fff; transition: all .4s;
    }
    .step-dot.active { border-color: var(--maroon); color: var(--maroon); }
    .step-dot.done   { border-color: #198754; background: #198754; color: #fff; }
    .step-line { flex: 1 1 0; height: 2px; background: #ddd; max-width: 40px; border-radius: 2px; transition: background .4s; }
    .step-line.done { background: #198754; }

    /* ACTION BUTTONS */
    .btn-scan-success {
      display: flex; align-items: center; justify-content: center; gap: .6rem;
      width: 100%; padding: .9rem; border: none; border-radius: 14px;
      background: linear-gradient(135deg, #198754, #20c997);
      color: #fff; font-weight: 700; font-size: 1rem; cursor: pointer;
      box-shadow: 0 4px 16px rgba(25,135,84,0.3); transition: transform .15s;
    }
    .btn-scan-success:hover { transform: translateY(-2px); }

    .btn-scan-fail {
      display: flex; align-items: center; justify-content: center; gap: .6rem;
      width: 100%; padding: .9rem; border: 2px solid #dc3545; border-radius: 14px;
      background: rgba(220,53,69,0.05); color: #dc3545;
      font-weight: 700; font-size: 1rem; cursor: pointer; transition: all .15s;
    }
    .btn-scan-fail:hover { background: #dc3545; color: #fff; }

    /* RESULT CARD */
    .result-card {
      border-radius: 16px; padding: 1.5rem; text-align: center;
      display: none; animation: fadeIn .4s ease;
    }
    @keyframes fadeIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .result-icon { font-size: 4rem; margin-bottom: .8rem; }

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

    .info-row {
      display: flex; align-items: center; gap: .6rem;
      padding: .5rem .8rem; background: var(--gray-bg); border-radius: 8px;
      font-size: .83rem; color: #555;
    }
    .info-row i { color: var(--maroon); }

    /* Toast */
    .toast-container { position: fixed; top: 80px; left: 50%; transform: translateX(-50%); z-index: 9999; }
  </style>
</head>
<body>

<!-- TOP HEADER -->
<div class="top-header">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ url('/' . request()->segment(1) . '/dashboard') }}" class="back-btn"><i class="bi bi-arrow-left"></i></a>
    <div>
      <div class="title">Scan QR Presensi</div>
      <small>Arahkan kamera ke QR code dosen</small>
    </div>
  </div>
</div>

<!-- STEP INDICATORS -->
<div class="step-bar bg-white border-bottom" id="stepBar">
  <div class="step-dot active" id="step1">1</div>
  <div class="step-line" id="line1"></div>
  <div class="step-dot" id="step2">2</div>
  <div class="step-line" id="line2"></div>
  <div class="step-dot" id="step3">3</div>
</div>
<div class="text-center bg-white border-bottom py-1 pb-2">
  <small class="text-muted" id="stepLabel" style="font-size:.75rem;">Langkah 1: Mulai scan kamera</small>
</div>

<!-- SCAN VIEWPORT -->
<div class="scan-viewport-wrap" id="scanViewport">
  <div class="scan-frame">
    <div class="scan-beam" id="scanBeam"></div>
    <div class="qr-placeholder">
      <i class="bi bi-qr-code" style="font-size:5rem;color:rgba(255,255,255,0.15);"></i>
    </div>
    <div class="corner-br"></div>
    <div class="corner-bl"></div>
  </div>

  <!-- overlaying status label -->
  <div style="position:absolute;bottom:12px;left:50%;transform:translateX(-50%);white-space:nowrap;">
    <span class="badge rounded-pill text-bg-warning px-3" id="scanStatus">
      <i class="bi bi-camera-video me-1"></i> Menunggu QR…
    </span>
  </div>
</div>

<!-- CONTENT BELOW VIEWPORT -->
<div class="p-3" style="max-width:480px;margin:auto;">

  <!-- RESULT CARD (hidden by default) -->
  <div class="result-card bg-white shadow-sm" id="resultCard">
    <div class="result-icon" id="resultIcon">✅</div>
    <h5 id="resultTitle" class="fw-bold">Presensi Berhasil!</h5>
    <p class="text-muted" id="resultMsg" style="font-size:.88rem;">Kehadiran Anda telah tercatat.</p>
    <div class="d-flex flex-column gap-2 mt-3" id="resultDetails"></div>
    <button class="btn btn-sm mt-3 px-4 rounded-pill text-white" style="background:var(--maroon);" onclick="resetScan()">
      <i class="bi bi-arrow-clockwise me-1"></i>Scan Lagi
    </button>
  </div>

  <!-- SCAN BUTTONS (shown by default) -->
  <div id="scanButtons">
    <!-- Info -->
    <div class="d-flex flex-column gap-2 mb-3">
      <div class="info-row"><i class="bi bi-person-fill"></i> <span>{{ auth()->user()->name }} &nbsp;<code>{{ auth()->user()->email }}</code></span></div>
      <div class="info-row"><i class="bi bi-calendar3"></i> <span id="currDate"></span></div>
      <div class="info-row"><i class="bi bi-clock"></i> <span id="currTime"></span></div>
    </div>

    <div class="d-flex flex-column gap-2">
      <button class="btn-scan-success" onclick="simulateScanSuccess()">
        <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
        Simulasi: Scan Berhasil
      </button>
      <button class="btn-scan-fail" onclick="simulateScanFail()">
        <i class="bi bi-x-circle-fill" style="font-size:1.2rem;"></i>
        Simulasi: Scan Gagal
      </button>
    </div>

    <p class="text-muted text-center mt-3" style="font-size:.75rem;">
      <i class="bi bi-info-circle me-1"></i>
      Pada implementasi nyata, kamera perangkat akan diaktifkan untuk membaca QR Code dari layar dosen.
    </p>
  </div>

</div><!-- end content -->

<!-- BOTTOM NAV -->
<nav class="bottom-nav">
  <a href="{{ url('/' . request()->segment(1) . '/dashboard') }}" class="nav-item-btn">
    <i class="bi bi-house-fill"></i><span>Beranda</span>
  </a>
  <a href="{{ url('/' . request()->segment(1) . '/list_matakuliah') }}" class="nav-item-btn">
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

<!-- Toast -->
<div class="toast-container">
  <div id="mainToast" class="toast align-items-center border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="toastMsg"></div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Current time display
  function updateTime() {
    const now = new Date();
    document.getElementById('currDate').textContent =
      now.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
    document.getElementById('currTime').textContent =
      now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit', second:'2-digit' });
  }
  updateTime();
  setInterval(updateTime, 1000);

  function setStep(n) {
    [1,2,3].forEach(i => {
      const dot = document.getElementById('step'+i);
      dot.className = 'step-dot' + (i < n ? ' done' : i === n ? ' active' : '');
      if (i < n) dot.innerHTML = '<i class="bi bi-check"></i>';
      else dot.textContent = i;
    });
    [1,2].forEach(i => {
      document.getElementById('line'+i).className = 'step-line' + (i < n ? ' done' : '');
    });
    const labels = {1:'Langkah 1: Mulai scan kamera', 2:'Langkah 2: Memproses QR Code…', 3:'Langkah 3: Selesai'};
    document.getElementById('stepLabel').textContent = labels[n];
  }

  function simulateScanSuccess() {
    // STEP 2 – processing
    setStep(2);
    document.getElementById('scanStatus').innerHTML = '<i class="bi bi-arrow-repeat spin me-1"></i> Memproses…';
    document.getElementById('scanStatus').className = 'badge rounded-pill text-bg-info px-3';
    document.getElementById('scanBeam').style.animationDuration = '0.4s';

    setTimeout(() => {
      // STEP 3 – success
      setStep(3);
      document.getElementById('scanBeam').classList.add('paused');
      document.getElementById('scanStatus').innerHTML = '<i class="bi bi-check2 me-1"></i> Terdeteksi!';
      document.getElementById('scanStatus').className = 'badge rounded-pill text-bg-success px-3';

      const now = new Date();
      document.getElementById('resultIcon').textContent = '✅';
      document.getElementById('resultTitle').textContent = 'Presensi Berhasil!';
      document.getElementById('resultTitle').style.color = '#198754';
      document.getElementById('resultMsg').textContent   = 'Kehadiran Anda telah tercatat oleh sistem.';

      const details = [
        { icon:'bi-book-fill',    label:'Mata Kuliah', val:'Algoritma & Pemrograman' },
        { icon:'bi-calendar3',   label:'Tanggal', val: now.toLocaleDateString('id-ID') },
        { icon:'bi-clock-fill',  label:'Waktu',   val: now.toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'}) },
        { icon:'bi-person-fill', label:'Status',  val: 'HADIR ✓' },
      ];
      const dd = document.getElementById('resultDetails');
      dd.innerHTML = '';
      details.forEach(d => {
        dd.innerHTML += `
          <div class="d-flex align-items-center gap-2 bg-light rounded px-3 py-2" style="font-size:.83rem;">
            <i class="bi ${d.icon}" style="color:var(--maroon);width:16px;"></i>
            <span class="text-muted">${d.label}:</span>
            <span class="fw-600">${d.val}</span>
          </div>`;
      });

      document.getElementById('scanButtons').style.display = 'none';
      document.getElementById('resultCard').style.display  = 'block';
      showToast('✅ Presensi berhasil dicatat!', 'success');
    }, 1400);
  }

  function simulateScanFail() {
    setStep(2);
    document.getElementById('scanStatus').innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i> Gagal…';
    document.getElementById('scanStatus').className = 'badge rounded-pill text-bg-danger px-3';

    setTimeout(() => {
      setStep(3);
      document.getElementById('scanBeam').classList.add('paused');

      document.getElementById('resultIcon').textContent = '❌';
      document.getElementById('resultTitle').textContent = 'Scan Gagal!';
      document.getElementById('resultTitle').style.color = '#dc3545';
      document.getElementById('resultMsg').textContent   = 'QR Code tidak valid atau sudah kadaluarsa. Hubungi dosen Anda.';

      document.getElementById('resultDetails').innerHTML = `
        <div class="alert alert-danger rounded-3 py-2 px-3 text-start" style="font-size:.82rem;">
          <i class="bi bi-exclamation-triangle me-1"></i>
          QR Code telah expired atau di luar area yang diizinkan.
        </div>`;

      document.getElementById('scanButtons').style.display = 'none';
      document.getElementById('resultCard').style.display  = 'block';
      showToast('❌ Scan gagal. QR tidak valid.', 'danger');
    }, 1200);
  }

  function resetScan() {
    setStep(1);
    document.getElementById('resultCard').style.display  = 'none';
    document.getElementById('scanButtons').style.display = 'block';
    document.getElementById('scanBeam').classList.remove('paused');
    document.getElementById('scanBeam').style.animationDuration = '2s';
    document.getElementById('scanStatus').innerHTML = '<i class="bi bi-camera-video me-1"></i> Menunggu QR…';
    document.getElementById('scanStatus').className = 'badge rounded-pill text-bg-warning px-3';
  }

  function showToast(msg, type) {
    const toast = document.getElementById('mainToast');
    toast.className = `toast align-items-center border-0 text-bg-${type}`;
    document.getElementById('toastMsg').textContent = msg;
    new bootstrap.Toast(toast, { delay: 3500 }).show();
  }
</script>
</body>
</html>
