<div class="col-md-6">
  <label class="form-label">NIM</label>
  <input type="text" name="nim" class="form-control" value="{{ old('nim', $mahasiswa->nim ?? '') }}" required>
</div>
<div class="col-md-6">
  <label class="form-label">Nama</label>
  <input type="text" name="nama" class="form-control" value="{{ old('nama', $mahasiswa->nama ?? '') }}" required>
</div>
<div class="col-md-6">
  <label class="form-label">Jurusan</label>
  <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $mahasiswa->jurusan ?? 'Teknik Informatika') }}" required>
</div>
<div class="col-md-6">
  <label class="form-label">Angkatan</label>
  <input type="number" name="angkatan" class="form-control" value="{{ old('angkatan', $mahasiswa->angkatan ?? date('Y')) }}">
</div>
<div class="col-md-6">
  <label class="form-label">Email Login</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', $mahasiswa->user->email ?? $mahasiswa->email ?? '') }}" required>
</div>
<div class="col-md-6">
  <label class="form-label">No. HP</label>
  <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $mahasiswa->no_hp ?? '') }}">
</div>
<div class="col-md-6">
  <label class="form-label">Password {{ $mahasiswa ? '(kosongkan jika tidak diganti)' : '' }}</label>
  <input type="password" name="password" class="form-control" {{ $mahasiswa ? '' : 'required' }}>
</div>
<div class="col-md-6">
  <label class="form-label">Status</label>
  <select name="status" class="form-select" required>
    @foreach(['Aktif', 'Cuti', 'Non-Aktif'] as $status)
      <option value="{{ $status }}" @selected(old('status', $mahasiswa->status ?? 'Aktif') === $status)>{{ $status }}</option>
    @endforeach
  </select>
</div>
