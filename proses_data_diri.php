<?php
// Hanya terima request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: form_data_diri.html');
    exit;
}

// Nama bulan dalam bahasa Indonesia
$bulan = [
    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

// Ambil dan bersihkan input
$nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
$tanggalInput = isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : '';
$hobiPilihan = isset($_POST['hobi']) && is_array($_POST['hobi']) ? $_POST['hobi'] : [];

// Validasi: nama dan tanggal lahir wajib diisi
$dt = DateTime::createFromFormat('Y-m-d', $tanggalInput);
$tanggalValid = $dt && $dt->format('Y-m-d') === $tanggalInput;

if ($nama === '' || !$tanggalValid) {
    echo 'Nama dan tanggal lahir wajib diisi dengan benar. <a href="form_data_diri.html">&laquo; Kembali ke Form</a>';
    exit;
}

// Ubah YYYY-MM-DD menjadi "7 Januari 2006"
$tanggalLahir = (int) $dt->format('j') . ' ' . $bulan[(int) $dt->format('n')] . ' ' . $dt->format('Y');

// Gabungkan hobi dengan koma dan spasi
$hobiValid = ['Membaca', 'Olahraga', 'Musik', 'Lainnya'];
$hobiPilihan = array_values(array_intersect($hobiValid, $hobiPilihan));
$hobi = count($hobiPilihan) > 0 ? implode(', ', $hobiPilihan) : 'Tidak ada hobi yang dipilih';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Data Anda</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 40px 16px;
        }
        .container {
            max-width: 480px;
            margin: 0 auto;
            background: #fff;
            padding: 24px 28px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }
        h2 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            font-size: 22px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        td {
            padding: 10px 0;
            vertical-align: top;
            font-size: 15px;
        }
        td.label {
            font-weight: bold;
            width: 140px;
        }
        a {
            display: inline-block;
            margin-top: 16px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tampilan Data Anda</h2>
        <table>
            <tr>
                <td class="label">Nama Lengkap:</td>
                <td><?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td class="label">Tanggal Lahir:</td>
                <td><?= htmlspecialchars($tanggalLahir, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td class="label">Hobi:</td>
                <td><?= htmlspecialchars($hobi, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        </table>
        <a href="form_data_diri.html">&laquo; Kembali ke Form</a>
    </div>
</body>
</html>
