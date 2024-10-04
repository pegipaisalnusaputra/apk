<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda
$dbname = 'db_client';

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data berdasarkan nama
$nama = $_GET['nama'];
$query = "SELECT * FROM tb_clientblmapprove WHERE nama='$nama'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Proses approve/reject
if (isset($_POST['approve'])) {
    // Pindahkan data ke tb_kredit
    $queryInsert = "INSERT INTO tb_kredit (nama, alamat, nohp, aplikasi, nominal_aplikasi, total_kredit, nama_marketing, persentase) VALUES ('$data[nama]', '$data[alamat]', '$data[nohp]', 'Aplikasi', 'Nominal', '$data[total_kredit]', 'Nama Marketing', 'Persentase')";
    mysqli_query($conn, $queryInsert);
    
    // Hapus dari tb_clientblmapprove
    $queryDelete = "DELETE FROM tb_clientblmapprove WHERE nama='$nama'";
    mysqli_query($conn, $queryDelete);
    echo "Data telah diapprove.";
} elseif (isset($_POST['reject'])) {
    // Hapus dari tb_clientblmapprove
    $queryDelete = "DELETE FROM tb_clientblmapprove WHERE nama='$nama'";
    mysqli_query($conn, $queryDelete);
    echo "Data telah ditolak.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Nasabah</title>
</head>
<body>
    <h2>Detail Nasabah</h2>
    <p>Nama: <?= $data['nama'] ?></p>
    <p>Alamat: <?= $data['alamat'] ?></p>
    <p>No HP: <?= $data['nohp'] ?></p>
    <p>Total Kredit: <?= $data['total_kredit'] ?></p>

    <form method="post">
        <button type="submit" name="approve">Approve</button>
        <button type="submit" name="reject">Reject</button>
    </form>
</body>
</html>
