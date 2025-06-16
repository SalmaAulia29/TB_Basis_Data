<?php
session_start();
require_once '../config/database.php';
require_once '../functions.php';

check_login(); // Pastikan user admin login

// Ambil data transaksi
$stmt = $pdo->query("
    SELECT t.*, p.nama_produk, pel.nama_pelanggan 
    FROM transaksi t 
    LEFT JOIN produk p ON t.id_produk = p.id_produk 
    LEFT JOIN pelanggan pel ON t.id_pelanggan = pel.id_pelanggan 
    ORDER BY t.tanggal DESC
");
$transaksi_result = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lihat Transaksi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
        }
        .navbar {
            background: #333;
            padding: 10px 0;
        }
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }
        .nav-menu {
            display: flex;
            list-style: none;
        }
        .nav-menu li {
            margin-left: 30px;
        }
        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .nav-menu a:hover {
            background: #555;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="../index.php" class="logo">TOKAGADGET</a>
        <ul class="nav-menu">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="produk.php">Produk</a></li>
            <li><a href="kategori.php">Kategori</a></li>
            <li><a href="transaksi.php">Transaksi</a></li>
            <li><a href="../logout.php" onclick="return confirm('Keluar dari admin?')">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Lihat Semua Transaksi</h2>

    <table>
        <tr style="background-color: #eee;">
            <th>ID</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>
        <?php foreach ($transaksi_result as $row): ?>
        <tr>
            <td><?= $row['id_transaksi']; ?></td>
            <td><?= $row['tanggal']; ?></td>
            <td><?= $row['nama_pelanggan']; ?></td>
            <td><?= $row['nama_produk']; ?></td>
            <td><?= $row['banyaknya']; ?></td>
            <td>Rp <?= number_format($row['total']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
