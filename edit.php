<?php
require_once 'config/koneksi.php';

// Ambil ID dari URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("ID tidak valid!");
}

// =====================
// PROSES UPDATE
// =====================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_siswa = trim($_POST['nama_siswa']);
    $kelas      = trim($_POST['kelas']);
    $tanggal    = $_POST['tanggal'];
    $status     = $_POST['status'];

    if ($nama_siswa == '' || $kelas == '' || $tanggal == '' || $status == '') {
        $error = "Semua field wajib diisi!";
    } else {

        $stmt = $conn->prepare("
            UPDATE tb_absensi 
            SET nama_siswa=?, kelas=?, tanggal=?, status=? 
            WHERE id=?
        ");

        $stmt->bind_param("ssssi", $nama_siswa, $kelas, $tanggal, $status, $id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Gagal update data!";
        }

        $stmt->close();
    }
}

// =====================
// AMBIL DATA LAMA
// =====================
$stmt = $conn->prepare("SELECT * FROM tb_absensi WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Absensi</title>

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
            background: #ffc107;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #e0a800;
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

    <h2>Edit Data Absensi</h2>

    <?php if (!empty($error)) : ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nama Siswa:</label>
        <input type="text" name="nama_siswa" value="<?= htmlspecialchars($data['nama_siswa']); ?>">

        <label>Kelas:</label>
        <input type="text" name="kelas" value="<?= htmlspecialchars($data['kelas']); ?>">

        <label>Tanggal:</label>
        <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>">

        <label>Status:</label>
        <select name="status">
            <option value="Hadir" <?= $data['status']=='Hadir'?'selected':''; ?>>Hadir</option>
            <option value="Izin" <?= $data['status']=='Izin'?'selected':''; ?>>Izin</option>
            <option value="Sakit" <?= $data['status']=='Sakit'?'selected':''; ?>>Sakit</option>
            <option value="Alpa" <?= $data['status']=='Alpa'?'selected':''; ?>>Alpa</option>
        </select>

        <button type="submit">Update</button>
    </form>

    <a class="back" href="index.php">← Kembali</a>

</div>

</body>
</html>