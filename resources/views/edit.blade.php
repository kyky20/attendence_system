<h2>Edit Mahasiswa</h2>

<form action="/mahasiswa/{{ $data->id }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nim" value="{{ $data->nim }}"><br>
    <input type="text" name="nama" value="{{ $data->nama }}"><br>
    <input type="text" name="jurusan" value="{{ $data->jurusan }}"><br>
    <input type="email" name="email" value="{{ $data->email }}"><br>

    <button type="submit">Update</button>
</form>
