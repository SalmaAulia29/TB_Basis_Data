<?php
require_once 'template/header.php';
session_start();
require_once 'config/database.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $data = $stmt->fetch();

    if ($data && $password === $data['password']) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        header("Location: admin/index.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<style>
    html, body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    .page-wrapper {
        display: flex;
        flex-direction: column;
        min-height: auto; /* Tidak memaksa tinggi penuh */
    }

    main {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px 15px;
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .login-container {
        max-width: 400px;
        width: 100%;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 10px;
    }

    .login-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-container form {
        display: flex;
        flex-direction: column;
    }

    .login-container label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .login-container button {
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .login-container button:hover {
        background-color: #0056b3;
    }

    .error-message {
        color: red;
        margin-bottom: 15px;
        text-align: center;
    }
</style>

<div class="page-wrapper">
    <main>
        <div class="login-container">
            <h2>Login Admin</h2>
            <?php if (isset($error)) echo "<div class='error-message'>$error</div>"; ?>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </main>
</div>

<?php require_once 'template/footer.php'; ?>
