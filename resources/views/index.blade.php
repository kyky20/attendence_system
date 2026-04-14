<h2>Data Mahasiswa</h2>

<a href="/mahasiswa/create">Tambah</a>

<table border="1">
    <tr>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Email</th>
        <th>Aksi</th>
    </tr>

    @foreach ($data as $mhs)
        <tr>
            <td>{{ $mhs->nim }}</td>
            <td>{{ $mhs->nama }}</td>
            <td>{{ $mhs->jurusan }}</td>
            <td>{{ $mhs->email }}</td>
            <td>
                <a href="/mahasiswa/{{ $mhs->id }}/edit">Edit</a>
                <form action="/mahasiswa/{{ $mhs->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
