<!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Login – Ambasen</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
      <style>
        :root {
          --maroon: #800020;
          --maroon-dark: #5a0016;
          --maroon-light: #a8003080;
          --gray-bg: #f4f6f9;
        }
    
        * { box-sizing: border-box; margin: 0; padding: 0; }
    
        body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background: var(--gray-bg);
          min-height: 100vh;
          display: flex;
          align-items: stretch;
        }
    
        .login-left {
          background: linear-gradient(135deg, var(--maroon-dark) 0%, var(--maroon) 60%, #c0003a 100%);
          flex: 1;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          padding: 3rem 2rem;
          position: relative;
          overflow: hidden;
        }
    
        .login-left::before {
          content: '';
          position: absolute;
          width: 400px; height: 400px;
          background: rgba(255,255,255,0.05);
          border-radius: 50%;
          top: -100px; left: -100px;
        }
        .login-left::after {
          content: '';
          position: absolute;
          width: 300px; height: 300px;
          background: rgba(255,255,255,0.04);
          border-radius: 50%;
          bottom: -80px; right: -80px;
        }
    
        .brand-logo {
          width: 90px; height: 90px;
          background: rgba(255,255,255,0.15);
          border-radius: 50%;
          display: flex; align-items: center; justify-content: center;
          margin-bottom: 1.5rem;
          border: 3px solid rgba(255,255,255,0.3);
          backdrop-filter: blur(4px);
        }
        .brand-logo i { font-size: 2.8rem; color: #fff; }
    
        .brand-title { color: #fff; font-size: 2.4rem; font-weight: 700; letter-spacing: 2px; }
        .brand-sub   { color: rgba(255,255,255,0.75); font-size: 0.95rem; margin-top: .4rem; text-align: center; }
    
        .login-right {
          width: 460px;
          background: #fff;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          padding: 3rem 2.5rem;
          box-shadow: -10px 0 40px rgba(0,0,0,0.08);
        }
    
        .login-right h2 { font-size: 1.7rem; font-weight: 700; color: #1a1a2e; }
        .login-right p.sub { color: #888; font-size: 0.88rem; margin-bottom: 2rem; }
    
        .form-label { font-weight: 600; font-size: 0.85rem; color: #444; }
    
        .form-control {
          border-radius: 10px;
          border: 1.5px solid #e0e0e0;
          padding: .65rem 1rem;
          font-size: 0.95rem;
          transition: border-color .25s, box-shadow .25s;
        }
        .form-control:focus {
          border-color: var(--maroon);
          box-shadow: 0 0 0 3px rgba(128,0,32,0.12);
        }
    
        .input-group .btn-outline-secondary {
          border-radius: 0 10px 10px 0;
          border: 1.5px solid #e0e0e0;
          border-left: none;
        }
    
        .login-as-label {
          font-size: 1.1rem;
          font-weight: 700;
          color: #1a1a2e;
          width: 100%;
          margin-bottom: .8rem;
        }
    
        .role-selector { display: flex; gap: .6rem; margin-bottom: 1.5rem; }
        .role-btn {
          flex: 1;
          padding: .55rem;
          border-radius: 10px;
          border: 2px solid #e0e0e0;
          background: #fff;
          cursor: pointer;
          font-size: 0.85rem;
          font-weight: 600;
          color: #888;
          display: flex; align-items: center; justify-content: center; gap: .4rem;
          transition: all .2s;
        }
        .role-btn.active {
          border-color: var(--maroon);
          background: rgba(128,0,32,0.06);
          color: var(--maroon);
        }
        .role-btn i { font-size: 1.1rem; }
    
        .btn-login {
          width: 100%;
          background: linear-gradient(135deg, var(--maroon), #c0003a);
          color: #fff;
          border: none;
          border-radius: 10px;
          padding: .75rem;
          font-size: 1rem;
          font-weight: 600;
          letter-spacing: .5px;
          transition: transform .15s, box-shadow .15s;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(128,0,32,0.35); }
        .btn-login:active { transform: translateY(0); }
    
        .alert-custom {
          border-radius: 10px;
          font-size: 0.88rem;
          display: none;
        }
    
        @media (max-width: 768px) {
          .login-left { display: none; }
          .login-right { width: 100%; padding: 2.5rem 1.5rem; }
        }
      </style>
    </head>
    <body>
    
      <!-- LEFT PANEL -->
      <div class="login-left d-none d-md-flex">
        <div class="brand-logo">
          <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div class="brand-title">AMBASEN</div>
        <div class="brand-sub">Aplikasi Presensi Akademik Modern</div>
      </div>
    
      <!-- RIGHT PANEL (Form) -->
      <div class="login-right">
        <!-- Alert -->
        @if ($errors->any())
        <div class="alert alert-danger alert-custom w-100" style="display:block;">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          <span>{{ $errors->first() }}</span>
        </div>
        @endif
    
        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="w-100">
          @csrf
          <div class="mb-3">
            <label class="form-label" id="usernameLabel">Email</label>
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0 rounded-start-3" style="border:1.5px solid #e0e0e0;border-right:none;">
                <i class="bi bi-person text-secondary"></i>
              </span>
              <input type="email" name="email" class="form-control border-start-0 rounded-0" id="email"
                placeholder="Masukkan Email" required value="{{ old('email') }}" autofocus autocomplete="username"
                style="border-left:none;border-radius:0 10px 10px 0 !important;border:1.5px solid #e0e0e0;"/>
            </div>
          </div>
    
          <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0 rounded-start-3" style="border:1.5px solid #e0e0e0;border-right:none;">
                <i class="bi bi-lock text-secondary"></i>
              </span>
              <input type="password" name="password" class="form-control border-start-0 rounded-0" id="password"
                placeholder="Masukkan password" required autocomplete="current-password"
                style="border-left:none;border:1.5px solid #e0e0e0;border-left:none;border-radius:0 !important;"/>
              <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                <i class="bi bi-eye" id="eyeIcon"></i>
              </button>
            </div>
          </div>
          
          <div class="block mb-4">
              <label for="remember_me" class="inline-flex items-center">
                  <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                  <span class="ms-2 text-sm text-gray-600" style="margin-left: 8px;">{{ __('Remember me') }}</span>
              </label>
          </div>
    
          <button type="submit" class="btn-login" id="btnLogin">
            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
          </button>
        </form>
      </div>
    
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        function togglePassword() {
          const pw  = document.getElementById('password');
          const eye = document.getElementById('eyeIcon');
          if (pw.type === 'password') {
            pw.type = 'text';
            eye.className = 'bi bi-eye-slash';
          } else {
            pw.type = 'password';
            eye.className = 'bi bi-eye';
          }
        }
      </script>
    </body>
</html>
