<?php
session_start();
require_once '../config/database.php';
require_once '../functions.php';

check_login(); // Pastikan admin sudah login

// Handle aksi POST
if ($_POST) {
    if ($_POST['action'] == 'add') {
        $stmt = $pdo->prepare("INSERT INTO produk (nama_produk, id_kategori, harga) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['nama_produk'], $_POST['id_kategori'], $_POST['harga']]);
    } elseif ($_POST['action'] == 'edit') {
        $stmt = $pdo->prepare("UPDATE produk SET nama_produk = ?, id_kategori = ?, harga = ? WHERE id_produk = ?");
        $stmt->execute([$_POST['nama_produk'], $_POST['id_kategori'], $_POST['harga'], $_POST['id_produk']]);
    } elseif ($_POST['action'] == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM produk WHERE id_produk = ?");
        $stmt->execute([$_POST['id_produk']]);
    }
}

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_data = $stmt->fetch();
}

// Ambil semua data
$produk_result = $pdo->query("SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori_produk k ON p.id_kategori = k.id_kategori")->fetchAll();
$kategori_result = $pdo->query("SELECT * FROM kategori_produk")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk</title>
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
    <h2 style="margin-bottom: 20px;"><?php echo $edit_data ? 'Edit Produk' : 'Tambah Produk'; ?></h2>
    <form method="POST">
        <input type="hidden" name="action" value="<?= $edit_data ? 'edit' : 'add'; ?>">
        <?php if ($edit_data): ?>
            <input type="hidden" name="id_produk" value="<?= $edit_data['id_produk']; ?>">
        <?php endif; ?>

        <p>Nama Produk:
            <input type="text" name="nama_produk" required value="<?= $edit_data['nama_produk'] ?? ''; ?>">
        </p>

        <p>Kategori:
            <select name="id_kategori" required>
                <option value="">Pilih Kategori</option>
                <?php foreach($kategori_result as $kat): ?>
                    <option value="<?= $kat['id_kategori']; ?>" <?= ($edit_data && $edit_data['id_kategori'] == $kat['id_kategori']) ? 'selected' : ''; ?>>
                        <?= $kat['nama_kategori']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>Harga:
            <input type="number" name="harga" required value="<?= $edit_data['harga'] ?? ''; ?>">
        </p>

        <p>
            <button type="submit"><?= $edit_data ? 'Update' : 'Tambah'; ?></button>
            <?php if ($edit_data): ?>
                <a href="produk.php">Batal</a>
            <?php endif; ?>
        </p>
    </form>

    <hr>

    <h3>Daftar Produk</h3>
    <table>
        <tr style="background-color: #eee;">
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($produk_result as $row): ?>
        <tr>
            <td><?= $row['id_produk']; ?></td>
            <td><?= $row['nama_produk']; ?></td>
            <td><?= $row['nama_kategori']; ?></td>
            <td>Rp <?= number_format($row['harga']); ?></td>
            <td>
                <a href="produk.php?edit=<?= $row['id_produk']; ?>">Edit</a>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Hapus produk ini?')">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id_produk" value="<?= $row['id_produk']; ?>">
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
