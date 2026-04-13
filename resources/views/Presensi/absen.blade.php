<!DOCTYPE html>
<html>
<head>
    <title>Form Absen</title>
</head>
<body>
    <h2>Isi Nama</h2>

    <form method="POST" action="/absen">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <input type="text" name="nama" placeholder="Masukkan nama">

        <button type="submit">Absen</button>
    </form>

</body>
</html>