<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'bioskop');

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM movies");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Schedule</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #000;
            color: #fff;
            scroll-behavior: smooth 0,5; /* Smooth scroll behavior */
        }

        header {
            position: sticky;
            top: 0;
            left: 0;
            width: 90%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            align-items: center;
            padding: 20px 50px;
            z-index: 1000;
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            margin-left: 50px;
        }

        section {
            height: 100vh; /* Setiap bagian memiliki tinggi 1 layar penuh */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .hero {
            text-align: center;
            background: url('download.jpg') no-repeat center center;
            background-size: cover;
        }

        .hero h1 {
            font-size: 36px;
            color: #fff;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
            margin-top: -101px;
        }

        .now-showing {
            padding: 50px 20px;
        }

        .now-showing h2 {
            margin-bottom: 30px;
            font-size: 28px;
        }

        .movies {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .movie {
            text-align: center;
        }

        .movie img {
            width: 200px;
            border-radius: 10px;
            transition: transform 0.5s ease;
        }

        .movie img:hover {
            transform: scale(1.05);
        }

        .movie h3 {
            margin-top: 10px;
            font-size: 18px;
        }

        .movie a {
            display: block;
            margin-top: 5px;
            color: #00f7ff;
            text-decoration: none;
            font-weight: 600;
        }

        .movie a:hover {
            text-decoration: underline;
        }

        /* Admin Link */
        .admin-login {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <header>
        <a href="#home">Home</a>
        <a href="#now-showing">Movies</a>
        <a href="dashboard.php">Admin</a> <!-- Link ke halaman dashboard -->
    </header>

    <!-- Bagian Home -->
    <section id="home" class="hero">
        <h1>Check movie schedule with your choice Movie.</h1>
    </section>

    <!-- Bagian Now Showing -->
    <section id="now-showing" class="now-showing">
        <h2>Now Showing</h2>
        <div class="movies">
            <?php while ($movie = $result->fetch_assoc()): ?>
                <div class="movie">
                    <img src="<?php echo $movie['image_url']; ?>" alt="<?php echo $movie['title']; ?>">
                    <h3><?php echo $movie['title']; ?></h3>
                    <a href="details.php?id=<?php echo $movie['id']; ?>">View Details</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Link Admin -->
    <section class="admin-login">
        <p><a href="dashboard.php" style="color: #00f7ff; text-decoration: none;">Admin Login</a></p>
    </section>

</body>
</html>

<?php
$conn->close();
?>
