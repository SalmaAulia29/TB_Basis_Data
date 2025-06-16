<?php
include 'config/database.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT p.*, k.nama_kategori, k.durasi_garansi FROM produk p 
                       JOIN kategori_produk k ON p.id_kategori = k.id_kategori 
                       WHERE p.id_produk = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Produk tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk - TOKAGADGET</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .nav { background: #333; padding: 10px; }
        .nav a { color: white; text-decoration: none; margin: 0 15px; }
        .product-detail { border: 1px solid #ddd; padding: 30px; margin: 20px 0; }
        .price { color: red; font-weight: bold; font-size: 24px; }
        .btn { background: #007cba; color: white; padding: 12px 25px; text-decoration: none; margin: 10px 5px; display: inline-block; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="index.php">Beranda</a>
        <a href="produk.php">Produk</a>
        <a href="keranjang.php">Keranjang</a>
        <a href="tentang.php">Tentang</a>
        <a href="kontak.php">Kontak</a>
    </div>

    <div class="container">
        <div class="product-detail">
            <h1><?= $product['nama_produk'] ?></h1>
            <p><strong>Kategori:</strong> <?= $product['nama_kategori'] ?></p>
            <p><strong>Garansi:</strong> <?= $product['durasi_garansi'] ?></p>
            <p class="price">Rp <?= number_format($product['harga']) ?></p>
            
            <div class="warning">
                <strong>Perhatian:</strong><br>
                Untuk Garansi Handphone inter selama 3 Bulan dan Garansi untuk Handphone iBox/Sein selama 1 Tahun, tidak bisa refund!
            </div>
            
            <a href="checkout.php?id=<?= $product['id_produk'] ?>" class="btn">Beli Sekarang</a>
            <a href="produk.php" class="btn" style="background: #6c757d;">Kembali</a>
        </div>
    </div>
</body>
</html>