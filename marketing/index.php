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

// Inisialisasi variabel
$success_message = '';
$error_message = '';

if (isset($_POST['kirim'])) {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];
    $tanggal_input = $_POST['tanggal_input'];
    $total_kredit = $_POST['total_kredit'];
    $biaya_admin = $_POST['biaya_admin'];

    // Upload KTP
    $ktp = $_FILES['ktp'];
    $ktp_name = $ktp['name'];
    $ktp_tmp_name = $ktp['tmp_name'];
    $ktp_error = $ktp['error'];
    $ktp_size = $ktp['size'];

    // Validasi upload KTP
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $file_extension = pathinfo($ktp_name, PATHINFO_EXTENSION);

    if ($ktp_error === 0) {
        if ($ktp_size <= 2 * 1024 * 1024 && in_array(strtolower($file_extension), $allowed_extensions)) {
            $new_ktp_name = uniqid('', true) . "." . $file_extension;
            $upload_path = "uploads/" . $new_ktp_name;

            if (move_uploaded_file($ktp_tmp_name, $upload_path)) {
                // Simpan data ke database
                $query = "INSERT INTO tb_clientblmapprove (nama, alamat, nohp, tanggal_input, total_kredit, biaya_admin, ktp) 
                          VALUES ('$nama', '$alamat', '$nohp', '$tanggal_input', '$total_kredit', '$biaya_admin', '$new_ktp_name')";

                if (mysqli_query($conn, $query)) {
                    $success_message = "Data berhasil dikirim!";
                } else {
                    $error_message = "Error: " . mysqli_error($conn);
                }
            } else {
                $error_message = "Terjadi kesalahan saat meng-upload KTP.";
            }
        } else {
            $error_message = "File KTP tidak valid. Pastikan ukuran file maksimal 2MB dan formatnya jpg, jpeg, atau png.";
        }
    } else {
        $error_message = "Terjadi kesalahan saat meng-upload KTP.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Nasabah</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Form Input Data Nasabah</h2>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message; ?></div>
        <?php endif; ?>

        <form id="nasabahForm" method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="mb-3">
                <label for="nohp" class="form-label">No HP</label>
                <input type="text" class="form-control" id="nohp" name="nohp" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_input" class="form-label">Tanggal Input</label>
                <input type="date" class="form-control" id="tanggal_input" name="tanggal_input" required>
            </div>
            <div id="creditFields">
                <div class="mb-3 row">
                    <div class="col">
                        <label for="kredit1" class="form-label">Aplikasi: </label>
                        <input type="text" class="form-control" name="nama_apk[]" id="kredit1" required>
                    </div>                    
                    <div class="col">
                        <label for="kredit1" class="form-label">Kredit 1</label>
                        <input type="number" class="form-control" name="kredit[]" id="kredit1" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="addCredit">Tambah Kredit</button>
            <div class="mt-3">
                <label for="total_kredit" class="form-label">Total Kredit</label>
                <input type="text" class="form-control" id="total_kredit" name="total_kredit" readonly>
            </div>
            <div class="mt-3">
                <label for="biaya_admin" class="form-label">Biaya Admin</label>
                <input type="text" class="form-control" id="biaya_admin" name="biaya_admin" readonly>
            </div>
            <div class="mb-3">
                <label for="ktp" class="form-label">Upload KTP</label>
                <input type="file" class="form-control" id="ktp" name="ktp" accept=".jpg, .jpeg, .png" required>
                <div class="form-text">Format: jpg, jpeg, png. Maksimal 2MB.</div>
            </div>
            <button type="submit" class="btn btn-primary mt-3" name="kirim">Kirim Data</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            var creditCount = 1; // Menghitung jumlah kredit
            $("#addCredit").click(function() {
                creditCount++;
                $("#creditFields").append(`
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="kredit" class="form-label">Aplikasi</label>
                            <input type="text" class="form-control" name="nama_apk[]" id="kredit" required>
                        </div>
                        <div class="col">
                            <label for="kredit${creditCount}" class="form-label">Kredit ${creditCount}</label>
                            <input type="number" class="form-control" name="kredit[]" id="kredit${creditCount}" required>
                        </div>
                    </div>
                `);
            });

            // Menghitung total kredit dan biaya admin
            $("#nasabahForm").on("input", "input[name='kredit[]']", function() {
                var totalKredit = 0;
                $("input[name='kredit[]']").each(function() {
                    totalKredit += parseFloat($(this).val()) || 0;
                });
                $("#total_kredit").val(totalKredit);
                $("#biaya_admin").val((totalKredit * 0.2).toFixed(2));
            });
        });
    </script>
</body>
</html>
