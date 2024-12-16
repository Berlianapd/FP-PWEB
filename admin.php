<!DOCTYPE html>
<html lang="en">
<head>
<?php
session_start();

// Koneksi ke database
include 'config.php'; 

// Ambil data dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Query untuk validasi login
$query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: dashboard.php"); // Redirect ke halaman admin dashboard
    exit();
} else {
    echo "<script>alert('Login failed! Check your credentials.'); window.location.href='admin_login.php';</script>";
}
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #f2f2f2;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #000;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .login-container button {
            background-color: #6c63ff;
            color: #fff;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #5751d9;
        }

        .login-container p {
            margin-top: 10px;
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <!-- Hanya layout, tidak ada fungsi login -->
        <input type="text" placeholder="Enter Username">
        <input type="password" placeholder="Enter Password">
        <button>Login</button>
        <p>For authorized personnel only.</p>
    </div>
</body>
</html>