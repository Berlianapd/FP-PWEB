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
$query = $conn->prepare("SELECT t.id, t.cinema_name, t.show_date, t.show_time, t.seat_type, t.total_price, m.title AS movie_title, m.image_url 
                         FROM tickets t 
                         LEFT JOIN movies m ON t.movie_id = m.id 
                         WHERE t.id = ?");
$query->bind_param("i", $order_id);
$query->execute();
$result = $query->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

// Variabel tambahan
$ticket_price = $order['total_price'] - 5000; // Misalkan convenience fee Rp5.000
$convenience_fee = 5000;
$total_price = $order['total_price'];

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Details</title>
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
        .ticket-container {
            background-color: #f0f0f0;
            color: #000;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            width: 500px;
            text-align: center;
        }
        h1, h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .detail {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 16px;
        }
        .separator {
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        .total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 18px;
        }
        .qr img {
            width: 200px;
            height: 200px;
            margin-top: 20px;
        }
        button {
            background-color: #6C63FF;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #534BBF;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <h1>Ticket Details</h1>
        <h2><?php echo htmlspecialchars($order['movie_title'] ?? 'Spiderman'); ?></h2>
        <div class="detail">
            <span>Cinema</span>
            <span><?php echo htmlspecialchars($order['cinema_name'] ?? 'Platinum Cineplex'); ?></span>
        </div>
        <div class="detail">
            <span>Date</span>
            <span><?php echo $order['show_date'] ? date('l, d-m-Y', strtotime($order['show_date'])) : '13-02-2024'; ?></span>
        </div>
        <div class="detail">
            <span>Time</span>
            <span><?php echo htmlspecialchars($order['show_time'] ?? '17.00'); ?></span>
        </div>
        <div class="detail">
            <span>Seat</span>
            <span><?php echo htmlspecialchars($order['seat_type'] ?? 'Regular'); ?></span>
        </div>
        
        <div class="separator"></div>

        <div class="detail">
            <span>Ticket Price</span>
            <span>Rp<?php echo number_format($ticket_price, 0, ',', '.'); ?></span>
        </div>
        <div class="detail">
            <span>Convenience Fee</span>
            <span>Rp<?php echo number_format($convenience_fee, 0, ',', '.'); ?></span>
        </div>
        <div class="total">
            <span>Total</span>
            <span>Rp<?php echo number_format($total_price, 0, ',', '.'); ?></span>
        </div>

        <div class="qr">
            <img src="qr_code_image.jpg" alt="QR Code">
        </div>
        <button onclick="window.print()">Print</button>
    </div>
</body>
</html>
