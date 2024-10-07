<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
// Koneksi ke database
require 'db_connect.php';

// Impor PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Fungsi untuk mengirim email menggunakan PHPMailer
function sendEmail($nama, $alamat, $nohp, $total_kredit) {
    global $_SESSION;
    $nama_marketing = $_SESSION['username'];
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'efaizal22@gmail.com';              // SMTP username
        $mail->Password = 'lzjarazjemorwlkt';                   // SMTP password (App Password)
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                   // TCP port to connect to

        //Recipients
        $mail->setFrom('no-reppy@mabesapk.com', 'Mabes APK');
        $mail->addAddress('suts30259@gmail.com');            // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Request Input Nasabah';
        $mail->Body    = "
        Ada request input nasabah baru: <br><br>
        <strong>Nama:</strong> $nama<br>
        <strong>Alamat:</strong> $alamat<br>
        <strong>No HP:</strong> $nohp<br>
        <strong>Total Kredit:</strong> $total_kredit<br>
        <strong>di input oleh: </strong> $nama_marketing<br>
        
        <br>
        Klik <a href='#'>di sini</a> untuk melihat detail dan approve.
        ";

        $mail->send();
    } catch (Exception $e) {
        echo "Email tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}";
    }
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
    // $nama_marketing = $_POST['nama_marketing']; // Nama marketing
    $persentase = 0.2; // Misalnya 20% bisa diubah sesuai kebutuhan

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
                // Simpan data ke database tb_clientblmapprove
                $query = "INSERT INTO tb_clientblmapprove (nama, alamat, nohp, tanggal_input, total_kredit, biaya_admin, ktp) 
                        VALUES ('$nama', '$alamat', '$nohp', '$tanggal_input', '$total_kredit', '$biaya_admin', '$new_ktp_name')";

                if (mysqli_query($conn, $query)) {
                    // Kirim email notifikasi
                    sendEmail($nama, $alamat, $nohp, $total_kredit);

                    // Simpan data ke database tb_kredit untuk setiap aplikasi
                    $kredit_aplikasi = $_POST['nama_apk'];
                    $kredit_nominal = $_POST['kredit'];

                    for ($i = 0; $i < count($kredit_aplikasi); $i++) {
                        $aplikasi = mysqli_real_escape_string($conn, $kredit_aplikasi[$i]);
                        $nominal_aplikasi = mysqli_real_escape_string($conn, $kredit_nominal[$i]);

                        // Insert ke tabel tb_kredit
                        $query_kredit = "INSERT INTO tb_kredit (nama, alamat, nohp, aplikasi, nominal_aplikasi, total_kredit, persentase)
                                        VALUES ('$nama', '$alamat', '$nohp', '$aplikasi', '$nominal_aplikasi', '$total_kredit', '$persentase')";

                        mysqli_query($conn, $query_kredit);
                    }

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
    <style>
        /* Gaya latar belakang */
        body {
            background-image: url('img/mabes.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
        .overlay {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 2rem;
            border-radius: 8px;
        }
        .form-container {
            max-width: 600px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="d-flex justify-content-center align-items-center vh-100">
        <div class="container overlay form-container">
            <h2 class="text-center mb-4">Form Input Data Nasabah</h2>

            <?php if ($success_message): ?>
                <div class="alert alert-success text-center"><?= $success_message; ?></div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="alert alert-danger text-center"><?= $error_message; ?></div>
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
                            <label for="kredit1" class="form-label">Aplikasi:</label>
                            <input type="text" class="form-control" name="nama_apk[]" id="kredit1" required>
                        </div>
                        <div class="col">
                            <label for="kredit1" class="form-label">Nominal</label>
                            <input type="number" class="form-control" name="kredit[]" id="kredit1" required>
                        </div>
                    </div>
                </div>
                <button type="button" id="addCredit" class="btn btn-success mb-3">Tambah Kredit</button>

                <!-- <div class="mb-3">
                    <h3 class="text-center">Grand Total: <span id="displayTotalKredit">0</span></h3>
                    <h3 class="text-center">Biaya Admin (20%): <span id="displayBiayaAdmin">0</span></h3>
                </div> -->

                <table>
                    <tr>
                        <td><h3>Grand Total: <span id="displayTotalKredit">0</span></h3></td>
                    </tr>
                    <tr>
                        <td><h3>Biaya Admin (20%): <span id="displayBiayaAdmin">0</span></h3></td>
                    </tr>
                </table>
                
                <br>
                <div class="mb-3">
                    <label for="ktp" class="form-label">Upload KTP</label>
                    <input type="file" class="form-control" id="ktp" name="ktp" accept=".jpg,.jpeg,.png" required>
                </div>
                <input type="hidden" name="total_kredit" id="total_kredit">
                <input type="hidden" name="biaya_admin" id="biaya_admin">

                <div class="d-grid">
                    <button type="submit" name="kirim" class="btn btn-primary">Kirim Data</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menambahkan titik pemisah ribuan
        function formatNumber(number) {
            return number.replace(/\D/g, '') // Hapus semua karakter non-digit
                         .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambahkan titik setiap 3 digit
        }

        // Event listener untuk input field
        document.getElementById('kredit1').addEventListener('input', function(e) {
            let input = e.target.value;
            e.target.value = formatNumber(input);
        });
    </script>

    <script>
        $(document).ready(function() {
            let totalKredit = 0;

            // Function to update total kredit and biaya admin
            function updateTotals() {
                totalKredit = 0;
                $("input[name='kredit[]']").each(function() {
                    const value = parseFloat($(this).val()) || 0;
                    totalKredit += value;
                });
                $("#total_kredit").val(totalKredit);
                $("#biaya_admin").val(totalKredit * 0.2); // Misalnya 20%

                //update display total kredit dan biaya admin realtime
                $("#displayTotalKredit").text(totalKredit);
                $("#displayBiayaAdmin").text((totalKredit * 0.2));
            }

            // Handle add credit button
            $("#addCredit").click(function() {
                const newCreditRow = `
                <div class="mb-3 row">
                    <div class="col">
                        <label for="kredit" class="form-label">Aplikasi: </label>
                        <input type="text" class="form-control" name="nama_apk[]" required>
                    </div>
                    <div class="col">
                        <label for="kredit" class="form-label">Kredit</label>
                        <input type="number" class="form-control" id="kredit1" name="kredit[]" required>
                    </div>
                </div>`;
                $("#creditFields").append(newCreditRow);
            });

            // Update totals on input change
            $(document).on('input', "input[name='kredit[]']", function() {
                updateTotals();
            });
        });
    </script>
</body>
</html>
