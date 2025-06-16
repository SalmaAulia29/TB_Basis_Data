<?php
include 'config/database.php';
require_once 'template/header.php';

$stmt = $pdo->query("SELECT * FROM toko LIMIT 1");
$toko = $stmt->fetch();

$stmt = $pdo->query("SELECT * FROM karyawan");
$karyawan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kontak Kami - TOKAGADGET</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .nav { background: #333; padding: 10px; }
        .nav a { color: white; text-decoration: none; margin: 0 15px; }
        .contact-info { background: #f8f9fa; padding: 20px; margin: 20px 0; }
        .staff-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0; }
        .staff-item { background: #e9ecef; padding: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Informasi Kontak</h1>
        
        <div class="contact-info">
            <h2><?= $toko['nama_toko'] ?></h2>
            <p><strong>Telepon:</strong> <?= $toko['telepon'] ?></p>
            <p><strong>Email:</strong> <?= $toko['email'] ?></p>
        </div>
        
        <h3>Tim Kami</h3>
        <div class="staff-list">
            <?php foreach($karyawan as $staff): ?>
            <div class="staff-item">
                <h4><?= $staff['nama_karyawan'] ?></h4>
                <p><?= $staff['posisi'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="contact-info">
            <h3>Pembayaran</h3>
            <p><strong>Bank BCA</strong><br>
            Atas Nama: Raka Maulidz<br>
            No. Rekening: 1481028472</p>
        </div>
    </div>
</body>
</html>
<?php require_once 'template/footer.php'; ?>