<?php
session_start();
include 'config/database.php';

$produk_dipesan = [];
$total = 0;

// Cek apakah ada pembelian langsung dari produk
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->execute([$id_produk]);
    $produk = $stmt->fetch();
	
	if ($produk) {
    $item = [
        'id_produk' => $produk['id_produk'],
        'nama_produk' => $produk['nama_produk'],  // Pastikan ini sesuai dengan kolom tabel produk
        'harga' => $produk['harga'],
        'jumlah' => 1,
        'subtotal' => $produk['harga']
    ];
    $produk_dipesan[] = $item;
    $total += $item['subtotal'];
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
}
// Jika tidak, cek apakah checkout dari keranjang
elseif (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
	foreach ($_SESSION['keranjang'] as $id_produk => $item) {
		$jumlah = isset($item['qty']) ? (int)$item['qty'] : 0;
		$harga = isset($item['harga']) ? (float)$item['harga'] : 0;

		if ($jumlah > 0 && $harga > 0) {
			$item['jumlah'] = $jumlah;
			$item['subtotal'] = $jumlah * $harga;
			$item['id_produk'] = $id_produk; // 👈 tambahan ini penting
			$produk_dipesan[] = $item;
			$total += $item['subtotal'];
		}
	}

} else {
    echo "Keranjang kosong dan tidak ada produk yang dipilih.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - TOKO GADGET</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 40px auto; padding: 20px; }
        .order-summary { background: #f8f9fa; padding: 20px; margin-bottom: 30px; border-radius: 5px; }
        .total { color: red; font-weight: bold; margin-top: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="tel"] {
            width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;
        }
        .payment-info {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<?php include 'template/header.php'; ?>

<div class="container">
    <h1>Form Pembelian</h1>

    <div class="order-summary">
        <h3>Ringkasan Pesanan:</h3>
        <?php foreach ($produk_dipesan as $produk): ?>
            <p><?= $produk['nama_produk'] ?> (<?= $produk['jumlah'] ?>x) - Rp <?= number_format($produk['subtotal'], 0, ',', '.') ?></p>
        <?php endforeach; ?>
        <p class="total">Total: Rp <?= number_format($total, 0, ',', '.') ?></p>
    </div>
	
	<form action="proses_checkout.php" method="post">
		<?php foreach ($produk_dipesan as $produk): ?>
			<input type="hidden" name="produk_id[]" value="<?php echo $produk['id_produk']; ?>">
			<input type="hidden" name="qty[]" value="<?php echo $produk['jumlah']; ?>">
		<?php endforeach; ?>
        <div class="form-group">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" name="nama" id="nama" required>
        </div>

        <div class="form-group">
            <label for="telepon">No. Telepon:</label>
            <input type="tel" name="telepon" id="telepon" required>
        </div>

        <div class="payment-info">
            <strong>Pembayaran:</strong><br>
            Transfer ke: Bank BCA<br>
            Atas Nama: Raka Maulidz<br>
            No. Rekening: 1481028472
        </div>

        <br>
        <button type="submit">Konfirmasi Pembelian</button>
    </form>
</div>

<?php include 'template/footer.php'; ?>

</body>
</html>
