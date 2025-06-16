<?php
session_start();
require_once '../config/database.php';
require_once '../functions.php';

check_login(); // Pastikan admin sudah login

// Proses tambah/edit/hapus
if ($_POST) {
    if ($_POST['action'] == 'add') {
        $stmt = $pdo->prepare("INSERT INTO kategori_produk (nama_kategori, durasi_garansi) VALUES (?, ?)");
        $stmt->execute([$_POST['nama_kategori'], $_POST['durasi_garansi']]);
    } elseif ($_POST['action'] == 'edit') {
        $stmt = $pdo->prepare("UPDATE kategori_produk SET nama_kategori = ?, durasi_garansi = ? WHERE id_kategori = ?");
        $stmt->execute([$_POST['nama_kategori'], $_POST['durasi_garansi'], $_POST['id_kategori']]);
    } elseif ($_POST['action'] == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM kategori_produk WHERE id_kategori = ?");
        $stmt->execute([$_POST['id_kategori']]);
    }
}

// Data untuk form edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM kategori_produk WHERE id_kategori = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_data = $stmt->fetch();
}

// Ambil semua data kategori
$kategori_result = $pdo->query("SELECT * FROM kategori_produk")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kategori</title>
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
    <h2 style="margin-bottom: 20px;"><?php echo $edit_data ? 'Edit Kategori' : 'Tambah Kategori'; ?></h2>
    <form method="POST">
        <input type="hidden" name="action" value="<?= $edit_data ? 'edit' : 'add'; ?>">
        <?php if ($edit_data): ?>
            <input type="hidden" name="id_kategori" value="<?= $edit_data['id_kategori']; ?>">
        <?php endif; ?>

        <p>Nama Kategori:
            <input type="text" name="nama_kategori" required value="<?= $edit_data['nama_kategori'] ?? ''; ?>">
        </p>

        <p>Durasi Garansi:
            <input type="text" name="durasi_garansi" required placeholder="Contoh: 1 Tahun" value="<?= $edit_data['durasi_garansi'] ?? ''; ?>">
        </p>

        <p>
            <button type="submit"><?= $edit_data ? 'Update' : 'Tambah'; ?></button>
            <?php if ($edit_data): ?>
                <a href="kategori.php">Batal</a>
            <?php endif; ?>
        </p>
    </form>

    <hr>

    <h3>Daftar Kategori</h3>
    <table>
        <tr style="background-color: #eee;">
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Durasi Garansi</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($kategori_result as $row): ?>
        <tr>
            <td><?= $row['id_kategori']; ?></td>
            <td><?= $row['nama_kategori']; ?></td>
            <td><?= $row['durasi_garansi']; ?></td>
            <td>
                <a href="kategori.php?edit=<?= $row['id_kategori']; ?>">Edit</a>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id_kategori" value="<?= $row['id_kategori']; ?>">
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
