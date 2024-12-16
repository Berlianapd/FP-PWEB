<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "movie_db";

$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Proses penambahan film
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];
    $cast = $_POST['cast'];
    $time = $_POST['time'];
    $synopsis = $_POST['synopsis'];
    $image = $_POST['image']; // Path gambar (misalnya URL gambar)

    // Simpan data ke database
    $sql = "INSERT INTO movies (title, genre, director, cast, time, synopsis, image) 
            VALUES ('$title', '$genre', '$director', '$cast', '$time', '$synopsis', '$image')";
    mysqli_query($conn, $sql);
}

// Ambil data film terakhir yang baru ditambahkan
$query = "SELECT * FROM movies ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$movie = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add and Show Movie</title>
    <style>
        /* CSS styling */
        body {
            background-color: #1c1c1c;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            background-color: #333;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            width: 300px;
            margin: 0 auto;
        }
        form input, form textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        .movie-layout {
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: center;
        }
        img {
            width: 300px;
            border-radius: 8px;
        }
        .movie-details {
            max-width: 400px;
        }
        .delete-btn {
            background-color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Add New Movie</h1>

    <!-- Form Add Film -->
    <form method="POST" action="">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="genre" placeholder="Genre" required>
        <input type="text" name="director" placeholder="Director" required>
        <input type="text" name="cast" placeholder="Cast" required>
        <input type="number" name="time" placeholder="Duration (in minutes)" required>
        <textarea name="synopsis" placeholder="Synopsis" required></textarea>
        <input type="text" name="image" placeholder="Image URL" required>
        <button type="submit">Add Movie</button>
    </form>

    <!-- Menampilkan Detail Film Terakhir -->
    <?php if ($movie): ?>
        <h1>Now Showing</h1>
        <div class="movie-layout">
            <img src="<?php echo $movie['image']; ?>" alt="Movie Poster">
            <div class="movie-details">
                <h2><?php echo $movie['title']; ?></h2>
                <p><strong>Synopsis:</strong> <?php echo $movie['synopsis']; ?></p>
                <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
                <p><strong>Director:</strong> <?php echo $movie['director']; ?></p>
                <p><strong>Cast:</strong> <?php echo $movie['cast']; ?></p>
                <p><strong>Time:</strong> <?php echo $movie['time']; ?> Minutes</p>
                <button class="delete-btn">Delete</button>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>
