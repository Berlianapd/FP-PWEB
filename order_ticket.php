<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'bioskop');

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Periksa apakah parameter id ada dalam URL
if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];  // Mengambil id dari URL
} else {
    echo "Movie ID tidak ditemukan.";
    exit;
}

// Ambil data film berdasarkan movie_id
$query = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$query->bind_param("i", $movie_id);  // Menggunakan $movie_id
$query->execute();
$result = $query->get_result();
$movie = $result->fetch_assoc();

if (!$movie) {
    echo "Film tidak ditemukan.";
    exit;
}

// Hitung biaya
$ticket_price = 40000; // Harga tiket tetap
$convenience_fee = 3000; // Biaya tambahan
$total_price = $ticket_price + $convenience_fee;

// Simpan pesanan jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menyimpan data pemesanan ke dalam tabel tickets
    $stmt = $conn->prepare("INSERT INTO tickets (movie_id, ticket_price, convenience_fee, total_price, order_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iddd", $movie_id, $ticket_price, $convenience_fee, $total_price);
    
    if ($stmt->execute()) {
        // Jika berhasil, dapatkan ID pemesanan dan arahkan ke halaman QR Code
        $order_id = $conn->insert_id;  // Mendapatkan ID pemesanan yang baru dimasukkan
        header("Location: pay_succes.php?order_id=" . $order_id);
        exit;
    } else {
        echo "<script>alert('Gagal memproses order!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Ticket</title>
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

        .order-container {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            display: flex;
            width: 800px;
        }

        .order-image {
            flex: 1;
            margin-right: 20px;
        }

        .order-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .order-details {
            flex: 2;
            text-align: left;
        }

        .order-details h2 {
            margin: 0 0 20px;
            font-size: 20px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .detail {
            font-size: 14px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .separator {
            border-bottom: 1px solid #333;
            margin: 10px 0;
        }

        .total {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
        }

        .order-details button {
            background-color: #A888B5;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
        }

        .order-details button:hover {
            background-color: #8174A0;
            transform: translateY(-3px);
        }

        .order-details button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="order-container">
        <div class="order-image">
            <img src="<?php echo htmlspecialchars($movie['image_url']); ?>" alt="Movie Poster">
        </div>
        <div class="order-details">
            <h2><?php echo htmlspecialchars($movie['title']); ?></h2>
            
            <div class="detail">
                <span>Cinema</span>
                <span>Platinum Cineplex</span>
            </div>
            <div class="detail">
                <span>Date</span>
                <span>Wednesday, 02-03-2022</span>
            </div>
            <div class="detail">
                <span>Time</span>
                <span>13:45</span>
            </div>
            <div class="detail">
                <span>Seat</span>
                <span>REGULAR</span>
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

            <form method="POST">
                <button type="submit">Order</button>
            </form>

        </div>
    </div>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>