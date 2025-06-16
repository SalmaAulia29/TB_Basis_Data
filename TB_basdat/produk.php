<?php
session_start();
include 'config/database.php';
require_once 'template/header.php';

// === Tangani penambahan ke keranjang ===
if (isset($_GET['add_to_cart'])) {
    $id_produk = $_GET['add_to_cart'];

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Ambil data produk dari database
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->execute([$id_produk]);
    $produk = $stmt->fetch();

    if (!$produk) {
        // Produk tidak ditemukan, redirect atau tampilkan error
        header("Location: produk.php");
        exit();
    }

    // Tambahkan ke keranjang
	if (isset($_SESSION['keranjang'][$id_produk]) && is_array($_SESSION['keranjang'][$id_produk])) {
		$_SESSION['keranjang'][$id_produk]['qty']++;
	} else {
		$_SESSION['keranjang'][$id_produk] = [
			'nama_produk' => $produk['nama_produk'],
			'harga' => $produk['harga'],
			'qty' => 1
		];
	}

    // Redirect agar tidak refresh menambahkan lagi
    header("Location: produk.php");
    exit();
}

// Ambil semua produk
$stmt = $pdo->query("SELECT p.*, k.nama_kategori, k.durasi_garansi FROM produk p 
                     JOIN kategori_produk k ON p.id_kategori = k.id_kategori");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk - TOKAGADGET</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .nav { background: #333; padding: 10px; }
        .nav a { color: white; text-decoration: none; margin: 0 15px; }
        .product-list { margin: 20px 0; }
        .product-item { border: 1px solid #ddd; margin: 10px 0; padding: 15px; display: flex; justify-content: space-between; background: white; border-radius: 6px; }
        .product-info { flex: 1; }
        .product-actions { text-align: right; }
        .price { color: red; font-weight: bold; }
        .btn {
            background: #007cba;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            margin: 5px;
            display: inline-block;
            border-radius: 4px;
        }
        .btn:hover {
            background: #005f99;
        }
        .btn-green {
            background: green;
        }
        .cart-button {
            display: inline-block;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Daftar Semua Produk</h1>

    <div class="cart-button">
        <a href="keranjang.php" class="btn">🛒 Lihat Keranjang</a>
    </div>

    <div class="product-list">
        <?php foreach($products as $product): ?>
        <div class="product-item">
            <div class="product-info">
                <h3><?= $product['nama_produk'] ?></h3>
                <p>Kategori: <?= $product['nama_kategori'] ?></p>
                <p>Garansi: <?= $product['durasi_garansi'] ?></p>
                <p class="price">Rp <?= number_format($product['harga']) ?></p>
            </div>
            <div class="product-actions">
                <a href="detail_produk.php?id=<?= $product['id_produk'] ?>" class="btn">Detail</a>
                <a href="checkout.php?id=<?= $product['id_produk'] ?>" class="btn btn-green">Beli Sekarang</a>
                <a href="produk.php?add_to_cart=<?= $product['id_produk'] ?>" class="btn">+ Keranjang</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>

<?php require_once 'template/footer.php'; ?>
