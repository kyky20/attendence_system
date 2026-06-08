<div class="col-md-4">
  <label class="form-label">Kode MK</label>
  <input type="text" name="kode_matakuliah" class="form-control" value="{{ old('kode_matakuliah', $matakuliah->kode_matakuliah ?? '') }}" required>
</div>
<div class="col-md-8">
  <label class="form-label">Nama Mata Kuliah</label>
  <input type="text" name="nama_matakuliah" class="form-control" value="{{ old('nama_matakuliah', $matakuliah->nama_matakuliah ?? '') }}" required>
</div>
<div class="col-md-6">
  <label class="form-label">Kelas</label>
  <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $matakuliah->kelas ?? '') }}">
</div>
<div class="col-md-3">
  <label class="form-label">SKS</label>
  <input type="number" name="sks" class="form-control" value="{{ old('sks', $matakuliah->sks ?? 3) }}" min="1" max="6" required>
</div>
<div class="col-md-3">
  <label class="form-label">Nilai</label>
  <input type="number" name="nilai" class="form-control" value="{{ old('nilai', $matakuliah->nilai ?? 0) }}" min="0" max="100">
</div>
<div class="col-md-6">
  <label class="form-label">Jadwal</label>
  <input type="time" name="jadwal" class="form-control" value="{{ old('jadwal', $matakuliah?->jadwal ? $matakuliah->jadwal->format('H:i') : '') }}">
</div>
<div class="col-md-6">
  <label class="form-label">Ruang</label>
  <input type="text" name="ruang" class="form-control" value="{{ old('ruang', $matakuliah->ruang ?? '') }}">
</div>
<div class="col-12">
  <label class="form-label">Status</label>
  <select name="status" class="form-select" required>
    @foreach(['Aktif', 'Non-Aktif'] as $status)
      <option value="{{ $status }}" @selected(old('status', $matakuliah->status ?? 'Aktif') === $status)>{{ $status }}</option>
    @endforeach
  </select>
</div>
