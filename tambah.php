<?php
require_once 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_siswa = trim($_POST['nama_siswa']);
    $kelas      = trim($_POST['kelas']);
    $tanggal    = $_POST['tanggal'];
    $status     = $_POST['status'];

    if ($nama_siswa == '' || $kelas == '' || $tanggal == '' || $status == '') {
        $error = "Semua field wajib diisi!";
    } else {

        $query = "INSERT INTO tb_absensi (nama_siswa, kelas, tanggal, status)
                  VALUES ('$nama_siswa', '$kelas', '$tanggal', '$status')";

        if (mysqli_query($conn, $query)) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Absensi</title>

    <!-- CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #333;
        }

        .error {
            background: #ffdddd;
            color: red;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>

</head>
<body>

<div class="container">

    <h2>Tambah Data Absensi</h2>

    <!-- Error message -->
    <?php if (!empty($error)) : ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nama Siswa:</label>
        <input type="text" name="nama_siswa">

        <label>Kelas:</label>
        <input type="text" name="kelas">

        <label>Tanggal:</label>
        <input type="date" name="tanggal">

        <label>Status:</label>
        <select name="status">
            <option value="">-- Pilih --</option>
            <option value="Hadir">Hadir</option>
            <option value="Izin">Izin</option>
            <option value="Sakit">Sakit</option>
            <option value="Alpa">Alpa</option>
        </select>

        <button type="submit">Simpan</button>
    </form>

    <a class="back" href="index.php">← Kembali</a>

</div>

</body>
</html>