<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Presensi Gagal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-5 text-center">

        <h1 class="text-danger mb-3">
            ❌ Presensi Gagal
        </h1>

        <p class="text-muted">
            {{ $message }}
        </p>

        <a href="/mahasiswa/dashboard"
           class="btn btn-danger mt-3">

            Kembali

        </a>

    </div>

</body>
</html>