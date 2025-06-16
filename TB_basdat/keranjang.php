<?php
session_start();
include 'config/database.php';
require_once 'template/header.php';

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

// Hapus item dari keranjang
if (isset($_GET['hapus'])) {
    $key = $_GET['hapus'];
    unset($_SESSION['keranjang'][$key]);
    $_SESSION['keranjang'] = array_values($_SESSION['keranjang']); // reindex array
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja - TOKAGADGET</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .nav { background: #333; padding: 10px; }
        .nav a { color: white; text-decoration: none; margin: 0 15px; }
        .cart-item { border: 1px solid #ddd; margin: 10px 0; padding: 15px; display: flex; justify-content: space-between; }
        .item-info { flex: 1; }
        .item-price { color: red; font-weight: bold; }
        .btn { background: #007cba; color: white; padding: 8px 15px; text-decoration: none; margin: 5px; }
        .btn-danger { background: #dc3545; }
        .total { background: #f8f9fa; padding: 20px; text-align: right; font-size: 18px; font-weight: bold; }
        .empty { text-align: center; padding: 50px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Keranjang Belanja</h1>
        
        <?php if (empty($_SESSION['keranjang'])): ?>
            <div class="empty">
                <h3>Keranjang Anda Kosong</h3>
                <p><a href="produk.php" class="btn">Mulai Belanja</a></p>
            </div>
        <?php else: ?>
            <?php foreach($_SESSION['keranjang'] as $key => $item): ?>
                <?php $total += $item['harga'] * $item['qty']; ?>
                <div class="cart-item">
                    <div class="item-info">
                        <h3><?= $item['nama_produk'] ?></h3>
                        <p>Quantity: <?= $item['qty'] ?></p>
                        <p class="item-price">Rp <?= number_format($item['harga'] * $item['qty']) ?></p>
                    </div>
                    <div>
                        <a href="keranjang.php?hapus=<?= $key ?>" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="total">
                Total: Rp <?= number_format($total) ?>
            </div>
            
            <div style="text-align: center; margin: 20px 0;">
                <a href="checkout.php" class="btn">Checkout</a>
                <a href="produk.php" class="btn" style="background: #6c757d;">Lanjut Belanja</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php require_once 'template/footer.php'; ?>