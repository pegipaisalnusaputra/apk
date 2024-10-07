<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Separator for Input</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Form Input dengan Pemisah Ribuan</h2>
        <form>
            <div class="mb-3">
                <label for="kredit" class="form-label">Masukkan Jumlah Kredit</label>
                <input type="text" class="form-control" id="kredit" placeholder="Masukkan jumlah kredit">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        // Fungsi untuk menambahkan titik pemisah ribuan
        function formatNumber(number) {
            return number.replace(/\D/g, '') // Hapus semua karakter non-digit
                         .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambahkan titik setiap 3 digit
        }

        // Event listener untuk input field
        document.getElementById('kredit').addEventListener('input', function(e) {
            let input = e.target.value;
            e.target.value = formatNumber(input);
        });
    </script>
</body>
</html>
