<?php
session_start();

// Proses login jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifikasi username dan password
    if ($username === 'admin' && $password === '12345') { // Ganti dengan validasi database jika perlu
        $_SESSION['admin_logged_in'] = true;
        header("Location: add_film.php"); // Arahkan ke add_film.php setelah login
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            text-align: center;
            background: #1a1a1a;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .login-container input {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #333;
            background: #333;
            color: #fff;
        }
        .login-container button {
            padding: 10px 20px;
            background: #A888B5;
            border: none;
            border-radius: 5px;
            color: #000;
            font-weight: 600;
            cursor: pointer;
        }
        .login-container button:hover {
            background: #00d1dd;
        }
        .error-message {
            color: #ff4d4d;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="dashboard.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
