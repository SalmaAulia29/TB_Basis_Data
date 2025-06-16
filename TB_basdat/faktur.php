<?php
include 'config/database.php';

$id_pelanggan = $_GET['pelanggan'] ?? 1;

// Ambil data pelanggan dan transaksi
$stmt = $pdo->prepare("SELECT p.nama_pelanggan, p.telepon FROM pelanggan p WHERE p.id_pelanggan = ?");
$stmt->execute([$id_pelanggan]);
$pelanggan = $stmt->fetch();

$stmt = $pdo->prepare("SELECT t.*, pr.nama_produk, pr.harga, k.nama_kategori FROM transaksi t 
                       JOIN produk pr ON t.id_produk = pr.id_produk 
                       JOIN kategori_produk k ON pr.id_kategori = k.id_kategori
                       WHERE t.id_pelanggan = ? ORDER BY t.id_transaksi DESC");
$stmt->execute([$id_pelanggan]);
$transaksi = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faktur Pembelian - TOKAGADGET</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 20px; }
        .faktur { max-width: 600px; margin: 0 auto; border: 1px solid #000; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .customer { margin: 20px 0; }
        .item { display: flex; justify-content: space-between; margin: 5px 0; }
        .total { border-top: 2px solid #000; padding-top: 10px; margin-top: 20px; font-weight: bold; }
        .payment-info { background: #f0f0f0; padding: 15px; margin: 20px 0; }
        .warning { background: #ffe6e6; padding: 15px; margin: 20px 0; border: 1px solid #ff9999; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="faktur">
        <div class="header">
            <h2>Faktur Pembelian</h2>
            <h3>TOKAGADGET</h3>
            <p>+62 896-5009-0645<br>tokagadget@gmail.com</p>
            <p><?= date('d M Y') ?></p>
        </div>
        
        <div class="customer">
            <p><strong>Yth : <?= $pelanggan['nama_pelanggan'] ?></strong></p>
            <p>Telepon: <?= $pelanggan['telepon'] ?></p>
        </div>
        
        <div class="warning">
            <strong>Perhatian :</strong><br>
            Untuk Garansi Handphone inter selama 3 Bulan dan Garansi untuk Handphone iBox/Sein selama 1 Tahun, tidak bisa refund !
        </div>
        
        <table width="100%" style="border-collapse: collapse;">
            <tr style="border-bottom: 1px solid #000;">
                <td><strong>Deskripsi</strong></td>
                <td><strong>Banyaknya</strong></td>
                <td><strong>Harga</strong></td>
                <td><strong>Total</strong></td>
            </tr>
            
            <?php 
            $grand_total = 0;
            foreach($transaksi as $item): 
                $grand_total += $item['total'];
            ?>
            <tr>
                <td><?= $item['nama_produk'] ?> <?= $item['nama_kategori'] ?></td>
                <td><?= $item['banyaknya'] ?></td>
                <td>Rp <?= number_format($item['harga']) ?></td>
                <td>Rp <?= number_format($item['total']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <div class="total">
            <div class="item">
                <span>Jumlah</span>
                <span>Rp <?= number_format($grand_total) ?></span>
            </div>
        </div>
        
        <div class="payment-info">
            <strong>Transfer ke :</strong><br>
            Bank BCA Raka Maulidz<br>
            Atas Nama Raka Maulidz<br>
            no. rekening 1481028472
        </div>
        
        <div style="text-align: right; margin-top: 30px;">
            <p>Kasir</p>
            <br><br>
            <p>___________________</p>
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cetak Faktur</button>
        <a href="index.php" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; margin-left: 10px;">Kembali</a>
    </div>
</body>
</html>