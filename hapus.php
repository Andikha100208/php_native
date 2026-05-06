<?php
require_once 'config/koneksi.php';

// Ambil ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("ID tidak valid!");
}

// =====================
// PROSES HAPUS
// =====================
if (isset($_POST['confirm_hapus'])) {

    $stmt = $conn->prepare("DELETE FROM tb_absensi WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?hapus=berhasil");
        exit;
    } else {
        echo "Gagal menghapus data!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Hapus</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #dc3545;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 25px;
            color: #333;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-back {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }

        .btn-back:hover {
            background: #5a6268;
        }
    </style>

</head>
<body>

<div class="container">

    <h2>⚠️ Konfirmasi Hapus</h2>

    <p>Apakah kamu yakin ingin menghapus data ini?<br>
    Data yang sudah dihapus tidak bisa dikembalikan.</p>

    <form method="POST">
        <button type="submit" name="confirm_hapus" class="btn-danger">
            Ya, Hapus
        </button>

        <a href="index.php" class="btn-back">
            Batal
        </a>
    </form>

</div>

</body>
</html>