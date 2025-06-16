<?php
session_start();
include 'config/database.php';

// Validasi parameter
if (!isset($_GET['pelanggan'])) {
    echo "ID pelanggan tidak tersedia.";
    exit;
}

$id_pelanggan = $_GET['pelanggan'];

// Ambil data pelanggan
$stmt = $pdo->prepare("SELECT nama_pelanggan, telepon FROM pelanggan WHERE id_pelanggan = ?");
$stmt->execute([$id_pelanggan]);
$pelanggan = $stmt->fetch();

if (!$pelanggan) {
    echo "Data pelanggan tidak ditemukan.";
    exit;
}

// Ambil transaksi terakhir pelanggan
$stmt = $pdo->prepare("SELECT t.*, pr.nama_produk, pr.harga FROM transaksi t 
                       JOIN produk pr ON t.id_produk = pr.id_produk 
                       WHERE t.id_pelanggan = ? ORDER BY t.id_transaksi DESC");
$stmt->execute([$id_pelanggan]);
$transaksi = $stmt->fetchAll();

// Kosongkan keranjang jika ada
unset($_SESSION['keranjang']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Berhasil - TOKAGADGET</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .nav { background: #333; padding: 10px; }
        .nav a { color: white; text-decoration: none; margin: 0 15px; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 20px; margin: 20px 0; text-align: center; }
        .invoice { border: 1px solid #ddd; padding: 20px; margin: 20px 0; }
        .btn { background: #007cba; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; }
        .total { font-weight: bold; color: red; }
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
        <div class="success">
            <h2>✓ Transaksi Berhasil!</h2>
            <p>Terima kasih atas pembelian Anda</p>
        </div>
        
        <div class="invoice">
            <h3>Detail Transaksi</h3>
            <p><strong>Nama:</strong> <?= htmlspecialchars($pelanggan['nama_pelanggan']) ?></p>
            <p><strong>Telepon:</strong> <?= htmlspecialchars($pelanggan['telepon']) ?></p>
            <p><strong>Tanggal:</strong> <?= date('d M Y') ?></p>
            
            <hr>
            
            <?php 
            $grand_total = 0;
            if (count($transaksi) > 0):
                foreach($transaksi as $item): 
                    $grand_total += $item['total'];
            ?>
                <p><?= htmlspecialchars($item['nama_produk']) ?> (<?= $item['banyaknya'] ?>x) - Rp <?= number_format($item['total'], 0, ',', '.') ?></p>
            <?php 
                endforeach; 
            else:
                echo "<p>Tidak ada transaksi ditemukan.</p>";
            endif;
            ?>
            
            <hr>
            <p class="total">Total: Rp <?= number_format($grand_total, 0, ',', '.') ?></p>
            
            <div style="background: #fff3cd; padding: 15px; margin: 15px 0;">
                <strong>Pembayaran:</strong><br>
                Transfer ke: Bank BCA<br>
                Atas Nama: Raka Maulidz<br>
                No. Rekening: 1481028472
            </div>
            
            <div style="background: #f8d7da; padding: 15px; margin: 15px 0;">
                <strong>Perhatian:</strong><br>
                Untuk Garansi Handphone inter selama 3 Bulan dan Garansi untuk Handphone iBox/Sein selama 1 Tahun, tidak bisa refund!
            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="faktur.php?pelanggan=<?= $id_pelanggan ?>" class="btn">Cetak Faktur</a>
            <a href="index.php" class="btn">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
