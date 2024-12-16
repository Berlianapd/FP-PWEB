<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'bioskop');

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah ID pemesanan ada dalam URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];  // Ambil order_id dari URL
} else {
    echo "Order ID tidak ditemukan.";
    exit;
}

// Ambil data pemesanan berdasarkan order_id
$query = $conn->prepare("SELECT * FROM tickets WHERE id = ?");
$query->bind_param("i", $order_id);  // Menggunakan $order_id
$query->execute();
$result = $query->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .qr-container {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .qr-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .qr-container img {
            width: 250px;
            height: 250px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .qr-container p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .qr-container button {
            background-color: #A888B5;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .qr-container button:hover {
            background-color: #8174A0;
            transform: translateY(-3px);
        }

        .qr-container button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <h1>Thank You for Your Order!</h1>
        <img src="qr_code_image.jpg" alt="QR Code"> <!-- Sesuaikan dengan path QR Code sesuai ID -->
        <p>Scan this QR to confirm your payment.</p>
        <button onclick="window.location.href='ticket_details.php?order_id=<?php echo $order_id; ?>'">Done</button>

    </div>
</body>
</html>