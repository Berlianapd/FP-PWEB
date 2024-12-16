<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'bioskop');

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data film berdasarkan ID
$id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$movie = $result->fetch_assoc();

if (!$movie) {
    echo "Film tidak ditemukan.";
    exit;
}

// Periksa apakah image_url sudah berupa URL lengkap atau hanya nama file
$image_path = htmlspecialchars($movie['image_url']);
if (!filter_var($image_path, FILTER_VALIDATE_URL)) {
    $image_path = "http://localhost/bioskop/images/" . $image_path;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?> View Details</title>
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

        .container {
            display: flex;
            background-color: #1e1e1e;
            border-radius: 10px;
            overflow: hidden;
            width: 900px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            color: #fff;
            border: none;
            font-size: 24px;
            cursor: pointer;
            font-weight: bold;
        }

        .close-button:hover {
            color: #ff5757;
        }

        .container img {
            width: 400px;
            height: 600px;
            object-fit: cover;
        }

        .details {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
        }

        .details h2 {
            margin: 0;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .details p {
            margin: 10px 0;
        }

        .details .info {
            margin-bottom: 15px;
        }

        .details .highlight {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        .details .buy-ticket {
            margin-top: 20px;
            text-align: center;
        }

        .buy-ticket button {
            background-color: #A888B5;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 10px #441752(255, 87, 87, 0.3);
        }

        .buy-ticket button:hover {
            background-color: #8174A0;
            transform: translateY(-3px);
        }

        .buy-ticket button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="close-button" onclick="window.location.href='index.php'">&times;</button>
        <img src="<?php echo $image_path; ?>" 
             onerror="this.onerror=null;this.src='http://localhost/bioskop/images/default.jpg';">
        <div class="details">
            <h2><?php echo htmlspecialchars($movie['title']); ?></h2>
            <div class="info">
                <span class="highlight">Synopsis:</span>
                <p><?php echo htmlspecialchars($movie['description']); ?></p>
            </div>
            <div class="info">
                <span class="highlight">Genre:</span>
                <p><?php echo htmlspecialchars($movie['genre']); ?></p>
            </div>
            <div class="info">
                <span class="highlight">Director:</span>
                <p><?php echo htmlspecialchars($movie['director']); ?></p>
            </div>
            <div class="info">
                <span class="highlight">Cast:</span>
                <p><?php echo htmlspecialchars($movie['cast']); ?></p>
            </div>
            <div class="info">
                <span class="highlight">Time:</span>
                <p><?php echo htmlspecialchars($movie['duration']); ?> Minutes</p>
            </div>
            <div class="buy-ticket">
    <a href="order_ticket.php?id=<?php echo $movie['id']; ?>">
        <button>Buy Ticket</button>
    </a>
</div>
        </div>
    </div>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>