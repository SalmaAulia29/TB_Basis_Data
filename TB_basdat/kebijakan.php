<?php
include 'config/database.php';
require_once 'template/header.php';

$stmt = $pdo->query("SELECT * FROM kebijakan");
$kebijakan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kebijakan Toko - TOKAGADGET</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .nav { background: #333; padding: 10px; }
        .nav a { color: white; text-decoration: none; margin: 0 15px; }
        .kebijakan-item { background: #f8f9fa; padding: 20px; margin: 15px 0; border-left: 4px solid #007cba; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Kebijakan Toko</h1>
        
        <?php foreach($kebijakan as $item): ?>
        <div class="kebijakan-item">
            <h3><?= $item['nama_kebijakan'] ?></h3>
            <p><?= $item['deskripsi'] ?></p>
        </div>
        <?php endforeach; ?>
        
        <div class="kebijakan-item">
            <h3>Garansi</h3>
            <p>- Garansi Handphone inter selama 3 Bulan<br>
            - Garansi Handphone iBox/Sein selama 1 Tahun<br>
            - Semua produk bergaransi tidak bisa refund</p>
        </div>
    </div>
</body>
</html>
<?php require_once 'template/footer.php'; ?>