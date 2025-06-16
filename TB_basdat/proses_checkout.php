<?php
session_start();
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];

    // Simpan data pelanggan
    $stmt = $pdo->prepare("INSERT INTO pelanggan (nama_pelanggan, telepon) VALUES (?, ?)");
    $stmt->execute([$nama, $telepon]);
    $id_pelanggan = $pdo->lastInsertId();

    // Ambil data referensi
    $id_toko = $pdo->query("SELECT id_toko FROM toko LIMIT 1")->fetchColumn();
    $id_rekening = $pdo->query("SELECT id_rekening FROM rekening_pembayaran LIMIT 1")->fetchColumn();
    $id_karyawan = $pdo->query("SELECT id_karyawan FROM karyawan LIMIT 1")->fetchColumn();
    $id_kebijakan = $pdo->query("SELECT id_kebijakan FROM kebijakan LIMIT 1")->fetchColumn();
    $tanggal = date('Y-m-d');

    // Cek apakah ini pembelian langsung (1 produk) atau dari keranjang
    if (isset($_POST['id_produk'])) {
        // 🔹 PEMBELIAN LANGSUNG
        $id_produk = $_POST['id_produk'];

        $stmt = $pdo->prepare("SELECT * FROM produk WHERE id_produk = ?");
        $stmt->execute([$id_produk]);
        $produk = $stmt->fetch();

        if (!$produk) {
            echo "Produk tidak ditemukan.";
            exit;
        }

        $jumlah = 1;
        $total = $produk['harga'];

        $stmt = $pdo->prepare("INSERT INTO transaksi 
            (id_toko, id_pelanggan, id_produk, id_rekening, id_karyawan, id_kebijakan, tanggal, banyaknya, total)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $id_toko,
            $id_pelanggan,
            $id_produk,
            $id_rekening,
            $id_karyawan,
            $id_kebijakan,
            $tanggal,
            $jumlah,
            $total
        ]);

    } elseif (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
        // 🔹 PEMBELIAN DARI KERANJANG
        foreach ($_SESSION['keranjang'] as $id_produk => $item) {
            $jumlah = isset($item['qty']) ? (int)$item['qty'] : 1;
            $harga = isset($item['harga']) ? (float)$item['harga'] : 0;
            $total = $jumlah * $harga;

            $stmt = $pdo->prepare("INSERT INTO transaksi 
                (id_toko, id_pelanggan, id_produk, id_rekening, id_karyawan, id_kebijakan, tanggal, banyaknya, total)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $id_toko,
                $id_pelanggan,
                $id_produk,
                $id_rekening,
                $id_karyawan,
                $id_kebijakan,
                $tanggal,
                $jumlah,
                $total
            ]);
        }

        // Kosongkan keranjang
        unset($_SESSION['keranjang']);
    } else {
        echo "Tidak ada produk yang dibeli.";
        exit;
    }

    // Arahkan ke halaman sukses
    header("Location: transaksi_sukses.php?pelanggan=" . $id_pelanggan);
    exit;
} else {
    echo "Akses tidak sah.";
}
