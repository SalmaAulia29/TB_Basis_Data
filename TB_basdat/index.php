<?php
require_once 'config/database.php';
require_once 'template/header.php';

$stmt = $pdo->query("SELECT p.*, k.nama_kategori FROM produk p 
                     JOIN kategori_produk k ON p.id_kategori = k.id_kategori 
                     LIMIT 4");
$products = $stmt->fetchAll();
?>

<div class="container">
    <section style="text-align: center; padding: 40px 0; background-color: #f4f4f4;">
        <h1 style="margin-bottom: 10px;">TOKAGADGET</h1>
        <p style="margin-bottom: 5px;">+62 896-5009-0645 | tokagadget@gmail.com</p>
        <h2 style="margin-top: 20px;">Produk Unggulan</h2>
    </section>

    <section class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin: 40px 0;">
        <?php foreach($products as $product): ?>
        <div class="product-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <h3 style="margin-bottom: 10px;"><?= htmlspecialchars($product['nama_produk']) ?></h3>
            <p style="margin-bottom: 5px;">Kategori: <?= htmlspecialchars($product['nama_kategori']) ?></p>
            <p class="price" style="color: red; font-weight: bold; font-size: 18px; margin: 10px 0;">
                Rp <?= number_format($product['harga']) ?>
            </p>
            <a href="detail_produk.php?id=<?= $product['id_produk'] ?>" class="btn" style="background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Lihat Detail</a>
        </div>
        <?php endforeach; ?>
    </section>
</div>

<?php require_once 'template/footer.php'; ?>
