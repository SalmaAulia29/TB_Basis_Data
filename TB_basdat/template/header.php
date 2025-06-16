<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'TOKO GADGET' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        
        .navbar { background: #333; padding: 10px 0; }
        .nav-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .logo { color: white; font-size: 24px; font-weight: bold; text-decoration: none; }
        .nav-menu { display: flex; list-style: none; }
        .nav-menu li { margin-left: 30px; }
        .nav-menu a { color: white; text-decoration: none; padding: 10px 15px; border-radius: 5px; transition: background 0.3s; }
        .nav-menu a:hover { background: #555; }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .btn { background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border: none; cursor: pointer; border-radius: 5px; display: inline-block; }
        .btn:hover { background: #005a8b; }
        .btn-secondary { background: #6c757d; }
        .btn-danger { background: #dc3545; }
        
        .alert { padding: 15px; margin: 15px 0; border-radius: 5px; }
        .alert-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .alert-warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
        .alert-danger { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">TOKO GADGET</a>
            <ul class="nav-menu">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="produk.php">Produk</a></li>
                <li><a href="keranjang.php">Keranjang</a></li>
                <li><a href="tentang.php">Tentang</a></li>
                <li><a href="kontak.php">Kontak</a></li>
                <li><a href="login.php">Login Admin</a></li> 
            </ul>
        </div>
    </nav>